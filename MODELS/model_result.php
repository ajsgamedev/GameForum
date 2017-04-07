<?php

$table='users';  //table to insert values into

//INSERT QUERY
//get the values entered in the form
$userName=$conn->real_escape_string($_POST['user_name']);
$email=$conn->real_escape_string($_POST['user_email']);
$pass1=$_POST['user_pass'];
$pass2=$_POST['user_pass_check'];

$msg='';  //this is an empty message initially , it will contain the result of the insertion


/* so, the form has been posted, we'll process the data in three steps:
1.  Check the data
2.  Let the user refill the wrong fields (if necessary)
3.  Save the data
*/
$errors = array(); /* declare the array for later use */

if(isset($_POST['user_name']))
{
//the user name exists
			if (!ctype_alnum($_POST['user_name']))
			{
				$errors[] ='The username can only contain letters and digits.';
			}
			if (strlen($_POST['user_name']) > 30)
			{
				$errors[] ='The username cannot be longer than 30 characters.';

    	}
}
else
{
	$errors[] = 'The username field must not be empty.';
}


if(isset($_POST['user_pass']))
{
	if ($_POST['user_pass'] != $_POST['user_pass_check'])
	{
	$errors[] ='The two passwords did not match.';
	}
}
else
{
	$errors[] ='The password field cannot be empty.';
}

if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
{
$contentStringMAIN= 'Uh-oh.. a couple of fields are not filled in correctly..';
$contentStringMAIN.= '<ul>';
				foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
		{
			$contentStringMAIN.= '<li>'. $value . '</li>'; /* this generates a nice error list */
		}
			$contentStringMAIN.= '</ul>';

			$contentStringMAIN.='<h3>Click <a href="controller_register.php">HERE</a> to register again!</h3>';
}
		else
{
//the form has been posted without, so save it
//notice the use of mysql_real_escape_string, keep everything safe!
$passEncrypt= hash('ripemd160', $pass1);

$sql = "INSERT INTO
				$table(User_Name, User_Pass, User_Email ,User_Date, User_Level)
		VALUES('$userName','$passEncrypt', '$email', NOW(),	0)";

//$result = mysql_query($sql);

if(query($conn,$sql)==1)
{

$contentStringMAIN='';
$contentStringMAIN.='<h2>Successfully registered.</h2> <br>';
$contentStringMAIN.='<p>You can now <a href="controller_login.php">Login</a> and start posting! :-)</p>';

	}
	else
	{
		$contentStringMAIN='';
		$contentStringMAIN.='<h3>Something went wrong while registering. Please try again later.</h3>';
		echo mysql_error(); //debugging purposes, uncomment when needed
	}
}
?>
