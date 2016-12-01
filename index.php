<!-- Do we need this page??? -->

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

  if (isset($_POST['login']) && isset($_POST['password'])){
    
    $select_salt = $dbconn->prepare('SELECT salt FROM users WHERE username = :username');
    $select_salt->execute(array(':username' => $_POST['username']));
    $res = $select_salt->fetch();
    $salt = ($res) ? $res['salt'] : '';
    $raw_pass = $_POST['password'];
    $hashed_salt = hash('sha256', $salt . $raw_pass);
    $stmt = $dbconn->prepare('SELECT * FROM users WHERE username=:username AND password = :password');
    $stmt->execute(array(':username' => $_POST['username'], ':password' => $hashed_salt));
   
    if ($user = $stmt->fetch()){
        $_SESSION['username'] = $user['username'];
        $_SESSION['uid'] = $user['id'];
        $msg = 'Succesfully Logged in';
    
        header('Location: index.php');
        exit();
    }
    else{
        $msg = 'Wrong username or password';
    }
  
  }
  if(isset($_POST['logout']) && isset($_SESSION['username'])){
    unset($_SESSION['username']);
    unset($_SESSION['uuid']);
    $msg = "You have been logged out.";
  }
 ?>





<html>
   <head>
     <title>SansSight - Index</title>
   </head>

   <body>

   <?php menu_builder() ?>

   <?php if (isset($_SESSION['username'])):?>
      <form action="login.php" method="post" id="logout-form" class="medium-6 columns">
        <h1 class="title">Log Out</h1>
        <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL; ?>
        <input id="submit" class="button" type = "submit" name="logout" value="Logout"/>
      </form>

   <?php else:
   //Redirect to Login
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'login.php';
    header("Location: http://$host$uri/$extra");?>


   <?php endif; ?>

  </body>


</html>