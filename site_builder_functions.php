<?php

//Function that builds the menu at the top of every page.
function menu_builder(){
	//Open div, menu, div
	echo "<div class='off-canvas-wrapper'><menu><div class='row column'>";
	//Test to see if user is logged in, echos out their user name
    if(isset($_SESSION['username'])){ echo "<p> Welcome " . htmlentities($_SESSION['username'])."</p>";}
    echo "<li id='title'><strong><a href='index.php'>SansSight</a></strong></li><li><a href='parse.php'>Parse</a></li>";
    //Test to see if user is logged in, echos out the History Page & options page
    if(isset($_SESSION['username'])){ echo "<li id ='title'><a href = 'history.php'>History</a></li></a></li><li id = title><a href = options.php>Options</a></li>";} 
    //Open li & link tag
    echo "<li><a href='login.php'>";
    //Test to see if user is logged in, echos Logout if they are Login if they are not.
    echo (isset($_SESSION['username'])) ? "Logout" : "Login"; 
    //Close  li, a, div, menu, div 
  	echo "</a></li></div></menu></div>";
  	//Close include scripts to apply foundation to the newly echoed menu (doesn't apply without something here, not sure what included all to be safe).
    echo"<link rel='stylesheet' href='https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css'><script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script><script src='https://cdn.jsdelivr.net/foundation/6.2.4/foundation.min.js'></script><script src='./resources/js/speech.js'></script><script>$(document).foundation();</script>";

         

}






?>