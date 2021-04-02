<?php
session_start();
if(isset($_POST['restore-password-submit'])) {
    require 'database.php';

    $mword =    $_POST['mWord'];
    $npsw =     $_POST['Npsw'];
    $email =    $_POST['email'];
    if(empty($mword) || empty($npsw) || empty($email)){
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
                $memCheck = $row['usersMem'];
                if(!$memCheck == $mword){
                    header("location: ../index.php?error-wrongword");
                    exit();
                }else if($memCheck == $mword){
                    $sql = "UPDATE users SET usersPsw=? WHERE usersEmail=?";
                    $statement = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($statement, $sql)){
                        header("location: ../index.php?error=sqlerror");
                        exit();
                    }else{
                        $hashedPsw = password_hash($npsw, PASSWORD_DEFAULT);

                        mysqli_stmt_bind_param($statement, "ss",$hashedPsw, $email);
                        mysqli_stmt_execute($statement);
                        header("location: ../index.php?password=success");
                        exit();
                    }
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
}else{
    header("location: ../index.php");
    exit();
}
