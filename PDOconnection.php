<?php

class Example
{
    public $PDOcon;

    public function __construct()
    {
        try {
            $db_host = 'localhost';
            $db_name = 'dai';
            $db_user = 'dai';
            $user_pw = 'dai';

            $this->PDOcon = new PDO('mysql:host='.$db_host.'; dbname='.$db_name, $db_user, $user_pw);  
            $this->PDOcon->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->PDOcon->exec("SET CHARACTER SET utf8");
        }
        catch (PDOException $err) {  
            echo "harmless error message if the connection fails";
            $err->getMessage() . "<br/>"; 
            die();
        }
    }

    public function con()
    {
        return $this->PDOcon;
    }

    public function statementCreate(){

       return $this->PDOcon->exec(
            "CREATE TABLE IF NOT EXISTS Employee (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            salary REAL NOT NULL,
            PRIMARY KEY (id))");

    }

    public function insertEmployee($name, $salary){

        $prepare = $this->PDOcon->prepare("INSERT INTO Employee (name, salary) VALUES (?, ?)");
        $prepare->execute(array($name, $salary));
 
        return $this->PDOcon->lastInsertId();
 
    }
 
     public function insertEmployeeBindParam($name, $salary){
 
         $prepare = $this->PDOcon->prepare("INSERT INTO Employee (name, salary) VALUES (?, ?)");
         $prepare->bindParam(1, $name, PDO::PARAM_STR);
         $prepare->bindParam(2, $salary);
         $prepare->execute();
 
         return $this->PDOcon->lastInsertId();
 
     }

   public function statementGetEmployeesData(){
       $result = $this->PDOcon->query("SELECT name, salary FROM Employee");
       $arrayEmployees = $result->fetchAll(PDO::FETCH_ASSOC);

       foreach($arrayEmployees as $employee){
           echo "Name: ".$employee["name"];
           echo "Salary: ".$employee["salary"];
       }
       return $arrayEmployees;
   }


}


?>