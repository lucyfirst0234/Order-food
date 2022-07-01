<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
            }
        ?>

        <form action = "" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name= "current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type = "password" name = "new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type = "password" name = "confirm_password" placeholder="confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name ="id" value = "<?php echo $id;?>">
                        <input type="submit" name ="submit" value= "Change Password" class ="btn-secondary">
                    </td>
                </tr>

            </table>
            </form>
    </div>
</div>


<?php
    if (isset($_POST['submit']))
    {
        //echo "Clicked";

        //1. Get the Data from form
            $id = $_POST['id'];
            $current_password = md5($_POST['current_password']);
            $new_password = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);
        
        //2. Check whether user with current ID and Password exists or Not
            $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password ='$current_password'";
            //Execute the Query
            $res = mysqli_query($conn, $sql);

            if($res == true)
            {
                $count = mysqli_num_rows($res);

                if($count == 1)
                {
                    //user exists and password can be change
                    //echo "User Found";
                    //check whether the new password and confirm match or not
                    if($new_password==$confirm_password)
                    {
                        //update the password
                        $sql2 = "UPDATE tbl_admin SET
                            password='$new_password'
                            WHERE id = $id
                        ";
                        //execute the query
                        $res2=mysqli_query($conn, $sql2);
                        //Check
                        if($res2==true)
                        {
                            //display message
                            //redirect to manager with error message
                            $_SESSION['change-pwd']="<div class = 'success'>Password change sucessfully. </div>";
                            //redirect the USer
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                        else{
                            //display fail
                            //redirect to manager with error message
                            $_SESSION['change-pwd']="<div class = 'error'>Password change fail. </div>";
                            //redirect the USer
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else{
                        //redirect to manager with error message
                        $_SESSION['pwd-not-match']="<div class = 'error'>Password did not Match. </div>";
                        //redirect the USer
                        header('location:'.SITEURL.'admin/manage-admin.php');

                    }
                }
                else{
                    //user does not exist set message and redirect
                    $_SESSION['user-not-found'] = "<div class = 'error'>User not Found.</div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        //3 Check whether the New Password anf Confirm Password Match or Not

        //4. Change Password if all above is true
    }
?>




<?php include('partials/footer.php') ?>