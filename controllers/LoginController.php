<?PHP

/**
* LoginController - Contains methods to run the login user dialog
*/
class LoginController extends Control
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Attempts to log in User - calls validateUserInfo
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
	 * validateUserInfo - Checks if un is in db, if yes, checks hashed password for match
	 * Calls db->verifyUser()
	 */
	public function validateUserInfo($un, $pw) {
		if ($un != null && $pw != null && $un != "" && $pw != "") {
			// go to DB and check creds //
			if ($this->db->connect()) {
				
				if($this->db->verifyUser($un, $pw)) {
					s("Successful Login");
					$_SESSION['username'] = $un;
					$this->db->disconnect();
					return true;

				} else $this->db->disconnect();		
			} 
		}	
		e("Could not verify Login Information");
		return false;
	}

}
?>






