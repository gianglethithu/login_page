<?php
include "dbconnect.php";
    if(isset($_POST['email']) && isset($_POST['pass'])){
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $email = validate($_POST['email']);
        $pass = validate($_POST['pass']);
        $error = "";

        if(empty($email)){
            $error = ['error'=> 'Email is required'];
        }else if(empty($pass)){
            $error = ['error'=> 'Password is required'];
        }else{
            $sql = "SELECT * FROM employees WHERE email='$email' AND password='$pass' ";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result)===1){
                header("location: product.php");
            }else{
                $error = ['error'=> 'Incorrect username or password '];
            }
        }
    }
