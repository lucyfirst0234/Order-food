<?php 

    //Authorlization - Access Control
    //Check whether the user is logged in or not
    if(!isset($_SESSION['user'])) //if user session is not set
    {
        //user is not logged in
        //Redirect to login page with message
        $_SESSION['no-login-message']= "<div class ='error text-center'> Please login to access Admin Panel.</div>";
        //redirect
        header('location:'.SITEURL.'admin/login.php'); 
    }
?>