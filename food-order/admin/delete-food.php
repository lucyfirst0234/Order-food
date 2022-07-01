<?php  
    //include Constants File
    include('../config/constants.php');
    //echo "Delete Page";
    //check whether id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Get the value and delete
        //echo "Get Value and Delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file is available
        if($image_name !="")
        {
            //image is avalable, so remove it
            $path = "../images/food/".$image_name;
            //remove the image
            $remove = unlink($path);
            //if failed  to remove then add an error message and stop the process
            if($remove==false)
            {
                //set the session message
                $_SESSION['remove']= "<div class = 'error'>Failed to remove food image</div>";
                //redirect
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop the process
                die();
            }
        }
        //Delete from db
        //SQL Query to Delete Data from Db
        $sql = "DELETE FROM tbl_food WHERE id = $id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //Check whether the data is delete from db or not
        if($res==true)
        {
            //Set Suceess mesage and Redirect
            $_SESSION['delete']="<div class = 'success'>Food Deleted Successfully</div>";
            //redirect
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //Set Fail message
            $_SESSION['delete']="<div class = 'error'>Food Deleted Failed</div>";
            //redirect
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        
        

    }
    else
    {
        $_SESSION['unauthorize'] = "<div class = 'error'>Unauthorized Access</div>";
        //redirect to manage food page
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>