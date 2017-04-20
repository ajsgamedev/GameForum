<?php
//set some application settings
//use a bootstrap template
//is a user logged in
session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){  //user is logged in
	include("MODELS/model_login_home.php");  //the model represents all of the data in our application
	include("VIEWS/view_login_home.php"); //use the bootstrap template for user logged in

}else{//user is not logged in
	include("MODELS/model_home.php");  //the model represents all of the data in our application
	include("VIEWS/view_home.php"); //use the bootstrap template for user NOT logged in
}

?>
