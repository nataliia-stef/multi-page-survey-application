<?php

/* Author: Nataliia Stefurak
Student ID: 0801536
Assignment: Project 1 - Multi-page Survey Application
Purpose of the code:  functions page that will be used in the project */


//allow sending multiple headers
ob_start();

//display all the errors
function display_error($error_msg){
   	echo "<div style='position: absolute; top: 5%; left: 50%;'><p class='warning-text'>\n";
   
        foreach($error_msg as $v){
      	  echo $v."<br>\n";
   	 }

         echo "</p></div>\n";
}

//we need this second function otherwise the errors will overlap on the screen
function display_error2($error_msg){
   	echo "<div style='position: absolute; top: 20%; left: 50%;'><p class='warning-text'>\n";
   
        foreach($error_msg as $v){
      	  echo $v."<br>\n";
   	 }

         echo "</p></div>\n";
}


//connection to the database
function dbconnect($host, $user, $pw,  $db){
    $db_conn = new mysqli($host, $user, $pw, $db);
    if ($db_conn->connect_errno) {
        die ("Could not connect to database server".$db_host."\n Error: "
            .$db_conn->connect_errno
            ."\n Report: ".$db_conn->connect_error."\n");
    }
    return $db_conn;
}

//disconnect
function dbdisconnect($db_conn){
    $db_conn->close();
}



//save submitted to the database
function saveCustomer($db_conn) {

    //insert into CUSTOMERS
    $qry_customers = "INSERT INTO customers (cust_full_name, cust_age, cust_stud_type) VALUES (?, ?, ?)";

    $stmt = $db_conn->prepare($qry_customers);
    $stmt->bind_param('sii', $_SESSION['fullName'], $_SESSION['age'],  $_SESSION['student']);
    $stmt->execute();
    $id = $db_conn->insert_id;


    //insert into ORDERS
    $qry_orders  = "INSERT INTO orders (order_cust_id, order_method) VALUES (?, ?)";

    $stmt = $db_conn->prepare($qry_orders);
    $stmt->bind_param('ii', $id , $_SESSION['howPurchased']);
    $stmt->execute();
    $id_order = $db_conn->insert_id;


    //insert into ORDER_DETAILS
    if (isset($_SESSION['purchases'])) {
        $my_final_purchases_arr = $_SESSION['purchases'];
        $prod_satisf_arr = $_SESSION['product_satisfaction'];
        $prod_recommend_arr = $_SESSION['product_recommendation'];

        foreach ($my_final_purchases_arr as $key => $value) {

            $qry_order_details  = "INSERT INTO order_details (order_id, order_product, order_rating, order_recommend) VALUES (?, ?, ?, ?)";

            $name_value = $value;
            $url_value = $prod_satisf_arr[$name_value . '_'. 'satisfaction'];
            $third_value = $prod_recommend_arr[$name_value . '_recommend'];

            $stmt = $db_conn->prepare($qry_order_details);
            $stmt->bind_param('isis', $id_order ,$name_value, $url_value, $third_value );
            $stmt->execute();

        }

    }
}

?>
