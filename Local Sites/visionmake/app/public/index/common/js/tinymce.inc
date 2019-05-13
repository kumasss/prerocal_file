<?php
    $ruri = $_SERVER['REQUEST_URI'];
    if(
        strpos($_SERVER['REQUEST_URI'],'/admin/builders/tp_tops/')===false
        &&
        strpos($_SERVER['REQUEST_URI'],'/admin/builders/tp_contents/')===false
    )
    return;
    
    if (isset($settings['is_edit'])){
        if (empty($settings['is_edit'])) return;
    }
    // plugin add 2015-10-13
    define('LIBADD', 'libadd.dat');
    $libadd = $buildersObj->get_plugin_text( LIBADD );
?><script type="text/javascript" src="<?php echo URL; ?>/common/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinymce.create('tinymce.plugins.replacelistbox', {
    createControl: function(n, cm) {
        switch (n) {
            case 'relistbox':
                var ilb = cm.createListBox('relistbox', {
                     title : '差し込み文字',
                     onselect : function(v) {
                         tinymce.execCommand('mceInsertContent', false, v);
                     }
                });
                ilb.add('会員名（姓）', '%name1%');
                ilb.add('会員名（名）', '%name2%');
                ilb.add('Email（ログインID）', '%email%');
                ilb.add('パスワード', '%password%');
                ilb.add('グループ', '%group%');
                ilb.add('会員ID', '%id%');
                ilb.add('注文ID', '%order_no%');
                ilb.add('会員サイトURL', '%url%');
                ilb.add('会員情報修正フォーム', '%form_edit%');
                ilb.add('解除フォーム', '%stopurl%');
                ilb.add('登録日', '%registday%');
                ilb.add('登録時IP', '%ip%');
                ilb.add('登録時HOST', '%host%');
                ilb.add('経過日', '%passeddays%');
                ilb.add('ステップメールバックナンバー一覧', '%backnumber%');
                //ilb.add('ステップメールバックナンバーURL', '%bnst%');
                ilb.add('号外メールバックナンバー一覧', '%extrabacknumber%');
                //ilb.add('号外メールバックナンバーURL', '%bnex%');
                return ilb;
        }
        return null;
    }
});
<?php if (!empty($libadd)):?>
tinymce.create('tinymce.plugins.pluginlistbox', {
    createControl: function(n, cm) {
        switch (n) {
            case 'plistbox':
                var ilb = cm.createListBox('plistbox', {
                     title : 'プラグイン',
                     onselect : function(v) {
                         tinymce.execCommand('mceInsertContent', false, v);
                     }
                });
                <?php echo $libadd?>
                return ilb;
        }
        return null;
    }
});
<?php endif;?>
tinymce.PluginManager.add('replace', tinymce.plugins.replacelistbox);
<?php if (!empty($libadd)):?>
tinymce.PluginManager.add('piplace', tinymce.plugins.pluginlistbox);
<?php endif;?>
tinymce.init({
    selector: "textarea#ContentsContent",
    theme : 'advanced',
	mode : "textareas",
    width : '100%',
<?php if (!empty($libadd)):?>
    plugins : '-piplace,-replace,media,inlinepopups,contextmediamenu,inlinesourceeditor,quickuploadfile,quickuploadaudio,quickuploadvideo,template,emotions',
<?php else:?>
    plugins : '-piplace,media,inlinepopups,contextmediamenu,inlinesourceeditor,quickuploadfile,quickuploadaudio,quickuploadvideo,template,emotions',
<?php endif;?>
    style_formats : [
    {title:'黒下線',inline:'span',classes:'bd-b'},
    {title:'青下線',inline:'span',classes:'bd-blue-b'},
    {title:'緑下線',inline:'span',classes:'bd-green-b'},
    {title:'赤下線',inline:'span',classes:'bd-red-b'},
    {title:'橙下線',inline:'span',classes:'bd-orange-b'},
    {title:'青マーカー',inline:'span',classes:'mk-blue'},
    {title:'水色マーカー',inline:'span',classes:'mk-lightblue'},
    {title:'ピンクマーカー',inline:'span',classes:'mk-pink'},
    {title:'赤マーカー',inline:'span',classes:'mk-red'},
    {title:'橙マーカー',inline:'span',classes:'mk-orange'},
    {title:'黄マーカー',inline:'span',classes:'mk-yellow'},
    {title:'緑マーカー',inline:'span',classes:'mk-green'},
    {title:'ボックス',block:'div',classes:'box-glay'},
    {title:'ブルーボックス',block:'div',classes:'box-darkblue'},
    {title:'グリーンボックス',block:'div',classes:'box-green'},
    {title:'レッドボックス',block:'div',classes:'box-red'},
    {title:'オレンジボックス',block:'div',classes:'box-orange'},
    {title:'ボタン',inline:'span',classes:'btn'},
    {title:'青ボタン',inline:'span',classes:'btn btn-info'},
    {title:'緑ボタン',inline:'span',classes:'btn btn-success'},
    {title:'赤ボタン',inline:'span',classes:'btn btn-danger'},
    {title:'橙ボタン',inline:'span',classes:'btn btn-warning'},
    {title:'黒ボタン',inline:'span',classes:'btn btn-inverse'},
    {title:'ラベル',inline:'span',classes:'label'},
    {title:'青ラベル',inline:'span',classes:'label label-info'},
    {title:'緑ラベル',inline:'span',classes:'label label-success'},
    {title:'赤ラベル',inline:'span',classes:'label label-important'},
    {title:'橙ラベル',inline:'span',classes:'label label-warning'},
    {title:'黒ラベル',inline:'span',classes:'label label-inverse'},
    {title:'バッチ',inline:'span',classes:'badge'},
    {title:'青バッチ',inline:'span',classes:'badge badge-info'},
    {title:'緑バッチ',inline:'span',classes:'badge badge-success'},
    {title:'赤バッチ',inline:'span',classes:'badge badge-important'},
    {title:'橙バッチ',inline:'span',classes:'badge badge-warning'},
    {title:'黒バッチ',inline:'span',classes:'badge badge-inverse'},
    ],
    theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,quickuploadfile,quickuploadaudio,quickuploadvideo',
    theme_advanced_buttons2 : 'formatselect,fontsizeselect,styleselect,relistbox,plistbox,emotions,|,removeformat,|,inlinesourceeditor',
    theme_advanced_toolbar_location : 'top',
    theme_advanced_toolbar_align : 'left',
    theme_advanced_statusbar_location : 'bottom',
    theme_advanced_resizing : true,
    theme_advanced_resize_horizontal : false,
    language                         : 'ja',
    skin : "cyfons",
    skin_variant : "silver",
    content_css : '<?php echo URL; ?>/common/css/rte.css',
    file_browser_callback: 'openKCFinder',
    document_base_url                : '<?php echo URL; ?>/',
    relative_urls                    : false,
    remove_script_host               : false,
    convert_urls                     : true,
    accessibility_warnings           : false,
    theme_advanced_font_sizes        : '90%,100%,130%,150%,180%,220%,260%,320%',
    theme_advanced_styles            : '黒下線=bd-b;青下線=bd-blue-b;緑下線=bd-green-b;赤下線=bd-red-b;橙下線=bd-orange-b;',
    template_popup_width             : '400px',
    template_popup_height            : '200px',
    media_types  : 'video=mp4;wmp=avi,wmv;audio=mp3,wav',
    media_strict : true,
    force_br_newlines : true,
    forced_root_block : '',
    force_p_newlines : false,
    valid_elements : '*[*]',
    extended_valid_elements : 'iframe[src|width|height|name|align|frameborder|class|allowfullscreen]'
});
function openKCFinder(field_name, url, type, win) {
    wm = tinyMCE.activeEditor.windowManager;
    var dir = type;
    if(url.indexOf('/')==0)
        url = '<?php echo substr(URL,0,strpos(URL,'/',8)); ?>' + url
    if(url.indexOf('<?php echo URL;?>')==0)
    {
        var begin = '<?php echo URL;?>/myfiles/'.length;
        var end   = url.lastIndexOf('/');
        dir = url.slice(begin,end);
    }
    wm.open({
    file: '<?php echo URL; ?>/common/js/kcfinder/browse.php?lang_code=ja&opener=tinymce&type=' + type + '&dir=' + dir,
    title: 'KCFinder',
    width: 700,
    height: 500,
    resizable: 'yes',
    inline: true,
    close_previous: 'no',
    popup_css: false
    }, {
    window: win,
    input: field_name
    });
    return false;
}
</script>