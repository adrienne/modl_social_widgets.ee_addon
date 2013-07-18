# MODL Social Widgets

## Overview

An ExpressionEngine 2.x plugin consisting of an evolving collection of social widgets to help a website get social. The defaults noted below are not necessarily those promoted by their respective platforms but rather are what we have found to be the most standard basic implementation for the sites we build. This plugin is maintained by Minds On Design Lab driven by internal use and needs.

- *Developed By:* Minds On Design Lab - http://mod-lab.com
- *Version:* 1.1.0
- *Copyright:* Copyright &copy; 2011 - 2013 Minds On Design Lab
- *License:* Licensed under the MIT license - Please refer to LICENSE

## Installation

- Install plugin in `system/expressionengine/third_party/modl_social_widgets`
- Install theme in `themes/third_party/modl_social_widgets`


## Google Analytics Social Widget Tracking

We currently support the widget_js approach. Universal analytics something we will consider in future. To enable this feature you need to include a JS library as well as set the `analytics="yes"` parameter in the Twitter JS and Facebook JS SDK tags as detailed below.

### Google Analytics Tracking JS

The following tag is used to set the js filed stored in the `themes/third_party/modl_social_widgets` folder. Should be placed above Twitter JS and Facebook JS SDK tags.

	{exp:modl_social_widgets:analytics_social_tracking_js}

## Twitter

