<?php

require_once( dirname(__FILE__).'/lib/stripe-php-6.16.0/init.php');

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_vxKGcG6UQZYIgtUF88FEanUv");

// Token is created using Stripe.js or Checkout!
// Get the payment token submitted by the form:
$token = $_POST['stripeToken'];
$email = $_POST['stripeEmail'];

// フォームから情報を取得:
try {
  $charge = \Stripe\Charge::create(array(
    "amount" => 9800,
    "currency" => "jpy",
    "source" => $token,
    "description" => "visionmake",
  ));
}catch (\Stripe\Error\Card $e) {
  // 決済できなかったときの処理
  die('決済が完了しませんでした');
}



// 自動返信メール
mb_language("Japanese");
mb_internal_encoding("UTF-8");
$title = "ご購入頂きありがとうございます";
$content = "会員制サイトを配布します。ご購入頂きまして、ありがとうございました。\n
\n
まず、「Vision Make」に参加するにあたって、最初に状況を知りたいです。\n
\n
1.名前\n
2.年齢(任意)\n
3.住んでいる都道府県\n
4.「Vision Make」をなぜ購入したか\n
5.「Vision Make」知った背景\n
6.悩み\n
7.成し遂げたいこと（ex.具体的に）\n
8.これまで生きていた上での成功体験（ex.ダイエット、 受験、恋愛など）\n
\n
このメールに返信をお待ちしています。\n
\n
当プログラムでは、会員制サイトにて公開をしているので、\n
以下の手順に従って会員制サイトにご登録後、会員制サイトにログインをして閲覧ください。\n
\n
【手順】\n
\n
1.以下のURLを開きましたら\n
https://vision-make.com/index/formadd/?group_id=1\n
\n
サイトパスワードである\n
「wc2v9ia#f」\n
を入力します。\n
\n
2.続いて「会員登録」の為、\n
\n
・姓名\n
・メールアドレス\n
・希望のログインパスワード（お好きな英数字）\n
\n
を入力して「Vision Make」のボタンをクリックします。\n
\n
※この情報は「Vision Make」にログインする為の大切な情報になりますので、\n
必ずメモを取るなどしておいてください。\n
\n
3.会員登録後、以下のURLをクリックして\n
https://vision-make.com/index/main.php\n
\n
先ほどの会員登録で入力したメールアドレスを「User ID」\n
希望のログインパスワード「Password」に入力すれば、会員制サイトにログインできます。\n
\n
\n
もしログインできない場合は、\n
会員登録時に入力ミスをしている可能性が非常に高いので、\n
他のメールアドレスなどで最初から手順をやりなおすことを推奨します。\n
\n
最初の状況について、返信をぜひお願いします。\n
\n
それでは、今後ともよろしくお願いします。\n
";

$from_name = "Vision Make";
$from_addr = "vision@vision-make.com";
$from_name_enc = mb_encode_mimeheader($from_name, "ISO-2022-JP");
$from = $from_name_enc . "<" . $from_addr . ">";
$header  = "From: " . $from . "\n";
$header = $header . "Reply-To: " . $from;

//to user send mail
    
if(mb_send_mail($email,$title, $content, $header, "-f" .$from_addr)){
  echo "メールを送信しました";
} else {
  echo "メールの送信に失敗しました";
};



// 管理者宛メール
$title_me = "Vision Make";
$from_me = "vision@vision-make.com";
$content_me = "Vision Makeが購入されました。";
if(mb_send_mail($from_me,$title_me, $content_me, $header, "-f" .$from_addr)){
  echo "メールを送信しました";
} else {
  echo "メールの送信に失敗しました";
};

// サンキューページへリダイレクト
header('Location: https://vision-make.com/page/thanks/');
exit;

?>