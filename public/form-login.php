<?php
#-> Include config and class files.
session_start();
if($_SESSION > 0)
{
	echo "<script type='text/javascript'>window.location.href = 'show-product.php';</script>";
}
include_once("/includes/config.php");
include_once("/includes/class_mysql.php");
#-> Get data from js and initialize
#$data = file_get_contents("php://input");
#$json = json_decode($data);
#-> Connect to the database
$db = new Database();
$db->connectdb(DB_NAME,DB_USER,DB_PASS);
$table = 'user';
$email = $_POST['email'];
$password = $_POST['password'];
$query = $db->querydb("SELECT * FROM ".$table." WHERE username='$email' AND password='$password'");
echo "SELECT * FROM ".$table." WHERE username='$email' AND password='$password'";
$arr = array();
#-> Preparing return data.
if($query) {
	$result = $db->fetch($query);
	if($result["user_id"]) {
		$_SESSION['id'] = $result["user_id"];
		echo "<script type='text/javascript'>window.location.href = 'show-product.php';</script>";
		/*$arr["status"] = "success";
		$arr["data"]["attributes"]["_id"]=$result["user_id"];
		$arr["data"]["attributes"]["name"]=$result["fullName"];
		$arr["data"]["attributes"]["email"]=$result["username"];
		$arr["data"]["attributes"]["address"]=$result["address"];
		$arr["data"]["attributes"]["type"]=$result["type"];	*/
	} else {
		$arr["status"] = "error";
		if(isset($username)) 
			echo "<script type='text/javascript'>alert('Please enter your username.');</script>";#$messages = "Please enter your username.";
		else if(isset($password)) echo "<script type='text/javascript'>alert('Please enter your password.');</script>"; #$messages = "Please enter your password.";
		else echo "<script type='text/javascript'>alert('Some error occured, Please check your data.');</script>"; #$messages = "Some error occured, Please check your data.";
		#$arr["messages"] = $messages;
	}
} else {
	$arr["status"] = "error";
	if(isset($email)) echo "<script type='text/javascript'>alert('Please enter your username.');</script>";#$messages = "Please enter your username.";
	else if(isset($password)) echo "<script type='text/javascript'>alert('Please enter your password.');</script>";#$messages = "Please enter your password.";
	else echo "<script type='text/javascript'>alert('Some error occured, Please check your data.');</script>";#$messages = "Some error occured, Please check your data.";
	#$arr["messages"] = $messages;
}
#-> Return json data.
#echo json_encode($arr);
// echo $query;
#-> Close database.
$db->closedb();
echo "<script type='text/javascript'>window.location.href = 'form-login.html';</script>";
?>