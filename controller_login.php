<?php
//signin.php
include 'CONFIG/connection.php';
include 'CONFIG/config.php';
session_start();
$table = 'users';

$username =$_POST['user_name'];
$pass1 = $_POST['user_pass'];

//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{
    include 'FORMS/navBarSuccessReg.php';
    echo 'You are already signed in, you can <a href="controller_main.php">sign out</a> if you want.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
      //  include 'FORMS/loginForm.html';
        include 'VIEWS/view_login.php';
    }
    else
    {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */
        $errors = array(); /* declare the array for later use */

        if(!isset($_POST['user_name']))
        {
            $errors[] = 'The username field must not be empty.';
        }

        if(!isset($_POST['user_pass']))
        {
            $errors[] = 'The password field must not be empty.';
        }

        if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
        {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
            {
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
        }
        else
        {
            //the form has been posted without errors, so save it
            //notice the use of mysql_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password

						$HashPassW = hash('ripemd160', $_POST['user_pass']);
            $sql = "SELECT ID_Users, User_Name, User_Level  FROM k00223375_gameforum.$table WHERE User_Name = '$username' AND User_Pass = '$HashPassW'";

            $result = mysql_query($sql);

            if(!$result)
            {
                //something went wrong, display the error
                echo 'Something went wrong while signing in. Please try again later.<br>';
                echo mysql_error(); //debugging purposes, uncomment when needed
            }
            else
            {
                //the query was successfully executed, there are 2 possibilities
                //1. the query returned data, the user can be signed in
                //2. the query returned an empty result set, the credentials were wrong
                if(mysql_num_rows($result) == 0)
                {
                    echo 'You have supplied a wrong user/password combination. Please try again.';
                }
                else
                {
                    //set the $_SESSION['signed_in'] variable to TRUE
                    $_SESSION['loggedin'] = true;

                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
                    while($row = mysql_fetch_assoc($result))
                    {
                        $_SESSION['ID_Users']  = $row['ID_Users'];
                        $_SESSION['User_Name']  = $row['User_Name'];
                        $_SESSION['User_Level'] = $row['User_Level'];
                    }
                    include 'FORMS/navBarSuccessReg.php';

                    echo 'Welcome, ' . $_SESSION['User_Name'] . '. <a href="controller_main.php">Proceed to the forum overview</a>.';
                }
            }
        }
    }
}
?>
