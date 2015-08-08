<?php

# Database.class.php
# used in MODEL part of website for interracting with the database

class Database
{
	private $host=DB_HOST;
	private $username=DB_USER;
	private $password=DB_PASSWORD;
	private $db=DB_DATABASE;
	private $link;
	
	/**
	 * constructor function
	 */
	 public function __construct()
	 {
	 	$this->createDbConnection();
	 }
	 
	 /**
	  * function creates the Database connection object
	  */
	  private function createDbConnection()
	  {
	  	$this->link=mysqli_connect($this->host,$this->username,$this->password,$this->db);
		
		# check connection
		if(!$this->link)
		{
			die("Connection failed: ".mysqli_connect_error());
		}
	  }
	  
	  /**
	   * function to close the connection
	   */
	   public function closeDbConnection()
	   {
	   		mysqli_close($this->link);
	   }
	   
	   /**
	    * function executes a query passed to it with an expected result of
	    * a single record. The record is converted to an assoc array
	    * 
	    * @param $query to be executed
	    * @return $result - assoc array of result
	    */
	   public function getSingleRecord($query)
	   {
	   		# execute the query
	   		$record=mysqli_query($this->link,$query);
			
			# put result into an assoc array
			$result=mysqli_fetch_assoc($record);
			
			return $result;
	   }
	   
	   /**
	    * function executes a query where one or more records are expected
	    * in the result
	    * 
	    * @param $query - to be executed
	    * @result $records - multidimensional array of results
	    */
	    public function getMultiRecords($query)
		{
			$row=null;

			# execute the query
			$recordSet=mysqli_query($this->link,$query);
			
			$records=array();
			
			# loop through the recordSet
			# convert each record to an assoc array
			# then add to a multidimensional array
			while($row=mysqli_fetch_assoc($recordSet))
			{
				$records[]=$row;
			}
			
			return $records;
		}
		
		/** 
		 * function processes query to insert a record
		 * 
		 * @param $query
		 * @return $update - boolean value to indicate success of update
		 */
		 public function insertRecord($query)
		 {
		 	$inserted=null;	
				
			# execute the query
			$inserted=mysqli_query($this->link,$query);
			
			return $inserted;
		 }
		 
		 /**
		  * function processes query to update a record
		  * 
		  * @param $query - update query
		  * @return $updated - true or false
		  */
		 public function updateRecord($query)
		 {
		 	$updated = null;
			
			# execute the query
			$updated=mysqli_query($this->link,$query);
			
			return $updated;
		 }
}
