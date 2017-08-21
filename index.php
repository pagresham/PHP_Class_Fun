<?PHP

session_start();
$errorMsg =$successMsg =$createSuccessMsg =$createErrMsg = "";

function e($msg) {
	global $errorMsg;
	$errorMsg = $msg;
}
function s($msg) {
	global $successMsg;
	$successMsg = $msg;
}
// Include class definitions Controllers/DB Services/helper methods
include "controllers/Control.php";
include "helperClasses/User.php";
include "services/DBConnection.php";
include "controllers/LoginController.php";
include "controllers/CreateUserController.php";


// Get post values from login form, and pass to LoginController
if( isset($_POST['submit_login'])) {
	
	$loginCtl = new LoginController();
	// print_r($_POST);
	$un = $_POST['username'];
	$pw = $_POST['password'];
	// Validates user info
	if ( $loginCtl->logInUser($un, $pw) ) {
		s("Successful Login");
		// $successMsg = "Validation Success";
	} else {
		// $errorMsg = "Validation Failure";
	}
}

// Get post values from new user form, and pass to CreateUserCtl
if ( isset($_POST['new_user'])) {
	
	$createCtl = new CreateUserController();
	$un = $_POST['username'];
	$em = $_POST['email'];
	$pw1 = $_POST['pw1'];
	$pw2 = $_POST['pw2'];

	if ($createCtl->createUserAccount($un, $pw1, $pw2, $em)) {
		s("New user created");
	}
	else {
		e("No user created");
	}
	// To do Here //

}

include "header.php";
print_r($_POST);

?>

<!-- Login User Form -->

<h3>Login</h3>	

<form class="well" method="post" action="index.php">
	<div>
		<label for="username">Username: </label>
		<input type="text" name="username">
	</div>
	<div>
		<label for="password">Password: </label>
		<input type="password" name="password" id="password">
	</div>
	<div>
		<label></label>
		<input class="btn btn-xs btn-default pull-right" type="submit" name="submit_login" value="LogIn">
	</div>
</form>

<div>
	<p><small style="color:maroon;"><?PHP echo $errorMsg ?></small></p>
	<p><small style="color:green;"><?PHP echo $successMsg ?></small></p>
</div>

<!-- Create User Form -->

<h3>New User</h3>
<form class="well" method="post" action="index.php" id="new-user">
	<div>
		<label for="username">Username: </label> 
		<input type="text" name="username" id="username">
	</div>
	<div>
		<label for="email">Email: </label>
		<input type="email" name="email" id="email">
	</div>
	<div>
		<label for="pw1">Password: </label>
		<input type="password" name="pw1" id="pw1">
	</div>
	<div>
		<label for="pw2">Re-enter Password: </label>
		<input type="password" name="pw2" id="pw2">
	</div>
	<div>
		<label></label>
		<input class="btn btn-xs btn-default pull-right" type="submit" name="new_user" value="Create New User">
	</div>
</form>
<div>
	<p><small style="color:maroon;"><?PHP echo $createErrMsg ?></small></p>
	<p><small style="color:green;"><?PHP echo $createSuccessMsg ?></small></p>
</div>

</div> <!-- End .container -->
</body>
</html>

<!-- Model - Data - User Object, Stored User Object -->

<!-- View - index.php -->

<!-- Controller - Logincontroller.php -->











