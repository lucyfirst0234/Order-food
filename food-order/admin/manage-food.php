<?php include('partials/menu.php'); ?>

<div class ="main-content">
        <div class = "wrapper">
            <h1>Manage Food</h1>
            <br><br>

            <!-- Button to Add Admin -->
            <a href="<?php echo SITEURL; ?>admin/add-food.php" class ="btn-primary">Add Food</a>

            <br> <br> <br>

            <?php 
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['remove']))
                {
                    echo $_SESSION['remove'];
                    unset ($_SESSION['remove']);
                }
                
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset ($_SESSION['delete']);
                }

                if(isset($_SESSION['unauthorize']))
                {
                    echo $_SESSION['unauthorize'];
                    unset ($_SESSION['unauthorize']);
                }
                
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
                
                

               
            ?>
            
            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>

                <?php 
                    //create SQL Query
                    //Query to Get all categories from Database
                $sql = "SELECT * FROM tbl_food";

                //Execute Query
                $res = mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                //create serial variable and asign value as 1
                $sn = 1;

                //Check whether we have data in database or not
                if ($count > 0){
                // We have data
                //get the data and display
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

            ?>
                <tr>
                        <td><?php echo $sn++ ?></td>
                        <td><?php echo $title ?></td>
                        <td>$<?php echo $price ?></td>
                        <td>
                            <?php
                            //check whether image name is avalable or not
                            if ($image_name != "") {
                                //dispaly image
                            ?>

                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px" ;>

                            <?php
                            } else {
                                //display message
                                echo "<div class='error'>image not found</div>";
                            }
                            ?>

                        </td>
                        <td><?php echo $featured ?></td>
                        <td><?php echo $active ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name ;?>" class="btn-danger">Delete Food</a>
                        </td>
                    </tr>

                <?php

                }
            } 
            else {
                //we do not have data
                //we'll display the message inside table
                ?>
                <tr>
                    <td colspan="6">
                        <div class="error">No Food Added.</div>
                    </td>
                </tr>
            <?php
            }
            ?>

               

            </table>
            
            
        </div>
        </div>

<?php include('partials/footer.php') ?> 