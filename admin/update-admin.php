<?php include('partials/menu.php'); ?>

<div class="=main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php 
            //1.get the id of selected admin
            $id=$_GET['id'];

            //2.create sql query to get the details
            $sql= "SELECT * FROM tbl_admin WHERE id=$id";

            //execute the query
            $res=mysqli_query($conn, $sql);
            
            //check whether the query is executed or not
            if($res==true)
            {
                //check whether the data is available or not
                $count = mysqli_num_rows($res);
                //check whether we have admin data or not
                if($count==1)
                {
                    //get the details
                    //echo "Admin Available";
                    $row=mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $user_name = $row['user_name'];
                }
                else
                {
                    //redirect to manage admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        ?>

        <form action="" method="POST">

            <table>
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="user_name" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
                
            </table>
        </form>
    </div>
</div>


<?php 

    //check whether th e submit the button is clicked or not
    if(isset($_POST['submit'])) 
    {
        //echo "Button Clicked";
        //get all values from form to update
        $id = $_POSt['id'];
        $full_name = $_POST['full_name'];
        $user_name = $_POST['user_name'];

        //create a sql query to update admin
        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        user_name = '$user_name' 
        WHERE id = '$id'
        ";

        //execute the query
        $res= mysqli_query($conn, $sql);

        //check whether the query executed successfully or not
        if($res==true)
        {
            //query executed and admin updated
            $_SESSION['update'] = "<div class='success'>Admin updated Successfully.</div>";
            //redirect to manage admin page
            header('location:'.SITEURL.'admin/manage0-admin.php');
        }
        else
        {
            //failed to update admin
            $_SESSION['update'] = "<div class='error'>Failed to Delete Admin.</div>";
            //redirect to manage admin page
            header('location:'.SITEURL.'admin/manage0-admin.php');
        }
    }

?>

<?php include('partials/footer.php'); ?>