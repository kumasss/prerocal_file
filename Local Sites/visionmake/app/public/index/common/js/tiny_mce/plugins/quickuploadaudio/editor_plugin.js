/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
  tinymce.create('tinymce.plugins.QuickUploadAudioPlugin', {
    init : function(ed, url) {
      // Register commands
      ed.addCommand('mceQuickUploadAudio', function() {

          if(ed.controlManager.get('quickuploadaudio').isActive()){
              ed.execCommand('mceMedia');
          }
          else{
            ed.windowManager.open({
              file : url + '/upload.php',
              title:'Upload Audio',
              inline : 1,
              width:350,height:100
            }, {
              plugin_url : url
            });
        }
      });
      // Register buttons
      ed.addButton('quickuploadaudio', {
        title : 'Upload Audio',
        image : url + '/icon.png',
        cmd : 'mceQuickUploadAudio'
      });
    },
    getInfo : function() {
      return {
        longname : 'Simple File Upload',
        author : 'enoyhs and yama',
        version : '0.0.2'
      };
    }
  });

  // Register plugin
  tinymce.PluginManager.add('quickuploadaudio', tinymce.plugins.QuickUploadAudioPlugin);
})();
