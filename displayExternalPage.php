<?php

  //check if the link field is set
  
  if( isset($_GET['URL']) && ($_GET['URL']) != '' ){
    
    //Needed because sometimes gives warnings about valid html5 tags like wbr
    //error_reporting(E_ALL ^ E_WARNING); 
    
    //get the link
    $ex_link = $_GET['URL'];
    
    //get all the html from site
    $html = file_get_contents($ex_link);

    
    //parse the parts of the url
    $scheme = $host = parse_url($ex_link, PHP_URL_SCHEME);
    $host = parse_url($ex_link, PHP_URL_HOST);

    $dom = new DOMDocument;
    $dom->loadHTML($html);
    
    
    $links = $dom->getElementsByTagName('link');
    foreach ($links as $link) {
      
      //check if link is a absoulte path or relative.
      
      $curr_link_str = $link->getAttribute('href');
      
      //regex to see if absoulte or relative link. Referenced stack overflow: http://stackoverflow.com/questions/12013268/php-regex-to-determine-relative-or-absolute-path
      if( !((substr($curr_link_str, 0, 7) == 'http://') || (substr($curr_link_str, 0, 8) == 'https://')) ){
        $link->setAttribute('href',  $scheme. "://" . $host . $link->getAttribute('href') );  
      }
      
    }
    
    $html = $dom->saveHTML();
    
    echo $html;
    
    
    
      
  }
  
  
  
  
?> 