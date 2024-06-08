<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
            }
        ?>

        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Current Password: </td>
                <td>
                    <input type="password" name="current_password" placeholder="Current Password">
                </td>
            </tr>

            <tr>
                <td>New Password: </td>
                <td>
                    <input type="password" name="new_password" placeholder="New Password">
                </td>
            </tr>

            <tr>
                <td>Confirm Password: </td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                </td>
            </tr>

        </table>
        </form>
    </div>
</div>

<?php
     // check whether the submit button is clicked or not
     if (isset($_POST['submit'])) {
        //  echo "Clicked";

        // 1.Get the data from form
        $id=$_POST['id'];
        $current_password=md5($_POST['current_pssword']);
        $new_password=md5($_POST['new_pssword']);
        $confirm_password=md5($_POST['confirm_pssword']);


        // 2.check whether the user with current Id and current Password Exists or not
        $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        // Execute the query
        $res=mysqli_query($conn,$sql);

        if ($res==true) {
            // check whether the data is available or not
            $count=mysqli_num_rows($res);
            if ($count==1) {
                // User Exists and password can be changed
                // echo "User Found";
                // check whether the new password and confirmed password is match or not

                if ($new_password==$confirm_password) {
                    // Update the password
                    $sql2="UPDATE tbl_admin SET
                    password='$new_password'
                    WHERE id=$id
                    
                    ";
                    // Execute the query

                    $res2=mysqli_query($conn,$sql2);

                    // check whether the query is executed or not

                    if ($res2==true) {
                        // display success massage
                        $_SESSION['change-pwd']=" <div class='success'> Password Changed Successfully.</div>";
                
                        // redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }else{
                        // display error massage
                        // display success massage
                        $_SESSION['change-pwd']=" <div class='error'> Failed to Change Password.</div>";
                
                        // redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');

                    }

                }else{
                    // redirect to manage admin page with error massage
                    $_SESSION['pwd-not-match']=" <div class='error'> Password did not match.</div>";
                
                    // redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }else{
                //User does not exist Set massage and redirect
                $_SESSION['user-not-found']=" <div class='error'> User Not Found.</div>";
                
                // redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }

        // 3.Check whether the new password and confirmed password match or not 

        // 4.Change password if all above is true
     }

?>

<?php include('partials/footer.php'); ?>