(function(a){a.create("tinymce.plugins.EmotionsPlugin",{init:function(b,c){b.addCommand("mceEmotion",function(){b.windowManager.open({file:c+"/emotions.htm",width:480+parseInt(b.getLang("emotions.delta_width",0)),height:320+parseInt(b.getLang("emotions.delta_height",0)),inline:1},{plugin_url:c})});b.addButton("emotions",{title:"emotions.emotions_desc",cmd:"mceEmotion"})},getInfo:function(){return{longname:"Emotions",author:"Moxiecode Systems AB",authorurl:"http://tinymce.moxiecode.com",infourl:"http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/emotions",version:a.majorVersion+"."+a.minorVersion}}});a.PluginManager.add("emotions",a.plugins.EmotionsPlugin)})(tinymce);