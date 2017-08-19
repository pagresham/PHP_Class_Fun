<?PHP

/**
* LoginController
*/
class LoginController extends FormControl
{
	
	// private $db; // handle to DB
	private $currentUser; // is set once a user successfully logs in 


	function __construct()
	{
		// $this->db = new DBConnection();
		parent::__construct();
	}

	public function hello() {
		print "<h1>Hello from LC</h1>";
	}
	// /**
	//  * Call connect on db hook - Sets DBConn->db to an opeen mysqli connection
	//  * @return [type] [description]
	//  */
	// public function connect() {
	// 	$this->db->connect();
	// }

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

	/**
	 * Create a new user account in the DB
	 * Assumes that the input hs been validated
	 *
	 * This method really belongs on the CreateAccountController
	 */
	public function createUserAccount($un, $pw, $em) {
		if ( $un == null || $pw == null || $em == null) {
			return; // handle this better //
		}
		else {
			if ( !$this->db->get_dbHook() == null) {
				// get the hook
				$hook = $this->db->get_dbHook();
				// check if un in already in use //
				$sql = "SELECT username  FROM users
						WHERE username = '$un'";
				
				$rs = $hook->query($sql);
				if (!$rs) {
					print "<h3>Check Logs LC 69</h3>";
					$this->db->writeError($hook->error);
				}
					
				else {
					// check if there are any rows, if yes, un is already in use
					if($rs->num_rows > 0) {
						
						echo "<h3>Username is already in use</h3>";
						
						// err to Client
						
					} else {
						// Go to db with new user info
						$hashedPassword = password_hash($pw, 1);
						$sql = "INSERT INTO users 
								(username, email, password)
								VALUES('$un', '$em', '$hashedPassword')";
						$rs = $hook->query($sql);
						
						if ( !$rs ) {
							print "<h3>Check Logs LC 90</h3>";
							$this->db->writeError($hook->error);
							
						} else {
							// Success message to Client
							print "<h3>Successful added user</h3>";
						}
					}
				} // else 
			} else {print "<h3>db is null 96</h3>";}
		} // else
	} // createUserAccount


	




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