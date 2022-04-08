<?php
include "dbconnect.php";
    if(isset($_POST['uname']) && isset($_POST['pass'])){
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $uname = validate($_POST['uname']);
        $pass = validate($_POST['pass']);
        $error = "";

        if(empty($uname)){
            $error = ['error'=> 'Username is required'];
        }else if(empty($pass)){
            $error = ['error'=> 'Password is required'];
        }else{
            $sql = "SELECT * FROM users WHERE name='$uname' AND password='$pass' ";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result)===1){
                header("location: pagination.php");
            }else{
                $error = ['error'=> 'Incorrect username or password '];
            }
        }
    }
    ?>