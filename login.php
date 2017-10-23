<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  require_once 'connect.php';
  include ('site_builder_functions.php');

  try{
    $dbconn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);


  }

  catch (Exception $e){
    echo "Error: " . $e->getMessage();
  }

  
  if(isset($_POST['password']) &&  $_POST['password'] == "" || isset($_POST['username']) && $_POST['username'] == "" ){
     $msg = "Username and password must not be left blank.";

}

  if(isset($_POST['register']) && $_POST['username'] != "" && $_POST['password'] != ""){
    echo "registering";
    //Hash the Salt and Raw Pass
    $raw_pass = $_POST['password'];
    $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
    $hashed_salt = hash('sha256', $salt . $raw_pass);


    $insert_user = $dbconn->prepare("INSERT INTO `users` (`username`, `salt`, `password`)  VALUES (:username, :salt, :password)");
    $insert_user->execute(array(':username' => $_POST['username'], ':salt' => $salt, ':password' => $hashed_salt ));
    
  }

  if (isset($_POST['login']) || isset($_POST['register']) && isset($_POST['password'])  && isset($_POST['username']) ){
    //Obtain User's Salt
    $select_salt = $dbconn->prepare("SELECT salt FROM users WHERE username = :username");
    $select_salt->execute(array(':username' => $_POST['username']));
    $res = $select_salt->fetch();
    
    $salt = (isset($res) ) ? $res['salt'] : '';
    $raw_pass = $_POST['password'];
    //Hash the Salt and Raw Pass
    $hashed_salt = hash('sha256', $salt . $raw_pass);
    //Obtain the user info
    $stmt = $dbconn->prepare('SELECT * FROM users WHERE username=:username AND password = :password');
    $stmt->execute(array(':username' => $_POST['username'], ':password' => $hashed_salt));

    //If the login is successful
    if ($username = $stmt->fetch()){
        $_SESSION['username'] = $username['username'];
        $_SESSION['uid'] = $username['id'];
       
        $msg = 'Succesfully Logged in';
        header('Location: home.php');
        exit();
    }
    else if(isset($_POST['login']) && isset($_POST['password'])){
        $msg = 'Wrong username or password';
      }
  
  }
  if(isset($_POST['logout']) && isset($_SESSION['username']))
  {
    unset($_SESSION['username']);
    unset($_SESSION['uid']);
    $msg = "You have been logged out.";
  }
 ?>

<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SANSIGHT</title>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
  <script>var $_POST = <?php echo !empty($_POST)?json_encode($_POST):'null';?>; </script>
  <script src='./resources/js/speech.js'></script>
</head>

 <!-- body content here -->

<body>
  <!-- from site_builder_functions.php -->
  <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span> Register/Log In <i class="fa fa-bars"></i>
        </button>
        <img src="sansightlogo.png" id="logo">
        <a class="navbar-brand page-scroll" href="#">SANSIGHT</a>
      </div>

    </div>
  </nav>

  <div id="form-wrapper">
   <?php if (isset($_SESSION['username'])):?>
      <form action="login.php" method="post" id="logout-form" class="medium-6 columns">
        <section>
        <h1>Log Out</h1>
        <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL; ?>
        </section>
        <section>
        <input id="submit" class="btn btn-secondary" type = "submit" name="logout" value="logout" />
        </section>
      </form>

   <?php else: ?>
   <form action="login.php" method="post" id="login-form" onsubmit="return validate_login(this);" class="medium-6 columns">
     <h1 class="title">Log In</h1>
     <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL;?>
     <section >
        <label for="name">Username:
          <input type="text" class="form-control" placeholder="Name" name="username" id="name" />
        </label>
     </section>

     <section >
         <label for="password">Password: 
         <input class="form-control" type="password" name="password" id="password" />
         </label>
     </section>

     <div class="form-group">
       <input id="submit" type="submit" class="btn btn-secondary" name="register" value="Register" />
       <input id="submit" type="submit" class="btn btn-primary" name="login" value="Login" />
     </div>
       
  
   </form>
   </div>
  


   <?php endif; ?>

</body>
</html>
