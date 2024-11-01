<?php
/*
Plugin Name: Yazı Sonu Metni
Plugin URI: https://drive.google.com/open?id=1VmZS4GKDdk31q6gKYmHRKp3xhtHthdKE
Description: WordPress blog yazılarının hepsinin sonuna aynı yazıyı eklemek için bir eklentidir.
Version: 1.0
Author: Mustafa Ersoy
Author URI: https://www.linkedin.com/in/mustafa-ersoy-152388157/
License: GNU
*/


add_filter("the_content","ysm_Function");
function ysm_Function($content){
   $yazimiz = get_option("yazi_sonu");
   return $content.$yazimiz;
}

add_action('admin_menu', 'ysm_menu');
function ysm_menu(){
 add_menu_page('Yazı Sonu Eklentisi','Yazı Sonu Eklentisi', 'manage_options', 'benim-eklentim', 'ysm_yonetim');
}

function ysm_yonetim(){
?>
<h1>Yazı Sonu Eklentisi</h1>
<form method="post">
<?php
wp_nonce_field('ysm_update','ysm_update');
?>
<table border="1">
<tr>
<td><label>Yazı sonlarında görünecek metin? </label></td>
<td><input type="text" name="yazi_sonu"></td>
</tr>
</table>

<input type="hidden" name="action" value="guncelle">
<input type="submit" value="Güncelle">
<input type="hidden" name="sil" value="temizle">
<input type="submit" value="Temizle">


</form>
<?php
	if($_POST["action"]=="guncelle"){
	  // Wp_nonce Kontrol edelim
	  if (!isset($_POST['ysm_update']) || ! wp_verify_nonce( $_POST['ysm_update'], 'ysm_update' ) ) {
	    print 'Üzgünüz, bu sayfaya erişim yetkiniz yok!';
	    exit;
	  }else{
	    // Güvenliği geçti ise
	    $yazi_sonu = sanitize_text_field($_POST['yazi_sonu']);
	    update_option('yazi_sonu', $yazi_sonu);
		echo 'Görünecek metin: '. get_option("yazi_sonu");
		echo '<div class="updated"><p><strong>Ayarlar kaydedildi.</strong></p></div>';
	  }
	}
	else if($_POST["sil"]=="temizle"){

	    $yazi_sonu = sanitize_text_field($_POST['yazi_sonu']);
		update_option('yazi_sonu', "");

		echo'<div class="updated"><p><strong>Ayarlar kaydedildi.  </strong></p></div>';
	}
}

?>