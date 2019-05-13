<script type="text/javascript">
$.fn.extend({
    insertAtCaret: function(v) {
        var o = this.get(0);
        o.focus();
        if (jQuery.browser.msie) {
            var r = document.selection.createRange();
            r.text = v;
            r.select();
        } else {
            var s = o.value;
            var p = o.selectionStart;
            var np = p + v.length;
            o.value = s.substr(0, p) + v + s.substr(p);
            o.setSelectionRange(np, np);
        }
    }
});
</script>
<div style="margin:0;max-width:100%;" class="span8">
    <div class="span3" style="float:right">
        <select id="reText" onchange="$('#textContent').insertAtCaret(this.options[this.selectedIndex].value);this.selectedIndex=0">
        <option value="">メール内に使える差込文字</option>
        <option value="%name1%">姓</option>
        <option value="%name2%">名</option>
        <option value="%email%">Email（ログインID）</option>
        <option value="%password%">パスワード</option>
        <option value="%group%">グループ</option>
        <option value="%id%">会員ID</option>
        <option value="%order_no%">注文ID</option>
        <option value="%url%">会員サイトURL</option>
        <option value="%form_edit%">会員情報修正URL</option>
        <option value="%form_stop%">解除フォーム</option>
        <option value="%stopurl%">即解除（ワンクリック解除）URL</option>
        <option value="%registday%">登録日</option>
        <option value="%ip%">登録時IP</option>
        <option value="%host%">登録時HOST</option>
        <option value="%passeddays%">経過日</option>
        <option value="%today%">送信時の日付</option>
        <option value="%today+n%">送信時+n日</option>
        <?php /*?><option value="%bnst%">ステップメール バックナンバーURL</option><?php */?>
        <?php /*?><option value="%bnex%">号外メール バックナンバーURL</option><?php */?>
        </select>
    </div>
</div>
