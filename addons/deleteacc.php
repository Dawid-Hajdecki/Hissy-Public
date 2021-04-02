<?php
session_start();
if(isset($_POST['delete-account-submit'])) {
    require 'database.php';

    $mem = $_POST['mWord'];
    $psw = $_POST['psw'];
    $usersID = $_SESSION['usersID'];

    if(empty($mem) || empty($psw)){
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
                $pswCheck = password_verify($psw,$row['usersPsw']);
                $memCheck = $row['usersMem'];
                if($pswCheck == false && $memCheck != $mem){
                    header("location: ../index.php?error-wrongdetails");
                    exit();
                }else if($pswCheck == true && $memCheck == $mem){
                    $sql = "DELETE FROM users WHERE usersID=?";
                    $statement = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($statement, $sql)){
                        header("location: ../index.php?error=sqlerror");
                        exit();
                    }else{
                        mysqli_stmt_bind_param($statement, "s", $usersID);
                        mysqli_stmt_execute($statement);
                        session_unset();
                        session_destroy();
                        header("location: ../index.php?account=deleted");
                        exit();
                    }
                }else{
                    header("location: ../index.php?error-wrongdetails");
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
