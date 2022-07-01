<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <?php 
            //Check whether id is set or not
            if (isset($_GET['id']))
            {
                //Get the ID and all other details
                //echo "Getting the Data";
                $id = $_GET['id'];
                //create SQL Query to get all other details
                $sql2 = "SELECT * FROM tbl_food WHERE id =$id";

                $res2 = mysqli_query($conn, $sql2);
                //Count the Rows to check whether the id is valid or not
               

            
                    //Get all the data
                $row2 = mysqli_fetch_assoc($res2);
                    
                $title = $row2['title'];
                $description = $row2['description'];
                $price = $row2['price'];
                $current_image = $row2['image_name'];
                $current_category = $row2['category_id']; 
                $featured = $row2['featured'];
                $active = $row2['active'];
                
            }
            
            else{
                //redirect
                header('location:'.SITEURL.'admin/manage-food.php');
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
                    <td>Description</td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5"><?php echo $description ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name ="price" value="<?php echo $price ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php  
                            if($current_image !="")
                            {
                                //Display the image
                                ?>
                                <img src ="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>"width="150px">;
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
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            
                            <?php 
                                //create PHP code to display category
                                //1 create SQL to get all active categories from database
                                $sql ="SELECT * FROM tbl_category WHERE active ='Yes'";
                                
                                //execute
                                $res = mysqli_query($conn, $sql);
                                //count Rows to check whether we have categiries or not
                                $count = mysqli_num_rows($res);

                                //If count is greater than zero, we have category else we do not
                                if($count>0)
                                {
                                    // we have categories
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        //get the detail
                                        $category_id = $row['id'];
                                        $category_title = $row['title'];
                                        ?>
                                            <option <?php if($current_category==$category_id){echo "Selected";}?> value="<?php echo $category_id; ?>"><?php echo $category_title ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //we do not
                                    ?>
                                    <option value="0"> No category found</option>
                                    <?php
                                }
                            ?>
                        
                        
                            
                        </select>
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
                        
                        <input <?php if($active =="No"){echo "checked";} ?> type="radio" name ="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name= "id" value ="<?php echo $id; ?>">
                        <input type="hidden" name= "current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name= "submit" value="Update Food" class= "btn-secondary">
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
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
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
                        $image_name = "Food_Name-".rand(0000,9999).'.'.$ext; //e.g Food_catagory_452

                        


                        $source_path = $_FILES['image']['tmp_name'];
                        
                        $destination_path = "../images/food/".$image_name;

                        //Upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whether the image is uploaded or not
                        //And if the image is not uploaded then we will stop the process
                        if($upload == false)
                        {
                            //SET message
                            $_SESSION['upload'] = "<div class = 'error'>Fail to Upload Image.</div>";
                            //Redirect
                            header('locaion:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die(); 
                        }

                        //B. remove the current image if available
                        if($current_image !="")
                        {
                            $remove_path = "../images/food/".$current_image;
                        
                            $remove = unlink($remove_path);

                            //Check whether the image is removed or not
                            //If failed to remove then Display message and stop

                            if($remove==false)
                            {
                                //Fail to remove
                                $_SESSION['failed-remove'] = "<div class = 'error'>Fail to Remove Image.</div>";
                                header('locaion:'.SITEURL.'admin/manage-food.php');
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
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";

                $res3 = mysqli_query($conn, $sql3);

                //4 Redirect to manage
                //Check whether execute or not
                if($res3 == true)
                {
                    //Category Update
                    $_SESSION ['update'] = "<div class = 'success'>Updated Sucessfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to update
                    $_SESSION ['update'] = "<div class= 'error'>Failed to Updated</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }
        ?>
    </div>
</div>
<?php include('partials/footer.php') ?>