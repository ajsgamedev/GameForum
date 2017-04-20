<?php
//create_cat.php
include 'CONFIG/connection.php';
$table = 'categories';
$table2 = 'topics';
$table3 = 'replies';
echo '<h2>Create a topic</h2>';


if($_SESSION['loggedin'] == FALSE)
{
    //the user is not signed in
    echo 'Sorry, you have to be <a href="/forum/signin.php">signed in</a> to create a topic.';
}
else
{
    //the user is signed in
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        //the form hasn't been posted yet, display it
        //retrieve the categories from the database for use in the dropdown
        $sql = "SELECT
                    ID_Cat,
                    Name_Cat,
                    Description_Cat
                FROM
                    k00223375_gameforum.$table";

        $result = mysql_query($sql);

        if(!$result)
        {
            //the query failed, uh-oh :-(
            echo 'Error while selecting from database. Please try again later.';
        }
        else
        {
            if(mysql_num_rows($result) == 0)
            {
                //there are no categories, so a topic can't be posted
                if($_SESSION['user_level'] == 1)
                {
                    echo 'You have not created categories yet.';
                }
                else
                {
                    echo 'Before you can post a topic, you must wait for an admin to create some categories.';
                }
            }
            else
            {

                echo '<form method="post" action="">
                    Subject: <input type="text" name="topic_subject" />
                    Category:';

                echo '<select name="topic_cat">';
                    while($row = mysql_fetch_assoc($result))
                    {
                        echo '<option value="' . $row['ID_Cat'] . '">' . $row['Name_Cat'] . '</option>';
                    }
                echo '</select><br>';

                echo 'Message: <textarea name="post_content" /></textarea><br>
                    <input type="submit" value="Create topic" />
                 </form>';
            }
        }
    }
    else
    {
        //start the transaction
        $query  = "BEGIN WORK;";
        $result = mysql_query($query);

        if(!$result)
        {
            //Damn! the query failed, quit
            echo 'An error occured while creating your topic. Please try again later.';
        }
        else
        {

            //the form has been posted, so save it
            //insert the topic into the topics table first, then we'll save the post into the posts table
            $topicName = mysql_real_escape_string($_POST['topic_subject']);
            $topicDes = mysql_real_escape_string($_POST['topic_cat']);



            $sql = "INSERT INTO k00223375_gameforum.$table2 (Topic_Subject, Topic_Date, Topic_ID_Cat, Topic_ID_Users)
                   VALUES('$topicName', NOW(),'$topicDes',".$_SESSION['ID_Users'].")";

            $result = mysql_query($sql);

            if(!$result)
            {
                //something went wrong, display the error
                echo 'An error occured while inserting your data. Please try again later.' . mysql_error();
                $sql = "ROLLBACK;";
                $result = mysql_query($sql);
            }
            else
            {
                //the first query worked, now start the second, posts query
                //retrieve the id of the freshly created topic for usage in the posts query
                $topicid = mysql_insert_id();
                $topicReply = mysql_real_escape_string($_POST['post_content']);
                $sql = "INSERT INTO k00223375_gameforum.$table3(Reply_Content, Reply_Date, Reply_ID_Topic, Reply_ID_Users)
                        VALUES('$topicReply', NOW(),$topicid,".$_SESSION['ID_Users'].")";
                $result = mysql_query($sql);

                if(!$result)
                {
                    //something went wrong, display the error
                    echo 'An error occured while inserting your post. Please try again later.' . mysql_error();
                    $sql = "ROLLBACK;";
                    $result = mysql_query($sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = mysql_query($sql);

                    //after a lot of work, the query succeeded!
                    echo 'You have successfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
                }
            }
        }
    }
}
?>
