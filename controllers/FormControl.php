<?PHP

 /**
* 
*/
abstract class FormControl
{
	protected $db;

	function __construct()
	{
		$this->db = new DBConnection();
	}

	public abstract function hello();

	/**
	 * Call connect on db hook - Sets DBConn->db to an opeen mysqli connection
	 * @return [type] [description]
	 */
	public function connect() {
		$this->db->connect();
	}
}
?>