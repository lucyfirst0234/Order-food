<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            
        
        ?>

        <form action ="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name ="title" placeholder="title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="description of the food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name = "price" >
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name = "image">
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
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title ?></option>
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
                                
                                 //2 Display on Dropdown
                                

                            ?>
                        
                            
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value = "Yes">Yes
                        <input type="radio" name="featured" value = "No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value = "Yes">Yes
                        <input type="radio" name="active" value = "No">No
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
        
            //check button
            if(isset($_POST['submit']))
            {
                //Add the Food in Db
                //echo "Click";
                //1. Get the Data from Form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                
                //check whether radio button for feature and active
                if(isset($_POST['featured']))
                {  
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; //Setting the default
                }
                
                if(isset($_POST['active']))
                {  
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; //Setting the default
                }
            
                //2. Upload the image if selected
                //check select image is click and upload only select
                if(isset($_FILES ['image']['name']))
                {
                    //get image detail
                    $image_name = $_FILES['image']['name'];

                    //whther the image the image is selected
                    if($image_name != "")
                    {
                        //image is selected
                        //REname
                        //Get the extension
                        $ext = end(explode('.', $image_name));

                        //rename the image
                        $image_name = "Food-name-".rand(0000,9999).'.'.$ext; //e.g Food_catagory_452

                        


                        $src = $_FILES['image']['tmp_name'];
                        
                        $dst = "../images/food/".$image_name;

                        //Upload the image
                        $upload = move_uploaded_file($src, $dst);
                        
                        //check upload
                        if($upload == false)
                        {
                            //SET message
                            $_SESSION['upload'] = "<div class = 'error'>Fail tp Upload  .</div>";
                            //Redirect
                            header('locaion:'.SITEURL.'admin/add-food.php');
                            //stop the process
                            die(); 
                        }
                        

                        
                    }
                    
                else{
                    $image_name = ""; //setting default as blank
                }

                //3. Insert Into Database
                // create SQL Query
                //For numberiacl do not need to pass value inside '' but for string it is compulsory to add quotes''    
            
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                ";
                $res2 = mysqli_query($conn, $sql2);
                //Check whether execute or not
                //4. Redirect 
                if($res2 == true)
                {
                    //Category Update
                    $_SESSION ['add'] = "<div class = 'success'>Add Sucessfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to update
                    $_SESSION ['add'] = "<div class = 'error'>Failed to Add Food</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                
                }
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php') ?>