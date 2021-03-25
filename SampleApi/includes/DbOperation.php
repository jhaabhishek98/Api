<?php
 
class DbOperation
{
    //Database connection link
    private $con;
 
    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();
 
        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }
	
	/*
	* The create operation
	* When this method is called a new record is created in the database
	*/
	
	
	
	
	
/*----------------------------------------------- REGISTER---------------------------------------------------*/
function insertData($name,$email,$pwd){

$stmt = "INSERT INTO `user`(`name`, `email`, `password`) VALUES('$name','$email','$pwd'	)";
// echo $stmt;
$data = $this->con->query($stmt);
		 
		if($data){

			return true; 
		}
		else{

			return false;
		}
	
 
	}
/*----------------------------------------------- LOGIN---------------------------------------------------*/
	
	
	function Login($email,$pwd){
		
		$sql="SELECT email,password FROM `user` where email ='$email' and password = '$pwd'";
		$stmt = mysqli_query($this->con,$sql);
		
		$num = mysqli_num_rows($stmt);
		
		if($num>0){
			
			return true;
		}
		else{
			
			return false;
		}
		
		
	}
	
/*----------------------------------------------- LOGIN DATA---------------------------------------------------*/

	
	function getLoginData($email,$pwd){


		$stmt = "SELECT * FROM `reg_form` where email = '$email' and password = '$pwd'";
		$result = $this->con->query($stmt);
 		
		$outer = array(); 
		
		while($obj = $result->fetch_object()){


			$inner  = array();
			$inner['user_id'] = $obj->user_id; 
			$inner['user_name'] = $obj->user_name; 
			$inner['email'] = $obj->email; 
			$inner['password'] = $obj->password; 
			$inner['address'] = $obj->address; 
			$inner['mobile'] = $obj->mobile; 
			$inner['user_image'] = $obj->user_image; 
 		 	
			array_push($outer, $inner); 
		}
		
		return $outer; 
	}
	
		
/*----------------------------------------------- Get Blood Group---------------------------------------------------*/

	
	function getBloodGroup(){


		$stmt = "SELECT * FROM `blood_group`";
		$data = mysqli_query($this->con,$stmt); 
		
		$outer = array(); 
		
		while($row = mysqli_fetch_assoc($data)){
			$inner  = array();
			
			$inner['group_id'] = $row['group_id']; 
			$inner['group_name'] = $row['group_name']; 
	  		
	  		array_push($outer, $inner); 
		}
		
		return $outer; 
	}	
  
		
/*------------------------------------------ Get Blood Group List By Id----------------------------------------------*/

	
	function getBloodGroupListById($user_id,$group_id){


		$sql = "SELECT address from reg_form where user_id = '$user_id'";
		$exe = $this->con->query($sql);
		$obj = $exe->fetch_object();

		$address = $obj->address;



$stmt = "SELECT * FROM `blood_bank_data`,blood_bank,blood_group where blood_bank_data.bb_id = blood_bank.bb_id and blood_bank_data.group_id = blood_group.group_id and blood_group.group_id = '$group_id' ORDER BY blood_bank.bb_address = '$address' DESC";

		$data = mysqli_query($this->con,$stmt); 
		
		$outer = array(); 
		
		while($row = mysqli_fetch_assoc($data)){
			$inner  = array();
			
			$inner['bb_id'] = $row['bb_id']; 
			$inner['group_id'] = $row['group_id']; 
			$inner['bb_name'] = $row['bb_name']; 
			$inner['group_name'] = $row['group_name']; 
			$inner['bb_address'] = $row['bb_address']; 
			$inner['price'] = $row['price']; 
	  		
	  		array_push($outer, $inner); 
		}
		
		return $outer; 
	}	
  	 
	
/*----------------------------------------------- Change Password---------------------------------------------------*/

	
	
	function ChangePwd($old,$new,$email){
		
		
		$sql="select * from reg where password='$old'";
		$stmt = mysqli_query($this->con,$sql);
		
		$num = mysqli_num_rows($stmt);
		 
		
		if($num>0){
			
		 $sql="UPDATE user_reg SET password = '$new' WHERE password = '$old' and email = '$email'";
		 $stmt = mysqli_query($this->con,$sql);

			
			return true;
		}
		else{
			
			return false;
		}
		
		
	}
	
 
	
}