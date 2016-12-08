
//Appends iframe w/ location to external page
$( document ).ready(function() {
       
       // console.log($_POST["URL"]);
        
        if( $('#exPage').find('#exiframe').length ){
            $('#exPage').empty();
        }
        
        $iframe = $("<iframe id='exiframe' width='750' height='500'></iframe>");

        //set on load to make sure iframe elements can be rendered for speech
        $iframe.on('load', function()
        {
                var iframe = document.getElementsByTagName("iframe")[0];

                var all = $(iframe.contentDocument).find("*");
                //console.log(all);
                for (var i=0, max=all.length; i < max; i++) {
                 // Make sure these elements are focusable
                 
                    if(all[i].tagName == "A" || all[i].tagName == "INPUT" || all[i].tagName == "IMG" || all[i].tagName == "P" || all[i].tagName == "IFRAME"){
                       all[i].setAttribute("tabIndex", 0);
                       all[i].addEventListener("focus", speech_onFocus);
                    }
                }



            //Iframe Widget controls
                document.getElementsByTagName("iframe")[0].contentWindow.document.onkeyup  = function(e){
                    
                    if(e.shiftKey && e.keyCode == 9) { 
                    //shift was down when tab was pressed
                    }

                    //Shift, stop speech
                    else if(e.keyCode == 16 ){
                        speech_stop();
                    }



                     //ctrl, replay focused element
                    else if(e.keyCode == 17){
                        focused = document.getElementsByTagName("iframe")[0].contentWindow.document.activeElement;
                        $focused = $(focused);
                        $focused.blur(); 
                        $focused.focus();

                    }

                    
                }

        });

        $iframe.appendTo("#exPage");
        
        $iframe.attr('src', './displayExternalPage.php?URL=' + $_POST["URL"]);
        
        
         
    });

