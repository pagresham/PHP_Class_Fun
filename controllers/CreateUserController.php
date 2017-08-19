<?PHP

/**
* CreateUserController
*/
class CreateUserController extends Control
{
	
	function __construct()
	{
		# code...
	}

	public function hello() {
		print "<h1>Hello from CC</h1>";
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

}
?>