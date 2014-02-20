<?php
#include the login.php file containing the info for connecting to mysql server
 require_once 'login.php';

#connecting to mysql server
 $db_server = mysql_connect($db_hostname, $db_username, $db_password);
 if (!$db_server){
    die ("Unable to connect to MySQL: ".mysql_error());
 }
 else{
    echo "Connected to mysql \n";
 }

#selecting a databse
 if (!mysql_select_db($db_database)){
     die("Unalbe to select database: ".mysql_error());
 }else{
     echo "Connected to database \n";
 }

# json object from end users;
 $json_data = '[{"name": "Lifang", "id": 0, "value": "hello", "timestamp": "2013-02-18 00:01:12"}, {"name": "Leah", "id": 1, "value": "world", "timestamp": "2014-01-18 00:01:12"}]';

$query = "create table if not exists users (
           name varchar(20) unique,
           id int primary key,
           value varchar(45),
           timestamp varchar(45))";
$result = mysql_query($query);


# function to process the json object and save it into mysql table testdb.profile 
 function processJSON($json_data){
  #decode json string into php varible;
  $data = (json_decode($json_data, true));
  #iterate the associate array and insert them into the table
  for ($i = 0; $i < count($data); $i++){
    $name = $data[$i]['name'];
    $id = $data[$i]['id'];
    $value = $data[$i]['value'];
    $timestamp = $data[$i]['timestamp'];
    $query = "insert into users values('$name', '$id', '$value', '$timestamp')";
    $result = mysql_query($query);
    if (!$result){
       die ("Database access failed: ".mysql_error());
    }else{
       echo "Add data into a table \n";
    }
  }
 }
#call the function
 processJSON($json_data);

#closing a mysql datbase connection
 mysql_close($db_server);   

?>
