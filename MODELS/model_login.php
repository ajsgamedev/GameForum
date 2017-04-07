<?php
//this model:
//-gets the user and shortlife cookie values
//-puts them into a string for display in the view

//initialise session variables
if(!isset($_SESSION['loggedin'])){$_SESSION['loggedin']=0;}
if(!isset($_SESSION['loginAttempts'])){$_SESSION['loginAttempts']=0;}
if(!isset($_SESSION['views'])){$_SESSION['views']=0;}

//template values
$title='LOGIN';
$pageHeading='Example 05 - Login, Password Encrypted in Database';

if ($_SESSION['loggedin']==1){
	//nav section content - logged in user
	$contentStringNAV='<a href="http://php.net/manual/en/book.mysqli.php">MySQLi Manual</a><br>';
	$contentStringNAV.= '<h4>Examples</h4>';
	$contentStringNAV.= '<a href="controller_main.php">HOME</a><br>';
	$contentStringNAV.= '<h4>Restricted</h4>';
	$contentStringNAV.= '<a href="controller_transcript_protected.php">TRANSCRIPT</a><br>';
	$contentStringNAV.= '<a href="controller_login_manager.php">RELOAD</a><br>';
}
else{
	//nav section content - not logged in
	$contentStringNAV='';
	$contentStringNAV.='<h3>NAV SECTION</h3>';
	$contentStringNAV.='<a href="http://php.net/manual/en/book.mysqli.php">MySQLi Manual</a><br>';
	$contentStringNAV.='<h4>Examples</h4>';
	$contentStringNAV.='<a href="controller_main.php">HOME</a></br>';
}

//main section content:
$contentStringMAIN='';
if ($_SESSION['loggedin']==1){
	//main section content - logged in user
	$contentStringMAIN.='<h2>Home Page of '.$_SESSION['firstName'].' '.$_SESSION['lastName'].'</h2>';
$contentStringMAIN.='<p>Welcome '.$_SESSION['firstName'].' to your PRIVATE home page. From here you can access parts of the website that are restricted to logged on users only.  </p>';

//logout form
	$contentStringMAIN.='<form method="post" action="controller_login_manager.php">';
	$contentStringMAIN.='<input name="logout3" type="submit" id="logout3" value="Log Out">';
	$contentStringMAIN.='</form>';

}
else{
	//main section content - user not logged in
	$contentStringMAIN.='<form class="login" method="post" action="controller_login_manager.php">';
	$contentStringMAIN.='	<div>';
	$contentStringMAIN.='		<h2>Lecturer Login Form</h2>';
	$contentStringMAIN.='		<table class="form">';
	$contentStringMAIN.='		<tr><td>';
	$contentStringMAIN.='		<label>';
	$contentStringMAIN.='		<span>Lecturer ID</span><input name="lectID" type="text" >';
	$contentStringMAIN.='		<span>Password</span><input name="lectPass" type="password" >';
	$contentStringMAIN.='		</label>';
	$contentStringMAIN.='		</td></tr>';
	$contentStringMAIN.='		<tr><td>';
	$contentStringMAIN.='		</td></tr>';
	$contentStringMAIN.='		<tr><td>';
	$contentStringMAIN.='		<label>';
	$contentStringMAIN.='		<input name="login" type="submit" id="login" value="Login">';
	$contentStringMAIN.='		</label>';
	$contentStringMAIN.='		</td></tr>';
	$contentStringMAIN.='		</table>';
	$contentStringMAIN.='	</div>';
	$contentStringMAIN.='</form>';
}



//RHS section content
$contentStringRHS='';
$contentStringRHS.='<h4>Login/Session Status</h4>';
if ($_SESSION['loggedin']==1){
	$contentStringRHS.='</br>You are logged in';
	$contentStringRHS.='</br>Nr. of Page Views='.$_SESSION['views'];
}
else{
	$contentStringRHS.='</br>You are not logged in';
	$contentStringRHS.='</br>Nr. of login attempts='.$_SESSION['loginAttempts'];
	$contentStringRHS.='</br>Nr. of Page Views='.$_SESSION['views'];
}


//footer section content
$contentStringFOOTER='';
if (__DEBUG==1) //construct the footer with debug information
	{
		$contentStringFOOTER.= '<footer class="debug">';

		$contentStringFOOTER.=  '<h3>***DEBUG INFORMATION***</h3>';

		$contentStringFOOTER.=  '<h4>$_COOKIE Array</h4>';
		foreach($_COOKIE as $key=>$value){
			$contentStringFOOTER.=  '$_COOKIE[\''.$key."'] = ".$value.'</br>';
		}

		$contentStringFOOTER.=  '<h4>$_SESSION Array</h4>';
		foreach($_SESSION as $key=>$value){
			$contentStringFOOTER.=  '$_SESSION[\''.$key."'] = ".$value.'</br>';
		}

		$contentStringFOOTER.=  '<h4>$_POST Array</h4>';
		foreach($_POST as $key=>$value){
			$contentStringFOOTER.=  '$_POST[\''.$key."'] = ".$value.'</br>';
		}

		if(isset($sql)){
			$contentStringFOOTER.=  '<h4>SQL QUERY</h4>';
			$contentStringFOOTER.= $sql;
		}



		$contentStringFOOTER.=  "</footer>";
	}
else{ //construct the standard footer
	$contentStringFOOTER.='<footer class="copyright">';
	$contentStringFOOTER.= 'Copyright 2017 Gerry Guinane';
	$contentStringFOOTER.= "</footer>";
}
?>
</body>
</html>
