(function() {
	tinymce.create('tinymce.plugins.newButtons', {
		getInfo : function() {
		return {
			longname : 'Float Clear Button',
			author : 'Nori Takahashi',
			authorurl : 'http://webdesignrecipes.com/',
			infourl : 'http://webdesignrecipes.com/',
			version : "1.0.0"
			};
		},
		init : function(ed, url) {
			var t = this;
			t.editor = ed;	
		//帯型サブヘッド
			ed.addCommand('subheadobi',
		function() {
				var str = t._newButton();
				ed.execCommand('mceInsertContent', false, str);
		});

	
		
		
		
		ed.addButton('subheadobi', {
			title : '帯型サブヘッド', 
			cmd : 'subheadobi', 
			image : url + '/images/cl.gif'});
			
			},
			
		 
			
		
		_newButton : function(d, fmt) {
			str = '<table class="obi" style="background-color: #ce1219;" border="0">\n<tbody>\n<tr>\n<td>\n<p>ここに文字を入力できます。</p>\n<p>背景色も、背景画像も、行数も自由です。</p>\n<p>文字色も変えることができます。</p>\n</td>\n</tr>\n</tbody>\n</table>\n';
			return str;
		  }
		  
		  
				  
		});
		
		
	tinymce.PluginManager.add('newButtons', tinymce.plugins.newButtons);
})();