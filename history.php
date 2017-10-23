<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  require_once 'connect.php'
  include ('site_builder_functions.php');
  try{

    
    $hostname = $config['DB_HOST'];
    $username =  $config['DB_USERNAME'];
    $pasword = $config['DB_PASSWORD'];
    $database = $config['DB_NAME'];
    
    
    $dbconn = new PDO("mysql:host=$hostname;dbname=$database", $username, $pasword);
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
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SANSIGHT</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    
    <script>var $_SESSION = <?php echo !empty($_SESSION)?json_encode($_SESSION):'null';?>;</script>
    <script src='./resources/js/speech.js'></script>
    
  </head>
  <body>
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Register/Log In <i class="fa fa-bars"></i>
                </button>
                <img src="sansightlogo.png" id="logo">
                <a class="navbar-brand page-scroll" href="home.php">SANSIGHT</a>
                <a class="navbar-brand page-scroll" href="./history.php">  History  </a>
                <a class="navbar-brand page-scroll" href="./options.php">  Options  </a>
                <a class="navbar-brand page-scroll" href="#history-form">  History Form  </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php
                          if(isset($_SESSION['username'])){
                            echo "<a class='navbar-brand page-scroll' href='./login.php'>". $_SESSION['username'] ."</a>";
                            echo "<a class='navbar-brand page-scroll' href='./login.php' id='sign-in'>Log Out</a>";
                            
                          }
                          else{
                            echo "<a class='navbar-brand page-scroll' href='./login.php' id='sign-in'>Register/Sign in</a>";
                          }
                        ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    
    <!-- If Logged in-->
    <section style="margin-left: 25px;"> 
    <?php if(isset($_SESSION['username']) ):{ 
     //Echo out form to hold history-->
        echo '<form action="home.php" method="post" class="medium-6 columns" id="history-form">';
      //<br> should be done in css not php 
      //Echo out their history as radio buttons -->
      foreach($res as $row) {
        echo '<input type="radio" name="URL" id="url_input" value="'.$row['url'].'"></input>'. $row['url'] . "\t"; echo $row['date'] . "<br>"; 
      }
      //Echo out input submit, closing input, form, and insert script with foundation required function call
      echo '<input id ="url_input_submit" type="submit" name="Parse" value="Submit" class="btn btn-secondary"></input></form>';
    }?>
    </section>     

        

     <?php else: //Redirect to Login
      $hostname  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'login.php';
      header("Location: http://$hostname$uri/$extra"); 
      ?>
      


    


     <?php endif; ?>



    <footer>
    </footer>
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>


















