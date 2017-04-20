<?php
//create_cat.php
include 'CONFIG/connection.php';
$table = 'categories';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //the form hasn't been posted yet, display it
  //  include 'FORMS/createCategoryForm.html';
}
else
{
    //the form has been posted, so save it
    $catName = mysql_real_escape_string($_POST['cat_name']);
    $catDes = mysql_real_escape_string($_POST['cat_description']);

    $sql = "INSERT INTO k00223375_gameforum.$table (Name_Cat, Description_Cat)
       VALUES('$catName', '$catDes')";
    $result = mysql_query($sql);
    if(!$result)
    {
        //something went wrong, display the error
        echo 'Error' . mysql_error();
    }
    else
    {
        echo 'New category successfully added.';
    }
}
?>
