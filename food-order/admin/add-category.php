<?php include('partials/menu.php') ?>

<div class="main-content">
    <div  class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br><br>

        <!-- Add category Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select image: </td>
                    <td>
                        <input type="file" name ="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name ="featured" value = "Yes"> Yes
                        <input type="radio" name ="featured" value = "No"> No
                    </td>
                </tr>
            
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name ="active" value = "Yes"> Yes
                        <input type="radio" name ="active" value = "No"> No
                    </td>
                </tr>
            
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value ="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
         <!-- Add category Form End -->

         <?php 
            //check whether the submit Button is Clicked or Not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                
                //1. Get the value from Category Form
                $title = $_POST['title'];

                //For Radio input, we need to check whether the button is selected or not
                if(isset($_POST['featured']))
                {
                    //Get the Value from form
                    $featured = $_POST['featured'];
                }
                else{
                    //Set the default value
                    $featured = "No";
                }
                if(isset($_POST['active']))
                {
                    //Get the Value from form
                    $active = $_POST['active'];
                }
                else{
                    //Set the default value
                    $active = "No";
                }

                //check whether the image is selected or not and set the value for image name accordingly
                //print_r($_FILES['image']);

                //die();
                
                if(isset($_FILES['image']['name']))
                {
                    //upload the image
                    //To upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];
                    
                    //Upload the Image only if image is selected
                    if($image_name != "")
                    {
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
                        //Anf if the image is not uploaded then we will stop the process
                        if($upload == false)
                        {
                            //SET message
                            $_SESSION['upload'] = "<div class = 'error'>Fail tp Upload Image.</div>";
                            //Redirect
                            header('locaion:'.SITEURL.'admin/add-category.php');
                            //stop the process
                            die(); 
                        }
                    }
                }
                else
                {
                    //don't upload and set blank
                    $image_name="";
                }
                //2 Create SQL Query to Insert Category into Database
                $sql = "INSERT INTO tbl_category SET
                    title= '$title',
                    image_name = '$image_name',
                    featured= '$featured',
                    active= '$active'
                ";

                //3 Execute the quryy and save in database
                $res = mysqli_query($conn, $sql);

                //4 Check whether the Query executed or not
                if($res==true)
                {
                    //query executed
                    $_SESSION['add'] = "<div class ='success'>Category Added Successfully</div>";
                    //redirect
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else{
                    //fail to Add category
                    $_SESSION['add'] = "<div class ='error'>Fail to Add</div>";
                    //redirect
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
         ?>

    </div>
</div>

<?php include('partials/footer.php') ?>