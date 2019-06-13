<?php
    session_start();
    // Create connection
    $con = new mysqli('localhost', 'root', '', 'adminpanel');
    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    } 

    $username = '';
    $pwd = '';
    $flag = '';
    $data = '';
    $del_id='';
    $edit_id='';
    echo '<script>window.alert("'.$_SESSION['username'].'")</script>';
    // if (!empty($_SESSION['username']))
    // {
    //     print_r($_SESSION['username']);
    // }
    if (empty($_SESSION['username']))
    {
       
    if(isset($_POST['username']) && isset($_POST['pwd']) && isset($_POST['flag'])){
        $username = $_POST['username'];
        $pwd = $_POST['pwd'];
        $flag = $_POST['flag'];

        //user login & validate
        switch($flag){
            case 'signin': {// validate user account
                $sql = "SELECT * FROM users WHERE username='$username' AND password=md5('$pwd')";
                $result = $con->query($sql);
                    if($result->num_rows > 0){
                        $row = mysqli_fetch_row($result);
                        echo "<script text='javascript'>console.log('aaa');</script>";
                        $_SESSION['username'] = $row['1'];
                        $_SESSION['authority'] = $row['3'];
                        $msg = 'Login Complete! Thanks';

                        header("Location: dashboard.php"); 
                        exit;
                    }else{
                        $msg = 'Login Failed!<br /> Please make sure that you enter the correct details and that you have activated your account.';
                        header("Location: index.php");
                    }
                break;
            }
            case 'create': {// creating new user
                $sql = "INSERT INTO users (username, password, path) VALUES ('$username', md5('$pwd'), '')";

                if ($con->query($sql) === TRUE) {
                    $msg = "New user created successfully";
                } else {
                    $msg = "Error: " . $sql . "<br>" . $con->error;
                }
                break;
            }
            default: break;
        }
    }

    // delete the user data
    else if(isset($_POST['del_id'])){

        $del_id = $_POST['del_id'];
        $sql = "DELETE FROM users WHERE id='$del_id'";

        if ($con->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $con->error;
        }
    }

    // when clicked the edit button
    else if(isset($_POST['edit_id'])){
        $edit_id = $_POST['edit_id'];
        $sql = "SELECT * FROM users WHERE id='$edit_id'";
        $result = $con->query($sql);
        $row = mysqli_fetch_assoc($result);
        $edit_data =  array();
        array_push($edit_data, $row['id'], $row['username'], $row['password']);
        echo json_encode($edit_data);
    }

    // modified user data saving
    else if(isset($_POST["editid"])) {
        $editid = $_POST['editid'];
        $username = $_POST['username'];
        $pwd = $_POST['pwd'];

        // echo $editid;

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileupload"]["name"]);
        $uploadOk = 1;
        
        // Check if file already exists
        if (file_exists($target_file)) {
            $msg = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileupload"]["size"] > 2000000) {
            $msg = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            $msg = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
                $msg = "The file ". basename( $_FILES["fileupload"]["name"]). " has been uploaded.";
            } else {
                $msg = "Sorry, there was an error uploading your file.";
            }
        }

        $sql = "UPDATE users SET username='$username', password=md5('$pwd'), path='$target_file' WHERE id='$editid'";
        // $sql = "UPDATE users SET username=$username, pwd=md5($pwd) WHERE id='$editid'";

        if ($con->query($sql) === TRUE) {
            $msg = "User data updated successfully";
        } else {
            $msg = "Error updating data: " . $con->error;
        }
    }
    }
  ?>