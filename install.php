

<?php
  // Creates sansSight Database and creates the user and history table if it doesn't already exist.
  require_once 'connect.php';
  	
  try{
    $dbh = new PDO("mysql:host=$hostname;", $username, $password);
  	$sql = "CREATE DATABASE IF NOT EXISTS `sansSight`;";
  	$dbh->exec($sql);

  	$dbconn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);


    $create_users = "CREATE TABLE IF NOT EXISTS users (
                  username varchar(50) PRIMARY KEY,
                  salt varchar(100) NOT NULL,
                  password varchar(100) NOT NULL
                ) COLLATE utf8_unicode_ci;";

  
    $create_history = "CREATE TABLE IF NOT EXISTS history (
                  username varchar(50),
                  url varchar(100) NOT NULL,
                  `date` date NOT NULL,	
                  id int(99) PRIMARY KEY AUTO_INCREMENT,
                  FOREIGN KEY(username) REFERENCES users(username)
                ) COLLATE utf8_unicode_ci;";

    /*$create_settings = "CREATE TABLE IF NOT EXISTS settings (
                  username varchar(50),
                  url varchar(100) NOT NULL,
                  `date` date NOT NULL, 
                  id int(99) PRIMARY KEY AUTO_INCREMENT,
                  FOREIGN KEY(username) REFERENCES users(username)
                ) COLLATE utf8_unicode_ci;";
    */
  $result_1 = $dbconn->query($create_users);
	$result_2 = $dbconn->query($create_history);


  }
  
  catch (Exception $e){
    echo "Error: " . $e->getMessage();
  }

 ?>