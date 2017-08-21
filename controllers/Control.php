<?PHP

 /**
* 
*/
abstract class Control
{
	public $db;

	function __construct()
	{
		$this->db = new DBConnection();
	}

	/**
	 * Call connect on db hook - Sets DBConn->db to an opeen mysqli connection
	 */
	public function connect() {
		return $this->db->connect();
	}
}
?>