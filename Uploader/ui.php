<!DOCTYPE HTML>
<!--
/*
 * jQuery File Upload Plugin jQuery UI Demo
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
-->

<html lang="en">
<head>
<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<meta charset="utf-8">
<title>Admin</title>
<script src="js/jquery.js">
</script>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../Style/w3.css">
<link rel="stylesheet" href="../Style/style.css">
<!-- jQuery UI styles -->
<link rel="stylesheet" href="css/jquery-ui.css" id="theme">
<!-- Demo styles -->
<link rel="stylesheet" href="css/demo.css">
<!--[if lte IE 8]>
<link rel="stylesheet" href="css/demo-ie8.css">
<![endif]-->
<style>
/* Adjust the jQuery UI widget font-size: */
.ui-widget {
    font-size: 1.05em;
}
</style>
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="css/jquery.fileupload.css">
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">

<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>
</head>
<body>

<div class="w3-card-8 w3-container w3 w3-green w3-display-container  w3-display-bottommiddle">

<ul>
	<li>Please Upload the files in the following fashion before pressing the generate recommendations button</li>
	<li>New Students CSV => new_s.csv</li>
	<li>Existing Students CSV => existing_s.csv</li>
	<li>Orgs CSV=> orgs.csv </li>
</ul>
<!-- Rounded switch -->
<p> You can download a locally run-able version of the main algorithm from </p><a href="https://s3-us-west-2.amazonaws.com/clubmatcher/Recommendation+Generator.tar.gz">here</a>  
<p> The Fast algorithm employs KD-trees and is 75~80% accurate on real world data, Whereas Classic algorithm is complete K-Nearest-Neighbor(KNN) with an accuracy of 95.2%. 
    The processes run in the background so you can leave the page and come back after 120 seconds for fast and 110 Mins after starting classic algorithm.
    You can see the size of the recommendations.csv increasing. For any queries contact me at sunejax@gmail.com.
    </p>
</div>


<!-- Rectangular switch -->

       <form id="rcomgen" action="ui.php" method="POST" class="w3-display-container w3-display-middle w3-container">
			<div class="onoffswitch ">			
			<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
			<label class="onoffswitch-label" for="myonoffswitch">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
        	</label>
        	</div>
        	<div id="progress" class="w3-progress-container" style="display:none">
  				<div id="myBar" class="w3-progressbar w3-green" style="width:0%">
  				</div>
			</div>
			<br>
			<input class="w3-btn w3-dark-grey w3-round-large" value="Generate Recommendations" id="rcomgenbtn" type="button">
		
			<input class="w3-btn w3-red w3-round-large" value="Stop" id="cancelbtn" type="button">
</form>
<script type="text/javascript">
var c=0;
$(document).ready(function(){
    $('#rcomgenbtn').click(function(){
    	var ch=$("#myonoffswitch").is(":checked");
    	if (ch==true) alert('Starting Fast Algorithm');
    	else alert('Starting Classic Algorithm');

        var ajaxurl = 'aj.php',
        data =  {'action': ch};
        $.post(ajaxurl, data, function (response) {
            c=response;
            if(c==-1)
            alert('Process Completed Successfully');
          	c=0;
        });
    });	
});
$(document).ready(function(){
    $('#cancelbtn').click(function(){
    	alert('Cancelling');
   //alert(c);
        var ajaxurl = 'aj.php',
        data =  {'inaction': c};
        $.post(ajaxurl, data, function (response) {
            
            alert(response);
        });
    });	
});
</script>
</div>
    
    



<!-- The file upload form used as target for the file upload widget -->
<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data "class="w3-container w3-display-topmiddle w3-display-container w3-padding-top">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript><input type="hidden" name="redirect" value="frametest.heroku.com"></noscript>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="fileupload-buttonbar">
        <div class="fileupload-buttons">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="fileinput-button">
                <span>Add files...</span>
                <input type="file" name="files[]" multiple>
            </span>
            <button type="submit" class="start">Start upload</button>
            <button type="reset" class="cancel">Cancel upload</button>
            <button type="button" class="delete">Delete</button>
            <input type="checkbox" class="toggle">
            <!-- The global file processing state -->
            <span class="fileupload-process"></span>
        </div>
        <!-- The global progress state -->
        <div class="fileupload-progress fade" style="display:none">
            <!-- The global progress bar -->
            <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
            <!-- The extended global progress state -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation"><tbody class="files"></tbody></table>
</form>
<!-- The blueimp Gallery widget -->

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress"></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="start" disabled>Start</button>
            {% } %}
            {% if (!i) { %}
                <button class="cancel">Cancel</button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            </p>
            {% if (file.error) { %}
                <div><span class="error">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            <button class="delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>Delete</button>
            <input type="checkbox" name="delete" value="1" class="toggle">
        </td>
    </tr>
{% } %}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
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
<!-- The File Upload user interface plugin -->
<script src="js/jquery.fileupload-ui.js"></script>
<!-- The File Upload jQuery UI plugin -->
<script src="js/jquery.fileupload-jquery-ui.js"></script>
<!-- The main application script -->
<script src="js/main.js"></script>
<script>
// Initialize the jQuery UI theme switcher:
$('#theme-switcher').change(function () {
    var theme = $('#theme');
    theme.prop(
        'href',
        theme.prop('href').replace(
            /[\w\-]+\/jquery-ui.css/,
            $(this).val() + '/jquery-ui.css'
        )
    );
});
</script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
</body>
</html>
