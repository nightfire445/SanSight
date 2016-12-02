window.onload = function(e) {
    //Check for speech support
    if ('speechSynthesis' in window) {

    var speechSynthesis = window.speechSynthesis;


  //Widget controls
  /*
    document.addEventListener('keydown', function (e) {
          if(speechSynthesis.speaking){

          speech_stop();
      
          }
        }, false);
  */
    function speech_onFocus(e) {
     
      console.log(e.target.tagName);
      var speech = new SpeechSynthesisUtterance();

      //Rendering cases based on tag

      if(e.target.tagName == "A"){

        speech = new SpeechSynthesisUtterance("Link " + e.target.textContent);

      }
      if(e.target.tagName == "INPUT"){
        speech = new SpeechSynthesisUtterance("Input type " + e.target.type + ", " + e.target.textContent);
      }

      if(e.target.tagName == "IMG"){
        speech = new SpeechSynthesisUtterance("Image " + e.target.alt);
      }



      //Speak at fast speed; "Earcon"
       speech.rate = 12;
       speechSynthesis.speak(speech);   

       // Any elements we dont want to apply "Earcon" to
      if(e.target.tagName == "P"){
        speech = new SpeechSynthesisUtterance("Paragraph, " + e.target.textContent);
      }

      

       //Speak at regular speed
       speech.rate = 1; 
       speechSynthesis.speak(speech);

    }


    var all = document.getElementsByTagName("*");

    for (var i=0, max=all.length; i < max; i++) {
         // Make sure these elements are focusable
         
        if(all[i].tagName == "A" || all[i].tagName == "INPUT" || all[i].tagName == "IMG" || all[i].tagName == "P"){
           all[i].setAttribute("tabIndex", 0);
           all[i].addEventListener("focus", speech_onFocus);
        }
        
        
         
         
    }

    function speech_stop(){
      //Stops all speech utterences
      speechSynthesis.cancel()

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