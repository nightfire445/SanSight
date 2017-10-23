<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include ('site_builder_functions.php');

//if We Posted
if(isset($_POST['URL'])){

  //if Logged in
  if(isset($_SESSION['username']) ){

    require_once 'connect.php';
    try{


      $hostname = $config['DB_HOST'];
      $username = $config['DB_USERNAME'];
      $password = $config['DB_PASSWORD'];
      $database = $config['DB_NAME'];
        
      $dbconn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
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
    
    <script>var $_POST = <?php echo !empty($_POST)?json_encode($_POST):'null';?>; var $_SESSION = <?php echo !empty($_SESSION)?json_encode($_SESSION):'null';?>;</script>
    <script src="./resources/js/parsepage.js"></script>
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
                <a class="navbar-brand page-scroll" href="./home.php">SANSIGHT</a>
                <a class="navbar-brand page-scroll" href="./history.php">  History  </a>
                <a class="navbar-brand page-scroll" href="./options.php">  Options  </a>
                <a class="navbar-brand page-scroll" href="#exiframe">  External Content  </a>
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

    <div id="sidebar-wrapper">
      <ul class="sidebar">
        <li>
          <h5>ABOUT SANSIGHT</h5>
          <p>SanSight helps visually impaired people navigate the web without assistance and free of cost.
        </li>
        <li>
          <h5>INSTRUCTIONS</h5>
          <p>Type a web address into the search bar to begin browsing</p>
          <p>Press <kbd>tab</kbd> to move through elements</p>
          <p>Press <kbd>ctrl</kbd> to replay current element</p>
          <p>Press <kbd>shift</kbd> to stop playing elements</p>
          <p>Press <kbd> shift + tab </kbd> to go back through elements</p>
        </li>
      </ul>
    </div>
    
    <form action="home.php" method="post" id="parse-form">
      <div id="main">
        <div class="form-group">
          <input type="search" value="" class="form-control" name="URL" id="search-bar" placeholder="Search">
          <input class="btn btn-secondary" type="submit" id="submit" value="Submit"/>
        </div>
      </div>
    </form>

    <!--<iframe src="hhtp://www.google.com"></iframe>-->
    <div id="exPage">
    
    </div>

    <footer>
    </footer>
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
    