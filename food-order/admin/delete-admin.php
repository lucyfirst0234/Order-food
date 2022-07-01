<?php 
    
    //iclude constants.php file here
    include('../config/constants.php');
    
    //1.Get the ID of Admin to be Delete
    $id = $_GET['id'];
    // 2.Create SQL Query to Delete Admin
    
    $sql = "DELETE FROM tbl_admin WHERE id = $id";

    //Excute the Query
    $res = mysqli_query($conn, $sql);
    
    //check whether The query executed successfully or not
    if($res == true)
    {
        //Query ececuted successfully and admin deleted
        //echo "Admin Deleted";
        //Create seesion variable to display message 
        $_SESSION['delete'] = "<div class = 'success'>Admin Delete Successfully.</div>";
        //redirect to manage page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //fail to delete
        //echo "Failed to deleted";
        $_SESSION['delete'] = "<div class = 'error'>Failed to delete Admin. Try again Later!</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //3. Redirect to Manage Admin page with masage (success,fail)
?>