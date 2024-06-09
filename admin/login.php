
<?php  include('../config/constants.php'); ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Delivery System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login">
        <h1 >Login</h1>
        <br><br>

        <?php
            if (isset($_SESSION['login'])) 
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
                
            }
            if (isset($_SESSION['no-login-message'])) {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        
        ?>

        <br><br>

        <!-- Login form starts here -->

        <form action="" method="POST" >
            UserName: <br>
            <input type="text" name="user_name" placeholder="Enter User Name"> <br><br>

            Password: <br>
            <input type="password" name="password" placeholder="Enter Password"> <br><br>


            <input type="submit" name="submit" value="Login" class="btn-primary">
        </form>
        <!-- Login form ends here -->
        <br><br>


        <p>Created by- <a href="#">Web Development group-24</a></p>
    </div>

    
</body>
</html>

<?php
   // check whether the submit button is clicked or not

    if (isset($_POST['submit'])) 
    {
        // Process for login
        // 1. Get the data from login form
        $user_name=$_POST['user_name'];
        $password=md5($_POST['password']);

        // 2.SQL to check whether the user with username and password exist or not
        $sql="SELECT * FROM tbl_admin WHERE user_name='$user_name' AND password='$password'";

        // 3.Execute the query
        $res=mysqli_query($conn,$sql);

        // 4.Count rows to check whether the user exist or not
        $count=mysqli_num_rows($res);

        if ($count==1) {
            // user availble and login success
            $_SESSION['login']="<div class='success'>Login Successful.</div>";
            $_SESSION['user']=$user_name; // to check whether the user is logged in or not and log out will unset it

            // redirect to homepage/dashboard

            header('location:'.SITEURL.'admin/');
            
        }
        else{
            // user not availble here and login failed
            $_SESSION['login']="<div class='error'>Login Failed.User Name or Password did not match.</div>";
            // redirect to homepage/dashboard

            header('location:'.SITEURL.'admin/login.php');
        }
    }

/*

    // Check whether the submit button is clicked or not
    if (isset($_POST['submit'])) 
    {
        // Process for login
        // 1. Get the data from login form
        $user_name = $_POST['user_name'];
        $password = $_POST['password']; // No need to hash the password since we're not verifying it

        // 2. Bypass SQL and login checks
        // Directly set the session variables
        $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
        $_SESSION['user'] = $user_name; // To check whether the user is logged in or not and log out will unset it

        // Redirect to homepage/dashboard
        header('location:'.SITEURL.'admin/');
    }
    else
    {
        // Redirect to login page if submit button was not clicked
        header('location:'.SITEURL.'admin/login.php');
    }


*/


?>