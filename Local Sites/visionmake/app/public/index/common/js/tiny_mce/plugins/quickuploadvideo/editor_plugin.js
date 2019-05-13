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
  tinymce.create('tinymce.plugins.QuickUploadVideoPlugin', {
    init : function(ed, url) {
    
      ed.__qve_selected = false;
      // Register commands
      ed.addCommand('mceQuickUploadVideo', function() {
      
          if(ed.controlManager.get('quickuploadvideo').isActive()){
              ed.execCommand('mceMedia');
          }
          else{
              ed.windowManager.open({
              file : url + '/upload.php',
              title:'Upload Video',
              inline : 1,
              width:350,height:100
              }, {
                plugin_url : url
              });
           }
      });
      // Register buttons
      ed.addButton('quickuploadvideo', {
        title : 'Upload Video',
        image : url + '/icon.png',
        cmd : 'mceQuickUploadVideo'
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
  tinymce.PluginManager.add('quickuploadvideo', tinymce.plugins.QuickUploadVideoPlugin);
})();
