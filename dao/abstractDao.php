<?php
mysqli_report(MYSQLI_REPORT_STRICT);

class abstractDao{
    protected $mysqli;
    
     /* Host address for the database */
    protected static $DB_HOST = "127.0.0.2";
    /* Database username */
    protected static $DB_USERNAME = "wp_eatery";
    /* Database password */
    protected static $DB_PASSWORD = "password";
    /* Name of database */
    protected static $DB_DATABASE = "wp_eatery";
    
    
    function __construct() {
        try{
            $this->mysqli = new mysqli(self::$DB_HOST, self::$DB_USERNAME, 
                self::$DB_PASSWORD, self::$DB_DATABASE);
        }catch(mysqli_sql_exception $e){
            throw  $e;
        }
    }
    
    public function getMysqli(){
        return $this->mysqli;
        
    }
  
}

?>