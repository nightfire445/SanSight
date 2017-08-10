//Included outside so parsepage can access these functions



      
function speech_stop(){
      //Stops all speech utterences
    speechSynthesis.cancel()

}


function speech_onFocus(e) {
      var flag;
      speech_stop();

      var speech = new SpeechSynthesisUtterance();

      //Rendering cases based on tag

      if(e.target.tagName == "A"){

        speech = new SpeechSynthesisUtterance("Link " + e.target.textContent);
        flag = 0;

      }
      if(e.target.tagName == "INPUT"){
        speech = new SpeechSynthesisUtterance("Input type " + e.target.type + ", " + e.target.value +", " +e.target.textContent);
        flag = 0;
      }

      if(e.target.tagName == "IMG"){
        speech = new SpeechSynthesisUtterance("Image " + e.target.alt);
        flag = 0;
      }

      if(e.target.tagName == "SELECT"){
        speech = new SpeechSynthesisUtterance("Select " + e.target.options[ e.target.selectedIndex ].value);
        flag = 0;
      }

      
      var voices = window.speechSynthesis.getVoices();

      if(flag == 0){

        //Speak at fast speed; "Earcon"
        if(typeof $_SESSION != 'null' && $_SESSION['rate']){
          
          speech.rate = 2 * $_SESSION['rate'];
        }
        else {
          speech.rate = 12; 
        }
   

        if(typeof $_SESSION != 'undefined' && $_SESSION['pitch']){

          speech.pitch = $_SESSION['pitch'];
        }
        

        if(typeof $_SESSION != 'undefined' && $_SESSION['voice']){
          
          
          for(i = 0; i < voices.length ; i++) {
          
            if(voices[i].name + ' (' + voices[i].lang + ')' === $_SESSION['voice']) {
               speech.voice = voices[i];
             
            }
          }     
        }

        console.log(speech);
        speechSynthesis.speak(speech);   
        speech.rate = 1;
        speechSynthesis.speak(speech);

      }

        

       // Any elements we dont want to apply "Earcon" to
      if(e.target.tagName == "P"){
        speech = new SpeechSynthesisUtterance("Paragraph, " + e.target.textContent);
        flag = 1;

      }

      
      if(flag == 1){

         //Speak at regular speed
        if( typeof  $_SESSION != 'null' && $_SESSION['rate']){

          speech.rate =  $_SESSION['rate'];
        }
        else {
          speech.rate = 1; 
        }


        if(typeof $_SESSION != 'undefined' && $_SESSION['pitch']){

          speech.pitch = $_SESSION['pitch'];
        }


        if(typeof $_SESSION != 'undefined' && $_SESSION['voice']){
         
          for(i = 0; i < voices.length ; i++) {
       
            if(voices[i].name + ' (' + voices[i].lang + ')' === $_SESSION['voice']) {

              speech.voice = voices[i];
           
            }
          }    
         
        }

        //console.log(speech);
        speechSynthesis.speak(speech);
      }

}


//Referenced: http://www.htmlgoodies.com/beyond/javascript/article.php/3724571/Using-Multiple-JavaScript-Onload-Functions.htm
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

function speechOnload(e) {
    //Check for speech support
    if ('speechSynthesis' in window) {

    var speechSynthesis = window.speechSynthesis;


  //Widget controls

  document.body.onkeyup = function(e){
    //Shift, stop speech
    if(e.shiftKey && e.keyCode == 9) { 
    //shift was down when tab was pressed
    }

    //Shift, stop speech
    else if(e.keyCode == 16 ){
        speech_stop();
    }

    //, move out of iframe


     //ctrl, replay focused element
    else if(e.keyCode == 17){
        $focused = $(':focus');
        $focused.blur(); 
        $focused.focus();

    }
  }


    var all = document.getElementsByTagName("*");

    for (var i=0, max=all.length; i < max; i++) {
         // Make sure these elements are focusable
         
        if(all[i].tagName == "A" || all[i].tagName == "INPUT" || all[i].tagName == "IMG" || all[i].tagName == "IFRAME" || all[i].tagName == "SELECT"){

          //Keep elements tab index value if it has it
          if(!all[i].hasAttribute("tabIndex")){
             all[i].setAttribute("tabIndex", 0);
          }
          
           all[i].addEventListener("focus", speech_onFocus);
        }

        if(all[i].tagName == "P"){
          //giv <p> higher priorty for tabbing for quick access
          all[i].setAttribute("tabIndex", 2);

          all[i].addEventListener("focus", speech_onFocus);
        }
    

    }

    

    function speech_pause(){
      //resumes if paused, pauses if speaking.
      
        if(speechSynthesis.paused){
          speechSynthesis.resume()
        }
        else{
          speechSynthesis.pause()
        }

    }



  } 
  else {
      // speech synthesis isn't supported.
  }


}


addLoadEvent(speechOnload);