<?php

$table = 'categories';
$sql = "SELECT ID_Cat, Name_Cat, Description_Cat FROM k00223375_gameforum.$table";

$result = mysql_query($sql);

if(!$result)
{
    echo 'The categories could not be displayed, please try again later.';
    echo mysql_error();
}
else
{
    if(mysql_num_rows($result) == 0)
    {
        echo 'No categories defined yet.';
    }
    else
    {
        //prepare the table
        echo '<table border="1">
              <tr>
                <th>Category</th>
                <th>Last topic</th>
              </tr>';

        while($row = mysql_fetch_assoc($result))
        {
            echo '<div class="container"><tr>';
                echo '<td class="leftpart">';
                    echo '<h3><a href="category.php?id">' . $row['Name_Cat'] . '</a></h3>' . $row['Description_Cat'];
                echo '</td>';
                echo '<td class="rightpart">';
                            echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
                echo '</td>';
            echo '</tr>';
            echo '</div>';
        }
    }
}
?>
