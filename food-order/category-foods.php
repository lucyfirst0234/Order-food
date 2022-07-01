<?php include('partials-front/menu.php'); ?>

    <?php 
        // CHeck whether id is passed or not
        if(isset($_GET['category_id']))
        {
            $category_id = $_GET['category_id'];
            // Get the Category Title Based on Category ID
            $sql= "SELECT title FROM tbl_category WHERE id = $category_id";
            // Execute the Query
            $res = mysqli_query($conn, $sql);
            // Get the value from Database
            $row = mysqli_fetch_assoc($res);
            // Get the Title
            $category_title = $row['title'];
        }
        else
        {
            // Category not passed
            // Redirect to Home page
            header('location:'.SITEURL);
        }
  
      // Category id is set and get the id
     
      
    ?>



    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                $sql2 = "SELECT * FROM tbl_food WHERE category_id = $category_id";

                $res2 = mysqli_query($conn, $sql2);

                $count2 = mysqli_num_rows($res2);
                
               
                if($count2 > 0)
                {
                    //food avail
                    while($row2 = mysqli_fetch_assoc($res2))
                    {
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];

                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    if($image_name=="")
                                    {
                                        echo "<div class = 'error'>Image no Avail</div>";
                                    }
                                    else{
                                        ?>
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title ?></h4>
                                <p class="food-price"><?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description ?>
                                </p>
                                <br>

                                <a href="#" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                    <?php
                    }
                    

                }
                else
                {
                    echo "<div class = 'error'>Food not available</div>";
                }
            ?>




            


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>