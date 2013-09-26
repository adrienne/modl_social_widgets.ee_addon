<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Minds On Design Lab MODL Social Widgets
 * REQUIRES ExpressionEngine 2+
 *
 * @package     Modl_social_widgets
 * @version     1.2.0
 * @author      Minds On Design Lab Inc http://mod-lab.com
 * @copyright   Copyright (c) 2011 - 2013 Minds On Design Lab Inc.
 * @License:    Licensed under the MIT license - Please refer to LICENSE
 *
 */

$plugin_info = array(
  'pi_name' => 'MODL Social Widgets',
  'pi_version' => '1.2.0',
  'pi_author' => 'Minds On Design Lab Inc.',
  'pi_author_url' => 'http://mod-lab.com',
  'pi_description' => 'A collection of functions to display social widgets. Includes Twitter, Facebook, LinkedIn, and Google + and the ability to enable social widgets tracking for Google Analytics for Twitter and Facebook.',
  'pi_usage' => Modl_social_widgets::usage()
  );

class Modl_social_widgets {

    private $init   = false;
    private $style  = '';

    private $doTrackLinkedIn    = false;
    private $doTrackGooglePlus  = false;

    public function __construct()
    {
        $this->EE =& get_instance();
    }

    /**
     * Google Analytics Social Tracking - loads JS file with code for widget tracking.
     * Should be added to head.
     */

    public function analytics_social_tracking_js() {
        if( $this->init ) {
            show_error('You may use analytics_social_tracking OR universial_social_tracking, not both');
        }
        $this->init = true;
        $this->style = 'gaq';

        $data = '<script src="'.URL_THIRD_THEMES.'modl_social_widgets/js/ga_social_tracking.js"></script>';
        return $data;
    }

    /**
     * Google Analytics Universial tracking code
     * You can only use analytics social tracking or universal tracking, not both
     */
    public function universal_social_tracking_js() {
        if( $this->init ) {
            show_error('You may use analytics_social_tracking OR universial_social_tracking, not both');
        }
        $this->init = true;
        $this->type = 'uni';

        $data = '<script src="'.URL_THIRD_THEMES.'modl_social_widgets/js/universal_social_tracking.js"></script>';
        return $data;
    }

    /**
     * Twitter JS. Must place before twitter button for successful tracking, ie. right after opening <body>
     * @param string analytics Accepts yes to inlcude GA tracking snippet
     * @return string JS snippet to load Twitter widget_js
     */

     public function tweet_js()
     {
        // Parameters

        $analytics = $this->EE->TMPL->fetch_param('analytics');

        // Build Code

        $data = '<script>
            window.twttr = (function (d,s,id) {
              var t, js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
              js.src="//platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
              return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
            }(document, "script", "twitter-wjs"));';
        if ($analytics == "yes") {
            if( $this->style == 'gaq' ) {
                $data .= '
                // Wait for the asynchronous resources to load
                twttr.ready(function(twttr) {
                    _ga.trackTwitter(); //Google Analytics tracking
                });';
            } else {
                $data .= '
                // Wait for the asynchronous resources to load
                twttr.ready(function(twttr) {
                    _modl_social.trackTwitter(); //Google Analytics tracking
                });';

            }

        }
        $data .='</script>';

        return $data;
     }


    /**
     * Twitter Tweet Button (Javascript Version) with optional Google Analytics tracking
     * @param string url Fully qualified URL you would like to track
     * @param string text Text to be included in default tweet
     * @param string count Treatment of display of tweet count, 3 cases 'done', 'vertical', 'horizontal'
     * @param string via Twitter handle for via
     * @param string lang Language code for widget, default 'en'
     * @param string recommend Twitter handle for recommend
     * @param string hashtag Twitter hashtag
     * @param string size Widget size, 2 cases 'medium' and 'large'
     */



    public function tweet_share()
    {

        // Parameters

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

        return $data;
    }


    /**
     * Facebook Javascript SDK to be added after body tag on pages where you want to add an HTML5 Like
     * @param int appid Facebook application unique id
     * @param string analytics Accepts yes to inlcude GA tracking snippet
     */

