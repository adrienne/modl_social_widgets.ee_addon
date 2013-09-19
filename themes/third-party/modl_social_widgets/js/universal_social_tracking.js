// Copyright 2013 Minds On Design Lab, Inc.
// Copyright 2012 Google Inc. All Rights Reserved.

/**
 * @fileoverview A simple script to automatically track Facebook and Twitter
 * buttons using Google Analytics social tracking feature.
 * @author api.nickm@gmail.com (Nick Mihailovski)
 * @author api.petef@gmail.com (Pete Frisella)
 *
 * Updates for Google Analytics Universial Tracking
 * @author mikej@mod-lab.com
 */

/**
 * Just make sure the GA object is available
 * @type {[type]}
 */
var ga = ga || {};

_modl_social = {

	/**
	 * Simple callback to generate the universal tracking code
	 * @param  {string} network the social network
	 * @param  {string} action  the social action
	 * @param  {string} target 	optional social target, uses current page as default
	 * @param  {object} gaOpts  optional list of secondary tracking data
	 */
	"trackSocial": (function(network, action) {
		var gaOpts = {};
		var target = window.location.href;
		if( arguments.length >= 3 ) {
			target = arguments[2];
		}
		if( arguments.length >= 4 ) {
			gaOpts = arguments[3];
		}

		ga(
			'send',
			'social',
			network,
			action,
			target,
			gaOpts
		);
	}),

	/**
	 * Extract parameter from URI
	 * @param  {string} uri   the URI
	 * @param  {string} param The parameter name
	 * @return {string}
	 */
	"extractParamFromUri": (function(uri, param) {
		if( !uri ) {
			return;
		}

		var regex = new RegExp('[\\?&#]' + param + '=([^&#]*)');
		var params = regex.exec(uri);
		if( params != null ) {
			return unescape(params[1]);
		}
		return;
	}),

	/**
	 * Track LinkedIn share
	 */
	"trackLinkedin": (function() {
		_modl_social.trackSocial('LinkedIn', 'share');
	}),

	/**
	 * Track Google+
	 * @param  {object} data Data returned from Google+ callback
	 */
	"trackGooglePlus": (function(data) {
		if( data.state && data.state == 'on' ) {
			_modl_social.trackSocial('GooglePlus', 'plus', data.id);
		} else {
			_modl_social.trackSocial('GooglePlus', 'minus', data.id);
		}
	}),

	/**
	 * Tracks Facebook likes, unlikes and sends by subscribing to the Facebook
	 * JSAPI event model. Note: This will not track facebook buttons using the
	 * iframe method.
	 * @param {string} opt_pagePath An optional URL to associate the social
	 *     tracking with a particular page.
	 */
	"trackFacebook": (function(opt_pagePath) {
		try {
			if( FB && FB.Event && FB.Event.subscribe ) {
				FB.Event.subscribe('edge.create', function(opt_target) {
					_modl_social.trackSocial('facebook', 'like', opt_target, {"page": opt_pagePath});
				});
				FB.Event.subscribe('edge.remove', function(opt_target) {
					_modl_social.trackSocial('facebook', 'unlike', opt_target, {"page": opt_pagePath});
				});
				FB.Event.subscribe('message.send', function(opt_target) {
					_modl_social.trackSocial('facebook', 'send', opt_target, {"page": opt_pagePath});
				});
			}
		} catch (e) {}
	}),

	/**
	 * Handles tracking for Twitter click and tweet Intent Events which occur
	 * everytime a user Tweets using a Tweet Button, clicks a Tweet Button, or
	 * clicks a Tweet Count. This method should be binded to Twitter click and
	 * tweet events and used as a callback function.
	 * Details here: http://dev.twitter.com/docs/intents/events
	 * @param {object} intent_event An object representing the Twitter Intent Event
	 *     passed from the Tweet Button.
	 * @param {string} opt_pagePath An optional URL to associate the social
	 *     tracking with a particular page.
	 * @private
	 */
	"trackTwitterHandler": (function(intent_event, opt_pagePath) {
		var opt_target; //Default value is undefined
		if( intent_event && intent_event.type == 'tweet'
			|| intent_event.type == 'click' ) {

			if( intent_event.target.nodeName == 'IFRAME' ) {
				opt_target = _modl_social.extractParamFromUri(intent_event.target.src, 'url');
			}

			var socialAction = intent_event.type +
				((intent_event.type == 'click') ? '-' + intent_event.region : ''); //append the type of click to action

			_modl_social.trackSocial('twitter', socialAction, opt_target, {"page": opt_pagePath});
		}
	}),

	/**
	 * Binds Twitter Intent Events to a callback function that will handle
	 * the social tracking for Google Analytics. This function should be called
	 * once the Twitter widget.js file is loaded and ready.
	 * @param {string} opt_pagePath An optional URL to associate the social
	 *     tracking with a particular page.
	 */
	"trackTwitter": (function(opt_pagePath) {
		var intent_handler = function(intent_event) {
			_modl_social.trackTwitterHandler(intent_event, opt_pagePath);
		};

		//bind twitter Click and Tweet events to Twitter tracking handler
		twttr.events.bind('click', intent_handler);
		twttr.events.bind('tweet', intent_handler);
	})

};

