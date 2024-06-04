<?php  include('partials/menu.php');?>


<div class="main-content">
  <div class="wrapper">
    <h1>Add Admin</h1>
    <br/>
    <br/>

    <?php 
      if(isset($_SESSION['add']))//checking whether the session in set or not
      {
        echo $_SESSION['add'];//Display session message if set
        unset($_SESSION['add']);//Remove session message
      }
    ?>

    <form action="" method="POST">

    <table class="tbl-30">
      <tr>
        <td>Full Name: </td>
        <td><input type="text" name="full_name" placeholder="Enter your name.."></td>
      </tr>

      <tr>
        <td>Username: </td>
        <td><input type="text" name="username" placeholder="Enter your username.."></td>
      </tr>

      <tr>
        <td>Password: </td>
        <td><input type="password" name="password" placeholder="Enter your password.."></td>
      </tr>

      <tr>
        <td colspan="2"><input type="submit" name ="submit" value="Add Admin" class="btn-secondary"></td>
      </tr>

    </table>
    </form>
  </div>

</div>
<?php  include('partials/footer.php');?>

<?php
//Process he value from form and save it in database.
// Check whether te  submit buttun is clicked or not.

if(isset($_POST['submit']))
{
  //Button Clicked
  //Button not clicked
  //1.Get the data from form

  $full_name = $_POST ['full_name'];
  $username=$_POST['username'];
  $password=md5($_POST['password']);// password encryption with MD5

  //2.sql query to save the data in database
  $sql ="INSERT INTO tbl_admin SET
  full_name='$full_name',
  username='$username',
  password='password'";

  //3. Executing query and saving data into database
  $res=mysqli_query($conn,$sql) or die(mysqli_error());


  //4.check whether the(the query is inserted) data is inserted or not display appropriate message
  if($res==TRUE){
    //data inserted
    //echo "Data insereted";
    //create a session variable to display message
    $_SESSION['add']='Admin added successfully';
    // redirect page to manage admin
    header("location:".SITEURL.'admin/manage-admin.php');
  }

  else{
    //failed to insert data
    //echo "Fail to insert data. ";
    //create a session variable to display message
    $_SESSION['add']='Fail to add admin';
    // redirect page to Add Admin page
    header("location:".SITEURL.'admin/add-admin.php');

  }

}





?>