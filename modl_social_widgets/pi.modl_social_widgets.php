<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Minds On Design Lab MODL Social Widgets
 * REQUIRES ExpressionEngine 2+
 * 
 * @package     Modl_social_widgets
 * @version     0.1.0
 * @author      Minds On Design Lab Inc http://mod-lab.com
 * @copyright   Copyright (c) 2011 Minds On Design Lab
 * @license     http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported
 * 
 */

$plugin_info = array(
  'pi_name' => 'MODL Social Widgets',
  'pi_version' => '0.1.0',
  'pi_author' => 'Minds On Design Lab',
  'pi_author_url' => 'http://mod-lab.com',
  'pi_description' => 'A collection of functions to display social widgets',
  'pi_usage' => Modl_social_widgets::usage()
  );  
  
class Modl_social_widgets {
    
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	/**
     * Twitter JS
     *
     */
     
     public function tweet_js() 
     {
     	$data = '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
		return $data;
     }
     
	
	/**
     * Twitter Tweet Button (Javascript Version)
     *
     */
	
	public function tweet_share()
	{
		$url = $this->EE->TMPL->fetch_param('url');
		$text = $this->EE->TMPL->fetch_param('text');
		$count = $this->EE->TMPL->fetch_param('count');
		$via = $this->EE->TMPL->fetch_param('via');
		$lang = $this->EE->TMPL->fetch_param('lang');
		$recommend = $this->EE->TMPL->fetch_param('recommend');
		$hashtag = $this->EE->TMPL->fetch_param('hashtag');
		
		$data = '<a href="https://twitter.com/share" class="twitter-share-button"';
		if($url) { 
			$data .= ' data-url="'.$url.'"';
			}
		if($text) {
			$data .= ' data-text="'.$text.'"';
		}
		if($count) {
			$data .= ' data-count="'.$count.'"';
		}	  
		if($via) {
			$data .= ' data-via="'.$via.'"';
		}
		if($lang) {
			$data .= ' data-lang="'.$lang.'"';
		} else {
			$data .= ' data-lang="en"';
		}
		if($recommend) {
			$data .= ' data-related="'.$recommend.'"';
		}
		if($hashtag) {
			$data .= ' data-hashtags="'.$hashtag.'"';
		} 
		$data .='>Tweet</a>';
		
		return $data;
	}
	
	/**
     * Facebook HTML5 Button
     *
     */
	
	// Javascript SDK to be added after body tag on pages where you want to add an HTML5 Like
	
	public function fb_js_sdk()
	{
		$appid = $this->EE->TMPL->fetch_param('appid');
		
		$data = '
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appid';
		if($appid) {
			$data .= '='.$appid;
		}
		$data .= '";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, "script", "facebook-jssdk"));</script>
			';
		return $data;
	}
	
	// Specific instance of like button to be added where needed
	
	public function fb_like_html5()
	{
		$data = '<div class="fb-like" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false" data-font="arial"></div>';
		return $data;
	}
	
	/**
     * LinkedIn Share
     *
     */
     
	public function li_share()
	{
		$counter = $this->EE->TMPL->fetch_param('counter');
		$data = '<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>';	
		$data .='<script type="IN/Share"';
		
		if($counter) {
			$data .= ' data-counter="'.$counter.'"';
		}
		$data .='></script>';
		return $data;
	}
		
	static function usage()
	{
		ob_start(); 
		?>

-----------------------------------------------------------------------------------------------		
Twitter JS - https://dev.twitter.com/docs/tweet-button
-----------------------------------------------------------------------------------------------

Will add the Twitter JS to the page. Required for Tweet Button Use. Can be added to bottom of page/footer.

{exp:modl_social_widgets:tweet_js}

-----------------------------------------------------------------------------------------------		
Twitter Share - https://dev.twitter.com/docs/tweet-button
-----------------------------------------------------------------------------------------------

Will add a complete tweet share button wherever this tag is placed.

{exp:modl_social_widgets:tweet_share url="" text="" count="" via="" lang="" recommend="" hashtag=""}

Optional Parameters:

* URL:Full URL
* Text: Default text to include in Tweet
* Count: "none", "horizontal" (default), "vertical"
* Via: Handle w/o @
* Lang: en (default), es, … consult Twitter documentation for language options
* Recommend: Handle w/o @,separate multiple entries with comma
* Hashtag: w/o #

-----------------------------------------------------------------------------------------------
Facebook JS SDK - HTML5 & XFBML Instances - https://developers.facebook.com/docs/reference/plugins/like/
-----------------------------------------------------------------------------------------------

Will add the script to call the FB JavaScript SDF. Facebook recommends after the opening body tag.

{exp:modl_social_widgets:fb_js_sdk appid=""}

Optional Parameters:

* appid: FB application id

-----------------------------------------------------------------------------------------------
Facebook HTML5 Like Button - https://developers.facebook.com/docs/reference/plugins/like/
-----------------------------------------------------------------------------------------------

Will add a simple FB HTML5 Like button wherever this tag is placed.

{exp:modl_social_widgets:fb_like_html5}

Optional Parameters:

Coming Soon

-----------------------------------------------------------------------------------------------
LinkedIn Share - https://developer.linkedin.com/plugins/share-button
-----------------------------------------------------------------------------------------------

Will add a LinkedIn Share button wherever this tag is placed.

{exp:modl_social_widgets:li_share}

Optional Parameters:

* Counter: "Top", "Right", Leaving out is no counter
				
		<?php
		$buffer = ob_get_contents();
	
		ob_end_clean(); 

		return $buffer;
  	}
 	// END
}

/* End of file pi.modl_social_widgets.php */
/* Location: ./system/expressionengine/third_party/modl_social_widgets/pi.modl_social_widgets.php */