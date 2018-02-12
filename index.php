<?php

/* Author: Nataliia Stefurak
Student ID: 0801536
Assignment: Project 1 - Multi-page Survey Application
Purpose of the code:  introduce the visitor to the survey, after clicking 'begin' the survey will start */

//start session
session_start();

//if the user refreshes the page, he will get the same page
//if the user leaves the app he will be redirected to the exact page he was at last before he navigated away from the app
//user won't proceed to the next page without clicking 'BEGIN SURVEY'
//So if the Session['page'] is already set (means that Start or Next has been clicked before) redirect him to that page number
if(isset($_SESSION['page'])){
    header('Location:page_'.$_SESSION['page'].'.php');
}
?>


<?php
//include html header
include 'includes/header.php' ?>

<div class="container">
        <div class="row">
            <div class="intro-text text-center">
                <form action= "page_1.php" method="post">
                    <h1>Welcome to our Online Survey Application</h1>
                    <p>We are going to ask you some questions in order to help us improve our work! <br>
                    The survey will take no more than 5 minutes.</p>
                    <p>In order to proceed to the next page click the NEXT button. <br>
                    You can always return to the previous page and change the answers by clicking the PREVIOUS button.</p>
                    <p>Required questions are marked by an asterisk (<span class="asterisk">*</span>). Please answer all the questions honestly.</p>
                    <p class="lead">Let's get started! To begin the survey click the button below. </p>
                    <input class="btn btn-primary" type="submit" name="start_button" value="Begin">
                </form>
                <br>
            </div>    
        </div>                         
</div><!-- container -->

<?php
//include html footer
include 'includes/footer.php' ?>
