<!DOCTYPE html>
<html lang="en">
<head>
  <title>Liveliness</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/form.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
   <style>
      body{
        background-color: #fff;
      }
       
        .centered-axis-xy {
        position: absolute;
        left: 50%;

        transform: translate(-50%,-50%);
}
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="http://evanw.github.io/glfx.js/glfx.js"></script>
  <script type="text/javascript" src="js/jsmanipulate.min.js"></script>
  <script src="js/whammy.js"></script>
  <script src="js/video.js"></script>
</head>
 <body>   

<img src="axis.png" style="margin-left:47%;" alt="logo" height="100" width="100">
<br><br><br>
<div class="centered-axis-xy">
    <form id="msform">
     <ul id="progressbar">
    <li class="active" style="color:RGB: (174, 39, 95)">Step 1</li>
    <li class="active" style="color:RGB: (174, 39, 95)">Step 2</li>
    </ul>
    </form> 
</div>
  <br>  

<div class="row" style="margin-top:2px;">

		<div class="col-xs-12" style="text-align:center">
			<video width="640" height="480" id="campreview" autoplay="true" muted></video>
		</div>
<br><br>
		<div class="col-xs-12" style="text-align:center">
		   <p style="color:red" id="chngtxt">Follow this to verify yoursel !</p>
                   <img id ="anger" src="anger.png" alt="Smiley face" width="80" height="80" style="display:none;">
                   <img id ="smile" src="smile.png" alt="Smiley face" width="42" height="42" style = "display:none;">
		</div>

</div>
<div class="text-center">
    <progress id="progress" style="visibility: hidden;"></progress><br/>
 <div id="information"></div>
</div>

<div class="row" style="text-align:center">
<form id="" action="submit.php" method="post" enctype="multipart/form-data">

  <fieldset style="position: absolute;">

    <div class="text-center">
	<div style="position: relative;left:3.1%;">
		<div class="span12">
			<video width="480" height="320" id="campreview" autoplay="true" muted></video>
            <video width="0" height="0" style="display:none;" id="result" controls="controls"></video>
		</div>
	</div>
</div>

  </fieldset>
    
</form>
     </div>
<script type="text/javascript">
var filterType  = 'normal';
var multiplyColor = [255, 105, 0];

$(document).ready(function(){



	$('.mastsave').click(function(){
		var daaudiopath = $('#recordingslist li a').attr('href');
		var davideopath = $('video#result').attr('href');



	});

});

</script>


  <script>
  function __log(e, data) {
    //log.innerHTML += "\n" + e + " " + (data || '');
  }

  var audio_context;
  var audio = document.querySelector('audio');
  var recorder;
  var localStream;
  function startUserMedia(stream) {
	var input = audio_context.createMediaStreamSource(stream);
	video.src = window.URL.createObjectURL(stream);
	__log('');

	var zeroGain = audio_context.createGain();
	zeroGain.gain.value = 0;
	input.connect(zeroGain);
	zeroGain.connect(audio_context.destination);
	__log('');

	//recorder = new Recorder(input);
	__log('');
}

  function startRecording(button) {
    recorder && recorder.record();
    button.disabled = true;
    button.nextElementSibling.disabled = false;
    ////console.log('Recording...');
  }

  function stopRecording(button) {
    recorder && recorder.stop();
    button.disabled = true;
    button.previousElementSibling.disabled = false;
    ////console.log('Stopped recording.');

    // create WAV download link using audio data blob
    createDownloadLink();

    recorder.clear();
  }

  function createDownloadLink() {
    recorder && recorder.exportWAV(function(blob) {
      var url = URL.createObjectURL(blob);
      var li = document.createElement('li');
      var au = document.createElement('audio');
      var hf = document.createElement('a');

      au.controls = true;
      au.src = url;
      hf.href = url;
      hf.download = new Date().toISOString() + '.wav';
      hf.innerHTML = hf.download;
      li.appendChild(au);
      li.appendChild(hf);
      recordingslist.appendChild(li);

      upload(blob);
    });
  }


  function upload(blobOrFile) {
          var xhr = new XMLHttpRequest();
          xhr.open('POST', 'saveaudio.php', true);
          xhr.onload = function (e) {
              var result = e.target.result;
          };

          xhr.send(blobOrFile);
      }



  window.onload = function init() {
    try {
    initvideo();

      // webkit shim
      window.AudioContext = window.AudioContext || window.webkitAudioContext;
      navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
      window.URL = window.URL || window.webkitURL;
      
      
      audio_context = new AudioContext;
      __log('Audio context set up.');
      __log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
    } catch (e) {
      //alert('No web audio support in this browser!');
    }
    
    navigator.getUserMedia({audio: true, video: true}, startUserMedia, function(e) {
      __log('No live audio input: ' + e);
    });
  };
  </script>
  
  
  <script>

   setTimeout(function(){startprocess(); }, 3000);

    function startprocess()
    {
       startCapture();
        chlng = Math.floor(Math.random()*(2-1+1)+1);
        if(chlng == 1)
         {
           $("#chngtxt").html("Smile Please..");
           $("#smile").show();
           $("#anger").hide();
           setTimeout(function(){stopCapture(); }, 1650);
           //setTimeout(function(){changeangtext(); }, 1650);
         }
        else
         {

           $("#chngtxt").html("Squeez eyes and say AAAA..");
           $("#anger").show();
           $("#smile").hide();
           setTimeout(function(){stopCapture(); }, 1650);
           //setTimeout(function(){smchangeangtext(); }, 1650);
         }
        function changeangtext()
        {
          //console.log('b');
          $("#chngtxt").html("Squeez eyes and say AAAA..");
          $("#anger").show();
          $("#smile").hide();
          setTimeout(function(){stopCapture(); }, 1650);
        }
        function smchangeangtext()
        {
          //console.log('a');
          $("#chngtxt").html("Smile Please..");
          $("#smile").show();
          $("#anger").hide();
          setTimeout(function(){stopCapture(); }, 1650);
        }
  
       var daaudiopath = $('#recordingslist li a').attr('href');
       var davideopath = $('video#result').attr('href');
       console.log('done');

    }

  </script>

</body>


</html>
