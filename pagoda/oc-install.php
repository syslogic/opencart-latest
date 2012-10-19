<?php
/*
	openCart v1.5.4.1
	
	cURL Installer for Pagoda Box v1.06
	Copyright 2012 by Martin Zeitler
	http://codefx.biz/contact
*/

/* the given environment */
$version='1.5.4.1';
$fn='opencart_v'.$version.'.zip';
$src='http://cloud.github.com/downloads/opencart/opencart/'.$fn;
$base_dir=str_replace('/pagoda','', dirname(__FILE__));
$upload=dirname(__FILE__).'/opencart_v'.$version.'/upload/';
$dst=$base_dir.'/pagoda/'.$fn;

/* fetch & extract the package */
wget($src, $dst);
$zip = new ZipArchive;
if($zip->open($dst) === TRUE) {
	$zip->extractTo(dirname(__FILE__));
	$zip->close();
}

/* patching the OC installer */
$files=array(
	'config.php',
	'admin/config.php',
	'install/controller/step_2.php',
	'install/controller/step_3.php',
	'install/template/step_2.tpl',
	'install/template/step_3.tpl'
);
foreach($files as $file) {
	echo 'pagoda/config/'.$file.' >> '.$upload.$file;
	copy('pagoda/config/'.$file, $upload.$file);
}

/* the end */
echo 'openCart v'.$version.' will now be deployed.';

function wget($src, $dst){
	$fp = fopen($dst, 'w');
	$curl = curl_init();
	$opt = array(CURLOPT_URL => $src, CURLOPT_HEADER => FALSE, CURLOPT_FILE => $fp);
	curl_setopt_array($curl, $opt);
	$rsp = curl_exec($curl);
	if($rsp===FALSE){
		die("[cURL] errno:".curl_errno($curl)."\n[cURL] error:".curl_error($curl)."\n");
	}
	$info = curl_getinfo($curl);
	curl_close($curl);
	fclose($fp);
	
	/* cURL stats */
	$time = $info['total_time']-$info['namelookup_time']-$info['connect_time']-$info['pretransfer_time']-$info['starttransfer_time']-$info['redirect_time'];
	echo "Fetched '$src' @ ".abs(round(($info['size_download']*8/$time/1024/1024),2))."MBit/s.\n";
}

function format_size($size=0) {
	if($size < 1024){
		return $size.'b';
	}
	elseif($size < 1048576){
		return round($size/1024,2).'kb';
	}
	else {
		return round($size/1048576,2).'mb';
	}
}
?>