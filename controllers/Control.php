<?PHP

 /**
* 
*/
abstract class Control
{
	protected $db;

	function __construct()
	{
		$this->db = new DBConnection();
	}

	public abstract function hello();

	/**
	 * Call connect on db hook - Sets DBConn->db to an opeen mysqli connection
	 */
	public function connect() {
		$this->db->connect();
	}
}
?>