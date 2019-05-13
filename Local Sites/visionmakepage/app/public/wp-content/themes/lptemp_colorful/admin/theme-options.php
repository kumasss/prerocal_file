<?php
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

function theme_options_add_page() {
	add_theme_page( 'テーマオプション', 'テーマオプション', 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
	add_theme_page( 'プログラムの追加', 'プログラムの追加', 'edit_theme_options', 'custom_css', 'custom_css_do_page' );
}

function theme_options_init() {
	register_setting( 'entire_options', 'entire_options', 'theme_options_validate' );
	register_setting( 'custom_css', 'custom_css', 'theme_options_validate' );
}

// 初期値
global $default_options;
$default_options = array(
	'bg_color' => '',
	'bg_image' => '',
	'bg_repeat' => 'repeat',
	'bg_attachment' => 'scroll',
	'bg_position' => 'left',

	'content_bg_color' => '',
	'content_bg_image' => '',
	'content_bg_repeat' => 'repeat',
	'content_bg_attachment' => 'scroll',
	'content_bg_position' => 'left',
	'shadow_enable' => 'on',
	'shadow_color' => '#000000',

	'sidebar_font_color' => '#000000',
	'sidebar_bg_color' => '',
	'sidebar_bg_image' => '',
	'sidebar_bg_repeat' => 'repeat',
	'sidebar_bg_attachment' => 'scroll',
	'sidebar_bg_position' => 'left',

	'sp_enable' => 'on',
	'pwidth' => 900,
	'font_family' => '',
	'fontsize' => 16,
	'lineheight' => 2.3,

	'menu_enable' => 'off',
	'menu_position' => 'top',
	'menu_name' => '',
	'menu_design' => 'design1',

	'sidebar' => 'left',
	'header_content' => 0,
	'footer_content' => 0,

	'all_enable' => 'off',

	'blog_type' => 'design1',
);

// プログラムの追加 初期値
global $custom_css;
$custom_css = array(
	'css' => '',
	'head' => '',
	'body' => '',
);

function get_theme_options() {
	global $default_options;
	return shortcode_atts($default_options, get_option('entire_options', array()));
}

function get_custom_css() {
	global $custom_css;
	return shortcode_atts($custom_css, get_option('custom_css', array()));
}

// JavaScriptの読み込み
add_action('admin_enqueue_scripts', 'my_admin_enqueue_scripts');
function my_admin_enqueue_scripts() {
	wp_enqueue_media();
	wp_enqueue_script('options-script', get_template_directory_uri().'/admin/options.js', array('jquery-ui-tabs', 'wp-color-picker'), false, true);
}

// CSSの読み込み
add_action('admin_print_styles', 'my_admin_print_styles');
function my_admin_print_styles() {
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_style('jquery-ui-tabs', get_template_directory_uri().'/admin/jquery-ui.min.css');
	wp_enqueue_style('myOptionsCSS', get_template_directory_uri().'/admin/options.css');
}

// バリデーションチェック
function theme_options_validate( $input ) {
	return $input;
}

// テーマオプションページ作成
function theme_options_do_page() {
  $options = get_theme_options();
?>
<div class="wrap">
<h2>テーマオプション サイト全体設定</h2>
<form method="post" action="options.php"> 
<?php settings_fields( 'entire_options' ); do_settings_sections( 'entire_options' ); ?>

<div id="tabs">
  <ul>
    <li><a href="#tab-content1">ブログ機能設定</a></li>
  </ul>

<div id="tab-content1">
  <p>ブログ利用も行いたい時に活用できる機能です。<br>
  ですので、通常のLP制作においては利用の必要がない応用機能となります。</p>

  <p>こちらでの設定は「全ての投稿ページ」「カテゴリページ」「アーカイブページ」に反映されます。<br>
  「固定ページ」には基本反映されません(つまり個別のLPには影響がありません)<br>
  しかし、下部の「固定ページ設定」より反映させることは可能です。</p>

  <p>なお、こちらは上級機能となりますので、<br>
  動画マニュアルを参照の上、操作をお願いいたします。</p>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">背景設定</h3>

    <h4 class="theme_option_headline_sub">背景色</h4>
    <div class="theme_option_input">
      <input type="text" name="entire_options[bg_color]" class="color-picker" value="<?= $options['bg_color']; ?>" data-default-color="<?= $options['bg_color']; ?>">
    </div>

    <h4 class="theme_option_headline_sub">背景画像URL</h4>
    <div class="theme_option_input">
      <input type="text" id="media1" name="entire_options[bg_image]" value="<?= $options['bg_image']; ?>" size="50">
      <button type="button" class="select-file button" data-input="media1">ファイルを選択</button>
    </div>

    <h4 class="theme_option_headline_sub">背景画像繰り返し</h4>
    <div class="theme_option_input">
      <?php
        $repeat_array = array (
          'repeat' => '繰り返す',
          'repeat-x' => '横方向に繰り返す',
          'repeat-y' => '縦方向に繰り返す',
          'no-repeat' => '繰り返さない'
        );
        $checked = '';
        $bg_repeat = $options['bg_repeat'];
        foreach( $repeat_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[bg_repeat]" value="<?= $value; ?>"<?= ($bg_repeat == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>

    <h4 class="theme_option_headline_sub">背景画像固定</h4>
    <div class="theme_option_input">
      <?php
        $attachment_array = array (
          'fixed' => '固定する',
          'scroll' => '固定しない'
        );
        $checked = '';
        $bg_attachment = $options['bg_attachment'];
        foreach( $attachment_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[bg_attachment]" value="<?= $value; ?>"<?= ($bg_attachment == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>

    <h4 class="theme_option_headline_sub">背景画像の配置</h4>
    <div class="theme_option_input">
      <?php
        $position_array = array (
          'right' => '右よせ',
          'center' => '中央',
          'left' => '左よせ'
        );
        $checked = '';
        $bg_position = $options['bg_position'];
        foreach( $position_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[bg_position]" value="<?= $value; ?>"<?= ($bg_position == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>
  </div>

  <hr>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">記事背景設定</h3>

    <h4 class="theme_option_headline_sub">背景色</h4>
    <div class="theme_option_input">
      <input type="text" name="entire_options[content_bg_color]" class="color-picker" value="<?= $options['content_bg_color']; ?>" data-default-color="<?= $options['content_bg_color']; ?>">
    </div>

    <h4 class="theme_option_headline_sub">背景画像URL</h4>
    <div class="theme_option_input">
      <input type="text" id="media2" name="entire_options[content_bg_image]" value="<?= $options['content_bg_image']; ?>" size="50">
      <button type="button" class="select-file button" data-input="media2">ファイルを選択</button>
    </div>

    <h4 class="theme_option_headline_sub">背景画像繰り返し</h4>
    <div class="theme_option_input">
      <?php
        $content_repeat_array = array (
          'repeat' => '繰り返す',
          'repeat-x' => '横方向に繰り返す',
          'repeat-y' => '縦方向に繰り返す',
          'no-repeat' => '繰り返さない'
        );
        $checked = '';
        $content_bg_repeat = $options['content_bg_repeat'];
        foreach( $content_repeat_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[content_bg_repeat]" value="<?= $value; ?>"<?= ($content_bg_repeat == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>

    <h4 class="theme_option_headline_sub">背景画像固定</h4>
    <div class="theme_option_input">
      <?php
        $content_attachment_array = array (
          'fixed' => '固定する',
          'scroll' => '固定しない'
        );
        $checked = '';
        $content_bg_attachment = $options['content_bg_attachment'];
        foreach( $content_attachment_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[content_bg_attachment]" value="<?= $value; ?>"<?= ($content_bg_attachment == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>

    <h4 class="theme_option_headline_sub">背景画像の配置</h4>
    <div class="theme_option_input">
      <?php
        $content_position_array = array (
          'right' => '右よせ',
          'center' => '中央',
          'left' => '左よせ'
        );
        $checked = '';
        $content_bg_position = $options['content_bg_position'];
        foreach( $content_position_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[content_bg_position]" value="<?= $value; ?>"<?= ($content_bg_position == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>

    <h4 class="theme_option_headline_sub">影の設定</h4>
    <div class="theme_option_input">
      <?php
        $shadow_array = array (
          'on' => 'ON',
          'off' => 'OFF'
        );
        $checked = '';
        $shadow_enable = $options['shadow_enable'];
        foreach( $shadow_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[shadow_enable]" class="shadow_enable" value="<?= $value; ?>"<?= ($shadow_enable == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>

    <div id="shadow_color"<?php if($options['shadow_color']!='on') : ?> style="display:none"<?php endif; ?>>
      <h4 class="theme_option_headline_sub">影の色</h4>
      <div class="theme_option_input">
        <input type="text" name="entire_options[shadow_color]" class="color-picker" value="<?= $options['shadow_color']; ?>" data-default-color="<?= $options['shadow_color']; ?>">
      </div>
    </div>
  </div>

  <hr>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">サイドバー背景設定</h3>

    <h4 class="theme_option_headline_sub">文字色</h4>
    <div class="theme_option_input">
      <input type="text" name="entire_options[sidebar_font_color]" class="color-picker" value="<?= $options['sidebar_font_color']; ?>" data-default-color="<?= $options['sidebar_font_color']; ?>">
    </div>

    <h4 class="theme_option_headline_sub">背景色</h4>
    <div class="theme_option_input">
      <input type="text" name="entire_options[sidebar_bg_color]" class="color-picker" value="<?= $options['sidebar_bg_color']; ?>" data-default-color="<?= $options['sidebar_bg_color']; ?>">
    </div>

    <h4 class="theme_option_headline_sub">背景画像URL</h4>
    <div class="theme_option_input">
      <input type="text" id="media3" name="entire_options[sidebar_bg_image]" value="<?= $options['sidebar_bg_image']; ?>" size="50">
      <button type="button" class="select-file button" data-input="media3">ファイルを選択</button>
    </div>

    <h4 class="theme_option_headline_sub">背景画像繰り返し</h4>
    <div class="theme_option_input">
      <?php
        $sidebar_repeat_array = array (
          'repeat' => '繰り返す',
          'repeat-x' => '横方向に繰り返す',
          'repeat-y' => '縦方向に繰り返す',
          'no-repeat' => '繰り返さない'
        );
        $checked = '';
        $sidebar_bg_repeat = $options['sidebar_bg_repeat'];
        foreach( $sidebar_repeat_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[sidebar_bg_repeat]" value="<?= $value; ?>"<?= ($sidebar_bg_repeat == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>

    <h4 class="theme_option_headline_sub">背景画像固定</h4>
    <div class="theme_option_input">
      <?php
        $sidebar_attachment_array = array (
          'fixed' => '固定する',
          'scroll' => '固定しない'
        );
        $checked = '';
        $sidebar_bg_attachment = $options['sidebar_bg_attachment'];
        foreach( $sidebar_attachment_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[sidebar_bg_attachment]" value="<?= $value; ?>"<?= ($sidebar_bg_attachment == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>

    <h4 class="theme_option_headline_sub">背景画像の配置</h4>
    <div class="theme_option_input">
      <?php
        $sidebar_position_array = array (
          'right' => '右よせ',
          'center' => '中央',
          'left' => '左よせ'
        );
        $checked = '';
        $sidebar_bg_position = $options['sidebar_bg_position'];
        foreach( $sidebar_position_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[sidebar_bg_position]" value="<?= $value; ?>"<?= ($sidebar_bg_position == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>
  </div>

  <hr>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">応用設定</h3>

    <h4 class="theme_option_headline_sub">スマホ最適化(レスポンシブ対応)</h4>
    <div class="theme_option_input">
      <?php
        $sp_array = array (
          'on' => 'ON',
          'off' => 'OFF'
        );
        $checked = '';
        $sp_enable = $options['sp_enable'];
        foreach( $sp_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[sp_enable]" value="<?= $value; ?>"<?= ($sp_enable == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>

    <h4 class="theme_option_headline_sub">ページ幅設定</h4>
      <input type="number" name="entire_options[pwidth]" value="<?= $options['pwidth']; ?>" size="50" step="1">
    <div class="theme_option_input">
    </div>

    <h4 class="theme_option_headline_sub">フォント設定</h4>
    <div class="theme_option_input">
      <select name="entire_options[font_family]">
      <?php
        $font_array = array (
          '0' => '設定なし',
          '1' => 'ゴシック体',
          '2' => '明朝体',
          '3' => 'メイリオ',
          '4' => '丸ゴシック体',
          '5' => '游ゴシック体',
          '6' => '游明朝体'
        );
        $font_family = $options['font_family'];
        foreach( $font_array as $value => $label ) :
      ?>
      <option value="<?= $value; ?>"<?= ($font_family == $value) ? ' selected="selected"': ''; ?>><?= $label; ?></option>
      <?php endforeach; ?>
      </select>
    </div>

    <h4 class="theme_option_headline_sub">フォントサイズ設定</h4>
    <div class="theme_option_input">
      <input type="number" name="entire_options[fontsize]" value="<?= $options['fontsize']; ?>" size="50" step="1">
    </div>

    <h4 class="theme_option_headline_sub">行間設定</h4>
    <div class="theme_option_input">
      <input type="number" name="entire_options[lineheight]" value="<?= $options['lineheight']; ?>" size="50" step="0.1">
    </div>
  </div>

  <hr>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">メニュー設定</h3>

    <h4 class="theme_option_headline_sub">メニュー表示</h4>
    <div class="theme_option_input">
      <?php
        $menu_enable_array = array (
          'on' => 'ON',
          'off' => 'OFF'
        );
        $checked = '';
        $menu_enable = $options['menu_enable'];
        foreach( $menu_enable_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[menu_enable]" value="<?= $value; ?>"<?= ($menu_enable == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>

    <h4 class="theme_option_headline_sub">【応用】メニュー位置</h4>
    <div class="theme_option_input">
      <?php
        $menu_position_array = array (
          'top' => '最上部',
          'middle' => '全体ヘッダー直下'
        );
        $checked = '';
        $menu_position = $options['menu_position'];
        foreach( $menu_position_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[menu_position]" value="<?= $value; ?>"<?= ($menu_position == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>

    <h4 class="theme_option_headline_sub">メニュー名</h4>
    <div class="theme_option_input">
      <input type="text" name="entire_options[menu_name]" value="<?= $options['menu_name']; ?>" size="50">
    </div>

    <h4 class="theme_option_headline_sub">メニューデザイン</h4>
    <div class="theme_option_input">
      <select name="entire_options[menu_design]">
      <?php
        $menu_design_array = array (
          'design1' => 'パターン1 (黒)',
          'design2' => 'パターン2 (白)',
          'design3' => 'パターン3 (赤色のグラデーション)',
          'design4' => 'パターン4 (ピンクのグラデーション)',
          'design5' => 'パターン5 (水色のグラデーション)',
          'design6' => 'パターン6 (シアンのグラデーション)'
        );
        $checked = '';
        $menu_design = $options['menu_design'];
        foreach( $menu_design_array as $value => $label ) :
      ?>
      <option value="<?= $value; ?>"<?= ($menu_design == $value) ? ' selected="selected"': ''; ?>><?= $label; ?></option>
      <?php endforeach; ?>
      </select>
    </div>
  </div>

  <hr>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">2カラム設定</h3>
    <div class="theme_option_input">
      <?php
        $sidebar_array = array (
          'left' => '左サイドバー',
          'right' => '右サイドバー'
        );
        $checked = '';
        $sidebar = $options['sidebar'];
        foreach( $sidebar_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[sidebar]" value="<?= $value; ?>"<?= ($sidebar == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>
  </div>

  <hr>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">ヘッダー</h3>
    <div class="theme_option_input">
      <select name="entire_options[header_content]">
      <option value="0"></option>
      <?php
        $hover_posts = get_posts(array(
          'post_type' => 'hfcontent'
        ));
        $header_content = $options['header_content'];
      ?>
      <option value="-1"<?= ($header_content == -1) ? ' selected="selected"': ''; ?>>ウィジットテンプレート</option>
      <?php foreach( $hover_posts as $hover ) : ?>
      <option value="<?= $hover->ID; ?>"<?= ($header_content == $hover->ID) ? ' selected="selected"': ''; ?>><?= $hover->post_title; ?></option>
      <?php endforeach; ?>
      </select>
    </div>
  </div>

  <hr>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">フッター</h3>
    <div class="theme_option_input">
      <select name="entire_options[footer_content]">
      <option value="0"></option>
      <?php
        $footer_content = $options['footer_content'];
      ?>
      <option value="-1"<?= ($footer_content == -1) ? ' selected="selected"': ''; ?>>ウィジットテンプレート</option>
      <?php foreach( $hover_posts as $hover ) : ?>
      <option value="<?= $hover->ID; ?>"<?= ($footer_content == $hover->ID) ? ' selected="selected"': ''; ?>><?= $hover->post_title; ?></option>
      <?php endforeach; ?>
      </select>
    </div>
  </div>

  <hr>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">固定ページ設定</h3>
    <h4 class="theme_option_headline_sub">全ての固定ページにも全体設定を反映させる</h4>
    <div class="theme_option_input">
      <?php
        $all_array = array (
          'on' => 'ON',
          'off' => 'OFF'
        );
        $checked = '';
        $all_enable = $options['all_enable'];
        foreach( $all_array as $value => $label ) :
      ?>
      <label>
        <input type="radio" name="entire_options[all_enable]" value="<?= $value; ?>"<?= ($all_enable == $value) ? ' checked="checked"': ''; ?>><?= $label; ?>
      </label>　
      <?php endforeach; ?>
    </div>
  </div>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">ブログ一覧表示設定</h3>
    <div class="theme_option_input">
      <select name="entire_options[blog_type]">
      <?php
        $blog_type_array = array (
          'design1' => 'デフォルト',
          'design2' => 'カード型'
        );
        $checked = '';
        $blog_type = $options['blog_type'];
        foreach( $blog_type_array as $value => $label ) :
      ?>
      <option value="<?= $value; ?>"<?= ($blog_type == $value) ? ' selected="selected"': ''; ?>><?= $label; ?></option>
      <?php endforeach; ?>
      </select>
    </div>
  </div>
</div><!-- #tab-content1 -->

</div><!-- #tabs -->

<?php submit_button(); ?>
</form>
</div>
<?php }
// プログラムの追加ページ作成
function custom_css_do_page() {
  $css = get_custom_css();
?>
<div class="wrap">
<h2>プログラムの追加</h2>
<p>プログラムを追加する場合は、こちらに記入することをオススメいたします。<br>
なお、こちらでのプログラム追加は、全ページに反映されます。</p>
<form method="post" action="options.php">
<?php settings_fields( 'custom_css' ); do_settings_sections( 'custom_css' ); ?>
  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">CSSプログラムの追加</h3>
    <textarea name="custom_css[css]" cols="70" rows="30"><?= esc_html($css['css']); ?></textarea>
  </div>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">「head内」にプログラムを追加する</h3>
    <textarea name="custom_css[head]" cols="70" rows="30"><?= esc_html($css['head']); ?></textarea>
  </div>

  <div class="theme_option_field cf">
    <h3 class="theme_option_headline">「body内」にプログラムを追加する</h3>
    <textarea name="custom_css[body]" cols="70" rows="30"><?= esc_html($css['body']); ?></textarea>
  </div>
<?php submit_button(); ?>
</form>
</div>
<?php } ?>