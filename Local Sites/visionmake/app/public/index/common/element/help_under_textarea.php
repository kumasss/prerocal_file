<div style="margin-bottom:20px">
<?php
    if (isset($settings['is_edit'])){
    	if (!empty($settings['is_edit'])){
    		echo '<span class="green">※YouTube 等の埋め込みタグを入れる場合は HTMLモード（<>アイコンクリック）して埋め込んでから、もう１度<>アイコンをクリックすると反映されます。</span>
';
    	}else{
    	echo <<< EOF
<span class="green">※「記事・本文」差し込み可能な文字列</span><br>
(姓)%name1%、(名)%name2%、(メール)%email%、(パスワード)%password%、(バックナンバー)%backnumber%<br>(サイト)%url%、(注文ID)%order_no%、(解除)%stopurl%、(登録日)%registday%、(経過日)%passeddays%
EOF;
    	}
    }
?>
</div>