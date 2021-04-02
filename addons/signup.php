<?php
if(isset($_POST['register-submit'])) {

    require 'database.php';

    $email = $_POST['email'];
    $psw = $_POST['psw'];
    $rpsw = $_POST['rpsw'];
    $word = $_POST['word'];

    if(empty($email) || empty($psw) || empty($rpsw) || empty($word)){
        header("location: ../index.php?error=emptyfields");
        exit();
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location: ../index.php?error=invalidinput");
        exit();
    }elseif($psw !== $rpsw){
        header("location: ../index.php?error=wrongpassword");
        exit();
    }else {
        $sql = "SELECT usersEmail From users WHERE usersEmail=?";
        $statement = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($statement, $sql)){
            header("location: ../index.php?error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($statement, "s", $email);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            $resultCheck = mysqli_stmt_num_rows($statement);
            if($resultCheck > 0){
                header("location: ../index.php?error=usertaken");
                exit();
            }else{
                $sql = "INSERT INTO users (usersEmail, usersPsw, usersMem) VALUES (?, ?, ?)";
                $statement = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($statement, $sql)){
                    header("location: ../index.php?error=sqlerror");
                    exit();
                }else{
                    $hashedPsw = password_hash($psw, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($statement, "sss", $email, $hashedPsw, $word);
                    mysqli_stmt_execute($statement);
                    header("location: ../index.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($statement);
    mysqli_close($conn);
}
else{
    header("location: ../index.php");
    exit();
}