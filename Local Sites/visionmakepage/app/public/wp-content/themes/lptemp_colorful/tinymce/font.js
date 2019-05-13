tinymce.PluginManager.add('jpfonts', function(editor) {

	var fontItems = [
		{ text: 'ゴシック体', data: '"ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","メイリオ",Meiryo, Osaka,"ＭＳ Ｐゴシック","MS PGothic",sans-serif' },
		{ text: '明朝体', data: '"ヒラギノ明朝 Pro W3","ＭＳ Ｐ明朝",serif' },
		{ text: 'メイリオ', data: '"メイリオ",Meiryo,"ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","ＭＳ Ｐゴシック",sans-serif' },
		{ text: '丸ゴシック体', data: '"ヒラギノ丸ゴ Pro W4","ヒラギノ丸ゴ Pro","Hiragino Maru Gothic Pro","ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","HG丸ｺﾞｼｯｸM-PRO","HGMaruGothicMPRO"' },
		{ text: '游ゴシック体', data: '"游ゴシック体","Yu Gothic",YuGothic,"ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","メイリオ",Meiryo,Arial,Sans-Serif' },
		{ text: '游明朝体', data: '"游明朝",YuMincho,"Hiragino Mincho ProN","Hiragino Mincho Pro","ＭＳ 明朝",serif' },
	];

	function insertTag(data) {
		editor.execCommand('FontName', false, data);
	}

	editor.addButton('fontlist', {
		type: 'menubutton',
		text: '日本語フォント',
		icon: false,
		menu: fontItems,
		onselect: function(e) {
			insertTag(e.control.settings.data);
		},
		selectcmd: 'FontName'
	});

});
