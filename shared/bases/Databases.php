<?php
include_once "Configs.php";

if(!class_exists("Databases")) {
	class Databases extends Configs {

		private $database; // Database Connection
		private $result; // Temporary result Set
		private $isDebug = true; // Flag for debug
			  
		function __construct(){
		    parent::__construct();
			$this->connect($this->PF_DB_HOST, $this->PF_DB_USER, $this->PF_DB_PASSWORD, $this->PF_DB_NAME, $this->PF_DB_CHARSET);
		}

        /**
         * Function for making connection via information in parameters
         * @param $db_host
         * @param $db_user
         * @param $db_pass
         * @param $db_name
         * @param $db_charset
         */
		function connect($db_host, $db_user, $db_pass, $db_name, $db_charset){
			$this->database = new mysqli($db_host, $db_user, $db_pass, $db_name);
			$this->database->set_charset($db_charset);
			$this->isConnectionAvailable();
		}

        /**
         * Function for executing a single query
         * @param $query
         */
		function execute($query){
			if(!$this->isConnectionAvailable()) return;
			$this->result = @mysqli_query($this->database, $query) or die(($this->isDebug) ? mysqli_error($this->database) : ERROR."Failed to execute a query.");
		}

        /**
         * Function for executing multiple queries.
         * @param $query
         * @return bool
         */
		function executeMultiple($query){
			return @mysqli_multi_query($this->database,$query) or die(($this->isDebug) ? mysqli_error($this->database) : ERROR."Failed to execute multiple queries.");
		}

        /**
         * Function for checking the database connection is available
         * @return bool
         */
		function isConnectionAvailable(){
			if(mysqli_connect_errno()) {
				$this->printErrorTrace(ERROR."Invalid Connection.");
				return false;
			}
			return true;
		}


        /**
         * Function for executing the query which changes tuple.
         * @param $query
         * @return Affected Rows
         * @throws Exception
         */
		function update($query){
			try {
				$this->execute($query);
				return mysqli_affected_rows($this->database);
			} catch(Exception $e) {
				throw new Exception(ERROR."Failed To launch [function update].");
			}
		}

        /**
         * Function to move the cursor of result set to next row
         * @return mixed
         */
		function next(){
			$assoc = $this->result->fetch_assoc();
			return $assoc;
		}

        /**
         * Function to retrieve the number of rows
         * @return int
         */
		function getNumber(){
			return mysqli_num_rows($this->result) ;
		}

        /**
         * Function to move to next result set
         * @return mixed
         */
		function nextResult(){
			if(mysqli_more_results($this->database)) return $this->database->next_result();
			else false;
		}

        /**
         * Function to retrieve the last inserted key value
         * @return int|string
         */
		function mysql_insert_id(){
			return mysqli_insert_id($this->database);
		}

        /**
         * Function for printing error messages
         * @param $msg
         */
		function printErrorTrace($msg){
			if($this->isDebug){
				echo "</UL></DL></OL>\n"; 
				echo "</TABLE></SCRIPT>\n"; 
				$text  = "<FONT COLOR=\"#ff0000\"><P>Error: $msg : </p>"; 
				$text .= mysql_error(); 
				$text .= "</FONT>\n"; 
				die($text);
			}
		}

        /**
         * Function to free the resources of the connection
         */
		function destroy(){
			if(is_resource($this->result)) mysql_free_result($this->result);  
			mysql_close($this->database);
		}

		function getValue($sql,$col){
			$row = $this->getRow($sql);
			if($row == null) return 0;
			else return $row[$col];
		}
		
		function getRow($sql){
			$this->execute($sql);
			$row = null;
			if(1 <= $this->getNumber()) $row = $this->next();
			$this->result->close();
			return $row;
		}
		
		
		function getMultiRow($sql){
			$this->executeMultiple($sql);
			return $this->next();
		}

		function getArray($sql){
			$this->execute($sql);

			$arrResult = Array();
			$i = 0;
			while($row = $this->next()){
				$arrResult[$i] = $row;
				$i++;
			}
			$this->result->close(); 
			
			return $arrResult;
		}

		function getMultiArray($sql){
			$isResult = $this->executeMultiple($sql);
			if($isResult) {
				$pack = Array();
				$multiNum = 0;
				do {
					if ($this->result = $this->database->store_result()) {
						$set = Array();
						$i = 0;
						while($row = $this->next()) {
							$set[$i] = $row;
							$i ++;
						}
						
						$this->result->close(); 

						$pack[$multiNum] = $set;
						$multiNum ++;
					} 
				} 
				while($this->nextResult());
			}

			return $pack;
		}
	   
	};

}

?>