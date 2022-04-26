<?php
session_start();
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
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            // $result = mysqli_query($conn, $sql);
            while($row = $result->fetch_assoc()){
                $_SESSION['user']['id'] = $row['id'];
                
            }
            if(mysqli_num_rows($result)===1){
                header("location: product.php");
            }else{
                $error = ['error'=> 'Incorrect username or password '];
            }
        }
    }
