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
		parent::__construct();
	}


	/**
	 * Attempts to log in with passed params
	 */
	public function logInUser($un, $pw) {

		if ($un != null && $pw != null && $un != "" && $pw != "") {
			if ($this->validateUserInfo($un, $pw)) {
				s("Successful Login");
				return true;
			}  
		} else e("Please Complete All Required Fields");
		return false;
	}

	/**
	 * logOutUser  
	 */
	public function logOutUser($user) {
		$_SESSION['username'] = "";
	}	

	/**
	 * validateUserInfo - Checks if un is in db, if yes, checks hashed password
	 * @param  $un - un passed in the post array
	 * @param  $pw - pw passed in the post array
	 */
	public function validateUserInfo($un, $pw) {

		$errors = [];
		$un = trim($un);
		$pw = trim($pw);
		if ( $un == "" || $pw == "") {
			$errors['username'] = "Please complete all fields 127";
		}
			
		// Do my form validation here //
		if(!preg_match("/^[a-zA-Z-.@_]{4,}$/", $un) || (strlen($un) > 45)) {
			$errors['username'] = "Invalid username 133";
		}

		if(strlen($pw) > 45) {
			$errors['password'] = "Please enter a valid password 137";
		}

		if(count($errors) > 0) { 
			e(reset($errors));
			return false; 

		} else {
			// go to DB and check creds //
			if (!$this->db->connect()) {
				return false;
			}
			else {
				if(!$this->db->verifyUser($un, $pw)){
					$this->db->disconnect();

					e("Could not verify Login Information");
					return false;
				} else { // user is verified - There auth is good
					// Set Session vars and current user //
					s("Successful Login");
					$_SESSION['username'] = $un;
					$this->db->disconnect();
					return true;
				}
			}
		}
	}
}

?>
