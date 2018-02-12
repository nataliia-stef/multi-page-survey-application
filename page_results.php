<?php
/* Author: Nataliia Stefurak
Student ID: 0801536
Assignment: Project 1 - Multi-page Survey Application
Purpose of the code: display all the values collected on Page 1,2,3 in a table with Session variables.
                     for each product selected on Page 2 there will be a satisfaction rating and recommendation placed in one row near the product*/

//start session
session_start();

//if the user refreshes the page, he will get the same page
//if the user leaves the app he will be redirected to the exact page he was at last before he navigated away from the app
//On the previous page after validation we set Session['page'] to 'results' (current page), so the user cannot access other pages unless the PREVIOUS button was clicked
if(!isset($_SESSION['page'])){
    header('Location:index.php');
} else if ($_SESSION['page'] !='results' ){
    header('Location:page_'.$_SESSION['page'].'.php');
}

//When the user clicks the previous button - change $_SESSION['page'] to 3, so now he can access page_3.php
if(isset($_POST['previous'])){
    $_SESSION['page'] = 3;
    header('Location:page_3.php');
}
?>

<?php
//include html header
include 'includes/header.php';
require_once ('includes/functions.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-9">
            <h1 class="lead text-success">Thank you for completing our survey!</h1>
            <form action="" method="post">
                <table class="table table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Your Age</th>
                            <th>Are you a student?</th>
                            <th>How did you complete your purchase?</th>
                            <th>What products did you purchase?</th>
                            <th>How happy are you with this device on a scale from 1 (not satisfied) to 5 (very satisfied)?</th>
                            <th>Would you recommend the purchase of this device to a friend?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php if(isset($_SESSION['fullName'])) echo $_SESSION['fullName']?></td>
                            <td><?php if(isset($_SESSION['age'])) echo $_SESSION['age']?></td>
                            <td><?php

                                //display whether a person is a student
                                $studentCategory = $_SESSION['student'];
                                if( $studentCategory == 1){
                                    echo "Yes, Full Time";
                                }else if($studentCategory == 2){
                                    echo "Yes, Part Time";
                                }else if($studentCategory == 3){
                                    echo "No";
                                } ?>
                            </td>
                            <td><?php

                                //display how the products are purchased
                                $howPurchased = $_SESSION['howPurchased'];
                                if($howPurchased == 1){
                                    echo "Online";
                                }else if($howPurchased == 2){
                                    echo "By Phone";
                                }else if($howPurchased == 3){
                                    echo "Mob App";
                                }else if($howPurchased == 4){
                                    echo "In Store";
                                } ?>
                            </td>
                            <td><?php

                                //display what products were purchased
                                $my_final_purchases_arr = $_SESSION['purchases'];

                                //loop through product array and display each product
                                foreach($my_final_purchases_arr as $product){
                                    echo $product ."<br>\n";
                                } ?>
                            </td>
                            <td style="width:200px;"> <?php

                                //display a rating for every product
                                if(isset($_SESSION['product_satisfaction'])){
                                    //Loop through it
                                    foreach($_SESSION['product_satisfaction'] as $product => $product_rating){
                                        echo  $product_rating . '<br>';
                                    }
                                } ?>
                            </td>
                            <td style="width:200px;"> <?php
                                //display whether the product will be recommended
                                 if(isset($_SESSION['product_recommendation'])){
                                   //Loop through it
                                     foreach($_SESSION['product_recommendation'] as $product => $product_recommendation){
                                          echo  $product_recommendation . '<br>';
                                     }
                                 } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <input type="submit" name="previous" class="btn btn-default" value="Previous Page" />
                <input type="submit" name="save" class="btn btn-danger" value="Next" />
            </form>

        </div>
    </div>
</div>

<?php
//include html footer
include 'includes/footer.php';
?>

<?php

//Validate fields on submit. If there are any errors - show them. If there are no errors - proceed to the next page
if(isset($_POST['save'])) {
    $db_conn = dbconnect('localhost', 'survey1user', '!Survey123!', 'survey');
    saveCustomer($db_conn);
    dbdisconnect($db_conn);

    $_SESSION['page'] = 'save';
    header('Location:page_save.php');
}
?>


