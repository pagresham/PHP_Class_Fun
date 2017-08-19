<?PHP

/**
* LoginController
*/
class LoginController extends Control
{
	// private $db; // handle to DB
	private $currentUser; // is set once a user successfully logs in 

	function __construct()
	{
		// $this->db = new DBConnection();ssssddssss
		parent::__construct();
	}

	public function hello() {
		print "<h1>Hello from LC</h1>";
	}

	// Tries to log in as passed user params
	// Calls validateUser which calls verifyUser();
	// If successful, creates user and sets $currentUser
	public function logInUser($un, $pw) {

		if ($un == null || $pw == null || $un == "" || $pw == "") {
			$_SESSION['errorMsg'] = "empty values";
			$this->writeErrMsg("Please Complete All Required Fields 33");
			return false;
		}
		else {
			if ($this->validateUserInfo($un, $pw)) {
				$this->writeSuccessMsg("Successful Login");
				return true;
			} else return false;
		}
	}

	
	/**
	 * logOutUser  
	 */
	public function logOutUser($user) {
		$_SESSION['username'] = "";
	}	

	


	




	public function deleteAccount() {

	}

	/**
	 * [validateUserInfo description]
	 * @param  [type] $un [description]
	 * @param  [type] $pw [description]
	 * @return [type]     [description]
	 */
	public function validateUserInfo($un, $pw) {
		$errors = [];
		$un = trim($un);
		$pw = trim($pw);
		if ( $un == "" || $pw == "") {
			$errors['username'] = "Please complete all fields 127";
			// $this->writeErrMsg("Please complete all fields 128");
		}
			
		// Do my form validation here //
		if(!preg_match("/^[a-zA-Z-.@_]{4,}$/", $un) || (strlen($un) > 45)) {
			$errors['username'] = "Invalid username 133";
		}

		if(strlen($pw) > 45) {
			$errors['password'] = "Please enter a valid password 137";
		}

		if(count($errors) > 0) { 

			// method to write error message for Client goes here
			$this->writeErrMsg(reset($errors));

			return false; 
		} else {
			// go to DB and check creds //
			if (!$this->db->connect()) {
				return false;
			}
			else {
				if(!$this->db->verifyUser($un, $pw)){
					$this->db->get_dbHook()->close();
					$this->writeErrMsg("Could not verify Login Information");
					return false;
				} else { // user is verified - There auth is good
					// Set Session vars and current user //
					$this->writeSuccessMsg("Successful Login");
					$_SESSION['username'] = $un;
					// $this->db->get_dbHook()->close();
					$this->db->disconnect();
					return true;
				}
			}
		}
	}

	/**
	 * Writes a message to the current View
	 */
	public function writeErrMsg($msg) {
		print "<p style='color:red'>Error: " . $msg . "</p>";
	}
	public function writeSuccessMsg($msg) {
		print "<p style='color:green'>Success: " . $msg . "</p>";
	}



 // Q How to handle closing the $db connection whenuser if finished
 // Maybe, I open it, do what I need to do, and then close it right away?
}

?>
