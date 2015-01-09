<html>
<head>
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
    <script src="<?php echo base_url();?>assets/js/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function(event) {
    $('.layerform').ajaxForm({
    beforeSend: function() {
        $('#'+$('#layerid').val()+'_displaylayer').empty();
        var percentVal = '0%';
        $('#'+$('#layerid').val()+'_bar').width(percentVal)
        $('#'+$('#layerid').val()+'_percent').html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        $('#'+$('#layerid').val()+'_bar').width(percentVal)
        $('#'+$('#layerid').val()+'_percent').html(percentVal);
    },
    success: function() {
        var percentVal = '100%';
        $('#'+$('#layerid').val()+'_bar').width(percentVal)
        $('#'+$('#layerid').val()+'_percent').html(percentVal);
    },
	complete: function(xhr) {
		$('#'+$('#layerid').val()+'_displaylayer').html(xhr.responseText);
	}
}); 
});
</script> 
  
  <style>
body { padding: 30px }
form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }

.progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
.bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
.percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style> 
</head>
<body>
<h1>File Upload Progress Demo #1</h1>
<form id="file_form1" class="layerform" action="<?php echo base_url()."web/network/import_from_file";?>" method="post" enctype="multipart/form-data" onsubmit="updateFieldValue('layerid', 'file_form1')">
    <input name="filename" id="filename" value="" placeholder="Enter the File Name" /><BR>
    <input id="file" type="file" name="file" /><br/>
    <input id="submit" type="submit" value="Upload File"/>
</form>

<div class="progress">
        <div id="file_form1_bar" class="bar"></div >
        <div id="file_form1_percent" class="percent">0%</div >
    </div>
<div id='file_form1_displaylayer'></div>
</body>
</html>