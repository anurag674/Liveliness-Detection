<!DOCTYPE html>
<html lang="en">
<head>
  <title>Livliness</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/form.css">
  <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/style.css">

<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
 <link rel="stylesheet" href="css/jquery.fileupload.css">
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</head>
<body>   
    
    <div class="container" id="error" style="display:none;">
        <div class="alert alert-danger">
            <strong>Already Registered!</strong>
        </div>
    </div>
  
<?php

    error_reporting(0);

   /* if($_GET['msg'] == "blank"){
        echo "<div class=\"container\"><div class=\"alert alert-danger\">
            <strong>All fields are required!</div></div>";
    }
    if($_GET['msg'] == "2"){
          echo "<div class=\"container\"><div class=\"alert alert-danger\">
              <strong>Please select an image file to upload !</div></div>";
      }
    if($_GET['msg'] == "3"){
        echo "<div class=\"container\"><div class=\"alert alert-danger\">
            <strong>Sorry there was an error in uploading for file. Either no faces or multiple delected!</div></div>";
    }*/
    
?>    

<form id="msform" method="post">

  <!-- progressbar -->
  <ul id="progressbar">
    <li class="active">Step 1</li>
    <li>Step 2</li>
  </ul>
    
 
  <!-- fieldsets -->
  <fieldset>
    <div class="text-center">
		<img src="img/disq-logo.png" width="150">
	</div>
    <h2 class="fs-title">Step 1</h2>
    <input type="text" id="name" name="name" placeholder="We can address you by? (Name)" required/>
    <input type="text" id="phone" name="phone" placeholder="We can reach you on? (+91 xxxxxxxxxx) " pattern="[789][0-9]{9}" required/>
    <input type="text" id="aadhar" name="aadhar" placeholder="12 Digit Aadhar Number" min="12" max="12" pattern="\d{12}" required/>
    
    <!--<input type="file" accept="image/jpeg, image/JPG, image/jpg, image/JPEG, image/png, image/PNG" id="camera" capture="camera" name="camera" required/>-->
    <div id="progress" class="progress" style="display:none;">
        <div class="progress-bar progress-bar-success"></div>
    </div>
        <span style="color:red" id="message"></span><br>
        <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span id="spanaddfiles">Add files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
        </span>
    
    <br>
    <br>
    <!-- The global progress bar -->
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
    
    <div class="text-center">
        <span class="power">Powered By </span>
        <br><img src="img/vlogo.png" width="100">
	</div>
  </fieldset>
</form>
    
</body>
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="js/jquery.fileupload-validate.js"></script>

<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */

$(function () {
    
    $('#msform').on('submit',function(event){
        event.preventDefault() ;
    });
    
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'server/php/',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 999000,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        $('#progress').show();
        $('.fileinput-button').hide();
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            if(document.forms['msform'].name.value === "" || document.forms['msform'].phone.value === "" || document.forms['msform'].aadhar.value === ""){
                
                $('#message').text("Please fill all the fields!");
                $('#progress').hide();
                //$('#files').hide();
                $("#files").html("");
                
            }
            else{
                if(document.forms['msform'].aadhar.value.length == 12){
                    $('#message').text("");
                //$('.fileinput-button').hide();
                data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error); 
                }
                else{
                    $('#message').text("Invalid Aadhar");
                    $('#progress').hide();
                     $("#files").html("");
                }
                
  
            }
        }
    }).on('fileuploadprogressall', function (e, data) {
        //$('#progress').hide();
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        
             $('#message').text("");
             var name = document.getElementById('name').value;
             var phone = document.getElementById('phone').value;
             var aadhar = document.getElementById('aadhar').value;
             var path = $('#files span').text();
                           
             $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: 'submit.php',
                        data: {
                                    name:name,
                                    phone:phone,
                                    aadhar:aadhar,
                                    path:path
                                },
                                success: function(data) { 
                                    
                                    if(data == 1){
                                        window.location.href = "step-2.php";
                                    }
                                    else{
                                        $('#message').text("Operation failed!");
                                         $("#files").html("");
                                    }
                                }
                    });
        
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
</html>
