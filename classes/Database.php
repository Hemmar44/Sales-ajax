<?php

require_once '/../initialize.php';

class Database {
    
    
    protected $_pdo;
    private $_result;
    private $_count;
    private $_all;
    private $_one;
    private static $_instance = null;


    public function __construct() {
            global $dsn;
            global $opt;
            $this->_pdo = new PDO($dsn, DB_USER, DB_PASS, $opt);
    }
    
    public function selectAll($tableName) {
            //select all elements form database
            $stmt = $this->_pdo->query("SELECT * FROM {$tableName}");
            return $_all = $stmt->fetchAll();
    }
    
    public function selectOne($tableName, $name, $value) {
            //select array of one user by id, nick, email and so on.
            $sql = "SELECT * FROM {$tableName} WHERE {$name} = :{$name}";
            $stmt = $this->_pdo->prepare($sql);
            $stmt->execute([$name => $value]);
            return $_one = $stmt->fetch();
    }

    public function selectLike($tableName, $name, $search) {
            $search = "%$search%";
            $stmt  = $this->_pdo->prepare("SELECT * FROM $tableName WHERE $name LIKE ?");
            $stmt->execute([$search]);
            return $data = $stmt->fetchAll();
    }

    public function selectBetween($tableName, $name, $min, $max) {
            
            $stmt  = $this->_pdo->prepare("SELECT * FROM $tableName WHERE $name BETWEEN ? AND ?");
            $stmt->execute([$min, $max]);
            return $data = $stmt->fetchAll();
    }

    public function selectAndLike($tableName, $strictName, $strict , $searchName, $search) {
            $search = "%$search%";
            $stmt  = $this->_pdo->prepare("SELECT * FROM $tableName WHERE $strictName = ? AND $searchName LIKE ?");
            $stmt->execute([$strict, $search]);
            return $data = $stmt->fetchAll();
    }

    public function selectAndBetween($tableName, $strictName, $strict , $minmaxName, $min, $max) {
            
            $stmt  = $this->_pdo->prepare("SELECT * FROM $tableName WHERE $strictName = ? AND $minmaxName BETWEEN ? AND ?");
            $stmt->execute([$strict, $min, $max]);
            return $data = $stmt->fetchAll();
    }

    public function selectDistinct($tableName, $header) {
            $stmt = $this->_pdo->query("SELECT DISTINCT {$header} FROM {$tableName}");
            return $_all = $stmt->fetchAll();
    }
    
    public function selectOr($tableName, $names = array()) {
            $set = '';
            $x=1;
            //creating name = ? pairs
                foreach($names as $name => $value) {
                $set .= "{$name} = ?";
                //adding comma strings
                if($x < count($names)){
                    $set .= ' OR ';
                }
                $x++;
            }
            $sql = "SELECT * FROM {$tableName} WHERE {$set} ";
            $stmt = $this->_pdo->prepare($sql);
            $stmt->execute(array_values($names));
            return $user = $stmt->fetchAll();
    }
    
    public function selectSingle($tableName, $field, $names = array()) {
            $set = '';
            $x=1;
            //creating name = ? pairs
                foreach($names as $name => $value) {
                $set .= "{$name} = ?";
                //adding comma strings
                if($x < count($names)){
                    $set .= ' OR ';
                }
                $x++;
            }
            $sql = "SELECT $field FROM {$tableName} WHERE {$set} ";
            $stmt = $this->_pdo->prepare($sql);
            $stmt->execute(array_values($names));
            return $user = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function selectSome($tableName, $fields = array(), $names = array()) {
            $fields = implode(", ",  $fields);
            $set = '';
            $x=1;
            //creating name = ? pairs
                foreach($names as $name => $value) {
                $set .= "{$name} = ?";
                //adding comma strings
                if($x < count($names)){
                    $set .= ' OR ';
                }
                $x++;
            }
            $sql = "SELECT $fields FROM {$tableName} WHERE {$set} ";
            $stmt = $this->_pdo->prepare($sql);
            $stmt->execute(array_values($names));
            return $user = $stmt->fetchAll();
    }
    
    public function delete($tableName, $name, $value) {
        //deletes one row by nick, id, email and so on
            $sql = "DELETE FROM {$tableName} WHERE {$name} = :{$name}";
            $stmt = $this->_pdo->prepare($sql);
            $stmt->execute([$name => $value]);
            return $_count = $stmt->rowCount();
    }
    
    public function insert($tableName, $fields=[]){
        //inserts value into table
        //names (fields keys) must equals tables headers
            $names = "(". implode(", ",array_keys($fields)).")";
        //generate proper amount of question marks
            $marks = "(".str_repeat('?, ', count($fields)-1).'?)';
        //takes values of fields
            $values = array_values($fields);
            $sql = "INSERT INTO {$tableName} {$names} VALUES {$marks}";
            $stmt = $this->_pdo->prepare($sql);
            return $stmt->execute($values);

    }
    
    public function update($tableName, $id, $fields=[]) {
           //some variables to start with
            $set = '';
            $x=1;
            //creating name = ? pairs
                foreach($fields as $name => $value) {
                $set .= "{$name} = ?";
                //adding comma strings
                if($x < count($fields)){
                    $set .= ', ';
                }
                $x++;
            }
            //getting values from array
            $values = array_values($fields);
          
           $sql = "UPDATE {$tableName} SET {$set} WHERE id = ?" ;
           $stmt = $this->_pdo->prepare($sql);
           //pushing id on the end to match last quetions mark
           array_push($values, $id);
           //print_r($values);
           $stmt->execute($values);
           return $stmt->rowCount();
        }
        
        public static function getInstance() {
            if(!isset(self::$_instance)){
                self::$_instance = new Database();
            }
            return self::$_instance;
        }
        
       public function submitted() {
       if(isset($_POST["submit"])){
           return true;
       }
       else {
           return false;
       }
   }

    public function checkCompleted() {
        
        if (isset($_POST["completed"])) {

        return "Yes";

        }

        else return "No";

  }
   
       public function filter($param, $filter) {
       return filter_var($param, $filter);
   }
   
   public function selectColumn($tableName, $column) {
            
            $stmt = $this->_pdo->query("SELECT {$column} FROM {$tableName}");
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
   public function selectColumns($tableName, $columns = array()) {
            //select all elements form database
            $stmt = $this->_pdo->query("SELECT {$column} FROM {$tableName}");
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


       
    

}
?>
