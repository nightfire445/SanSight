<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require ('simple_html_dom.php');
include ('site_builder_functions.php');

//if We Posted
if(isset($_POST['URL'])){

  //if Logged in
  if(isset($_SESSION['username']) ){

    $configs = include('config.php');
    try{


      $host = $config['DB_HOST'];
      $user = $config['DB_USERNAME'];
      $pass = $config['DB_PASSWORD'];
      $dbname = $config['DB_NAME'];
        
      $dbconn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    }

    catch (Exception $e){
      echo "Error: " . $e->getMessage();
    }

    $today = date("Y-m-d");
    //Add url to history

    /*

    'INSERT INTO history
    (username, url)
    SELECT ":username", ":URL"
    FROM dual
    WHERE NOT EXISTS (SELECT *
    FROM history
    WHERE history.url = ":URL" && history.username = ":username")'

    Doesn't Work
    Error:
    Cannot add or update a child row: a foreign key constraint fails (`sanssight`.`history`, CONSTRAINT `history_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`))

    Why?? :username is defined...
    

    VS 

    
    'INSERT INTO history
    (username, url)
    SELECT "test", "http://www.google.com"
    FROM dual
    WHERE NOT EXISTS (SELECT *
    FROM history
    WHERE history.url = "http://www.google.com" && history.username = "test")'

    Works


    "INSERT INTO `history` (`username`,`url`, `date`) VALUES (:username, :URL, :today)"
    */

    $history_insert = $dbconn->prepare(  'INSERT INTO `history` (`username`,`url`, `date`) VALUES (:username, :URL, :today)');

    $insert =  $history_insert->execute( array(':username' => $_SESSION['username'], ':URL' => $_POST['URL'], ':today' => $today) );
    //print_r($history_insert->errorInfo());

    if(!$insert){
    $history_update = $dbconn->prepare("UPDATE `history` SET (`date` = :today) WHERE (username = :username && url = :URL)");
    $history_update->execute( array(':username' => $_SESSION['username'], ':URL' => $_POST['URL'], ':today' => $today) );
     //print_r($history_update->errorInfo());
    }
  }

}

?>

<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >

<head>
  <meta charset="utf-8">
  <!-- If you delete this meta tag World War Z will become a reality -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sansight - Parse</title>

</head>

 <!-- body content here -->

<body>
<!-- from site_builder_functions.php -->
<div id="exPage">
      
</div>

  <?php menu_builder(); ?>
  <!-- Following script allows parsepage to grab the URL -->
  <script>var $_POST = <?php echo !empty($_POST)?json_encode($_POST):'null';?>; </script>
  <script src="./resources/js/parsepage.js"></script>
  <script src='./resources/js/speech.js'></script>
    

   <form action="parse.php" method="post" id="parse-form"  class="medium-6 columns">
     <h1 class="title">URL</h1>
     <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL; ?>
     


     
      <input type="url" name="URL" id="url_input" value=""></input>
   	  <input id ="url_input_submit" type="submit" name="Parse" value="Submit" class="button expanded"></input>
     
   </form>


 <!-- foundation required function call -->
  <script>

    $(document).foundation();
  </script>
</body>
</html>