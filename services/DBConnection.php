<?PHP
/**
 * DBConnection - Contains methods for all the DB calls in the login app
 */
class DBConnection {
	private $db_host = "localhost";
	private $db_name = "exampleDB";
	private $db_user = "exampleUser";
	private $db_passwd = "password";

	private $db = null;

	/**
	 * Closes a connection to the DB, and reset this.db to null
	 */
	public function disconnect() {
		mysqli_close($this->db);
		$this->db = null;
	}

	/**
	 * Opens the connection with the DB, and sets $this->db to the connection 
	 */
	public function connect() {
		$con = new mysqli($this->db_host, $this->db_user, $this->db_passwd, $this->db_name);
		
		if ($con) {
			$this->db = $con;
			return true;
		} else {
			$this->writeError($con->connect_error, 43);
			return false;
		}
	}

	/**
	 * Go to the DB, and get the entry with the matching username
	 * If un is in the database, run password_verify()
	 * Method gets called from LC::validateUserInfo()
	 */
	public function verifyUser($un, $pw) {
		$sql = "SELECT user_id, username, password 
				FROM users WHERE
				username = '$un'";
		$rs = $this->db->query($sql);
		if ($rs) {
			if ( $rs->num_rows == 1) { // username is in the db -- check if pw match
				$login_row = mysqli_fetch_assoc($rs);
				if ($login_row) {
					return password_verify($pw, $login_row['password']);
				}
			} 
		} else $this->writeError(mysqli_error($this->db), 68); 
		return false; // username not in db
	}

	/**
	 * Checks if the username is already in the DB
	 */
	public function checkUserPresence($un) {
		$sql = "SELECT username FROM users WHERE username = '$un'";
		$rs = $this->db->query($sql);
		if ($rs) {
			if ($rs->num_rows == 0) {
				return true;
			}
		} else writeError($this->db->error, 84);
		return false;
	}

	/**
	 * Adds new user to the DB
	 */
	public function addNewUser($un, $em, $pw) {
		$sql = "INSERT INTO users (username, email, password) 
				VALUES('$un', '$em', '$pw')";
		$rs = $this->db->query($sql);

		if ($rs) {
			return true;
		} else {
			$this->writeError($this->db->error, 93);
			return false;
		}		
	}

	/**
	 * Generic method to record DB error messages to logs/errorLog.txt 
	 * @param  $err - the error to be displayed
	 */
	public function writeError($err, $line) {
		$fp = fopen("logs/errorLog.txt", "a");
		
		if($fp) {
			echo "<p>Check Logs ". $line ."</p>";
			fwrite($fp, "Error:  " . date("m-d-Y h:i:s A") . "  ". $err . "\n\n");	
		} 
	}

}


?>