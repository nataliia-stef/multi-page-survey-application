<?php

/* Author: Nataliia Stefurak
Student ID: 0801536
Assignment: Project 1 - Multi-page Survey Application
Purpose of the code:  ask user some questions and validate answers (display errors), next page cannot be accessed unless all fields are valid. */

//start session
session_start();

//include functions page
require_once ('includes/functions.php');

//if the user refreshes the page, he will get the same page
//if the user leaves the app he will be redirected to the exact page he was at last before he navigated away from the app
//user won't proceed to the next page without clicking 'NEXT'
//In this case we set Session['page'] to 1 (current page), so the user cannot access other pages unless the PREVIOUS/NEXT button was clicked
if(isset($_POST['start_button'])){
    $_SESSION['page'] = 1;
}

//go back to the index page if you haven't clicked BEGIN button yet
if(!isset($_SESSION['page'])){
    header('Location:index.php');
}else if($_SESSION['page'] !=1){
    header('Location:page_'.$_SESSION['page'].'.php');
}

//When the user clicks the previous button - destroy $_SESSION['page'] and redirect him to index
if(isset($_POST['previous'])){
    unset($_SESSION['page']);
    header('Location:index.php');
}
?>

<?php include 'includes/header.php' ?>


<?php
//if the user has already entered some values - redisplay them again
function main_form($fullName, $age, $student){ ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h4 class="text-center headings">Page 1 of the Survey</h4>
            <br>
            <form  action="" method="post">
                <div class="form-group">
                    <label for="fullName">Full Name <span class="asterisk">*</span></label>
                    <input class="form-control" type="text" name="fullName" placeholder="Full Name" value="<?php if(isset($_SESSION['fullName'])){echo $_SESSION['fullName'];}else{echo $fullName;}; ?>">
                </div>

                <div class="form-group">
                    <label for="username">Your Age <span class="asterisk">*</span></label>
                    <input class="form-control" type="text" name="age" placeholder="Your Age" value="<?php if(isset($_SESSION['age'])){echo $_SESSION['age'];}else{echo $age;};?>">
                </div>

                 <!--  Dropdown for student category-->
                <div class="form-group">
                    <label for="student">Are you a student? <span class="asterisk">*</span></label>
                    <select class="form-control" name="student">
                        <option value="0"></option>
                        <option value="1" <?php if ($student == 1) echo "selected='selected'";?> >Yes, Full Time</option>
                        <option value="2" <?php if ($student == 2) echo "selected='selected'";?> >Yes, Part Time</option>
                        <option value="3" <?php if ($student == 3) echo "selected='selected'";?> >No</option>
                    </select>
                </div>

                <input type="submit" name="previous" class="btn btn-default" value="Main Page" />
                <input class="btn btn-info" type="submit" name="next" value="Next">
            </form>
        </div>
    </div>
</div>

<?php
//include html footer
include 'includes/footer.php' ?>
<?php } ?>

<?php

//FORM VALIDATION, if there are errors - display them, otherwise - proceed to the next page
if (isset($_POST['next'])){
    $error_msg = validate_fields();
    if (count($error_msg) > 0){
        display_error($error_msg);
        main_form($_POST['fullName'], $_POST['age'], $_POST['student']);
    } else {
        save_data();
    }
} else {
    main_form("", "", "");
}

//validation for all fields
function validate_fields(){
    $error_msg = array();
    //full Name field
    if (!isset($_POST['fullName'])) {
        $error_msg[] = "The Full Name field not defined";
    } else if (isset($_POST['fullName'])) {
        $fullName = trim($_POST['fullName']);
        if (empty($fullName)) {
            $error_msg[] = "Please enter your Full Name";
        }
    }

    //Age field
    if (!isset($_POST['age'])) {
        $error_msg[] = "The Age field not defined";
    } else if (isset($_POST['age'])) {
        $age = trim($_POST['age']);
        if (empty($age)) {
            $error_msg[] = "Please enter your Age";
        } else if(!is_numeric($age)){
            $error_msg[] = "The Age field must contain numbers";
        }
    }

    //Student category field
    if(isset($_REQUEST['student']) && $_REQUEST['student'] == '0') {
        $error_msg[] = "Please select your Student Category";
    }

    return $error_msg;
}

//save all entered data to the Session variables and proceed to the next page
function save_data(){
    //save data after validation
    $_SESSION['fullName'] = $_POST['fullName'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['student'] = $_POST['student'];
    $_SESSION['page'] = 2; //now you can go to the next page
    header('Location:page_2.php');
}

?>
                    
