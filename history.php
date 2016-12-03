<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  include('config.php');
  include ('site_builder_functions.php');
  try{

    
    $host = $config['DB_HOST'];
    $user =  $config['DB_USERNAME'];
    $pass = $config['DB_PASSWORD'];
    $dbname = $config['DB_NAME'];
    
    
    $dbconn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
  }

  catch (Exception $e){
    echo "Error: " . $e->getMessage();
  }
  //If Logged in
  if ( isset($_SESSION['username']) ){
    //Get History
    $history = $dbconn->prepare('SELECT url, `date` FROM history WHERE username = :username ORDER BY `date`');
    $history->execute(array(':username' => $_SESSION['username']));
    $res = $history->fetchAll();

    
  }
  
 ?>

<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >

<head>
  <meta charset="utf-8">
  <!-- If you delete this meta tag World War Z will become a reality -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sansight - History</title>

</head>

<body>
  <!-- from site_builder_functions.php -->
  <?php menu_builder(); ?>

<!-- If Logged in-->
  <section> 
  <?php if(isset($_SESSION['username']) ):{ 
   //Echo out form to hold history-->
      echo '<form action="parse.php" method="post" class="medium-6 columns" id="login-form">';
    
    //Echo out their history as radio buttons -->
    foreach($res as $row) {
      //<br> should be done in css not php 
      echo '<input type="radio" name="URL" id="url_input" value="'.$row['url'].'"></input>'. $row['url'] . "\t"; echo $row['date'] . "<br>"; 
    }
    //Echo out input submit, closing input, form, and insert script with foundation required function call
    echo '<input id ="url_input_submit" type="submit" name="Parse" value="Submit" class="button expanded"></input></form><script> $(document).foundation();</script>';
  }?>
  </section>     

      

   <?php else: //Redirect to Login
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'login.php';
    header("Location: http://$host$uri/$extra"); 
    ?>
    


  


   <?php endif; ?>

 <!-- foundation required function call -->
  <script>
    $(document).foundation();
  </script>
</body>
</html>
