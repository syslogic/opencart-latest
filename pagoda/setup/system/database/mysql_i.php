<?php
final class MySQL_i {
	private $connection;
	
	public function __construct($hostname, $username, $password, $database) {
		$this->connection = new mysqli($hostname, $username, $password, $database);
		
		if(mysqli_connect_error()) {
			exit('Error: Could not make a database connection using ' . $username . '@' . $hostname . '<br />Error: ' . $this->connection->connect_error . '<br />Error No: ' . $this->connection->connect_errno);
		}
		
		$this->connection->query("SET NAMES 'utf8'");
		$this->connection->query("SET CHARACTER SET utf8");
		$this->connection->query("SET CHARACTER_SET_CONNECTION=utf8");
		$this->connection->query("SET SQL_MODE = ''");
		$this->connection->query("SET time_zone = '" . date('P') . "'");
		
  	}
		
  	public function query($sql) {
		$object = $this->connection->query($sql);

		if ($object) {
			if (is_object($object)) {
				$i = 0;

				$data = array();

				while ($result = $object->fetch_assoc()) {
					$data[$i] = $result;
					$i++;
				}

				$object->free();

				$query = new stdClass();
				$query->row = isset($data[0]) ? $data[0] : array();
				$query->rows = $data;
				$query->num_rows = $i;

				unset($data);

				return $query;	
    		} else {
				return TRUE;
			}
		} else {
      		exit('Error: ' . $this->connection->error . '<br />Error No: ' . $this->connection->errno . '<br />' . $sql);
    	}
  	}
	
	public function escape($value) {
		return $this->connection->real_escape_string($value);
	}
	
  	public function countAffected() {
    	return $this->connection->affected_rows;
  	}

  	public function getLastId() {
    	return $this->connection->insert_id;
  	}	
	
	public function __destruct() {
		$this->connection->close();
	}
}
?>