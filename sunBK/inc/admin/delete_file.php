<?php
$header_img_dir		= DP_UPLOAD_DIR . "/header";
$mb_header_img_dir	= DP_UPLOAD_DIR . "/header/mobile";
$bg_img_dir			= DP_UPLOAD_DIR . "/background";
$title_img_dir		= DP_UPLOAD_DIR . "/title";

$dp_theme_title_images 		= dp_get_uploaded_images("title");
$dp_theme_header_images 	= dp_get_uploaded_images("header");
$dp_theme_mb_header_images 	= dp_get_uploaded_images("header/mobile");
$dp_theme_bg_images 		= dp_get_uploaded_images("background");
?>

<div class="wrap">
<div id="dp_custom">
<h2 class="dp_h2"><span class="dp-admin-logo"></span>アップロード画像削除</h2>
<p class="ft11px"><?php echo DP_THEME_NAME . ' Ver.' . DP_OPTION_SPT_VERSION; ?></p>
<?php dp_permission_check(); ?>

<form method="post" action="#" name="dp_form" enctype="multipart/form-data">
<h3 class="dp_h3 icon-menu">タイトル画像削除</h3>
<div class="dp_box">
	<dl>
		<!-- 画像一覧・選択 -->
		<dt id="set_custom_hd_img">
		<p class="dp_set_title1 icon-bookmark">削除するタイトル画像の選択
		</p>
		</dt>
			<dd>
			<div class="imgHover">
			<?php
			if ( !empty($dp_theme_title_images) ) {
				if ( strpos($dp_theme_title_images[0][0], DP_THEME_URI . "/img/sample/") === false ) {
					echo '<ul class="clearfix thumb">';
					foreach ($dp_theme_title_images[0] as $key => $current_image) {
						//Current Image
						if ($options['dp_title_img'] === $current_image) {
							$chk	= " checked";
						} else {
							$chk	= "";
						}
						echo '<li><div class="clearfix pd10px-btm">
							<img src="' . $current_image . '"  class="thumbImg" />
							<img src="' . $current_image . '" class="hiddenImg" />
							</div>
							<input name="dp_title_img" id="dp_title_img'.$key.'" type="radio" value="' . $title_img_dir . '/'. $dp_theme_title_images[1][$key] . '"' . $chk . ' />
							<label for="dp_title_img'.$key.'">' . $dp_theme_title_images[1][$key] . '</label></li>';
					}
					echo '</ul>';
				} else {
					echo '<p>アップロードされたイメージはまだありません。</p>';
				}
			} else {
				echo '<p>アップロードされたイメージはまだありません。</p>';
			}
			?>
			<div class="slide-title icon-attention mg12px-top"><?php _e('Note...', 'DigiPress'); ?></div>
			<div class="slide-content">
			※削除できない場合は、FTPクライアント等にて<span class="red">サーバーから該当ファイルを直接削除</span>してください。<br />
			※削除対象のファイルが存在する場所は「<?php echo $title_img_dir; ?>」です。
			</div>
			</div>

			<input class="btn btn-red" type="submit" name="dp_delete_file_title_img" value=" <?php _e('Delete File', 'DigiPress'); ?> " onclick="return confirm('選択したアップロードファイルを削除しますか？')" />
			</dd>
	</dl>
</form>
</div>

<input class="btn close_all mg15px-btm" type="button" name="close_all" value="   <?php _e('Close All', 'DigiPress'); ?>   " />


