<?php
class DB extends PDO
{
    public $error = false; // выводить сообщения об ошибках на экран? (true/false)
    
    public function __construct($dsn, $username='', $password='', $driver_options=array())
    {
        try {
            parent::__construct($dsn, $username, $password, $driver_options);
                
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('DBStatement', array($this)));
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        } 
        catch(PDOException $e) { 
            echo "UError #1873: Произошла ошибка в работе с базой данных...";
            exit();
        }
    }
    
    public function prepare($sql, $driver_options=array())
    {
        try {
            return parent::prepare($sql, $driver_options);
        } 
        catch(PDOException $e) {
			echo '<pre>'; print_r($sql); echo '</pre>';
            $this->error($e->getMessage());
        }
    }
    
    public function query($sql)
    {
        try {		
            $res = parent::query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $res;
        }
        catch(PDOException $e) { 
			echo '<pre>'; print_r($sql); echo '</pre>';
            $this->error($e->getMessage());
        }
    }   
	
    public function row($sql)
    {
        try {		
            return parent::query($sql)->fetch();
        } 
        catch(PDOException $e) {
			echo '<pre>'; print_r($sql); echo '</pre>';
            $this->error($e->getMessage());
        }
    }
    
    public function exec($sql)
    {
        try {
            $result = parent::exec($sql);
			return array($result);
        } 
        catch(PDOException $e) { 
			echo '<pre>'; print_r($sql); echo '</pre>';
            $this->error($e->getMessage());
        }
    }    
	
    public function query_count($sql)
    {
        try {
            $result = self::query("SELECT COUNT(*) AS count FROM (" . $sql . ")");
			return (int)$result[0]['count'];
        } 
        catch(PDOException $e) {
			echo '<pre>'; print_r($sql); echo '</pre>';
            $this->error($e->getMessage());
        }
    }
    
    public function error($msg)
    {
        if($this->error)
        {
            echo $msg;
        }
        else
        {
            echo "Произошла ошибка в работе с базой данных...";
        }
        
        exit();
    }
	
    public function escape($string)
    {
		return SQLite3::escapeString($string);
    }
}

class DBStatement extends PDOStatement 
{
 protected $DBH;
    
    protected function __construct($DBH) {
 $this->DBH = $DBH;
 }
    
    public function execute($data=array())
    {
        try {
            return parent::execute($data);
        } 
        catch(PDOException $e) {
            $this->DBH->error($e->getMessage());
        }
    }
}


?>
