<?php
require_once ('abstractDao.php');
require_once ('./model/customer.php');

/*
 *  @author:Jiangqi Li
 */

 class customerDao extends abstractDao {
    
    function __construct() {
        try{
             parent::__construct() ;
        } catch (mysqli_sql_exception $e){
            throw $e;
        }        
    }
 
   public function getCustomers(){
    $result = $this->mysqli->query('SELECT * FROM mailinglist');
    $customers = array();
    
    if($result->num_rows >= 1){
        while( $row = $result->fetch_assoc()){
            $customer = new customer($row['customerName'],$row['phoneNumber'],$row['emailAddress'],$row['referrer']);
            $customers[] = $customer;
        }
        $result->free();
        return $customers;
    }
    
        $result->free();
        return false;    
   }
   
   
   public function getID(){
      $result = $this->mysqli->query('SELECT * FROM mailinglist');
      $ID = array();
      
      if($result->num_rows >= 1){
        while( $row = $result->fetch_assoc()){
           $id=$row['_id'];
           $ID[]=$id;
        }           
        $result->free();
        return $ID;
    }
        $result->free();
        return false;
   }
 
   
   public function getCustomer($id){
    $query = 'SELECT * FROM mailinglist WHERE _id = ?';
    $stmt = $this->mysqli->prepare($query);
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $result = $stem->get_result();
    if($result->num_rows == 1){
        $temp = $result->fetch_assoc();
        $customer = new customer($temp['customerName'],$temo['phoneNumber'],$temp['emailAddress'],$temp['referrer']);
        $result->free();
        return $customer;
    }
        $result->free();
        return false;   
   }
   
   
   
   public function addCustomer($customer){
      if(!$this->mysqli->connect_errno){
        $query = 'INSERT INTO mailinglist (customerName,phoneNumber,emailAddress,referrer) values (?,?,?,?)';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('siss',$customer->getName(),$customer->getPhone(),$customer->getEmail(),$customer->getReferrer());
        $stmt->execute();
        if($stmt->error){
            return $stmt->error;
        }else {
            return $customer->getName().' signned up successfully';
        }
      }else{
        return 'Could not connect to Database.';
      }
   }
   
   
  /*
   * For delete and edit.
   * 
   public function deleteCustomer($id){
    if(!$this->mysqli->connect_errno){
        $query = 'DELETE FROM mailinglist WHERE _Id = ? ';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        if($stmt->error){
            return false;
        }else{
            return true;
        }
    }else{
        return false;
      }
   }
 
  public function editCustomer($id,$customerName,$phoneNumber,$emailAddress,$referrer){
    if(!$this->mysqli->connect_errno){
        $query = 'UPDATE mailinglist SET customerName=?,phoneNumber=?,emailAddress=?,referrer=? where _id=?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('sissi',$customerName,$phoneNumber,$emailAddress,$referrer,$id);
        $stmt->execute();
        if($stmt->error){
            return false;
        }else{
            return $stmt->affected_rows;
        }
    }else{
        return false;
      }
         
  }
 
   
  */ 
   
   
   public function duplicateEmail($emailAddress){     
      if(!$this->mysqli->connect_errno){
         $result = $this->mysqli->query('SELECT emailAddress FROM mailinglist');
         $email = array();   
         if($result->num_rows >= 1){
            while( $row = $result->fetch_assoc()){
               $email[] = $row['emailAddress'];
            }
            $result->free();
         }
        foreach( $email as $value){
          $hash = $value;
          if(password_verify($emailAddress,$hash)){
            return true;
          } 
        }
          return false;
       }
       return false;
   }

 
 
 }