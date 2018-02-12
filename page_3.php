<?php
/* Author: Nataliia Stefurak
Student ID: 0801536
Assignment: Project 1 - Multi-page Survey Application
Purpose of the code:  generate the page dynamically using input from page 2. Next page can't be accessed unless all fields are valid. */

//start session
session_start();

//include functions page
require_once ('includes/functions.php');

//allow sending multiple headers
ob_start();

//if the user refreshes the page, he will get the same page
//if the user leaves the app he will be redirected to the exact page he was at last before he navigated away from the app
//user won't proceed to the next page without clicking 'NEXT'
//On the previous page after validation we set Session['page'] to 3 (current page), so the user cannot access other pages unless the PREVIOUS/NEXT button was clicked
if(!isset($_SESSION['page'])){
    header('Location:index.php');
} else if ($_SESSION['page'] !=3 ){
    header('Location:page_'.$_SESSION['page'].'.php');
}

//When the user clicks the previous button - change $_SESSION['page'] to 2, so now he can access page_2.php
if(isset($_POST['previous'])){
    $_SESSION['page'] = 2;
    header('Location:page_2.php');
}


//retrieve products what were purchased (page_2) from the session variable
$my_purchases_arr = $_SESSION['purchases'];

//create some arrays to store values from form for every product and for possible errors
$product_satisf_arr  = array();
$product_recommend_arr = array();
$errors_sat = array();
$errors_rec = array();
?>

<?php
//include html header
include 'includes/header.php'?>

<!-- NOTE: HERE (FOR RADIO and DROPDOWN) I DON'T REDISPAY THE VALUES AFTER REFRESHING THE PAGE -->
<!-- NOTE2 : FOR THIS PAGE THE ERRORS DISPLAY AT THE BOTTOM OF THE PAGE -->
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form action="" method="post">
                <h4 class="text-center headings">Page 3 of the Survey</h4>
                <br>
                <?php
                //loop through the my_purchases_arr and redisplay the new form for every product that was chosen on the previous page
                foreach($my_purchases_arr as $product){

                ?>

                <h5 class="headings-page3">Please complete the following questions for the <?php echo $product; ?> you purchased with us:</h5>
                <label>How happy are you with this device on a scale from 1 (not satisfied) to 5 (very satisfied)? <span class="asterisk">*</span></label>

                 <!-- Radio-->
                <div class="form-group">
                     <div class="form-check form-check-inline">
                          <label class="radio-inline control-label">
                              <input class="form-check-input" type="radio" name="<?php echo $product . '_'?>satisfaction" value="1"> 1
                          </label>
                     </div>
                </div>
                <div class="form-group">
                     <div class="form-check inline">
                          <label class="radio-inline control-label">
                              <input class="form-check-input" type="radio" name="<?php echo $product . '_'?>satisfaction" value="2"> 2
                          </label>
                     </div>
                </div>
                <div class="form-group">
                     <div class="form-check form-check-inline">
                           <label class="radio-inline control-label">
                               <input class="form-check-input" type="radio" name="<?php echo $product . '_'?>satisfaction" value="3"> 3
                           </label>
                     </div>
                </div>
                <div class="form-group">
                     <div class="form-check form-check-inline">
                           <label class="radio-inline control-label">
                               <input class="form-check-input" type="radio" name="<?php echo $product . '_'?>satisfaction" value="4"> 4
                           </label>
                     </div>
                </div>
                <div class="form-group">
                     <div class="form-check form-check-inline">
                          <label class="radio-inline control-label">
                              <input class="form-check-input" type="radio" name="<?php echo $product . '_'?>satisfaction" value="5"> 5
                          </label>
                     </div>
                </div>

                <!--  Dropdown-->
                <div class="form-group">
                     <label>Would you recommend the purchase of this device to a friend? <span class="asterisk">*</span></label>
                     <select class="form-control" style="width: 170px;" name="<?php echo $product . '_'?>recommend">
                          <option value="0"></option>
                          <option value="Yes">Yes</option>
                          <option value="No">No</option>
                     </select>
                </div>

                <?php

                //Fill new arrays with values from the form, if there ane empty values, fill the $errors_rec and $errors_sat arrays
                if(isset($_REQUEST[$product . '_' . 'recommend']) && $_REQUEST[$product . '_' . 'recommend'] == '0'){
                     $errors_rec [] = "You didn't give any recommendation for the " . $product;
                } else if (isset($_POST[$product . '_' . 'recommend'])) {
                     $product_recommend_arr[$product . '_' . 'recommend'] = $_POST[$product . '_' . 'recommend'];
                }


                if (isset($_POST[$product . '_' . 'satisfaction'])) {
                     $product_satisf_arr[$product . '_' . 'satisfaction'] = $_POST[$product . '_' . 'satisfaction'];
                } else if (!isset($_POST[$product . '_' . 'satisfaction'])) {
                     $errors_sat[] = "You didn't give any rating for the " . $product;
                }

                ?>

                <?php } //CLOSE FOREACH

                //store arrays in the session variables
                $_SESSION['product_satisfaction'] = "";
                $_SESSION['product_recommendation'] = "";
                $_SESSION['product_satisfaction'] = $product_satisf_arr;
                $_SESSION['product_recommendation'] = $product_recommend_arr;

                ?>
                <input type="submit" name="previous" class="btn btn-default" value="Previous" />
                <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
                <a name="bottomOfPage"></a>
            </form>
        </div>
    </div>
</div>

<?php
//include html footer
include 'includes/footer.php' ?>

<?php

//Validate fields on submit. If there are any errors - show them. If there are no errors - proceed to the next page
if(isset($_POST['submit'])) {
    if(isset($errors_sat) || isset($errors_rec)){
        if(count($errors_sat) !== 0 || count($errors_rec) !== 0) {

            display_error($errors_sat);
            display_error2($errors_rec);
        }else{
            $_SESSION['page'] = 'results';
            header('Location:page_results.php');
            ob_end_flush();
        }
    }
}

?>
