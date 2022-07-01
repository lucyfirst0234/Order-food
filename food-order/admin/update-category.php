<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php 
            //Check whether id is set or not
            if (isset($_GET['id']))
            {
                //Get the ID and all other details
                //echo "Getting the Data";
                $id = $_GET['id'];
                //create SQL Query to get all other details
                $sql = "SELECT * FROM tbl_category WHERE id =$id";

                $res = mysqli_query($conn, $sql);
                //Count the Rows to check whether the id is valid or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Get all the data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    //redirect to manage category with seesion message
                    $_SESSION['no-category-found']="<div class = 'error'>Category Not Found</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
            else{
                //redirect
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">    
            
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name ="title" value ="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php  
                            if($current_image != "")
                            {
                                //Display the image
                                ?>
                                <img src ="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>"width="150px">;
                                <?php
                            }
                            else{
                                //Dispaly Message
                                echo"<div class = 'error'>image Not Added</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name ="image">
                    </td>
                </tr>
                
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured =="Yes"){echo "checked";} ?> type="radio" name ="featured" value="Yes">Yes

                        <input <?php if($featured =="No"){echo "checked";} ?> type="radio" name ="featured" value="No">No
                    </td>
                </tr>    
                
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active =="Yes"){echo "checked";} ?> type="radio" name ="active" value="Yes">Yes
                        
                        <input <?php if($active =="No"){echo "checked";}?> type="radio" name ="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type ="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name = "id" value = <?php echo $id; ?> >
                        <input type="submit" name="submit" value="Update Category" class= "btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //1. Get all the values from our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2 Update New image if selected
                //check imageis selectd or not
                if(isset($_FILES['image']['name']))
                {
                    //Get the image detail
                    $image_name = $_FILES['image']['name'];

                    if($image_name != "")
                    {
                        //image available
                        //A. Upload the New image
                        //Auto Rename our image

                        //Get the Extension of image(ipg, png, gif,) e.g "food1.ipg"

                        $ext = end(explode('.', $image_name));

                        //rename the image
                        $image_name = "Food_Category".rand(000,999).'.'.$ext; //e.g Food_catagory_452

                        


                        $source_path = $_FILES['image']['tmp_name'];
                        
                        $destination_path = "../images/category/".$image_name;

                        //Upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whether the image is uploaded or not
                        //And if the image is not uploaded then we will stop the process
                        if($upload == false)
                        {
                            //SET message
                            $_SESSION['upload'] = "<div class = 'error'>Fail to Upload Image.</div>";
                            //Redirect
                            header('locaion:'.SITEURL.'admin/manage-category.php');
                            //stop the process
                            die(); 
                        }

                        //B. remove the current image if available
                        if($current_image !="")
                        {
                            $remove_path = "../images/category/".$current_image;
                        
                            $remove = unlink($remove_path);

                            //Check whether the image is removed or not
                            //If failed to remove then Display message and stop

                            if($remove==false)
                            {
                                //Fail to remove
                                $_SESSION['failed-remove'] = "<div class = 'error'>Fail to Remove Image.</div>";
                                header('locaion:'.SITEURL.'admin/manage-category.php');
                                die();
                            }
                        }
                        
                        

                    }
                    else
                    {
                        $image_name = $current_image;
                    }

                }
                else
                {
                    $image_name = $current_image;
                }

                //3 Update the DB
                $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";

                $res = mysqli_query($conn, $sql2);

                //4 Redirect to manage
                //Check whether execute or not
                if($res == true)
                {
                    //Category Update
                    $_SESSION ['update'] = "<div class = 'success'>Updated Sucessfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to update
                    $_SESSION ['update'] = "<div class = 'error'>Failed to Updated</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
        ?>

    </div>
</div>


<?php include('partials/footer.php') ?>
