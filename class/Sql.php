<?php

class Sql extends PDO{

	private $conn;

	public function __construct(){

		$this->conn = new PDO("mysql:dbname=dbphp7;host=localhost", "root", "");

	}

	/* Auxiliar methods to help to prepare a query for execution */
	private function setParams($statement, $parameters = array()){
		foreach ($parameters as $key => $value) {
			$this->setParam($key, $value);
		}
	}

	private function setParam($statement, $key, $value){
		$statement->bindParam($key, $value);
	}

	public function query($rawQuery, $parameters = array()){
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $parameters);
		$stmt->execute();
		return $stmt;
	}

	public function select($rawQuery, $parameters = array()):array{
		$stmt = $this->query($rawQuery,$parameters);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

}

?>