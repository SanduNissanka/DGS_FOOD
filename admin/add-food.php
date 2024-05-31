<?php include('partials/menu.php'); ?>

<div class="maincontent">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Title of the food:"></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td><textarea name="description"  cols="30" rows="5" placeholder="Description of the food:"></textarea>
                </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category" >

                            <?php
                                // create php code to display categories from database

                                // 1.crate sql to get all active categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                // display on database
                                // executing query
                                $res=mysqli_query($conn,$sql);

                                // count rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                // if count is greater than 0 , we have categories else we dont have categories
                                if ($count>0) {
                                    // we have categories
                                    while ($row=mysqli_fetch_assoc($res)) {
                                        // get the details of categories
                                        $id=$row['id'];
                                        $title=$row['title'];

                                        ?>

                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                    }
                                }
                                else{
                                    // we dont have categories
                                    ?>

                                        <option value="0">No Category Found</option>
                                    <?php

                                }
                            
                            ?>




                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No" >No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No" >No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php

            // check whether the button is clicked or not
            if (isset($_POST['submit'])) {
                // add the food in database
                //echo "Food Added";
                // 1.get the data from form
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $category=$_POST['category'];
                
                // check whether the radio button for featured or active are checked or not

                if (isset($_POST['featured'])) {
                    $featured=$_POST['featured'];
                }
                else{
                    // setting the default value
                    $featured="No";
                }

                if (isset($_POST['active'])) {
                    $active=$_POST['active'];
                }
                else{
                    // setting the default value
                    $active="No";
                }

                //2.upload the image if selected
                // check whether the selected image is clicked or not and upload the image only if the image is selected

                if (isset($_FILES['image']['name'])) {
                    // we will get the details of the selected image
                    $image_name=$_FILES['image']['name'];

                    // check whether the image is selected or not and upload image only if selectd
                    if ($image_name!="") {
                        // image is selectd
                        // A.rename the image

                        // get the extension of the selected image which is like jpg,png,gif etc

                        $ext=end(explode('.',$image_name));

                        // create new name for image
                        $image_name="food-Name".rand(0000,9999).".".$ext;  // new image name may be "food-name-656.jpg"

                        // B.upload the image
                        // get the source path and destiation path

                        // source path is the current location of the image 
                        $src=$_FILES['image']['tmp_name'];

                        // get the destination path for the image to be uploaded
                        $des="../images/foods/".$image_name;

                        // finally upload the food image

                        $upload=move_uploaded_file($src,$des);

                        // check whether the image uploaded or not

                        if ($upload==false) {
                            // failed to upload image

                            // redirect to add food page with error massage
                            $_SESSION['upload']="<div class='error'>Failed To upload image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');

                            // stop the process
                            die();
                        }
                    }
                }
                else{
                    $image_name="";  // setting default value as blank
                }

                //3. insert into database

                // create a sql query to save or add food
                // for numerical value we dont need to pass value inside quotes
                $sql2="INSERT INTO tbl_food SET

                    title='$title',
                    description='$description',
                    price=$price,
                    image_name='$image_name',
                    category_id='$category',
                    featured='$featured',
                    active='$active'
                
                
                ";

                // execute the query
                $res2=mysqli_query($conn,$sql2);

                // check whether data inserted or not
                if ($res2==true) {
                    // data inserted successfully
                    $_SESSION['add']="<div class='success'>Food Added Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else{
                    // failed to insert data
                    $_SESSION['add']="<div class='error'>Failed to add food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

                //4.redirect with message to manage-food page
            }
        
        
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>