    public function fb_js()
    {

        // Parameters

        $appid = $this->EE->TMPL->fetch_param('appid');
        $analytics = $this->EE->TMPL->fetch_param('analytics');

        // Build code

        $data = '
            <div id="fb-root"></div>
            <script>
            window.fbAsyncInit = function() {
                // init the FB JS SDK
                FB.init({
                  appId      : \''.$appid.'\',// App ID from the app dashboard
                  //channelUrl : \'//WWW.YOUR_DOMAIN.COM/channel.html\', // Channel file for x-domain comms
                  status     : true,                                 // Check Facebook Login status
                  xfbml      : true                                  // Look for social plugins on the page
                });

                // Additional initialization code such as adding Event Listeners goes here';

        // Check for analytics

        if($analytics == 'yes') {
            if( $this->style == 'gaq' ) {
                $data .= '
                    _ga.trackFacebook(); //Google Analytics tracking
                ';
            } else {
                $data .= '
                    _modl_social.trackFacebook(); //Google Analytics tracking
                ';
            }
        };

        $data .= '

              };

              // Load the SDK asynchronously
              (function(d, s, id){
                 var js, fjs = d.getElementsByTagName(s)[0];
                 if (d.getElementById(id)) {return;}
                 js = d.createElement(s); js.id = id;
                 js.src = "//connect.facebook.net/en_US/all.js";
                 fjs.parentNode.insertBefore(js, fjs);
               }(document, \'script\', \'facebook-jssdk\'));
            </script>
        ';
        return $data;
    }

    /**
     * Facebook HTML 5 Like button
     * @param string url Fully qualified URL to be liked
     * @param string send Enable the send (messaging) capability, 2 cases 'true', 'false'
     * @param string layout Layout of widget, 3 cases 'standard', 'button_count', 'box_count'
     * @param string width Width of widget, min is 90
     * @param string faces Show faces, 2 cases 'true', 'false'
     * @param string verb Change from like to 'recommend', one case 'recommend', default is 'like'
     * @param string color Opt for dark or light, one case 'dark', defaul is 'light'
     * @param string font Set font type, 6 cases 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
     */

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
     * LinkedIn Required JS Code
     * @param string analytics Accepts yes to inlcude GA tracking snippet
     */

    public function li_js()
    {
        $analytics = $this->EE->TMPL->fetch_param('analytics');

        // we do this here to maintain tag parity with the Twitter and Facebook tags
        $this->doTrackLinkedIn = $analytics;

        // Build Code
        $data = '<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>';

        return $data;
    }

   /**
    * LinkedIN Share button
    * @param string url Fully qualified URL to be shared
    * @param string counter Display of share counter, 2 cases 'top', 'right'
    */
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

        if( $this->doTrackLinkedIn ) {
            if( $this->style == 'gaq' ) {
                show_error('LinkedIn interactions can only be tracked with the Universal tracking code');
                return;
            }
            $data .= 'data-onsuccess="_modl_social.trackLinkedin"';
        }
        $data .='></script>';
        return $data;
    }

    /**
     * Google +1 Button - JS for asynchronous loading. Currently US English.
     * @param string analytics Accepts yes to inlcude GA tracking snippet
     */

    public function google_plusone_js()
    {
        $analytics = $this->EE->TMPL->fetch_param('analytics');

        // we do this here to maintain param parity with the Twitter and Facebook tags
        // $this->doTrackGooglePlus = $analytics;

        $data = '
            <script type="text/javascript">
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
     * @param string url Fully qualified URL to be shared
     * @param string size Size of button, four cases 'small', 'medium', 'standard', 'tall', default is 'medium'
     * @param string annotation Count/layout treatment, thre cases 'none', 'bubble', 'inline', default is 'bubble'
     * @param string align Sets the alignment of the button assets within its frame, two cases 'left', 'right', default is 'left'
     * @param int width Width of widget, refer to google docs for options
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

        // if( $this->doTrackGooglePlus ) {
        //     if( $this->style == 'gaq' ) {
        //         show_error('Google+ interactions can only be tracked with the Universal tracking code');
        //         return;
        //     }
        //     $data .= ' data-callback="_modl_social.trackGooglePlus"';
        // }

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