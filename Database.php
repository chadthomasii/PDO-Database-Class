<?php

//Display All Errors
ini_set('display_errors', 1);


class Database
{
    
    //Database Credentials
	private $host	= 'localhost';
	private $user	= 'root';
	private $pass	= 'root';
	private $dbname	= 'ig_clone';
    
    //Database handlers, Error, and Prepeared statement handler
	private $dbh;
	private $error;
	private $stmt;

	public function __construct()
    {
		// Set Connection to pdo
		$dsn = 'mysql:host='. $this->host . ';dbname='. $this->dbname;
		// Set PDO  Options 
		$options = array
        (
			PDO::ATTR_ERRMODE	 => PDO::ERRMODE_EXCEPTION
		);
		// Try and Create new PDO Instance
		try 
        {
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            
		} 
        //Catch any errros that happen when trying to create it.
        catch(PDOEception $e)
        {
            $this->error = $e->getMessage();
            
		}
	}
    
    //Used for calling sql queries
    public function query($query)
    {
        //Takes prepared statement, and makes it a prepared query
        $this->stmt = $this->dbh->prepare($query);
    }
    
    //Bind prepared statement
    public function bind($param,$value, $type = null)
    {
        //If input is not null
        if(is_null($type))
        {
            //Just Checks what type of data is being passed
            switch(true)
            {
                case is_int($value):
                    $type = PDO::PARAM_INT; //If INT, Will enter Database as INT
                    break;
                    
                case is_bool($value):
                    $type = PDO::PARAM_BOOL; //If BOOL, Will enter Database as BOOL
                    break;
                    
                case is_null($value):
                    $type = PDO::PARAM_NULL; //If NOTHING, Will enter Database as NULL
                    break;
                    
                default:
                    $type = PDO::PARAM_STR; //DEAFUALTS to STIRNG
                    
                    
            }
            
        }
        //Bind the statment object
        $this->stmt->bindValue($param, $value, $type);
        
    }
    
    //Executes statement
    public function execute()
    { 
        return $this->stmt->execute();
    }
    
    //Gives result set
    public function resultSet()
    {
        
        //Returns Results in an assosiative Array
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Returns the last inserted ID of an insert statement
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function getInfoWithId($table, $id)
    {
        //Use the given id to find
        $this->query("SELECT * FROM $table WHERE id = :id");
        $this->bind(":id", $id);
        $this->execute();
        
        //give back the 
        return $this->resultSet();

    }
    
    
    
}

$database = new Database();






