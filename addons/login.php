<?php

if(isset($_POST['login-submit'])){
    require 'database.php';

    $email = $_POST['email'];
    $psw = $_POST['psw'];

    if(empty($email) || empty($psw)){
        header("location: ../index.php?error-emptyinput");
        exit();
    }else{
        $sql = "SELECT * FROM users WHERE usersEmail=?";
        $statement = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($statement,$sql)){
            header("location: ../index.php?error-sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($statement,"s", $email);
            mysqli_stmt_execute($statement);
            $results = mysqli_stmt_get_result($statement);
            if($row = mysqli_fetch_assoc($results)){
                $pswCheck = password_verify($psw,$row['usersPsw']);
                if($pswCheck == false){
                    header("location: ../index.php?error-wrongpassword");
                    exit();
                }else if($pswCheck == true){
                    session_start();
                    $_SESSION['usersID'] = $row['usersID'];
                    $_SESSION['usersEmail'] = $row['usersEmail'];
                    header("location: ../index.php?success=login");
                    exit();
                }else{
                    header("location: ../index.php?error-wrongpassword");
                    exit();
                }
            }else{
                header("location: ../index.php?error-nouser");
                exit();
            }
        }
    }
}else {
    header("location: ../index.php?login-successful");
    exit();
}