//Self contained widget to populate options.php.

//Referenced: https://developer.mozilla.org/en-US/docs/Web/API/SpeechSynthesis#Examples




window.onload = function() {

  var synth = window.speechSynthesis;

  var inputForm = document.querySelector("form");
  var inputTxt = document.querySelector('.txt');
  var voiceSelect = document.querySelector('select');

  var pitch = document.querySelector('#pitch');
  var pitchValue = document.querySelector('.pitch-value');
  var rate = document.querySelector('#rate');
  var rateValue = document.querySelector('.rate-value');

  var voices = [];

  function populateVoiceList() {
    voices = synth.getVoices();

    for(i = 0; i < voices.length ; i++) {
      var option = document.createElement('option');
      option.textContent = voices[i].name + ' (' + voices[i].lang + ')';
      
      if(voices[i].default) {
        option.textContent += ' -- DEFAULT';
      }

      option.setAttribute('data-lang', voices[i].lang);
      option.setAttribute('data-name', voices[i].name);
      voiceSelect.appendChild(option);
    }

  }

 
  populateVoiceList();


  if (speechSynthesis.onvoiceschanged !== undefined) {
    speechSynthesis.onvoiceschanged = populateVoiceList;
  }

function preview() {
    voices = window.speechSynthesis.getVoices();
    console.log(voices);
    var text;
    if($_POST != null ){

      text = $_POST["txt"];
    }
    else{
      text = "";
    }
    var utterThis = new SpeechSynthesisUtterance(text);
     if($_POST != null ){

     var selectedOption = $_POST["voice"];
    }
    else{
      var selectedOption = voices[0];
    }
    
    for(i = 0; i < voices.length ; i++) {

      if(voices[i].name === selectedOption) {
        utterThis.voice = voices[i];
      }
    }
    if($_POST != null){
      utterThis.pitch = $_POST['pitch'];
      utterThis.rate = $_POST['rate'];

    }
    
    synth.speak(utterThis);
  }

  preview();

}