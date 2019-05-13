(function() {
    tinymce.create('tinymce.plugins.SampleButtons', {//プラグイン関数名
        getInfo : function() {//プラグイン情報
        return {
            longname : 'WebTecNote CustomButtons Sample',
            author : 'Tenderfeel',
            authorurl : 'http://tenderfeel.xsrv.jp',
            infourl : 'http://tenderfeel.xsrv.jp',
            version : "1.0"
            };
        },
        init : function(ed, url) {
            var t = this;
            t.editor = ed;
            ed.addCommand('Table01',//コマンドID
        function() {
                var str = t._SampleTable();
                ed.execCommand('mceInsertContent', false, str);
        });
        ed.addButton('Table01', {//ボタンの名前
            title : 'サンプルテーブル', //tileのテキスト
            cmd : 'Table01', //コマンドID
            image : url + 'http://pocowan.com/wp-content/uploads/boton.jpg'}); //ボタン画像
       
        },
        _SampleTable : function(d, fmt) {//挿入するテキスト
            str = '<table width="400" border="1" cellspacing="0" cellpadding="0" class="sample" summary="tinyMCEサンプル用テーブル">\n\n<caption>\n\n\nTable Sample\n\n</caption>\n\n<tr>\n\n\n<th scope="col">Name</th>\n\n\n<th scope="col"></th>\n\n</tr>\n\n<tr>\n\n\n<th scope="col">Address</th>\n\n\n<td></td>\n\n</tr>\n\n<tr>\n\n\n<th scope="row">TEL</th>\n\n\n<td></td>\n\n</tr>\n\n<tr>\n\n\n<th scope="row">FAX</th>\n\n\n<td></td>\n\n</tr>\n\n<tr>\n\n\n<th scope="row">URL</th>\n\n\n<td></td>\n\n</tr>\n</table>';
            return str;
          }
        });
    tinymce.PluginManager.add('SampleButtons', tinymce.plugins.SampleButtons);//プラグインID,プラグイン関数名
})();