<h3 class="dp_h3 icon-menu">ヘッダー画像削除</h3>
<div class="dp_box">
	<dl>
		<!-- ヘッダー画像一覧・選択 -->
		<dt id="set_custom_hd_img">
		<p class="dp_set_title1 icon-bookmark">削除するヘッダー画像の選択
		</p>
		</dt>
			<dd>
				<div class="imgHover mg30px-btm">
				<h3 class="dp_set_title2">PCテーマ用</h3>
				<form method="post" action="#" name="dp_form" enctype="multipart/form-data">
				<?php
				if ( !empty($dp_theme_header_images) ) {
					if ( strpos($dp_theme_header_images[0][0], DP_THEME_URI . "/img/sample/") === false ) {
						echo '<ul class="clearfix thumb">';
						foreach ($dp_theme_header_images[0] as $key => $current_image) {
							//Current Image
							if ($options['dp_header_img'] === $current_image) {
								$chk	= " checked";
							} else {
								$chk	= "";
							}
							echo '<li><div class="clearfix pd10px-btm">
								<img src="' . $current_image . '"  class="thumbBannerImg_crop" />
								<img src="' . $current_image . '" class="hiddenImg" />
								</div>
								<input name="dp_header_img" id="dp_header_img'.$key.'" type="radio" value="' . $header_img_dir . '/' . $dp_theme_header_images[1][$key] . '"' . $chk . ' />
								<label for="dp_header_img'.$key.'">' . $dp_theme_header_images[1][$key] . '</label></li>';
						}
						echo '</ul>';
					} else {
						echo '<p>アップロードされたイメージはまだありません。</p>';
					}
				} else {
					echo '<p>アップロードされたイメージはまだありません。</p>';
				}
				?>
				<div class="slide-title icon-attention mg12px-top"><?php _e('Note...', 'DigiPress'); ?></div>
				<div class="slide-content mg15px-btm">
				※削除できない場合は、FTPクライアント等にて<span class="red">サーバーから該当ファイルを直接削除</span>してください。<br />
				※削除対象のファイルが存在する場所は「<?php echo $header_img_dir; ?>」です。
				</div>

				<input class="btn btn-red" type="submit" name="dp_delete_file_hd" value=" <?php _e('Delete File', 'DigiPress'); ?> " onclick="return confirm('選択したアップロードファイルを削除しますか？')" />
				</form>
				</div>


				<div class="imgHover">
				<h3 class="dp_set_title2">モバイルテーマ用</h3>
				<form method="post" action="#" name="dp_form" enctype="multipart/form-data">
				<?php
				if ( !empty($dp_theme_mb_header_images) ) {
					if ( strpos($dp_theme_mb_header_images[0][0], DP_THEME_URI . "/img/sample/") === false ) {
						echo '<ul class="clearfix thumb">';
						foreach ($dp_theme_mb_header_images[0] as $key => $current_image) {
							//Current Image
							if ($options['dp_header_img_mobile'] === $current_image) {
								$chk	= " checked";
							} else {
								$chk	= "";
							}
							echo '<li><div class="clearfix pd10px-btm">
								<img src="' . $current_image . '"  class="thumbBannerImg_crop" />
								<img src="' . $current_image . '" class="hiddenImg" />
								</div>
								<input name="dp_header_img_mobile" id="dp_header_img_mobile'.$key.'" type="radio" value="' . $mb_header_img_dir . '/' . $dp_theme_mb_header_images[1][$key] . '"' . $chk . ' />
								<label for="dp_header_img_mobile'.$key.'">' . $dp_theme_mb_header_images[1][$key] . '</label></li>';
						}
						echo '</ul>';
					} else {
						echo '<p>アップロードされたイメージはまだありません。</p>';
					}
				} else {
					echo '<p>アップロードされたイメージはまだありません。</p>';
				}
				?>
				<div class="slide-title icon-attention mg12px-top"><?php _e('Note...', 'DigiPress'); ?></div>
				<div class="slide-content mg15px-btm">
				※削除できない場合は、FTPクライアント等にて<span class="red">サーバーから該当ファイルを直接削除</span>してください。<br />
				※削除対象のファイルが存在する場所は「<?php echo $mb_header_img_dir; ?>」です。
				</div>
				
				<input class="btn btn-red" type="submit" name="dp_delete_file_hd_mobile" value=" <?php _e('Delete File', 'DigiPress'); ?> " onclick="return confirm('選択したアップロードファイルを削除しますか？')" />
				</form>
				</div>
			</dd>
	</dl>
</div>

<input class="btn close_all mg15px-btm" type="button" name="close_all" value="   <?php _e('Close All', 'DigiPress'); ?>   " />


<form method="post" action="#" name="dp_form" enctype="multipart/form-data">
<h3 class="dp_h3 icon-menu">背景画像削除</h3>
<div class="dp_box">
	<dl>
		<!-- 背景画像一覧・選択 -->
		<dt id="set_custom_hd_img">
		<p class="dp_set_title1 icon-bookmark">削除する背景画像の選択
		</p>
		</dt>
			<dd>
			<div class="imgHover">
			<?php
			if ( !empty($dp_theme_bg_images) ) {
				if ( strpos($dp_theme_bg_images[0][0], DP_THEME_URI . "/img/sample/") === false ) {
					echo '<ul class="clearfix thumb">';
					foreach ($dp_theme_bg_images[0] as $key => $current_image) {
						//Current Image
						if ($options['dp_background_img'] === $current_image) {
							$chk	= " checked";
						} else {
							$chk	= "";
						}
						echo '<li><div class="clearfix pd10px-btm">
							<img src="' . $current_image . '"  class="thumbBannerImg_crop" />
							<img src="' . $current_image . '" class="hiddenImg" />
							</div>
							<input name="dp_background_img" id="dp_background_img'.$key.'" type="radio" value="' . $bg_img_dir . '/' . $dp_theme_bg_images[1][$key] . '"' . $chk . ' />
							<label for="dp_background_img'.$key.'">' . $dp_theme_bg_images[1][$key] . '</label></li>';
					}
					echo '</ul>';
				} else {
					echo '<p>アップロードされたイメージはまだありません。</p>';
				}
			} else {
				echo '<p>アップロードされたイメージはまだありません。</p>';
			}
			?>
			<div class="slide-title icon-attention mg12px-top"><?php _e('Note...', 'DigiPress'); ?></div>
			<div class="slide-content">
			※サムネイルにカーソルを合わせると実寸大のイメージが表示されます。<br />
			※削除できない場合は、FTPクライアント等にて<span class="red">サーバーから該当ファイルを直接削除</span>してください。<br />
			※削除対象のファイルが存在する場所は「<?php echo $bg_img_dir; ?>」です。
			</div>
			</div>

			<input class="btn btn-red" type="submit" name="dp_delete_file_bg" value=" <?php _e('Delete File', 'DigiPress'); ?> " onclick="return confirm('選択したアップロードファイルを削除しますか？')" />
			</dd>
	</dl>
</form>
</div>

<input class="btn close_all mg15px-btm" type="button" name="close_all" value="   <?php _e('Close All', 'DigiPress'); ?>   " />

</div>
</div>
