     <?php
        
        $server="127.0.0.1";
        $username="root";
        $password="root";
        $database="musYEum";
        
   
        $connect = mysqli_connect($server,$username,$password,$database);
        $sql = "SELECT * FROM VIDEOS";
        $result = mysqli_query($connect, $sql);
        $json_array = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $json_array[] = $row;
        }
        $fp = fopen('videos.json', 'w');
        fwrite($fp, json_encode($json_array));
        fclose($fp);
        
        
        
        ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>musYeum</title>
        
        
        <link rel="stylesheet" href="CSS/styles.css">
        
        <script
            accesskey=""src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous">
        </script>
        <script>

    
    
$(document).ready(() => {
        
        var $dateOrAlbum;
        var $dateSelected;
        var $albumSelected;
        
        var outputHeight = 800;


        
        var dates = [];
        var uniqueDates = [];
        var notUniqueDate = 1;
        
        
        
        $.ajax({
                        type: 'GET',
                        url: 'videos.json',
                        success: function(videos) {
                            $.each(videos, function(i, video){//traverse json file 
                                var d = video.Date;
                                d = d.split("-");
                                d = d[0];
        
                                dates.push(d);
                             
                            });
                            
           
                        for(var i = 0; i < dates.length; i++){//traverse through type array
                            for(var j = 0; j < uniqueDates.length; j++){//traverse through unique Types
                                if(dates[i]===uniqueDates[j]){//if the type is also in the uniqeType its not unique
                                    notUniqueDate = 1;
                                    }
                                    }
        
                            if(notUniqueDate === 0){//means the current type was not in the uniqueType array
                                    uniqueDates.push(dates[i]);//adds types to uniqe array
                                    }
                                    notUniqueDate = 0;//set notUnique back to not true
                                                             }   
           
                       for(var k = 0; k < uniqueDates.length; k++){//traverse through uniqueType array
                                $('#byDate').append('<dev class = dates id='+uniqueDates[k]+'>'+uniqueDates[k]+'</dev>');//adds type button
                                    }                                        
            }           
        });//end of ajax
        
        
$(document).on ("click", ".dates", function (e) {
                    
        $dateOrAlbum = 'date';
                    
        $('#dateTypeAlbums').css({"-webkit-filter": "blur(20px)", "filter": "blur(20px)"});//blurs BG
        $dateSelected = (e.target.id);//get album selected ID
                  
        var $output = $('#output');//div element
        var $overlay = $('.morePanel');//overlay element
                   
        $('.optionList').empty();//empty overlay text
        $('#overlayCover').remove();//empty overlay img
                   
        $overlay.show();//overlay
        $output.empty();//clears div
        $('.morePanelRight').empty();
        $('.morePanelLeft').empty();
   
        $('.morePanelLeft').append('<div id = dateDiv><p id = dateLabel>'+$dateSelected+'</p></dv>');
        $('#dateDiv').animate({width: '100%'},250);//animate album cover


        $output.empty();//clears div
        var types = [];//holds all types
        var uniqueTypes = [];//holds unique types
        var notUnique = 1;//boolean
                   
        $.ajax({
            type: 'GET',
            url: 'videos.json',
            success: function(videos) {
                $.each(videos, function(i, video){//traverse json file
                    var d = video.Date;
                        d = d.split("-");
                        d = d[0];
                                
                    if(d === $dateSelected){//adds only videos from the album selected
                        types.push(video.Type);//adds type to array
                        console.log(video.Type);
                                            }
                                                  });                      

               for(var i = 0; i < types.length; i++){//traverse through type array
                   for(var j = 0; j < uniqueTypes.length; j++){//traverse through unique Types
                      if(types[i]===uniqueTypes[j]){//if the type is also in the uniqeType its not unique
                      notUnique = 1;
                                                   }
                                                              }
        
              if(notUnique === 0){//means the current type was not in the uniqueType array
                    uniqueTypes.push(types[i]);//adds types to uniqe array
                                 }
                     notUnique = 0;//set notUnique back to not true
                                                  }
            $('.morePanelRight').empty();
            $('.morePanelRight').append('<dev id = close><p id = exit>X</p></dev>');//add exit button
            $('.morePanelRight').append('<dev class = options id=all>All</dev>'); //adds all button       

   
            for(var k = 0; k < uniqueTypes.length; k++){//traverse through uniqueType array
                    $('.morePanelRight').append('<dev class = options id='+uniqueTypes[k]+'>'+uniqueTypes[k]+'</dev>');//adds type button
                                                        }                
              }
      }); //end of ajax
 }); //end of date clicked
                
        
        
$('.album').click(function (e) {
                
    $dateOrAlbum = 'album';
    $albumSelected = (e.target.id);//get album selected ID

    $('#dateTypeAlbums').css({"-webkit-filter": "blur(20px)", "filter": "blur(20px)"});//blurs BG
                    
    $('#'+$albumSelected).css({"visibility": "hidden" });//hides slected Album from BG
                   
    var $output = $('#output');//div element
    var $overlay = $('.morePanel');//overlay element
                   
    $('.optionList').empty();//empty overlay text
    $('#overlayCover').remove();//empty overlay img
    $('.morePanelLeft').css({"background-image": "none"});//adds selected cover to overlay panel

    $overlay.show();//overlay
    $output.empty();//clears div
                   
    var types = [];//holds all types
    var uniqueTypes = [];//holds unique types
    var notUnique = 1;//boolean
                   
        $.ajax({
            type: 'GET',
            url: 'videos.json',
            success: function(videos) {
                $.each(videos, function(i, video){//traverse json file
                    if(video.Era === $albumSelected){//adds only videos from the album selected
                       types.push(video.Type);//adds type to array
                                                    }
                    });                      

                  

            $('.morePanelLeft').append('<img id=overlayCover src="assets/'+$albumSelected+'.jpg" ></img> ');//adds selected cover to overlay panel
            $('#overlayCover').animate({width: '100%'},250);//animate album cover

                 
    
            for(var i = 0; i < types.length; i++){//traverse through type array
                for(var j = 0; j < uniqueTypes.length; j++){//traverse through unique Types
                    if(types[i]===uniqueTypes[j]){//if the type is also in the uniqeType its not unique
                    notUnique = 1;
                                                 }
                                                            }
                if(notUnique === 0){//means the current type was not in the uniqueType array
                    uniqueTypes.push(types[i]);//adds types to uniqe array
                                    }
                    notUnique = 0;//set notUnique back to not true
                                                }
    
        $('.morePanelRight').empty();
        
        $('.morePanelRight').append('<dev id = close><p id = exit>X</p></dev>');//add exit button
        $('.morePanelRight').append('<dev class = options id=all>All</dev>'); //adds all button       

   
            for(var k = 0; k < uniqueTypes.length; k++){//traverse through uniqueType array
                $('.morePanelRight').append('<dev class = options id='+uniqueTypes[k]+'>'+uniqueTypes[k]+'</dev>');//adds type button
                                                       }                
                    }
      });//end of ajax 
 });//end of album click
   
$(document).on ("click", "#exit", function (e) {// exit button clicked
    var $overlay = $('.morePanel');
    $overlay.hide();
   
    $('.morePanelRight').empty();
    $('.morePanelLeft').empty();
   
    $('#dateTypeAlbums').css({"-webkit-filter": "none", "filter": "none"});//blurs BG
                   
    $('.album').css({"visibility": "visible" });//removes selected album
   
});//end of exit clicked
    

$(document).on ("click", ".options", function (a) {// one of the types is selected
        
    var $typeSelected = $(this).text();
    var $output = $('#output');//div element
    
        
    $output.empty();//clears div
    var typesArr = [];
    
    $output.append('<div id=outputTitle></div>');
    

    
    
    if($dateOrAlbum === 'album'){$('#outputTitle').append('<p id=albumTitle>'+$albumSelected+'</p>')};
    if($dateOrAlbum === 'date'){$('#outputTitle').append('<p id=dateTitle>'+$dateSelected+'</p>')};
        
        $.ajax({
            type: 'GET',
            url: 'videos.json',
            success: function(videos) {
                $.each(videos, function(i, video){//traverse through json file
                    var d = video.Date;
                        d = d.split("-");
                        d = d[0];
                                                  
                    if($dateOrAlbum === 'album'){   
                        if ($typeSelected === 'All'){//for the all button
                            if(video.Era === $albumSelected){
                                typesArr.push(video.Type);//
                                $output.append('<div class=videoPanel><iframe src=https://drive.google.com/file/d/'+video.Link+'/preview></iframe><p>'+video.Description+'</p><p>'+video.Type+'</p></div>');//adds all videos
                                                            } 
                                                    }
                    else if(video.Era === $albumSelected  && video.Type === $typeSelected){//for the other buttons
                        typesArr.push(video.Type);
                        $output.append('<div class=videoPanel><iframe src=https://drive.google.com/file/d/'+video.Link+'/preview></iframe><p>'+video.Description+'</p><p>'+video.Type+'</p></div>');//adds certain type videos
                                                                                           }
                                                }
                    if($dateOrAlbum === 'date'){
                        if ($typeSelected === 'All'){//for the all button
                            if(d === $dateSelected){
                                typesArr.push(video.Type);//
                                $output.append('<div class=videoPanel><iframe src=https://drive.google.com/file/d/'+video.Link+'/preview></iframe><p>'+video.Description+'</p><p>'+video.Type+'</p></div>');//adds all videos
                                                    } 
                                                     }
                        else if(d === $dateSelected  && video.Type === $typeSelected){//for the other buttons
                            typesArr.push(video.Type);
                            $output.append('<div class=videoPanel><iframe src=https://drive.google.com/file/d/'+video.Link+'/preview></iframe><p>'+video.Description+'</p><p>'+video.Type+'</p></div>');//adds certain type videos
                                                                                    }
                                            } 
                           }); 
            }    
        });//end of ajax
 
        

        $('html, body').animate({scrollTop: $("#output").offset().top}, 1000);
        $('#returnTop').css({"visibility": "visible" });//add returnTop button
        $('#returnTop').animate({opacity: 1.0}, 1500);

 
});//end of options clicked


$('#returnTop').click(function (e) {

    $('html, body').animate({scrollTop: $("body").offset().top}, 1000);
    //$('#output').empty();



});


});//end of javascript document
        </script>
    </head>
    <body>
        
        <div id ="returnTop">^</div>
        <div class = "banner">
        <a href="index.php" id="title">musYeum</a>
        <p id="subtitle">Kanye Video Database</p>
        <hr>
        </div>
        
        
        
        
        <div class = "pickPanel">
        
            <div class = "morePanel">
                <div class = "morePanelLeft"></div>
                
                <div class = "morePanelRight">
                                       
                    
                 
                </div>
       
            </div>
        <div id = "dateTypeAlbums"> 
           
            <p id = "byDateLabel">By Year</p> 
            <div id = "byDate">
                
                
            </div>    

        <p id = "byAlbumLabel">By Album</p>
        <div id="albums">
        <img src="assets/CD.jpg" id="CD" class="album"></img>
        <img src="assets/LR.jpg"  id="LR" class="album"></img>
        <img src="assets/GRAD.jpg" id="GRAD" class="album"></img>
        <img src="assets/808.jpg" id="808" class="album"></img>
        <img src="assets/MBDTF.jpg" id="MBDTF" class="album"></img>
        <img src="assets/YEEZUS.jpg" id="Yeezus" class="album"></img>
        <img src="assets/TLOP.jpg"  id="TLOP" class="album"></img>
        <img src="assets/YE.jpg"  id="ye" class="album"></img>  
        </div>

        </div>         
        </div>
   
        <div id="output" >
            
            
        </div>
        
     
    </body>
</html>
