<?php
/*
Hustream Video Embed Popup
*/
include('../../../../wp-load.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Hustream Player Settings</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
</head>
<body id="link">
    <div id="chooser">
    
    <form name="hustream_player" action="#">
          <label style="width:200px;" for="player_video_url">Video URL</label>
          <input style="width:300px;" name="player_video_url" id="player_video_url" type="text">
          <p><strong>Format:</strong> http://apps.hustream.com/your_channel/your_video</p>
          <br />
          <br />
          <label for="player_dimensions">Player Size</label>
          <select id="player_dimensions" name="player_dimensions">
            <option value="854x480">480p</option>
            <option value="640x360" selected="selected">360p (Default)</option>
            <option value="426x240">240p</option>
            <option value="custom">Custom</option>
          </select>
          <br />
          <br />
          <div id="custom_dims" style="display:none;">
            <label style="width:40px; float:left;"  for="player_width">Width </label>
            <input style="width:200px;" name="player_width" type="text" id="player_width" value="426">
            <br clear="all">
            <label style="width:40px; float:left; margin-top:6px;" for="player_height">Height</label>
            <input style="width:200px; margin-top:6px;" name="player_height" type="text" id="player_height" value="240">
            <br />
            <br />
          </div>
          <label for="player_sharing" >
            <input name="player_sharing" type="checkbox" id="player_sharing" value="1" checked="checked">
            Enable Sharing.</label>
          <br />
          <br />
          <label for="player_keyboard" >
            <input name="player_keyboard" type="checkbox" id="player_keyboard" value="1" checked="checked">
            Enable Keyboard Controls.</label>
          <br />
          <br />
          <label for="player_resume" >
            <input name="player_resume" type="checkbox" id="player_resume" value="1" checked="checked">
            Allow Resume on Return Visits.</label>
          <br />
          <br />
          <input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();" />
          <input type="submit" id="insert" name="insert" value="Add Player" onClick="insertShortcode();" />
    </form>
    <script type="text/javascript">
    jQuery('#player_dimensions').change(function(e){
        var dims = (jQuery(this).val());
        if(dims == 'custom'){
            jQuery('#custom_dims').show();
            }
        else {
            jQuery('#custom_dims').hide();
            }
        });
		
    insertShortcode = function() {
		var player_url = jQuery('#player_video_url').val();
		var player_dims = jQuery('#player_dimensions').val();
		var player_width = jQuery('#player_width').val();
		var player_height = jQuery('#player_height').val();
		var player_sharing = (jQuery('#player_sharing').is(':checked')) ? 1 : 0;
		var player_keyboard = (jQuery('#player_keyboard').is(':checked')) ? 1 : 0;
		var player_resume = (jQuery('#player_resume').is(':checked')) ? 1 : 0;
		if(player_dims == 'custom'){
			player_size = player_width + "x" + (parseInt(player_height));
			}
		else {
			player_size = player_dims;
			}
		
        var shortcodeText = '[hustream url="'+player_url+'" size="'+player_size+'" sharing="'+player_sharing+'" keyboard="'+player_keyboard+'" resume="'+player_resume+'"]';
        
        var dimensions = '';
        if(window.tinyMCE) {
            window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcodeText); 
            tinyMCEPopup.editor.execCommand('mceRepaint');
            tinyMCEPopup.close();
        }
    }
    </script>
</body>
</html>