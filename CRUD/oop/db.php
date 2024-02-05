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

        // public function getInstance(){
        //     // if instance exist then return the existing instance 
        //     if (self::$instance == null)
        //     {
        //     self::$instance = new self();
        //     }
        
        //     return self::$instance;
        // }

        // public function getConnection(){
        //     return $this->conn;
        // }

        public function abortConnection(){
            $this->conn->close();
        }
    }

    class UserCrud extends DatabaseConnection {
        // private $conn;
        
        public function __construct(){
            parent::__construct();
        }

        public function create($name, $score, $id){
            $sql = "INSERT INTO data(name, score, user_id) VALUE('$name', '$score', '$id')";
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
                    // format of data array
                    // ([0] => Array
                    //     (
                    //         [id] => 1
                    //         [name] => Sana
                    //         [score] => 50
                    //     )
                    //  [1] => Array
                    //         (
                    //             [id] => 2
                    //             [name] => Fatima
                    //             [score] => 12
                    //         )
                    // );
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
//  on W3Schools, they create for every query a new connection 
// and then close it after use. See here: w3schools.com

// Close the connection when you are done using it for that page. 
// If you have, say, a blog, the button that you use to post 
// it would start the code that would open the connection, do some work with the 
// connection (like adding it to your db and or showing it on a page) 
// and then it would close the connection so that it isn't open any longer than 
// it needs. But when you click the button again it would start the process over, 
// only using resources as it needs them.
?>