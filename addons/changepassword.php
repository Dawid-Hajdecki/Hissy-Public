<?php
session_start();
if(isset($_POST['password-submit'])) {
    require 'database.php';

    $ppsw = $_POST['Opsw'];
    $npsw = $_POST['Npsw'];
    $usersID = $_SESSION['usersID'];

    if(empty($ppsw) || empty($npsw)){
        header("location: ../index.php?error-emptyinput");
        exit();
    }else{
        $sql = "SELECT * FROM users WHERE usersID=?";
        $statement = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($statement,$sql)){
            header("location: ../index.php?error-sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($statement,"s", $usersID);
            mysqli_stmt_execute($statement);
            $results = mysqli_stmt_get_result($statement);
            if($row = mysqli_fetch_assoc($results)){
                $pswCheck = password_verify($ppsw,$row['usersPsw']);
                if($pswCheck == false){
                    header("location: ../index.php?error-wrongpassword");
                    exit();
                }else if($pswCheck == true){
                    $sql = "UPDATE users SET usersPsw=? WHERE usersID=?";
                    $statement = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($statement, $sql)){
                        header("location: ../index.php?error=sqlerror");
                        exit();
                    }else{
                        $hashedPsw = password_hash($npsw, PASSWORD_DEFAULT);

                        mysqli_stmt_bind_param($statement, "ss",$hashedPsw, $usersID);
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
