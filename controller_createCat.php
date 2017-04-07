<?php
//set some application settings
//use a bootstrap template
$loggedin=TRUE;  //is a user logged in

if($loggedin){  //user is logged in
	include("MODELS/model_CreateCategory.php");  //the model represents all of the data in our application
	include("VIEWS/view_createCat.php"); //use the bootstrap template for user logged in

}else{//user is not logged in
	include("MODELS/model_home.php");  //the model represents all of the data in our application
	include("VIEWS/view_home.php"); //use the bootstrap template for user NOT logged in
}

?>
