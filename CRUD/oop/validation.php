<?php
    Class Validation{

        static function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        public static function nameValidation($name){
            if(empty($name)){
                return 'Name field cannot be empty.';
            }else{
                $name = self::test_input($name);
                if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                    return "Only letters and white space allowed.";
                  }
            }
            return '';
        }

        public static function scoreValidation($score){
            if(empty($score)){
                return 'Score field cannot be empty.';
            }else{
                $score = self::test_input($score);
                if ($score < 0 || $score >100) {
                    return "Scores can only be between 0-100.";
                  }
            }
            return '';
        }

        public static function emailValidation($email){
            if(empty($email)){
                return 'Email field cannot be empty.';
            }else{
                $email = self::test_input($email);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return "Invalid email format";
                }
            }
            return '';
        }

        public static function passwordValidation($password){
            if(empty($password)){
                return 'Password field cannot be empty.';
            }else{
                $password = self::test_input($password);
                if (strlen((string)$password) > 16 || strlen((string)$password) < 8){
                    return "Invalid Password length.";
                }
            }
            return '';
        }
    }
?>