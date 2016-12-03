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

  
  if($_POST['username'] == "" || $_POST['password'] == ""){
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

  if (isset($_POST['login']) || isset($_POST['register']) && isset($_POST['password']) ){
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
    if ($user = $stmt->fetch()){
        $_SESSION['username'] = $user['username'];
        $_SESSION['uid'] = $user['id'];
       
        $msg = 'Succesfully Logged in';
        header('Location: index.php');
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
  <!-- If you delete this meta tag World War Z will become a reality -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sansight - Login</title>

  <!-- If you are using the CSS version, only link these 2 files, you may add app.css to use for your overrides if you like -->
  
</head>

 <!-- body content here -->

<body>
  <!-- from site_builder_functions.php -->
  <?php menu_builder(); ?>


   <?php if (isset($_SESSION['username'])):?>
      <form action="login.php" method="post" id="logout-form" class="medium-6 columns">
        <section>
        <h1 >Log Out</h1>
        <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL; ?>
        </section>
        <section>
        <input id="submit" class="button expanded" type = "submit" name="logout" value="logout" />
        </section>
      </form>

   <?php else: ?>
   <form action="login.php" method="post" id="login-form" onsubmit="return validate_login(this);" class="medium-6 columns">
     <h1 class="title">Log In</h1>
     <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL;?>
     <section >
        <label for="name">Username:
          <input type="text" placeholder="Name" name="username" id="name" />
        </label>
     </section>

     <section >
         <label for="password">Password: 
         <input type="password" name="password" id="password" />
         </label>
     </section>

     
       
       <input id="submit" type="submit" class="button expanded" name="login" value="Login" />
       <input id="submit" type="submit" class="button expanded" name="register" value="Register" />
  
   </form>

  


   <?php endif; ?>

 <!-- foundation required function call -->
  <script>
    $(document).foundation();
  </script>
</body>
</html>
