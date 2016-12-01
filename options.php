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
    echo "<";
  }
  else if (isset($_POST['speak'])){

  }

?>

<!DOCTYPE html>
<html>

  <head>
    <title>SansSight - Voice Options</title>
    <script src=".\resources\js\voice_options.js"></script>
  </head>

  <body>
    <?php menu_builder(); ?>
    <form class = 'medium-6 columns' action="options.php" method="post" id="options-form" >
    <select name = "voice">
    </select>
    <input type="text" placeholder="Text to speak" class = "txt" name="txt" id="txt" />
    <input id="preview" type="submit" class="button expanded" name="speak" value="Preview" /> 
    <!-- Store in settings locally and submit to the server (Dont need to make the request if its in session) -->
    <input id="preview" type="submit" class="button expanded" name="save" value="Save Settings" />


    <input type= 'range' value='127' name= 'pitch' id  ="pitch" min= '0' max= '255'><label for 'pitch-value'>Pitch</label></input>
    <input type= 'range' value='127' name= 'rate' id  ="rate" min= '0' max= '255'><label for 'pitch-value'>Rate</label></input>
    </form>

  </body>


</html>
