<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../common/element/gnav_top.php'); ?>
</div>
</div>
</div>
</div>
<div class="container" id="container">
<div id="content">
<div id="message"></div>
<div class="titles form">
<form accept-charset="utf-8" method="POST" id="contactForm" action="">
<fieldset>
<legend>提案・改善</legend>
<div class="waku">
<p>Cyfonsは、「皆で一緒に作っていくシステム」をコンセプトにしています。</p>
<p>実際にシステムをご利用される中で気がついた、ユニークな使い方、新機能のご意見などありましたら下記フォームからどんどんと連絡ください。<p>
<p>動作に関する改善項目なども、こちらのフォームからご連絡ください。<p>
<p>頂いた意見は、更なるシステムの向上に役立てていきます。<br>
また、<span class="bold">画期的な機能を提案して下さった方には、素敵なプレゼントを用意しています。</span><br>
こちらに関してはまたいずれ告知する予定ですが、アイデアのユニークさに応じて、<br>
貰えるプレゼントは変わっていきます。<p>
<p>Cyfonsとは一見全く関係無いシステムでも構いませんので、少しでも、<br>
<span class="bold">「こんなシステムがあれば面白いんじゃないか」</span><br>
と思ったものがあれば、どんどんご提案下さい。<p>
<p class="red">※送信の際、Cyfonsのシステム情報を送信します。個人に関わる情報は一切送信しません。<p>
</div>
<?php if(isset( $message )) echo '<div class="alert alert-success">'.$message.'</div>';?>
<?php if(isset( $err_message )) echo '<div class="alert alert-danger">'.$err_message.'</div>';?>
<div class="control-group">
<div class="controls required">
<label class="control-label" for="title"><span class="red">*</span>件名</label>
<input id="" class="input-xxlarge" name="title" value="<?php echo $form_data['title']; ?>">
<?php if(isset($err['title'])) echo '<p class="red">'.$err['title'].'</p>'; ?>
</div>
</div>
<div class="control-group">
<div class="controls required">
<label class="control-label" for="name"><span class="red">*</span>お名前</label>
<input id="" class="input-xxlarge" name="name" value="<?php echo $form_data['name']; ?>">
<?php if(isset($err['name'])) echo '<p class="red">'.$err['name'].'</p>'; ?>
</div>
</div>
<div class="control-group">
<div class="controls required">
<label class="control-label" for="email"><span class="red">*</span>メールアドレス</label>
<input id="" class="input-xxlarge" name="email" value="<?php echo $form_data['email']; ?>">
<?php if(isset($err['email'])) echo '<p class="red">'.$err['email'].'</p>'; ?>
</div>
</div>

<div class="control-group">
<div class="controls required">
<label class="control-label" for="title"><span class="red">*</span>カテゴリ</label>
<select class="span2"  name="cat">
	<option value="">選択してください</option>
	<option <?php echo ($form_data['cat']=='提案') ? 'selected="selected"':''; ?> >提案</option>
	<option <?php echo ($form_data['cat']=='メール全般') ? 'selected="selected"':''; ?> >メール全般</option>
	<option <?php echo ($form_data['cat']=='ステップメール') ? 'selected="selected"':''; ?> >ステップメール</option>
	<option <?php echo ($form_data['cat']=='号外メール') ? 'selected="selected"':''; ?> >号外メール</option>
	<option <?php echo ($form_data['cat']=='コンテンツ') ? 'selected="selected"':''; ?> >コンテンツ</option>
	<option <?php echo ($form_data['cat']=='サイドバー') ? 'selected="selected"':''; ?> >サイドバー</option>
	<option <?php echo ($form_data['cat']=='グループ') ? 'selected="selected"':''; ?> >グループ</option>
	<option <?php echo ($form_data['cat']=='短縮URL') ? 'selected="selected"':''; ?> >短縮URL</option>
	<option <?php echo ($form_data['cat']=='商品入金管理') ? 'selected="selected"':''; ?> >商品入金管理</option>
	<option <?php echo ($form_data['cat']=='その他') ? 'selected="selected"':''; ?> >その他</option>
</select>
<?php if(isset($err['cat'])) echo '<p class="red">'.$err['cat'].'</p>'; ?>
</div>
</div>

<div class="control-group">
<div class="controls required">
<label class="control-label" for="content"><span class="red">*</span>本文</label>
<textarea id="content" rows="6" class="input-xxlarge" cols="5" name="content"><?php echo $form_data['content']; ?></textarea>
<?php if(isset($err['content'])) echo '<p class="red">'.$err['content'].'</p>'; ?>
</div>
</div>

</fieldset>
<div class="form-actions">
<input type="hidden" value="confirm" name="status">
<button type="submit" class="btn btn-primary btn-large" style="margin-right:5px;">確認画面へ</button>
</div>
</form>
</div>
</div>
</div>
</body>
</html>
