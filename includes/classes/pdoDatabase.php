<?
/**********************************************************************
pdoDatabase.php
2016-03-01 02:56PM ET
Christopher P. Burton
**********************************************************************/
//error_reporting(-1);
//ini_set('display_errors', 1);
/**********************************************************************
The DB_HOST,DB_USER,DB_PASS & DB_NAME constants are defined elsewhere

Example:
$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$db->query("SELECT * FROM table_1 WHERE ID = :getID");
$db->bind(":getID", $passedVariable, PDO::PARAM_INT);
$db->execute();
$results = $db->resultset();

**********************************************************************/
class pdo_Database{

	private $pdoHost = DB_HOST;
	private $pdoUser = DB_USER;
	private $pdoPass = DB_PASS;
	private $pdoDBName = DB_NAME;

	private $pdoDB;
	private $pdoError;
	private $stmt;

	public function __construct(){
		$dsn = 'mysql:host='.$this->pdoHost.';dbname='.$this->pdoDBName;
		$pdoOptions = array(
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);
		try{
			$this->pdoDB = new PDO($dsn, $this->pdoUser, $this->pdoPass, $pdoOptions);
		}
		catch(PDOException $e){
			$this->pdoError = $e->getMessage();
		}
	}

	public function query($query){
		$this->stmt = $this->pdoDB->prepare($query);
	}

	public function bind($param, $value, $type = null){
		if(is_null($type)){
			switch(true){
				case is_int($value):
					$type = PDO::PARAM_INT;
				break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
				break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
				break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}

	public function execute(){
		return $this->stmt->execute();
	}

	public function resultset(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function rowCount(){
		return $this->stmt->rowCount();
	}

	public function lastInsertId(){
		return $this->pdoDB->lastInsertId();
	}

	public function beginTransaction(){
		return $this->pdoDB->beginTransaction();
	}

	public function endTransaction(){
		return $this->pdoDB->commit();
	}

	public function cancelTransaction(){
		return $this->pdoDB->rollBack();
	}

	public function debugDumpParams(){
		return $this->stmt->debugDumpParams();
	}
}