- [Twitter Docs](https://dev.twitter.com/docs/tweet-button":https://dev.twitter.com/docs/tweet-button)

### Twitter JS

Will add the Twitter JS to the page. Required for Tweet Button Use. Can be added to bottom of page/footer before `</body>`.

	{exp:modl_social_widgets:tweet_js}

#### Optional Parameters
	
	{exp:modl_social_widgets:tweet_js
		analytics="yes"
	}	

#### Definitions

|Parameter|Options|Default|Additional Notes|
|:--------|:------|:------|:---------------|
| analytics | yes | | Used to enable social widget tracking in Google Analytics |


### Twitter Share Button

Will add a complete tweet share button wherever this tag is placed using defaults as detailed below.

	{exp:modl_social_widgets:tweet_share}

#### Optional Parameters:

	{exp:modl_social_widgets:tweet_share 
		url="" 
		text="" 
		count="" 
		via="" 
		lang="" 
		recommend="" 
		hashtag="" 
		size=""
	}

#### Definitions

|Parameter|Options|Default|Additional Notes|
|:--------|:------|:------|:---------------|
|url| | |Full qualified URL, eg. http://twitter.com. Default will use current URL at time of initiating a tweet.|
|text| | |Text to include in default Tweet.|
|count|"none", "vertical", "horizontal"|horizontal| |
|via| | |Twitter handle w/o @|
|lang|"en", "es", … consult Twitter documentation for language options|en| |
|recommend| | |Handle w/o @,separate multiple entries with commas|
|hashtag| | |Hashtag w/o #|
|size|"medium", "large"|medium| |

## Facebook

- [Facebook Docs](https://developers.facebook.com/docs/reference/plugins/like/":https://developers.facebook.com/docs/reference/plugins/like/)

### Facebook JS SDK - HTML5 & XFBML Instances

Will add the script to call the FB JavaScript SDF using XBFML. Facebook recommends after the opening body tag; however, we tend to add before closing body.

	{exp:modl_social_widgets:fb_js}

#### Optional Parameters

	{exp:modl_social_widgets:fb_js 
		appid=""
		analytics="yes"
	}

|Parameter|Options|Default|Additional Notes|
|:--------|:------|:------|:---------------|
| appid | | | FB application id |
| analytics | yes | | Used to enable social widget tracking in Google Analytics |

### Facebook HTML5 Like Button

Will add a simple FB HTML5 Like button wherever this tag is placed using default parameter options as noted below.

	{exp:modl_social_widgets:fb_like_html5}

#### Optional Parameters

	{exp:modl_social_widgets:fb_like_html5 
		url="" 
		send="" 
		layout="" 
		width="" 
		faces="" 
		verb="" 
		color=""
	}

### Definitions

|Parameter|Options|Default|Additional Notes|
|:--------|:------|:------|:---------------|
| url | | | Entering a fully qualified URL, eg. http://facebook.com. Default will use current URL at time of initiating a like. |
| send | "true", "false" | false | |
| layout | "standard", "button_count", "box_count"| button_count | |
| width | | | Enter an int for width in pixels (90 default). Please note that each layout combined with other parameters such as whether you enable the send feature has minimum and max widths that may override anything added here. Please refer to Facebook docs for details. |
| faces | "true", "false"|false|Only used for standard layout, ignored if others are used. |
| verb | "recommend" | | No parameter or any other value defaults to use of "Like". |
| color | "dark" | | No parameter or any other value defaults to light version. |
| font | "arial", "lucida grande", "segoe ui", "tahoma", "trebuchet ms", "verdana" | arial | |

## Linkedin

* [Docs](https://developer.linkedin.com/plugins/share-button":https://developer.linkedin.com/plugins/share-button)

### Linkedin JS

Will add the Linkedin JS to the page. Required for Tweet Button Use. Likely added to bottom of page/footer before `</body>`.

	{exp:modl_social_widgets:li_js}

### Linkedin Share

Will add a Linkedin Share button wherever this tag is placed.

	{exp:modl_social_widgets:li_share}

#### Optional Parameters

	{exp:modl_social_widgets:li_share 
		counter=""
	}

|Parameter|Options|Default|Additional Notes|
|:--------|:------|:------|:---------------|
| url | | | Entering a fully qualified URL, eg. http://linkedin.com. Default will use current URL at time of initiating a share. |
| Counter | "top", "right" | | Leaving out will result in no counter |

## Google +1 Button

* [Docs](https://developers.google.com/+/plugins/+1button/":https://developers.google.com/+/plugins/+1button/)

### Google +1 JS

Will add the JS for asynchronous loading of +1 buttons on page.  Should be placed after last +1 instance. Likely before closing body tag.

	{exp:modl_social_widgets:google_plusone_js}
	
#### Optional Parameters

_No optional parameters supported at this time. Languages and various load/call types may be needed in future. Consult docs above to explore options._

### Google +1 Button

Will add a Google +1 button wherever this tag is placed using defaults as detailed below.

	{exp:modl_social_widgets:google_plusone_share}

#### Optional Parameters

	{exp:modl_social_widgets:google_plusone_share 
		size="" 
		annotation="" 
		align=""
	}

#### Definitions

|Parameter|Options|Default|Additional Notes|
|:--------|:------|:------|:---------------|
| url | | | Entering a fully qualified URL, eg. http://google.com. Default will use current URL at time of initiating a +. |
| size | "small", "medium", "standard", "tall" | medium | The button size to render. |
| annotation | "none", "bubble", "inline" | bubble | The annotation to display next to the button. |
| align | "left", "right" | left | Sets the alignment of the button assets within its frame. |
| width | | | Width in pixels of the annotation area if you specify to annotation "inline". There is a minimum of 120 and default is 450 if not specified both controlled by Google. For details please refer to the official +1 documentation. |

## Change Log

### 1.1.0

- Google Analytics social widget tracking for Facebook Like and Twitter
- Facebook
	- Track likes, unlikes, send
- Twitter
	- Track clicks and tweets

### 1.0.1

- Revised parameters where there are specific values that are accepted to use switches
- Revised method naming conventions
	- fb_js_sdk -> fb_js (this will break current implementations, please update w/ care)
	- google_plusone_script -> google_plusone_js (this will break current implementations, please update w/ care)
	- google_plusone_button -> google_plusone_share (this will break current implementations, please update w/ care)
- Tweet_share
	- Added size parameter to tweet_share
- Fb_like_html5
	- Added optional parameters
- Li_share
	- Separated out script method (li_js) (this will break current implementations, please update w/ care)
	- Added URL parameter
- Google_plusone_share
	- Added url parameter to +1 share
	- Changed size default to medium for +1 share
	- Added width parameter for inline annotations for +1 share

### 1.0.0

- First pass
