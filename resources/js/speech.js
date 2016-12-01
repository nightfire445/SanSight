

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

/*
var x = document;
x.addEventListener("focus", speech_onFocus, true);
*/

var speechSynthesis = window.speechSynthesis;


function speech_onFocus(element) {

	var speech = new SpeechSynthesisUtterance(element.id);
  
 	//Speak at fast speed; "Earcon".
   speech.rate = 10;
   speechSynthesis.speak(speech);   

   //Speak at regular speed
   speech.rate = 1; 
   speechSynthesis.speak(speech);

}

function speech_stop(){
  //Stops all speech utterences
  SpeechSynthesis.cancel()

}

function speech_pause(){
  //resumes if paused, pauses if speaking.
  
  if(SpeechSynthesis.paused){
    SpeechSynthesis.resume()
  }
  else{
    speechSynthesis.pause()
  }

}
