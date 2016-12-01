window.onload = function(e) {

  //Enable speech support.
  var context;
  if (typeof AudioContext !== "undefined") {
        context = new AudioContext();
  } 
  else if (typeof webkitAudioContext !== "undefined") {
        context = new webkitAudioContext();
  }
  else {
        throw new Error('AudioContext not supported. :(');
  }


  var speechSynthesis = window.speechSynthesis;


  function speech_onFocus(e) {
    
    speech_stop();
   
    console.log(e.target.tagName);
    var speech = new SpeechSynthesisUtterance();

    if(e.target.tagName == "A"){

      speech = new SpeechSynthesisUtterance("link " + e.target.textContent);

    }
    if(e.target.tagName == "INPUT"){

      speech = new SpeechSynthesisUtterance("Input type " + e.target.type + ", " + e.target.textContent);

    }

    
    //Speak at fast speed; "Earcon".
     speech.rate = 12;
     speechSynthesis.speak(speech);   

     //Speak at regular speed
     speech.rate = 1; 
     speechSynthesis.speak(speech);

  }


  var all = document.getElementsByTagName("*");

  for (var i=0, max=all.length; i < max; i++) {
       // Do something with the element here like focus:
       
      if(all[i].tagName == "A" || all[i].tagName == "INPUT" ){
         all[i].setAttribute("tabIndex", 0);
         all[i].addEventListener("focus", speech_onFocus);
      }
      
      
       
       
  }
  console.log("added on focus");

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