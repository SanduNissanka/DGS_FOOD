<?php

    //Include  constants.php file hera
    include('../config/constants.php');

    //1.get the 10 of Admin to be deleted
    echo $id = $_GET['id'];

    //2.Create SQL Query to Deleta Admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //Execute the query
    $res = mysqli_query($con, $sql);

    //check whether the query executed successfully or not
    if($res==true)
    {
        //Query executed successfully and Admin Deleted
        //echo "Admin Deleted";
        //create session variable to display message
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
        //Redirect to manage Admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //failed to delete admin
        //echo "failed to delete admin"

        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try again Later.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //3.Redirect to Manage Admin page with message (success/error)

?>