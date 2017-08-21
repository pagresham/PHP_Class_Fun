<?PHP
/**
* CreateUserController - Contains method to run the create user dialog 
*/
class CreateUserController extends Control
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Checks all passed vars for empty and null
	 * Check passwords to match
	 */
	public function basicValidation($un, $em, $pw1, $pw2) {
		if ( $un != null && $pw1 != null && $em != null && $pw2 != null) {
			if ( trim($un) != "" && trim($pw1) != "" && trim($em) != "" && trim($pw2) != "") {
				if ( strlen($un) <= 45 && strlen($em) <= 60 && strlen($pw1) <= 45) {
					if ($pw1 == $pw2) {
						return true; // for too long args
					} else eCreate("Passwords do not match");
				} 
			} else eCreate("All fields are required");
		} else eCreate("All fields are required");
		return false;
	}

	/**
	 * Pass values through a regex check
	 */
	public function regexCheck($un, $em, $pw) {
		if(preg_match("/^[a-zA-Z0-9'-.@_]{4,}$/", $un)) {
			if (preg_match("/^[a-zA-Z0-9]{4,}$/", $pw)) {
				if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
					return true;
				} else eCreate("Please enter a valid Email address");
			} else eCreate("Invalid password");
		} else eCreate("Invalid username");
		return false;
	}

	/**
	 * Attempts to create a new user account in the DB
	 */
	public function createUserAccount($un, $em, $pw1, $pw2) {
		
		if($this->connect()) {
			if ($this->basicValidation($un, $em, $pw1, $pw2)) {
			 	if ($this->db->checkUserPresence($un)) {
					if ($this->regexCheck($un, $em, $pw1)) {
						$un = addslashes($un);
						$em = addslashes($em);
						$hashPasswd = password_hash($pw1, 1);

						if ($this->db->addNewUser($un, $em, $hashPasswd)) {
							sCreate("New user successfuly created");
							$this->db->disconnect();
							return true;
						} else eCreate("Error submitting info to DB");
					} 		
				} else eCreate("That Username is already taken");
			} 
		} else eCreate("Database Error");

		$this->db->disconnect();
		return false;
	} // createUserAccount

}
?>