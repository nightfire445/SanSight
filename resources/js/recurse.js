function speech_onFocus(element) {

	var speech = new SpeechSynthesisUtterance(element.id);
  
 	//Speak at fast speed; "Earcon".
   speech.rate = 10;
   speechSynthesis.speak(speech);   

   //Speak at regular speed
   speech.rate = 1; 
   speechSynthesis.speak(speech);

}
function recurseDOM(node, depth) {
  console.log(node);
  node.addEventListener("onFocus", speech_onFocus(this) );
  depth +=1;
  node = node.firstChild;

  while(node) {
    recurseDOM(node, depth);
    node = node.nextSibling;
  }

}

//get  html element
console.log("recursing");
var start = document.documentElement;
var level = 0;
recurseDOM(start, level);
