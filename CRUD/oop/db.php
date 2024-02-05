<?php 

    class DatabaseConnection{
        protected $conn;
        private $hostname =  'localhost';
        private $username = 'root' ;
        private $password = '' ;
        private $database = "php_test_user";

        private $instance = null;

        public function __construct(){
            $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
            if ($this->conn->connect_error) {
                echo 'db Connection Failed: ' . $this->conn->connect_error;
            } 
        }
        public function abortConnection(){
            $this->conn->close();
        }
    }

    class UserCrud extends DatabaseConnection {
       
        public function __construct(){
            parent::__construct();
        }

        public function create($name, $score, $id, $img){
            $sql = "INSERT INTO data(name, score, user_id, img) VALUE('$name', '$score', '$id', '$img')";
            $result = $this->conn->query($sql);
            return $result ? $result : $this->conn->error;
            // $this->abortConnection();
        }

        public function read($id){
            $sql = "SELECT * FROM data WHERE user_id = '$id'";
            $result = $this->conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            // $this->abortConnection();
            return $data;
        }

        public function update($id, $name, $score){
            $sql = "UPDATE data SET name = '$name' ,score = '$score' WHERE id = $id";
            $result = $this->conn->query($sql);
            // $this->abortConnection();
            return $result ? $result : $this->conn->error;
        }

        public function delete($id){
            $sql = "DELETE FROM data WHERE id=$id"; 
            $result = $this->conn->query($sql);
            // $this->abortConnection();
            return $result ? $result : $this->conn->error;
        }
    }
?>