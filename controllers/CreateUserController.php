<?PHP

/**
* CreateUserController
*/
class CreateUserController extends Control
{
	
	function __construct()
	{
		parent::__construct();
		# code...
	}


	public function validate($un, $pw, $em) {
		if ( $un == null || $pw == null || $em == null) {
			return false; // for null args
		} 
		if ( trim($un) == "" || trim($pw) == "" || trim($em) == "") {
			return false; // for empty args
		}
		if ( strlen($un) > 45 || strlen($em) > 60 || strlen($pw) > 45 ) {
			return false; // for too long args
		}
		return true;
	}

	/**
	 * Create a new user account in the DB
	 * Assumes that the input hs been validated
	 *
	 * This method really belongs on the CreateAccountController
	 */
	public function createUserAccount($un, $pw, $em) {
		// if($this->connect()) {
		// 	print "True";
		// } else print "False";

		if (!$this->validate($un, $pw, $em)) {
			return -1; // -1 for null or blank values
		}

		else {

			// validate un
			// if(!preg_match("/^[a-zA-Z0-9'-.@_]{8,}$/", $un) {

			// }

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
					return -2; // -2 for db connection error;
				}
					
				else {
					// check if there are any rows, if yes, un is already in use
					if($rs->num_rows > 0) {
						
						echo "<h3>Username is already in use</h3>";
						return -3; // -3 for name in use
						
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
							return true;
						}
					}
				} // else 
			} else {print "<h3>db is null 96</h3>";}
		} // else
	} // createUserAccount

}
?>