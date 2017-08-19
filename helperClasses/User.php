<?PHP

/**
* User
*/
class User 
{
	private $uname;
	private $email;
	private $password;
	
	
	function __construct($uname, $email, $password)
	{
		$this->uname      = $uname;
		$this->email      = $email;
		$this->password   = $password;
	
	}
	public function getUname() {
		return $this->uname;
	}
	public function getEmail() {
		return $this->email;
	}
	public function getPassword() {
		return $this->password;
	}
	public function hashPassword() {
		return password_hash($this->password, 1);
	}
	public function setPassword($newPassword) {
		$this->password = $newPassword;
	}
}

?>