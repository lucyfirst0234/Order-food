<?php include('partials-front/menu.php'); ?>

    <!-- fOOD SEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                //Create SQL to display category from database
                $sql ="SELECT*FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 4";
                //Execute the Query
                $res = mysqli_query($conn, $sql);
                //Count Rows to check whether the category is avalable or not
                $count = mysqli_num_rows($res);
                
                if($count>0)
                {
                    //category is avalable
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">

                                <?php 
                                    //check whether image is avalable or not
                                    if($image_name=="")
                                    {
                                        //display message
                                        echo"<div class ='error'>image not available</div>";
                                    }
                                    else
                                    {
                                        //image Avalable
                                        ?>
                                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>

                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                            </a>
                        <?php
                    }
                }
                else
                {
                    //category not 
                    echo "<div class = 'error'>Category no Added</div>";
                }
            ?>

            

            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
            
                //Getting Foods from Database that are Active and Featured
                //SQL Query
                $sql2 = "SELECT * FROM tbl_food WHERE active ='Yes' AND featured ='Yes' LIMIT 6";

                $res2 = mysqli_query($conn, $sql2);

                $count2 = mysqli_num_rows($res2);

                if($count2 > 0)
                {
                    //category avalable
                    while($row = mysqli_fetch_assoc($res2))
                    {
                        //Get values
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                <?php 
                                    if($image_name=="")
                                    {
                                        //image not have
                                        echo "<div class= 'error'> Image not found</div>";
                                    }
                                    else{
                                        ?>
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>

                                    
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price">$<?php echo $price; ?></p>
                                    <p class="food-detail">
                                       <?php echo $description; ?>
                                    </p>
                                    <br>

                                    <a href="order.html" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>
                            
                        </a>


                        <?php
                    }
                }
                else{
                    echo "<div class= 'error'> Food not found</div>";
                }

            ?>
            
            <div class ="clearfix"></div>

        </div>

        <p class="text-center see-all-food"  >
            <a href="#">See All Foods</a>
        </p>
        
    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>