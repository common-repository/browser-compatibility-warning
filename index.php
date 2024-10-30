<?php
/*
Plugin Name: Browser Compatibility Warning
Description: Allows a minimum browser compatibility to be set. Any users below the minimum will be shown a warning message that elements of the website may not display or work as intended.
Version: 1.05
Author: Impression11
Author URI: http://impression11.co.uk/
*/
require_once ( dirname(__FILE__).'/include/options.php' );
function bro_layout_view() {
	global $sa_options;
	$settings = get_option( 'sa_options', $sa_options );
	if( $settings['layout_view'] == 'fluid' ) : ?>
<style type="text/css">
#wrapper {
	width: 94%;
	max-width: 1140px;
	min-width: 940px;
}
#branding, #branding img, #access, #main, #colophon {
	width: 100%;
}
</style>
<?php endif;
}
add_action( 'wp_head', 'bro_layout_view' );
function Browser_Warning_4_WP() {
if(!isset($_COOKIE['browserchecker'])) {?>
<script src="wp-content/plugins/browser-compatibility-warning/js/detect.js"></script>
<link rel="stylesheet" href="wp-content/plugins/browser-compatibility-warning/css/style.css"/>
<script src="wp-content/plugins/browser-compatibility-warning/js/jquery.cookie.js"></script>
<script>
function setbrowsercheck(){
   days=30; // number of days to keep the cookie
   myDate = new Date();
   myDate.setTime(myDate.getTime()+(days*24*60*60*1000));
   document.cookie = 'browserchecker=checked; expires=' + myDate.toGMTString();
}
jQuery(function($){
$('#toggle').click(function() {
$('#browser').hide();
});
});
var browser=new Array("Chrome","Firefox","Safari","Opera","MSIE");
<?php $latestvar = array(29,23,6,16,10);?>
<?php $defaultdiff =array(($latestvar[0]-5),($latestvar[1]-5),($latestvar[2]-2),($latestvar[3]-3),($latestvar[4]-3));?>
<?php //get the minimum versions
$options = get_option('browser_plugin_options');
if (!$options['chrome'] == ""){$chrome = $options['chrome'];} else {$chrome = $defaultdiff[0];}
if (!$options['firefox'] == ""){$firefox = $options['firefox'];} else {$firefox = $defaultdiff[1];}
if (!$options['safari'] == ""){$safari = $options['safari'];} else {$safari = $defaultdiff[2];}
if (!$options['opera'] == ""){$opera = $options['opera'];} else {$opera = $defaultdiff[3];}
if (!$options['ie'] == ""){$ie = $options['ie'];} else {$ie = $defaultdiff[4];}
?>
var versiondiff=new Array((<?php echo $latestvar[0]-$chrome;?>),(<?php echo $latestvar[1]-$firefox;?>),(<?php echo $latestvar[2]-$safari;?>),(<?php echo $latestvar[3]-$opera;?>),(<?php echo $latestvar[4]-$ie;?>))
var latestversion=new Array(
<?php $i=0; foreach($latestvar as $latest){
if($i<4){
echo '"'.$latest.'",';
$i=$i+1;}
else{echo '"'.$latest.'"';}
};?>
)
var fancyname=new Array("Google Chrome","Mozilla Firefox","Safari","Opera","Internet Explorer");
var browserpos = jQuery.inArray(jscd.browser, browser);
var info = <?php $options = get_option('browser_plugin_options');
echo $options['info'];?>;
if (jscd.os=="Mac OS X" || jscd.os=="Windows" ){
	if(jscd.browserVersion <= (latestversion[browserpos]-versiondiff[browserpos])){
		document.write('<div id="browser"><div id="innerbrowser"><img src="wp-content/plugins/browser-compatibility-warning/img/warning.png"/>'+"Your " + fancyname[browserpos] + " browser is out of date. Please be aware that some of the features on this website may not display or work correctly until you update.");
		if (info=="1"){document.write(' <a style="text-decoration:underline;" target="_blank" href="http://browserchecker.co.uk/">More info...</a>')}
		document.write(' <a id="toggle" onclick="setbrowsercheck()" href="#">X</a></div></div>')
	}
} 
</script>
<?php }}
add_action('wp_footer','Browser_Warning_4_WP');
function browser_enqueue() {
		wp_enqueue_script('jquery');
	}
add_action('init', 'browser_enqueue');