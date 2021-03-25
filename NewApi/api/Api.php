<?php 

	//getting the dboperation class
	require_once '../includes/DbOperation.php';

	//function validating all the paramters are available
	//we will pass the required parameters to this function 
	function isTheseParametersAvailable($params){
		//assuming all parameters are available 
		$available = true; 
		$missingparams = ""; 
		
		foreach($params as $param){
			if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
				$available = false; 
				$missingparams = $missingparams . ", " . $param; 
			}
		}
		
		//if parameters are missing 
		if(!$available){
			$response = array(); 
			$response['error'] = true; 
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
			
			//displaying error
			echo json_encode($response);
			
			//stopping further execution
			die();
		}
	}
	
	
	
	
	
	//an array to display response
	$response = array();
	
	//if it is an api call 
	//that means a get parameter named api call is set in the URL 
	//and with this parameter we are concluding that it is an api call
	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
		 
			case 'register':

 			isTheseParametersAvailable(array('name','email','pwd'));
			 $db = new DbOperation();
				
 			$result = $db->insertData(
						$_POST['name'],
						$_POST['email'],
						$_POST['pwd']
						);
				

 				if($result){

 					$response['error'] = false; 
					$response['message'] = 'Regitered successfully';
 
				}else{

 					$response['error'] = true; 
					$response['message'] = 'Some error occurred please try again';
				}
				
			break; 
			
			/*----------------------------------------------- LOGIN---------------------------------------------------*/

			case 'student':

 			isTheseParametersAvailable(array('name','occupation'));
			 $db = new DbOperation();
				
 			$result = $db->insertData(
						$_POST['name'],
						$_POST['occupation'],
						
						);
				

 				if($result){

 					$response['error'] = false; 
					$response['message'] = 'Regitered successfully';
 
				}else{

 					$response['error'] = true; 
					$response['message'] = 'Some error occurred please try again';
				}
				
			break; 
			
			
			
/*----------------------------------------------- LOGIN---------------------------------------------------*/
	
			
			case 'login':
			
			isTheseParametersAvailable(array('email','pwd'));
			$db = new DbOperation();
			$result = $db->Login($_POST['email'],$_POST['pwd']);
			
			 
				if($result){
					 
					$response['error'] = false; 
					$response['message'] = 'Login successfully';
					$response['user'] = $db->getLoginData($_POST['email'],$_POST['pwd']);
 					 

					
					}else{

 					$response['error'] = true; 
					$response['message'] = 'email or Password is Invalid';
					
 				}
			break; 
			
			
	/*----------------------------------------------- LOGIN DATA---------------------------------------------------*/
	
			
			case 'login_data':
			
			isTheseParametersAvailable(array('email'));
			$db = new DbOperation();
 			
			 
			 					 
					$response['error'] = false; 
					$response['message'] = 'Data Fetched';
					$response['records'] = $db->getLoginData($_POST['email']);
					 
  
			break; 		 
			
	/*----------------------------------------------- LOGIN DATA---------------------------------------------------*/
		case 'pincode':

			isTheseParametersAvailable(array('pincode'));
			$db =  new DbOperation();

				// $response['pincode'] = $db->getPincode($_POST['pincode']);
							$pincode = $db->getPincode($_POST['pincode']);
			break;

		}
	}		
			
		
	else{
		//if it is not api call 
		//pushing appropriate values to response array 
		$response['error'] = true; 
		$response['message'] = 'Invalid API Call';
	}
	
	//displaying the response in json structure 
	echo json_encode($response);