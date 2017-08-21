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
function eCreate($msg) {
	global $createErrMsg;
	$createErrMsg = $msg;
}
function sCreate($msg) {
	global $createSuccessMsg;
	$createSuccessMsg = $msg;
}

// Include class definitions Controllers/DB Services/helper methods
include "controllers/Control.php";
include "helperClasses/User.php";
include "services/DBConnection.php";
include "controllers/LoginController.php";
include "controllers/CreateUserController.php";
include "header.php";

// Get post values from login form, and pass to LoginController
if( isset($_POST['submit_login'])) {
	
	$loginCtl = new LoginController();
	$un = $_POST['username'];
	$pw = $_POST['password'];
	
	$loginCtl->logInUser($un, $pw); 
}

// Get post values from new user form, and pass to CreateUserCtl
if ( isset($_POST['new_user'])) {
	
	$createCtl = new CreateUserController();
	$un = $_POST['username'];
	$em = $_POST['email'];
	$pw1 = $_POST['pw1'];
	$pw2 = $_POST['pw2'];

	$createCtl->createUserAccount($un, $em, $pw1, $pw2);
}


?>

<!-- Login User Form -->

<h3>Login</h3>	
<form class="well" method="post" action="index.php">
	<div>
		<label for="username">Username: </label>
		<input type="text" name="username" maxlength="45" required>
	</div>
	<div>
		<label for="password">Password: </label>
		<input type="password" name="password" id="password" maxlength="45" required>
	</div>
	<div>
		<label></label>
		<input class="btn btn-xs btn-default pull-right" type="submit" name="submit_login" value="LogIn">
	</div>
	<div>
		<p><small style="color:maroon;"><?PHP echo $errorMsg ?></small></p>
		<p><small style="color:green;"><?PHP echo $successMsg ?></small></p>
	</div>
</form>



<!-- Create User Form -->

<h3>New User</h3>
<form class="well" method="post" action="index.php" id="new-user">
	<div>
		<label for="username">Username: </label> 
		<input type="text" name="username" id="username" maxlength="45" required>
	</div>
	<div>
		<label for="email">Email: </label>
		<input type="email" name="email" id="email" maxlength="60" required>
	</div>
	<div>
		<label for="pw1">Password: </label>
		<input type="password" name="pw1" id="pw1" maxlength="45" required>
	</div>
	<div>
		<label for="pw2">Re-enter Password: </label>
		<input type="password" name="pw2" id="pw2" maxlength="45" required>
	</div>
	<div>
		<label></label>
		<input class="btn btn-xs btn-default pull-right" type="submit" name="new_user" value="Create New User">
	</div>
	<div>
		<p><small style="color:maroon;"><?PHP echo $createErrMsg ?></small></p>
		<p><small style="color:green;"><?PHP echo $createSuccessMsg ?></small></p>
	</div>
</form>


</div> <!-- End .container -->
</body>
</html>

<!-- Model - Data - User Object, Stored User Object -->
<!-- View - index.php -->
<!-- Controller - Logincontroller.php -->











