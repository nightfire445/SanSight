
//Appends iframe w/ location to external page
$( document ).ready(function() {
        
        //console.log($_POST["URL"]);
        
        if( $('#exPage').find('#exiframe').length ){
            $('#exPage').empty();
        }
        
        $('#exPage').append("<iframe id='exiframe' width='750' height='500' src='./displayExternalPage.php?URL=" + $_POST["URL"] + "'></iframe>");
        
         
    });

