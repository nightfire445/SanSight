<?php 

   if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  require ('config.php');
  include ('site_builder_functions.php');


  try{
    $servername = $config['DB_HOST'];
    $username = $config['DB_USERNAME'];
    $password = $config['DB_PASSWORD'];
    $dbname = $config['DB_NAME'];

    $dbconn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  }
  
  catch (Exception $e){
    echo "Error: " . $e->getMessage();
  }

  if (isset($_POST['save']) ){
    
  }
  else if (isset($_POST['speak'])){

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

    <script>var $_POST = <?php echo !empty($_POST)?json_encode($_POST):'null';?>; </script>
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

    <div class="container-fluid" style="text-align: center;">
    <form class = 'medium-6 columns' action="options.php" method="post" id="options-form" >
      
      <div class="row optionsRow">
        <select class="form-control" name = "voice">
        </select>
      </div>

      <div class="row optionsRow">
        <input type="text" placeholder="Text to speak" class = "txt form-control" name="txt" id="txt" />
      </div>
           
      <div class="row optionsRow">
        <label for='pitch'>Pitch</label>
        <input type= 'range' value='1' name= 'pitch' id="pitch" min= '0.5' max= '2' step="0.1"></input>
      </div>      

      <div class="row optionsRow">
        <label for='rate'>Rate</label></input>
      <input type= 'range' value='1' name= 'rate' id="rate" min= '0.5' max= '2' step="0.1">
      </div>      

      <div class="row optionsRow">
        <input id="preview" type="submit" class="btn btn-secondary" name="speak" value="Preview" />
      <!-- </div> -->

      <!-- Store in settings locally and submit to the server (Dont need to make the request if its in session) -->
      <!-- <div class="row optionsRow"> -->
        <input id="save" type="submit" class="btn btn-secondary" name="save" value="Save Settings" />
      </div> 
      
      
    </form>
    </div>

    <script src=".\resources\js\voice_options.js"></script>

    <footer>
    </footer>
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
    

