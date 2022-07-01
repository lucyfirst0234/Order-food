<?php include('../config/constants.php') ?>
<html>
    <head>
        <title>Login = Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    
    <body>

        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']); 
                }
            ?>
            <br><br>

            <!-- Login  Form start here -->
                <form action = "" method="POST" class="text-center">
                Username:<br>
                <input type="text" name = "username" placeholder="Enter Username"><br><br>
                Password:<br>
                <input type="password" name = "password" placeholder="Enter Password"><br><br>

                <input type= "submit" name="submit" value="Login" class="btn-primary">
                <br><br>
                </form>
            <!-- Login Form End here -->

            <p class="text-center"> Created By - <a href="VMH.com">VMH</a></p>

        </div>


    </body>
</html>

<?php 
    //Check whether the submit is Clicked or Not
    if(isset($_POST['submit']))
    {
        //Process for login
        //1. Get data from login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. SQL to check whether the user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password='$password'";
        //3.Execute the Query
        $res = mysqli_query($conn, $sql);
        //4. Count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);
        if($count == 1)
        {
            //user Available
            $_SESSION['login']= "<div class = 'success'>Login successful</div>";
            $_SESSION['user'] = $username; //To check whether the user is logged in or logout will unset

            //redirect
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //user not Available
            //user Available
            $_SESSION['login']= "<div class = 'error text-center'>Login Failed</div>";
            //redirect
            header('location:'.SITEURL.'admin/login.php');
        }



    }
?>