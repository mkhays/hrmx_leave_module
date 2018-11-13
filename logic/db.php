<?php
class db{
	/**
	 * $pdo
	 *
	 * the PDO object handle
	 *
	 * @access	public
	 */
    private $pdo = null;
  
 	/**
	 * $result
	 *
	 * the query result handle
	 *
	 * @access	private
	 */
    private $result = null;

 	/**
	 * $query_params
	 *
	 * @access	private
	 */
    private $query_params = array('select' => '*');

 	/**
	 * $last_query
	 *
	 * @access	private
	 */
    private $last_query = null;

 	/**
	 * $last_query_type
	 *
	 * @access	private
	 */
    private $last_query_type = null;
  
 	/**
	 * class constructor
	 *
	 * @access	public
	 */
	 	/**
	 * class constructor
	 *
	 * @access	public
	 */
  public function __construct() {
    
   if(!class_exists('PDO',false))
  echo "PHP PDO package is required.";

   $dsn = "mysql:host=localhost;dbname=baylor_hrm;charset=utf8";
     
    /* attempt to instantiate PDO object and database connection */
    try {    
      $this->pdo = new PDO(
        $dsn,
		'hrm_user2',
		'123Hrm123',
        array(PDO::ATTR_PERSISTENT =>true)
        );
      $this->pdo->exec("SET CHARACTER SET utf8"); 
    } catch (PDOException $e) {
        echo sprintf("Can't connect to  database  Error: %s",$e->getMessage());
    }
	
    // make PDO handle errors with exceptions
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
	   
  }
	
	//function to handle insert queries
	public function insert($table, $columns){
		if(empty($table)){
			echo "table empty";
			exit;
			}
		if(empty($columns)||!is_array($columns)){
			echo "colums empty";
			exit;
			}
		$column_names = array_keys($columns);
	   $query = array(sprintf("INSERT INTO `{$table}` (`%s`) VALUES",implode('`,`',$column_names)));
       $fields = array();
       $params = array();
    foreach($columns as $cname => $cvalue)
    {
      if(!empty($cname))
      {
        $fields[] = "?";
        $params[] = $cvalue;
      }
    }
    $query[] = '(' . implode(',',$fields) . ')';
    
    $query = implode(' ',$query);
    
    $this->_query($query,$params);
    return $this->last_insert_id();
		}
// function to do the inserting of data
private function _query($query,$params=null,$return_type = TMVC_SQL_NONE,$fetch_mode=null)
  {
  
    /* if no fetch mode, use default */
    if(!isset($fetch_mode))
      $fetch_mode = PDO::FETCH_OBJ;  
	  
    /* prepare the query */
    try {
      $this->result = $this->pdo->prepare($query);
    } catch (PDOException $e) {
      //  show_error(sprintf("Error: %s Query: %s",$e->getMessage(),$query),'db_error');
        return false;
    }      
    
    /* execute with params */
    try {
      $this->result->execute($params);  
    } catch (PDOException $e) {
      printf("Error: %s Query: %s",$e->getMessage(),$query);
	  exit;
        return false;
    }      
  
    /* get result with fetch mode */
    $this->result->setFetchMode($fetch_mode);  
  
    switch($return_type)
    {
      case TMVC_SQL_INIT:
        return $this->result->fetch();
        break;
      case TMVC_SQL_ALL:
        return $this->result->fetchAll();
        break;
      case TMVC_SQL_NONE:
      default:
        return true;
        break;
    }
    
  }
		/**
	 * last_insert_id
	 *
	 * get last insert id from previous query
	 *
	 * @access	public
	 * @return	int $id
	 */    
  public function last_insert_id()
  {
    return $this->pdo->lastInsertId();
  }
 	/**
	 * query_all
	 *
	 * execute a database query, return all records
	 *
	 * @access	public
	 * @param   array $params an array of query params
	 * @param   int $fetch_mode the fetch formatting mode
	 */    
  public function query($query=null,$params=null,$fetch_mode=null)
  {
    //if(!isset($query))
      //$query = $this->_query_assemble($params,$fetch_mode);
  
    return $this->_query($query,$params,TMVC_SQL_NONE,$fetch_mode);
  }
  
  
   public function result()
  {
    return $this->result->fetchAll();
  }
    
  
	
	
	}
?>