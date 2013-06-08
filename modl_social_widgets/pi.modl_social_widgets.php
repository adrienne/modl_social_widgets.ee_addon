<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Minds On Design Lab MODL Social Widgets
 * REQUIRES ExpressionEngine 2+
 * 
 * @package     Modl_social_widgets
 * @version     1.0.1
 * @author      Minds On Design Lab Inc http://mod-lab.com
 * @copyright   Copyright (c) 2011 Minds On Design Lab Inc.
 * @License: 	Licensed under the MIT license - Please refer to LICENSE
 * 
 */

$plugin_info = array(
  'pi_name' => 'MODL Social Widgets',
  'pi_version' => '1.0.1',
  'pi_author' => 'Minds On Design Lab Inc.',
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
     * Twitter JS. Must place before twitter button for successful tracking, ie. right after opening <body>
     *
     */
     
     public function tweet_js() 
     {
     	// Build code
     	
     	// Load the widgets.js file asynchronously for events support. 
     	
     	// Can we replace old build code with new async code?

     	$data = '<script>
		    window.twttr = (function (d,s,id) {
		      var t, js, fjs = d.getElementsByTagName(s)[0];
		      if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
		      js.src="//platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
		      return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
		    }(document, "script", "twitter-wjs"));
			</script>';
			return $data;
     }
     
	
	/**
     * Twitter Tweet Button (Javascript Version) with optional Google Analytics tracking
     *
     */

	// New parameter added: track = "yes" sets tracking on, track = "no" or undefined or ommitted sets tracking off.
  // Twitter callbacks to Google Analytics added
  // Wait for asynchronous resources to load, then bind custom callbacks to events
		// Track tweets
		// Track clicks
	
	public function tweet_share()
	{
		
		// Parameters
		
		$track = $this->EE->TMPL->fetch_param('track');
		$url = $this->EE->TMPL->fetch_param('url');
		$text = $this->EE->TMPL->fetch_param('text');
		$count = $this->EE->TMPL->fetch_param('count');
		$via = $this->EE->TMPL->fetch_param('via');
		$lang = $this->EE->TMPL->fetch_param('lang');
		$recommend = $this->EE->TMPL->fetch_param('recommend');
		$hashtag = $this->EE->TMPL->fetch_param('hashtag');
		$size = $this->EE->TMPL->fetch_param('size');
		
		// Build Code
		
		$data = '<a href="https://twitter.com/share" class="twitter-share-button"';
		if($url) { 
			$data .= ' data-url="'.$url.'"';
			}
		if($text) {
			$data .= ' data-text="'.$text.'"';
		}
		if($count) {
			switch ($count) {
			    case "none":
			        $data .= ' data-count="none"';
			        break;
			    case "vertical":
			        $data .= ' data-count="vertical"';
			        break;
			    case "horizontal":
			        $data .= ' data-count="horizontal"';
			        break;
			    default:
			    	$data .= ' data-count="horizontal"';
			}
		} else {
			$data .= ' data-count="horizontal"';
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
		
		if($size) {
			switch ($size) {
			    case "medium":
			        $data .= ' data-size="medium"';
			        break;
			    case "large":
			        $data .= ' data-size="large"';
			        break;
			   	default: 
			   		$data .= ' data-size="medium"';
			}
		} else {
			$data .= ' data-size="medium"';
		}
		
		$data .='>Tweet</a>';

		if($track) {
			switch ($track) {
			    case "yes":
			        $data .= '
								<script>
						    	twttr.ready(function (twttr) {
						        
						        twttr.events.bind(\'tweet\', function(event) { 
						          if (event) {
						            _gaq.push([\'_trackSocial\', \'Twitter\', \'Tweet\'';
												if($url) { 
													$data .= ',\''.$url.'\'';
													}
												$data .=']);   
										  }
						        });

						        twttr.events.bind(\'click\', function(event) { 
						          if (event) {
						            var region = "Twitter "+event.region+" clicked";
						            _gaq.push([\'_trackSocial\', \'Twitter\', \'Click\', region]);  
						          }
						        });  

						      });
								</script>';
			        break;
			    default:
			    	$data .= '';
			}		
		}		
		return $data;
	}

	
	/**
     * Facebook HTML5 Button
     *
     */
	
	// Javascript SDK to be added after body tag on pages where you want to add an HTML5 Like
	
	public function fb_js()
	{
		
		// Parameters
		
		$appid = $this->EE->TMPL->fetch_param('appid');
		
		// Build code
		
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
		// Parameters
		
		$url = $this->EE->TMPL->fetch_param('url');
		$send = $this->EE->TMPL->fetch_param('send');
		$layout = $this->EE->TMPL->fetch_param('layout');
		$width = $this->EE->TMPL->fetch_param('width');
		$faces = $this->EE->TMPL->fetch_param('faces');
		$verb = $this->EE->TMPL->fetch_param('verb');
		$color = $this->EE->TMPL->fetch_param('color');
		$font = $this->EE->TMPL->fetch_param('font');
		
		// Build Code
		
		$data = '<div class="fb-like"';
		
		if ($url) {
			$data.= ' data-href="'.$url.'"';
		}
		
		if ($send) {
			switch ($send) {
			    case "true":
			        $data .= ' data-send="true"';
			        break;
			    case "false":
			        $data .= ' data-send="false"';
			        break;
			   	default: 
			   		$data .= ' data-send="false"';
			}
		} else {
			$data .= ' data-send="false"';
		}
		
		if ($layout) {
			switch ($layout) {
			    case "standard":
			        $data .= ' data-layout="standard"';
			        break;
			    case "button_count":
			        $data .= ' data-layout="button_count"';
			        break;
			    case "box_count":
			        $data .= ' data-layout="box_count"';
			        break;
			   	default: 
			   		$data .= ' data-layout="button_count"';
			}
		} else {
			$data .= ' data-layout="button_count"';
		}
		
		if ($width) {
			$data .= ' data-width="'.$width.'"';
		} else {
			$data .= ' data-width="90"';
		}
		
		if ($faces) {
			switch ($faces) {
			    case "true":
			        $data .= ' data-show-faces="true"';
			        break;
			    case "false":
			        $data .= ' data-show-faces="false"';
			        break;
			   	default: 
			   		$data .= ' data-show-faces="false"';
			}
		} else {
			$data .= ' data-show-faces="false"';
		}
		
		if ($verb == 'recommend') {
			$data .= ' data-action="recommend"';
		}
		
		if ($color == 'dark') {
			$data .= ' data-colorscheme="dark"';
		}
		
		if ($font) {
			switch ($font) {
			    case "arial":
			        $data .= ' data-font="arial"';
			        break;
			    case "lucida grande":
			        $data .= ' data-font="lucida grande"';
			        break;
			    case "segoe ui":
			        $data .= ' data-font="segoe ui"';
			        break;
			    case "tahoma":
			        $data .= ' data-font="tahoma"';
			        break;
			    case "trebuchet ms":
			        $data .= ' data-font="trebuchet ms"';
			        break;
				case "verdana":
				    $data .= ' data-font="verdana"';
				    break;
			    default:
			    	$data .= ' data-font="arial"';
			}
		} else {
			$data .= ' data-font="arial"';
		}
		$data .= '></div>';
		return $data;
	}
	
	/**
     * LinkedIn Share
     *
     */
	
	// LinkedIn Required JS Code.
	
	public function li_js()
	{
		$data = '<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>';	
		return $data;
	}
   
   
   	// LinkedIN Share button
     
	public function li_share()
	{
		// Parameters
		
		$url = $this->EE->TMPL->fetch_param('url');
		$counter = $this->EE->TMPL->fetch_param('counter');
		
		// Build Code
		
		$data ='<script type="IN/Share"';
		
		if ($url) {
			$data .= ' data-url="'.$url.'"';
		}
		
		if($counter) {
			switch ($counter) {
			    case "top":
			        $data .= ' data-counter="top"';
			        break;
			    case "right":
			        $data .= ' data-counter="right"';
			        break;
			}
		}
		$data .='></script>';
		return $data;
	}
	
	/**
     * Google +1 Button - JS for asynchronous loading. Currently US English.
     *
     */
	
	public function google_plusone_js() 
	{
		$data = '<script type="text/javascript">
      window.___gcfg = {
        lang: \'en-US\'
      };

      (function() {
        var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
        po.src = \'https://apis.google.com/js/plusone.js\';
        var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>';
    
    	return $data;
	}
	
	/**
     * Google +1 Button
     *
     */
	
	public function google_plusone_share() 
	{
		
		// Parameters
		
		$url = $this->EE->TMPL->fetch_param('url');
		$size = $this->EE->TMPL->fetch_param('size');
		$annotation = $this->EE->TMPL->fetch_param('annotation');
		$align = $this->EE->TMPL->fetch_param('align');
		$width = $this->EE->TMPL->fetch_param('width');
		
		// Build Code
		
		$data = '<div class="g-plusone"';
		
		if($url) {
			$data .= ' data-href="'.$url.'"';
		}
		
		if($size) {
			switch ($size) {
			    case "small":
			        $data .= ' data-size="small"';
			        break;
			    case "medium":
			        $data .= ' data-size="medium"';
			        break;
			    case "standard":
			        $data .= ' data-size="standard"';
			        break;
			    case "tall":
			        $data .= ' data-size="tall"';
			        break;
			    default:
			    	$data .= ' data-size="medium"';
			}
		} else {
			$data .= ' data-size="medium"';
		}
		
		if($annotation) {
			switch ($annotation) {
			    case "none":
			        $data .= ' data-annotation="none"';
			        break;
			    case "bubble":
			        $data .= ' data-annotation="bubble"';
			        break;
			    case "inline":
			        $data .= ' data-annotation="inline"';
			        break;
			    default:
			    	$data .= ' data-annotation="bubble"';			    	
			}
		}
		
		if($align) {
			switch ($align) {
			    case "left":
			        $data .= ' data-align="left"';
			        break;
			    case "right":
			        $data .= ' data-align="right"';
			        break;
			    default:
			    	$data .= ' data-align="left"';			    	
			}
		}
		
		if($width) {
			$data .= ' data-width="'.$width.'"';
		}
		
		$data .= '></div>';
		
		return $data;
	
	}
	
	
		
	static function usage()
	{
		ob_start(); 
		?>

		Please refer to online documentation at https://github.com/Minds-On-Design-Lab/modl_social_widgets.ee-addon
				
		<?php
		$buffer = ob_get_contents();
	
		ob_end_clean(); 

		return $buffer;
  	}
 	// END
}

/* End of file pi.modl_social_widgets.php */
/* Location: ./system/expressionengine/third_party/modl_social_widgets/pi.modl_social_widgets.php */