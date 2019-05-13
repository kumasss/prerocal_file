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
  tinymce.create('tinymce.plugins.QuickUploadFilePlugin', {
    init : function(ed, url) {
      // Register commands
      ed.addCommand('mceQuickUploadFile', function() {
        ed.windowManager.open({
          file : url + '/upload.php',
          title:'Upload File',
          inline : 1,
          width:300,height:100
        }, {
          plugin_url : url
        });
      });
      // Register buttons
      ed.addButton('quickuploadfile', {
        title : 'Upload File',
        image : url + '/icon.png',
        cmd : 'mceQuickUploadFile'
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
  tinymce.PluginManager.add('quickuploadfile', tinymce.plugins.QuickUploadFilePlugin);
})();
