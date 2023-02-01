<?php
	
	/*
	 * CSC-Spretz Admin Interface
	 * last changes July 2015 by Frank Bergmann
	 * Copyright 2015 CSC-Spretz
	 * 
	 *  --- MODIFIED 05.12.2022 ----
	 */
	
	class Dbo extends PDO
	{
		/*
		 * ************************************************************************
		 *
		 *
		 * Implementierung der abwärtskompatiblen Funktionen der Db-Klasse
		 * ---------------------------------------------------------------
		 *
		 * der Aufruf erfolgt im Objekt Kontext
		 *
		 *
		 * *************************************************************************
		 */
		
		private static $INSTANCE;
		
		public function __construct()
		{
			parent::__construct('mysql:host=' . (defined('DBHOST') ? DBHOST : 'localhost') . ';dbname=' . explode(":", DBPAR)[2] . ';charset=UTF8;', explode(":", DBPAR)[0], explode(":", DBPAR)[1]);
		}
		
		public static function getInstance()
		{
			if (!self::$INSTANCE) {
				self::$INSTANCE = new self;
			}
			
			return self::$INSTANCE;
		}
		
		// RAW Query für Kreuzabfragen etc.
		
		public function raw_query($sql, $fetchMode = PDO::FETCH_OBJ)
		{
			$sth = $this->query($sql);
			$result = $sth->fetchAll($fetchMode);
			
			return $result;
		}

		// requires Array
		public function do_statement($statements) {
			foreach ($statements as $statement) {
				$this->exec($statement);
			}
		}
		
		/**
		 *
		 * @param type $sql
		 * @param type $array
		 * @param type $fetchMode
		 *
		 * @return type
		 */
		public function select($tab, $array = '', $limit = '', $fetchMode = PDO::FETCH_OBJ)
		{
			
			$sql = "SELECT * FROM $tab";
			
			// where Array oder string
			if (is_array($array)) {
				$sql .= $this->getWhere($array);
			}
			
			if (is_string($array) && !empty($array)) {
				$sql .= " WHERE " . $array;
			}
			
			// Limit
			$sql .= $this->getLimit($limit);
			
			$sth = $this->prepare($sql);
			
			//echo $sql; exit;
			
			if (is_array($array)) {
				// bind Values für Prepare
				foreach ($array as $key => $value) {
					$sth->bindValue(":$key", $value);
				}
			}
			
			// execute handler
			if ($sth->execute()) {
				return $sth->fetchAll($fetchMode);
			} else {
				return $sth->errorInfo();
			}
		}
		
		// Batch inserts
		public function insert_batch($table, $inserts) {
			foreach($inserts as $row) {
				$this->insert($table, $row);
			}
		}

		/**
		 * Standard Insert-Handler by PDO
		 *
		 * @param string $table
		 * @param array  $data
		 *
		 * @return int
		 */
		public function insert($table, $data)
		{
			// Sortiereb
			ksort($data);
			$fieldDetails = NULL;
			
			foreach ($data as $key => $value) {
				$fieldDetails .= "$key=:u_$key,";
			}
			
			// letztes Komma weg
			$fields = substr($fieldDetails, 0, -1);
			
			$sql = "INSERT $table SET $fields";
			
			$sth = $this->prepare($sql);
			
			// bind Values für Prepare INSERT keys
			foreach ($data as $key => $value) {
				$sth->bindValue(":u_$key", $value);
				
				//echo ":u_$key - $value <br>";
			}
			
			// PDO Statement ausführen
			if ($sth->execute()) {
				return $this->lastInsertId();
			} else {
				return $sth->errorInfo();
			}
		}
		
		/**
		 * Standard Update-Handler by PDO
		 *
		 * @param string $table
		 * @param array  $data
		 * @param string $where
		 *
		 * @return int
		 */
		public function update($table, $data, $where)
		{
			// Sortiereb
			ksort($data);
			$fieldDetails = NULL;
			
			foreach ($data as $key => $value) {
				$fieldDetails .= "$key=:u_$key,";
			}
			
			// letztes Komma weg
			$fields = substr($fieldDetails, 0, -1);
			
			$sql = "UPDATE $table SET $fields";
			$sql .= $this->getWhere($where);
			
			//echo $sql;
			$sth = $this->prepare($sql);
			
			// bind Values für Prepare UPDATE keys
			foreach ($data as $key => $value) {
				$sth->bindValue(":u_$key", $value);
				//echo "<br><br>";
				//echo ":u_$key - $value <br>";
			}
			
			// bind Values für Prepare WHERE keys
			// wenn Array
			if (is_array($where)) {
				foreach ($where as $wkey => $wvalue) {
					$sth->bindValue(":$wkey", $wvalue);
					//echo ":$wkey - $wvalue <br>";
				}
			}
			
			// PDO Statement ausführen
			if ($sth->execute()) {
				return TRUE;
			} else {
				return $sth->errorInfo();
			}
		}
		
		/**
		 * Standard delete with exec
		 *
		 * @param string $table
		 * @param string $where
		 * @param int    $limit
		 *
		 * @return int affected rows
		 */
		public function delete($table, $where, $limit = 1)
		{
			// gibt affected rows zurück
			// $wheresoll Array sein
			$sql = "DELETE FROM $table ";
			$sql .= $this->getWhere($where);
			
			if ($limit != 'all') {
				$sql .= " LIMIT $limit";
			}
			
			//echo $sql; exit;
			
			$sth = $this->prepare($sql);
			
			// bind Values für Prepare WHERE keys
			// wenn Array
			if (is_array($where)) {
				foreach ($where as $wkey => $wvalue) {
					$sth->bindValue(":$wkey", $wvalue);
					//echo ":$wkey - $wvalue <br>";
				}
			}
			
			// PDO Statement ausführen
			if ($sth->execute()) {
				return TRUE;
			} else {
				return $sth->errorInfo();
			}
		}
		
		public function print_pre($array)
		{
			$str = '';
			$str .= "<pre>";
			$str .= print_r($array, TRUE);
			$str .= "</pre>";
			
			return $str;
		}
		
		/**
		 * Generiert einen WHERE string
		 *
		 * @param array mixed $bedingungen
		 */
		public function where($bedingungen)
		{
			// standardverkettung ist AND
			$whereString = '';
			$i = 0;
			foreach ($bedingungen as $key => $value) {
				$vor = "";
				if ($i > 0) {
					$vor = (is_array($value) && strtoupper($key) == "OR") ? "OR" : "AND";
				}
				
				
				echo $i . " => " . $vor . "<br>";
				// $whereString = array_walk($bedingungen, 'Dbo::array_walk_r', $vor);
				if (is_array($value)) {
					//print_r($value); exit;
					foreach ($value as $k => $v) {
						$whereString = $vor;
						if (!empty($vor)) {
							$whereString .= " ";
						}
						$whereString .= $k;
						$whereString .= (strpos($v, '%') === false) ? " = " : " LIKE ";
						$whereString .= " '" . $v . "' ";
					}
				} else {
					
					
					$whereString = $vor;
					if (!empty($vor)) {
						$whereString .= " ";
					}
					$whereString .= $key;
					$whereString .= (strpos($value, '%') === false) ? " = " : " LIKE ";
					$whereString .= " '" . $value . "' ";
				}
				
				$i++;
			}
			
			
			return $whereString;
		}
		
		public function array_walk_r($item, $vor = "")
		{
			
			$whereString = $vor;
			if (!empty($vor)) {
				$whereString .= " ";
			}
			$whereString .= $key;
			$whereString .= (strpos($item, '%') === false) ? " = " : " LIKE ";
			$whereString .= " '" . $item . "' ";
			
			return $whereString;
		}
		
		public function wheretest($bedingung)
		{
			//init var
			$wherestring = "";
			
			// wenn element der Bedingung Array, dann setze or
			foreach ($bedingung as $key => $item) {
				if (is_array($item)) {
					$wherestring .= " OR w_$key='" . implode("' OR w_$key='", $item) . "'";
				} else {
					$wherestring .= " AND w_$key='" . $item . "'";
				}
			} // end foreach
			//$wherestring = substr($wherestring, 0, -1);
			
			return $wherestring;
		}
		
		/**
		 * WHERE Statement aus Array oder String
		 *
		 * @param array or string $array
		 *
		 * @return string
		 */
		public function getWhere($array)
		{
			// wenn Array
			$sql = "";
			$tmp = array();
			if (is_array($array)) {
				$sql .= " WHERE ";
				foreach ($array as $k => $v) {
					$tmp[] = $k . "=:" . $k;
					//echo $k."=:".$v."<br>";
				}
				// wenn größer 1
				if (count($tmp) > 1) {
					$sql .= implode(' AND ', $tmp);
				} else {
					$sql .= $tmp[0];
				}
			}
			
			// wenn string
			if (is_string($array) && !empty($array)) {
				$sql .= " WHERE " . $array;
			}
			
			return $sql;
		}
		
		public function getLimit($limit)
		{
			$sql = "";
			if (!empty($limit)) {
				$sql .= " LIMIT " . $limit;
			}
			
			return $sql;
		}
		
		// Append Order to SQL
		public function getOrderBy($order)
		{
			$sql = "";
			if (!empty($order)) {
				$sql .= " ORDER BY " . $order;
			}
			
			return $sql;
		}
	}