<?php

/*
Plugin Name: Google's PlusOne (+1) Buttons
Plugin URI: http://www.teknoblogo.com/
Description: Adds Google's new PLUSONE (+1) button to your posts ! Author : <a href="http://www.teknoblogo.com">teknoblogo.com</a><br /> <strong>Don't forgot to re-configure plugin !</strong>
Version: 1.0
Author: Eray Alakese
Author URI: http://www.teknoblogo.com
License: GPL2
*/


        wp_register_script('googleplusone', "http://apis.google.com/js/plusone.js");
        wp_enqueue_script('googleplusone');
    

function gpb_ayarlari_yap()
{
	add_option('gpb_yer', 'u');
	add_option('gpb_boyut', 'standart');
	add_option('gpb_sayi', 'yes');
}
register_activation_hook( __FILE__, 'gpb_ayarlari_yap' );

function gpb_ayarlari_sil()
{
    delete_option('gpb_yer');
    delete_option('gpb_boyut');
    delete_option('gpb_sayi');
}
register_deactivation_hook( __FILE__, 'gpb_ayarlari_sil' );

function gpb_ekle($content)
{
    $gpb_yer = get_option('gpb_yer');
    $gpb_boyut = get_option('gpb_boyut');
    $gpb_sayi = get_option('gpb_sayi');
    $gpb_perma	= rawurlencode(get_permalink());

			if($gpb_boyut == 'small' || $gpb_boyut == 'medium' || $gpb_boyut == 'tall')
			{}
			else {
				$gpb_boyut = '';
			}
				
    
    		if($gpb_sayi == 'yes')
    		{
    			$gpb_button = "<g:plusone size=\"$gpb_boyut\" href=\"$gpb_perma\"></g:plusone>";
    		}
    		else
    		{
    			$gpb_button = "<g:plusone size=\"$gpb_boyut\" count=\"false\" href=\"$gpb_perma\"></g:plusone>";
    		}
    
        if ($gpb_yer == "u")
        {
            $content = $gpb_button."<br />".$content;
            return $content;
        }
        elseif ($gpb_yer == "a")
        {
            $content = $content."<br />".$gpb_button;
            return $content;
        }
   		elseif($gpb_yer == 'manual') {
        		echo $gpb_button;
    		}
}
if (get_option('gpb_yer')!="manual"){ add_filter( "the_content", "gpb_ekle" ); }
    
    
add_action('admin_menu', 'gpb_admin_menu');
function gpb_admin_menu() {
	add_options_page('Google PlusOne Button', 'Google PlusOne Button', 'manage_options', 'gpb', 'gpb_admin_options');
} 
function gpb_admin_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	echo '<div class="wrap">';
    ?>
		
		<h2>Google's PlusOne (+1) Button</h2>
		<?
    	if($_POST["gpb_gonder"])
    	{
      	echo "<h3>saved</h3>";
      	update_option('gpb_boyut', $_POST["gpb_boyut"]);
      	update_option('gpb_sayi', $_POST["gpb_sayi"]);
      	update_option('gpb_yer', $_POST["gpb_yer"]);
    	}
    	?>
    	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
    		<p>Size : </p>
    		<input type="radio" name="gpb_boyut" value="small" <?php if(get_option('gpb_boyut') == 'small'){ echo "CHECKED"; }?> > Small (15 px)
    		<input type="radio" name="gpb_boyut" value="medium" <?php if(get_option('gpb_boyut') == 'medium'){ echo "CHECKED"; }?> > Medium (20 px)
    		<input type="radio" name="gpb_boyut" value="standard" <?php if(get_option('gpb_boyut') == 'standard'){ echo "CHECKED"; }?> > Standard (24 px)
    		<input type="radio" name="gpb_boyut" value="tall" <?php if(get_option('gpb_boyut') == 'tall'){ echo "CHECKED"; }?> > Tall (60 px)
    		
    		<p>Include +1 count ?</p> 		
    		<input type="radio" name="gpb_sayi" value="yes" <?php if(get_option('gpb_sayi') == 'yes'){ echo "CHECKED"; }?> > Yes
    		<input type="radio" name="gpb_sayi" value="no" <?php if(get_option('gpb_sayi') == 'no'){ echo "CHECKED"; }?> > No
    		
    		<p>Place ?</p>
    		<input type="radio" name="gpb_yer" value="u" <?php if(get_option('gpb_yer') == 'u'){ echo "CHECKED"; }?> > Before post
    		<input type="radio" name="gpb_yer" value="a" <?php if(get_option('gpb_yer') == 'a'){ echo "CHECKED"; }?> > After post
    		<input type="radio" name="gpb_yer" value="manual" <?php if(get_option('gpb_yer') == 'manual'){ echo "CHECKED"; }?> > Manual (put <code>&lt;?php if(function_exists('gpb_ekle')) {   gpb_ekle(); }?&gt;</code> to anywhere)
    		
    		<input type="submit" class="button-primary" name="gpb_gonder" value="<?php _e('Save Changes') ?>" />
   	 </form>
   	 
   	 	<hr />
    		<em>If you <iframe src="http://www.facebook.com/plugins/like.php?app_id=190028181045651&amp;href=http%3A%2F%2Fwordpress.org%2Fextend%2Fplugins%2Fgoogles-plusone-1-button-wordpress-plugin%2F&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe> this plugin, please <a href="http://wordpress.org/extend/plugins/googles-plusone-1-button-wordpress-plugin/">vote</a> or <a href="http://twitter.com/share" class="twitter-share-button" data-url="http://wordpress.org/extend/plugins/googles-plusone-1-button-wordpress-plugin/" data-text="First Wordpress plugin for Google's PlusOne (+1) Plugin" data-count="horizontal" data-related="teknoblogo:author of plugin">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> it .
    		Author : <a href="http://www.teknoblogo.com">Eray Alakese</a>
	    	You can <a href="mailto:info@teknoblogo.com">mail me</a> for bugs, <a href="http://www.twitter.com/teknoblogo">follow me</a> for upgrades, thanks.</em>


<?php
} 
?>