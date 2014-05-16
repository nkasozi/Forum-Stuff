<?php

include "C:\wamp\www\KadicTalks\laravel\app\controllers\Utilities.php";

// Host name
$host = "localhost";

// Mysql username
$username = "root";

//MYSQL PASSWORD
$password = "";

//DATABASE NAME
$db_name = "new";

//TABLE NAME
$tbl_name = "conversations";

//CONNECT TO MYSQL
mysql_connect("$host", "$username", "$password") or die("cannot connect");

//SELECT DATABASE IN MYSQL
mysql_select_db("$db_name") or die("cannot select DB");

//SELECT SQL
$select_sql = "SELECT * FROM $tbl_name";

//EXECUTE QUERY
$select_sql_results = mysql_query($select_sql);

//LOOP THROUGH RESULTS
while ($conversation = mysql_fetch_assoc($select_sql_results))
{
  //IF THE TIME ELAPSED SINCE CREATION DAY OF CONVERSATION IS GREATER THAN THE DAYS TO EXPIRY OF CONVERSATION
  if ((Utilities::GetDaysGoneBy($conversation['created_at'])) >= ($conversation['days_to_expiry']))
  {
    //GET THE CONVERSATION ID
    $id = $conversation['id'];

    // DELETE SQL
    $delete_sql = "DELETE FROM $tbl_name WHERE id='$id'";

    //DELETE CONVERSATION
    $delete_sql_results = mysql_query($delete_sql);

    // PRINT OUT SUCESS OR FAILURE
    if ($delete_sql_results)
    {
      echo "CONVERSATION $id DELETED SUCESSFULLY";
    }
    else
    {
      echo "ERROR!!!";
    }
  }
}
//TELL USER WE ARE DONE
echo '!SUCESSFULLY COMPLETED ALL DELETION ACTIONS! ';

echo '!GOOD NIGHT!';

//CLOSE MYSQL CONNECTION
mysql_close();

