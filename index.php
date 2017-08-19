<?PHP

session_start();

$errorMsg = "";
$successMsg = "";

include "controllers/FormControl.php";
include "helperClasses/User.php";
include "services/DBConnection.php";
include "controllers/LoginController.php";
include "controllers/CreateUserController.php";

$currentUser = "";


if( isset($_POST['submit_login'])) {
	$lC = new LoginController();
	$lC->hello();
	// print_r($_POST);
	$un = $_POST['username'];
	$pw = $_POST['password'];
	// Validates user info
	if ( $lC->logInUser($un, $pw) ) {
		$currentUser = $un;
		// $successMsg = "Validation Success";
	} else {
		$errorMsg = "Validation Failure";
	}
}

if ( isset($_POST['new_user'])) {
	$cC = new CreateUserController();
	$cC->hello();
	$un = $_POST['username'];
	$em = $_POST['email'];
	$pw1 = $_POST['pw1'];
	$pw2 = $_POST['pw2'];

	// To do Here //

}


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<h3>Welcome <?PHP echo (isset($_SESSION['username'])) ? $_SESSION['username'] : ""  ?></h3>
<h3>Login</h3>	

<form method="post" action="index.php">
	<p>UserName: <input type="text" name="username"></p>
	<p>Password: <input type="password" name="password"></p>
	<div>
		<input class="btn btn-xs btn-default" type="submit" name="submit_login" value="LogIn">
	</div>
</form>

<div>
	<p><small style="color: blue;"><?PHP echo (isset($_SESSION['errorMsg'])) ? $_SESSION['errorMsg'] : "" ?></small></p>
	<p><small style="color:maroon;"><?PHP echo $errorMsg ?></small></p>
	<p><small style="color:green;"><?PHP echo $successMsg ?></small></p>
</div>


<h3>New User</h3>
<form method="post" action="index.php" id="new-user">
	<p>Username: <input type="text" name="username"></p>
	<p>Email: <input type="email" name="email"></p>
	<p>Password: <input type="password" name="pw1"></p>
	<p>Re-enter Password: <input type="password" name="pw2"></p>
	<p><input class="btn btn-xs btn-default" type="submit" name="new_user" value="Create New User"></p>
</form>



</body>
</html>

<!-- Model - Data - User Object, Stored User Object -->

<!-- View - index.php -->

<!-- Controller - Logincontroller.php -->











