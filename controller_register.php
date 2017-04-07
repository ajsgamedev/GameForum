<?php
//includes
include("CONFIG/connection.php");  //include the database connection
include("CONFIG/config.php");  //include the application configuration settings

//variables
$tab="Register";

//views
if(isset($_POST['btn_register'])){
			//process the registration data
			include("LIBRARY/helperFunctionsDatabase.php");
			include("LIBRARY/helperFunctionsTables.php");
			include("MODELS/model_result.php");
			include("VIEWS/view_register_result.php");

		}
else{
			include("MODELS/model_register.php");
			include("VIEWS/view_register.php");
}
?>
