<?PHP
/**
 * DBConnection
 * A Service to the Controller 
 */
class DBConnection {
	private $db_host = "localhost";
	private $db_name = "exampleDB";
	private $db_user = "exampleUser";
	private $db_passwd = "password";

	private $db = null;


	/**
	 * Returns the $db that holds the connection to the DB
	 * It is not guaranteed to be not null
	 */
	public function get_dbHook() {
		return $this->db;
	}

	/**
	 * Closes a connection to the DB, and reset this.db to null
	 */
	public function disconnect() {
		// echo "<p>Closing DB connection @DBConnection::disconnect()</p>";
		mysqli_close($this->db);
		$this->db = null;
	}

	/**
	 * Opens the connection with the DB, and sets $db to the connection 
	 */
	public function connect() {
		// Below line, suppresses error messages to client, sql error is written to log instead
		// error_reporting(E_ERROR);
		
		$con = new mysqli($this->db_host, $this->db_user, $this->db_passwd, $this->db_name);
		
		// check if conn isn't  true write errors to a log file //
		if ($con->connect_error) {
			$this->writeError($con->connect_error, 43);
			return false;
		} else {
			// echo "<p>Successful DB connection @ DBConnection::connect()</p>";
			$this->db = $con;
			return true;
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
		
		if (!$rs) {
			$this->writeError(mysqli_error($this->db), 68);
			return false;
		}
		
		else if ( $rs->num_rows == 1) { // username is in the db -- check if pw match

			$login_row = mysqli_fetch_assoc($rs);
			
			if ($login_row) {
				return password_verify($pw, $login_row['password']);
			}
		} 
		else return false; // username not in db
	}

	/**
	 * Generic method to record DB error messages to logs/errorLog.txt 
	 * @param  $err - the error object t be displayed
	 */
	public function writeError($err, $line) {
		echo "<p>Check Logs ". $line ."</p>";
		$fp = fopen("logs/errorLog.txt", "a");
		
		if(!$fp) {
			die("Log file not found");
		} 
		else {
			fwrite($fp, "Error:  " . date("m-d-Y h:i:s A") . "  ". $err . "\n\n");	
		}
	}

}


?>