<?php
/* Author: Nataliia Stefurak
Student ID: 0801536
Assignment: Project 1 - Multi-page Survey Application
Purpose of the code:  ask user next set of questions and validate answers (display errors), next page cannot be accessed unless all fields are valid. */

//start session
session_start();

//include functions page
require_once ('includes/functions.php');

//if the user refreshes the page, he will get the same page
//if the user leaves the app he will be redirected to the exact page he was at last before he navigated away from the app
//user won't proceed to the next page without clicking 'NEXT'
//On the previous page after validation we set Session['page'] to 2 (current page), so the user cannot access other pages unless the PREVIOUS/NEXT button was clicked
if(!isset($_SESSION['page'])){
    header('Location:index.php');
}else if($_SESSION['page'] !=2 ){
    header('Location:page_'.$_SESSION['page'].'.php');
}

//When the user clicks the previous button - change $_SESSION['page'] to 1, so now he can access page_1.php
if(isset($_POST['previous'])){
    $_SESSION['page'] = 1;
    header('Location:page_1.php');
}
?>

<?php

//FORM VALIDATION, if there are errors - display them, otherwise - proceed to the next page
if (isset($_POST['next'])){
    $error_msg = validate_fields();
    if (count($error_msg) > 0) {
        display_error($error_msg);
        if(isset($_POST['howPurchased'])) {
              main_form($_POST['howPurchased']);
        }else {
            main_form("");
        }
    }else {
        if (!empty($_POST['purchases']) && !empty($_POST['howPurchased'])) {
            save_data();
        }
    }
} else {
    main_form("");
}
 ?>

<?php
//include html header
include 'includes/header.php' ?>

<?php
//if the user has already entered some values - redisplay them again
//NOTE: HERE I DIDN'T DO IT FOR THE CHECKBOXES, ONLY FOR RADIO
function main_form($howPurchased){ ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form action="" method="post">
                <h4 class="text-center headings">Page 2 of the Survey</h4>
                <br>

                <!-- Radio-->
                <div class="form-group">
                    <label>How did you complete your purchase? <span class="asterisk">*</span></label>
                    <div class="form-check">
                        <label class="radio-inline control-label">
                            <input class="form-check-input" type="radio" name="howPurchased" value="1" <?php if ($howPurchased == 1) echo "checked='checked'";?> >
                        Online
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <label class="radio-inline control-label">
                            <input class="form-check-input" type="radio" name="howPurchased" value="2" <?php if ($howPurchased == 2) echo "checked='checked'";?> >
                        By phone
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <label class="radio-inline control-label">
                            <input class="form-check-input" type="radio" name="howPurchased" value="3" <?php if ($howPurchased == 3) echo "checked='checked'";?> >
                        Mobile App
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="radio-inline control-label">
                            <input class="form-check-input" type="radio" name="howPurchased" value="4" <?php if ($howPurchased == 4) echo "checked='checked'";?> >
                        In store
                        </label>
                    </div>
                </div>


                <!-- Checkbox-->
                <div class="form-group">
                    <label>Which of the following did you purchase? <span class="asterisk">*</span></label>
                    <div class="form-check ">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="purchases[]" value="Phone" >
                        Phone
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="purchases[]" value="SmartTV">
                        Smart TV
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="purchases[]" value="Laptop">
                        Laptop
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="purchases[]"  value="Tablet">
                        Tablet
                        </label>
                  </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="purchases[]" value="HomeTheater">
                         Home Theater
                        </label>
                    </div>
                </div>

                <input type="submit" name="previous" class="btn btn-default" value="Previous" />
                <input type="submit" name="next" class="btn btn-info" value="Next" />
            </form>
        </div>
    </div>
</div>
    
<?php
//include html footer
include 'includes/footer.php' ?>
<?php } ?>

<?php

//validation for all fields
function validate_fields(){
    $error_msg = array();
    //purchases field
    if(empty($_POST['purchases'])) {
       $error_msg[] = "You didn't select any products";
    }

    //howPurchased field
    if(!isset($_POST['howPurchased'])){
        $error_msg[] = "You didn't select how the product was purchased";
    }

    return $error_msg;
}

//save all entered data to the Session variables and proceed to the next page
function save_data() {
    $_SESSION['howPurchased'] = $_POST['howPurchased'];
    $_SESSION['purchases'] = $_POST['purchases'];
    $_SESSION['page'] = 3;
    header('Location:page_3.php');
}
?>
