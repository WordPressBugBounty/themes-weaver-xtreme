/*! Weaver Xtreme JavaScript Library 3.1 - Copyright 2016-2021, Weaver Theme + Copyrights of sub-scripts */
/* Weaver Xtreme FitVids - added to end of page html. If add more than FitVids, need to fix
 * how _disable_FitVids works.
 * */
/*global jQuery */
/*jshint browser:true */
/*
 * FitVids 1.1
 *
 * Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 *
 */
(function ($) {

	'use strict';

	$.fn.fitVids = function (options) {
		var settings = {
			customSelector: null,
			ignore: '.wp-block-embed'
		};

		if (!document.getElementById('fit-vids-style')) {
			// appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
			var head = document.head || document.getElementsByTagName('head')[0];
			var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
			var div = document.createElement("div");
			div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
			head.appendChild(div.childNodes[1]);
		}

		if (options) {
			$.extend(settings, options);
		}

		return this.each(function () {
			var selectors = [
				'iframe[src*="player.vimeo.com"]',
				'iframe[src*="youtube.com"]',
				'iframe[src*="youtu.be"]',
				'iframe[src*="youtube-nocookie.com"]',
				'iframe[src*="kickstarter.com"][src*="video.html"]',
				'object',
				'embed'
			];

			if (settings.customSelector) {
				selectors.push(settings.customSelector);
			}

			var ignoreList = '.fitvidsignore';

			if (settings.ignore) {
				ignoreList = ignoreList + ', ' + settings.ignore;
			}

			var $allVideos = $(this).find(selectors.join(','));
			$allVideos = $allVideos.not('object object'); // SwfObj conflict patch
			$allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

			$allVideos.each(function () {
				var $this = $(this);
				if ($this.parents(ignoreList).length > 0) {
					return; // Disable FitVids on this video.
				}
				if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) {
					return;
				}
				if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width')))) {
					$this.attr('height', 9);
					$this.attr('width', 16);
				}
				var height = (this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10)))) ? parseInt($this.attr('height'), 10) : $this.height(),
					width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
					aspectRatio = height / width;
				if (!$this.attr('id')) {
					var videoID = 'fitvid' + Math.floor(Math.random() * 999999);
					$this.attr('id', videoID);
				}
				$this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100) + '%');
				$this.removeAttr('height').removeAttr('width');
			});
		});
	};
	// Works with either jQuery or Zepto
})(window.jQuery || window.Zepto);

// TABS - put in front to make show faster

jQuery(document).ready(function ($) {		// self-defining function - for tabs shortcode
	// Tabs
	$('.wvr-tabs-nav').delegate('span:not(.wvr-tabs-current)', 'click', function () {
		$(this).addClass('wvr-tabs-current').siblings().removeClass('wvr-tabs-current')
			.parents('.wvr-tabs').find('.wvr-tabs-pane').hide().eq($(this).index()).show();
	});
	$('.wvr-tabs-pane').hide();
	$('.wvr-tabs-nav span:first-child').addClass('wvr-tabs-current');
	$('.wvr-tabs-panes .wvr-tabs-pane:first-child').show();

});

/* -------------------------
	support [showhide]
*/
function weaverx_ToggleDIV(his, me, show, hide, text) {

	if (his.style.display != 'none') {
		his.style.display = 'none';
		if (text == 'img') {
			me.innerHTML = '<img src="' + show + '" alt="show" />';
		} else {
			me.innerHTML = '<span class="weaverx_showhide_show">' + show + '</span>';
		}
	} else {
		his.style.display = '';
		if (text == 'img') {
			me.innerHTML = '<img src="' + hide + '" alt="hide" />';
		} else {
			me.innerHTML = '<span class="weaverx_showhide_hide">' + hide + '</span>';
		}
	}
}


function wvrxFlowColor() {
	//version 1.1 - 20 oct 2014
	//IE8 Fix
	if (typeof wvrxEndOpts === 'undefined' || wvrxEndOpts.flowColor == '0')
		return;

	var SdbConf = wvrxEndOpts.sbLayout; //get the sidebar layout

	var MyContent = document.getElementById('content');
	var MyPSdb = document.getElementById('primary-widget-area');
	var MySSdb = document.getElementById('secondary-widget-area');

	//reset min height, must be outside the sidebar test
	if (MyPSdb) {
		MyPSdb.style.minHeight = "";
	}
	if (MySSdb) {
		MySSdb.style.minHeight = "";
	}
	if (MyContent) {
		MyContent.style.minHeight = "";
	}

	function weaverxMarginTop(select) {
		var val = jQuery(select).css('margin-top');
		if (val == 'auto') // Fix for jQuery returning auto on IE7 and IE8 when no margin is set
			val = '0px';
		return parseInt(val);
	}

	function weaverxMarginBottom(select) {
		var val = jQuery(select).css('margin-bottom');
		if (val == 'auto') // Fix for jQuery returning auto on IE7 and IE8 when no margin is set
			val = '0px';
		return parseInt(val);
	}

	var ContTopM, ContHeight, MaxHeight, SSdbTopM, PSdbTopM, PSdbHeight, SSdbHeight;

	//Test if on desktop size using weaverxBrowserWidth()
	if (weaverxBrowserWidth() >= 768) {

		//Start testing from actual presence of sidebar, regardless of sidebar config to cover cases of empty split sidebars
		if (MyPSdb && (MySSdb === null) || MySSdb && (MyPSdb === null)) {
			//--Single SB case--
			if (MyPSdb) { //Primary SB only
				ContTopM = weaverxMarginTop('#content');
				PSdbTopM = weaverxMarginTop('#primary-widget-area');
				PSdbHeight = MyPSdb.offsetHeight + PSdbTopM;
				ContHeight = MyContent.offsetHeight + ContTopM;

				//Take the highest content height
				MaxHeight = Math.max(PSdbHeight, ContHeight);

				//Apply appropriate min height to containers
				MyContent.style.minHeight = (MaxHeight - ContTopM) + "px";
				MyPSdb.style.minHeight = (MaxHeight - PSdbTopM) + "px";
			} else { //Secondary SD only
				ContTopM = weaverxMarginTop('#content');
				SSdbTopM = weaverxMarginTop('#secondary-widget-area');
				SSdbHeight = MySSdb.offsetHeight + SSdbTopM;
				ContHeight = MyContent.offsetHeight + ContTopM;

				//Take the highest content height
				MaxHeight = Math.max(SSdbHeight, ContHeight);

				//Apply appropriate min height to containers
				MyContent.style.minHeight = (MaxHeight - ContTopM) + "px";
				MySSdb.style.minHeight = (MaxHeight - SSdbTopM) + "px";
			}
		}
		if (MyPSdb && MySSdb) {
			if (SdbConf == 'right' || SdbConf == 'left' || SdbConf == 'right-top' || SdbConf == 'left-top') {
				//--Two stacked Sidebars case--
				ContTopM = weaverxMarginTop('#content');
				SSdbTopM = weaverxMarginTop('#secondary-widget-area');
				PSdbTopM = weaverxMarginTop('#primary-widget-area');
				var PSdbBotM = weaverxMarginBottom('#primary-widget-area');
				PSdbHeight = MyPSdb.offsetHeight + PSdbTopM + PSdbBotM;
				SSdbHeight = MySSdb.offsetHeight + SSdbTopM;
				ContHeight = MyContent.offsetHeight + ContTopM;
				var TotSdbHeight = PSdbHeight + SSdbHeight;

				//Take the highest content height
				MaxHeight = Math.max(TotSdbHeight, ContHeight);

				//Apply appropriate min height to containers
				MyContent.style.minHeight = (MaxHeight - ContTopM) + "px";
				MySSdb.style.minHeight = (MaxHeight - PSdbHeight - SSdbTopM) + "px";
			}
			if (SdbConf == 'split-top' || SdbConf == 'split') {
				//--Two Split Sidebar case
				ContTopM = weaverxMarginTop('#content');
				SSdbTopM = weaverxMarginTop('#secondary-widget-area');
				PSdbTopM = weaverxMarginTop('#primary-widget-area');
				PSdbHeight = MyPSdb.offsetHeight + PSdbTopM;
				SSdbHeight = MySSdb.offsetHeight + SSdbTopM;
				ContHeight = MyContent.offsetHeight + ContTopM;

				//Take the highest content height
				MaxHeight = Math.max(PSdbHeight, ContHeight, SSdbHeight);

				//Apply appropriate min height to containers
				MyContent.style.minHeight = (MaxHeight - ContTopM) + "px";
				MyPSdb.style.minHeight = (MaxHeight - PSdbTopM) + "px";
				MySSdb.style.minHeight = (MaxHeight - SSdbTopM) + "px";
			}
		}
	} else {
		if (weaverxBrowserWidth() > 580) {
			//Test if on small tablet size using screensize function
			if (MyPSdb && MySSdb) {
				if (SdbConf == 'right' || SdbConf == 'left' || SdbConf == 'split') { //Sidebar Right left or Split Sidebar are the only one side by side on small tablets
					SSdbTopM = weaverxMarginTop('#secondary-widget-area');
					PSdbTopM = weaverxMarginTop('#primary-widget-area');
					PSdbHeight = MyPSdb.offsetHeight + PSdbTopM;
					SSdbHeight = MySSdb.offsetHeight + SSdbTopM;
					//Take the highest content height of both sidebars
					MaxHeight = Math.max(PSdbHeight, SSdbHeight);
					//Apply appropriate min height to containers
					MyPSdb.style.minHeight = (MaxHeight - PSdbTopM) + "px";
					MySSdb.style.minHeight = (MaxHeight - SSdbTopM) + "px";
				}
			}
		}
	}
}

// fix up vw widths

function weaverxScrollbarClass() {

	//detect vertical Scrollbar and add a class to the body tag

	var BrowserWidth = jQuery('#wvrx-page-width').width(); //width of browser

	jQuery('#wvrx-page-width').css('width', '100vw'); //change width to 100vw to measure viewport

	var expandWidth = jQuery('#wvrx-page-width').width(); //Width of the Expanded container (viewport)

	if (expandWidth > BrowserWidth) { //If viewport is larger there is a scrollbar
		jQuery('body').addClass('vert-scrollbar');
		jQuery('body').removeClass('no-vert-scrollbar');
	} else {
		jQuery('body').addClass('no-vert-scrollbar');
		jQuery('body').removeClass('vert-scrollbar');
	}
	jQuery('#wvrx-page-width').css('width', ''); //remove vw CSS on test container
}

/*	-------------------------------------------------------------------------------
	This is the full-width method using padding and margin
	It requires the base rules (below) to be in the general CSS (no longer requires html {overflow-x:hidden;})

		.content-box {box-sizing:content-box !important;
                -moz-box-sizing:content-box !important;
                -webkit-box-sizing:content-box !important;}

	It requires the #wvrx-page-width to get the following CSS so it becomes 100% wide and works with the monitoring
		#wvrx-page-width {
			width:100%;
			display:block;
			direction: ltr;
			position:absolute;
		}

*/

function weaverxFullWidth() {
	// V4.1 - minor syntax fix
	//V4 merge Extend and Expand in same script
	//V3.3.1 Auto overflow:visible for #content, #container when fullwidth used
	//V3.3 Fixed prcision changes parseInt to parseFloat
	//V3-2 testing a way to measure error in total width
	//V3-1 Fixed RTL mode. The #wvrx-page-width div must be given direction:LTR  for the real time monitoring to work
	//V3- Fixed to support right and left padding and borders, as well as non centered containers.
	//Only limitation: Width, left / right padding & border should not be set with inline style, but with a separate custom CSS rule.
	//This is because the script will write its own computed width and padding as inline style, so anything already there would be lost and lead to wrong calculation.

	var BrowserWidth = jQuery('#wvrx-page-width').width(); //Gather Internal(content) width of browser
	var overFlowVisible = false;

//***SCAN BOTH CLASSES for Extend and Expand
	jQuery(".wvrx-fullwidth, .wvrx-expand-full").each(function () {
		jQuery(this).removeClass('content-box'); //reset container box-sizing status to its original state
		jQuery(this).css({ //Remove previously computed inline width, paddings and margins to always measure original values
			'width': '',
			'margin-left': '',
			'margin-right': '',
			'padding-left': '',
			'padding-right': ''
		});
		var ElemWidth = jQuery(this).width(); //width of content
		var ElemOuterWidth = jQuery(this).outerWidth(); //width of content
		var OrigLeftPad = parseFloat(jQuery(this).css("padding-left"));
		var OrigRightPad = parseFloat(jQuery(this).css("padding-right"));
		var OrigLeftBor = parseFloat(jQuery(this).css("border-left-width")) || 0; //or zero is for IE8 that returns NaN if not set
		var OrigRightBor = parseFloat(jQuery(this).css("border-right-width")) || 0;
		var LeftPadding, RightPadding;

		var Extension = BrowserWidth - ElemOuterWidth; //Difference between browser and content
		var LeftMargin, LeftMarginMinus, RightMargin, RightMarginMinus;


		if (Extension > 4) { //If positive we must compute extensions
			var ParentWidth = jQuery(this).parent().width(); //width of parents content
			var ElemBoxSizing = jQuery(this).css("box-sizing"); //Box sizing
			var OrigLeftMarg = parseFloat(jQuery(this).css("margin-left")) || 0; //Left margin

			var LeftPosition = Math.ceil(jQuery(this).offset().left); //ceil is to avoid a 1px scrollbar in s0me configuration
			// var LeftPosition = jQuery(this).offset().left; // don't need ceil on some browsers
			var RightPosition = BrowserWidth - (LeftPosition + ElemOuterWidth); //Distance between right side of content and right side of browser

			if (!overFlowVisible) { // auto fix these whenver fullwidth used
				overFlowVisible = true;
				jQuery("#content").css({'overflow': 'visible'});
				jQuery(".content-page").css({'overflow': 'visible'});
				jQuery("#container").css({'overflow': 'visible'});
			}


			if (Math.abs(LeftPosition - RightPosition) < 2) { //if object is centered compute margins from difference with parent
				OrigLeftMarg = Math.max(0, ((ParentWidth - ElemOuterWidth) / 2)); //to workaround FF  bug with jquery auto margins
			}
			//COmputing any error from jQuery so we can add it to the final padding
			var WidthError = BrowserWidth - (LeftPosition + RightPosition + OrigLeftPad + OrigRightPad + OrigLeftBor + OrigRightBor + ElemWidth);

			if (jQuery("body.rtl").length) {
				//RTL loop
				LeftMargin = LeftPosition + 'px'; //Make  margin strings
				LeftMarginMinus = '-' + LeftMargin;
				RightMargin = (Math.max(0, RightPosition - OrigLeftMarg)) + 'px';
				RightMarginMinus = '-' + RightMargin;
			} else {
				//LTR loop
				LeftMargin = (Math.max(0, LeftPosition - OrigLeftMarg)) + 'px'; //Make  margin strings
				LeftMarginMinus = '-' + LeftMargin;
				RightMargin = RightPosition + 'px';
				RightMarginMinus = '-' + RightMargin;
			}
//These are padding  for Extend
			if (jQuery(this).hasClass("wvrx-fullwidth")) {
				LeftPadding = (LeftPosition + OrigLeftPad + WidthError) + 'px'; //Make  padding strings with error correction
				RightPadding = (RightPosition + OrigRightPad) + 'px';
				if (ElemBoxSizing == "border-box") { //This checks if object is border box
					jQuery(this).addClass('content-box'); //If so change container to content box
					jQuery(this).css({ //and set the CSS width to the width without padding to match content box
						'width': Math.floor(ElemWidth) + 'px'
					});
				}
			}
//***These are paddings for Expand
			if (jQuery(this).hasClass("wvrx-expand-full")) {
				LeftPadding = OrigLeftPad + 'px';
				RightPadding = OrigRightPad + 'px';
				jQuery(this).css({ //Sets the inline margin and padding
					'width': BrowserWidth,
					'max-width': 'none'
				});
			}

			jQuery(this).css({ //Sets the inline margin and padding
				'margin-left': LeftMarginMinus,
				'margin-right': RightMarginMinus,
				'padding-left': LeftPadding,
				'padding-right': RightPadding
			});
		}
	});
}


function weaverxWidgetEq(WdgtClass, AreaId) {
	//version 0.9 - 26 Nov 2014
	//-- added check for actual margin and presence of widget area, and fixed bottom margin eval
	//--use offsetxxx instead of clientxxx to account for borders
	//--Capture margin in its actual form not only pixel value
	//--remove position relative being added to the primary sidebar to avoid problem in split SB layout
	//--Improved bottom margin handling, makes it fully ie8 compliant
	//--Simplified with jQuery and added test for nobm class to decide on margin removal

	//Equalizing widgets in any widget area
	var WdgtArea = document.getElementById(AreaId);
	if (WdgtArea !== null) {
		var noBotMargin = jQuery('#' + AreaId).hasClass('nobm'); //checks if the nobm class is present
		var widget = jQuery("#" + AreaId + ' .' + WdgtClass);
		//Enter monitoring of widget area
		var WgtPos = -10000;
		var Rows = 0; //initialise row number
		var WdgtInRow = [];
		for (var i = 1; i <= 20; ++i) {
			WdgtInRow[i] = 0;
		}

		//counting rows and widgets
		for (i = 0; i < widget.length; i++) {
			if (widget[i].offsetTop !== WgtPos) { //if dif position, new row
				Rows = Rows + 1;
				WdgtInRow[Rows] = 1; //initialize number of widgets in row
			} else {
				WdgtInRow[Rows] = WdgtInRow[Rows] + 1; //increment Nb of widget in row
			}
			WgtPos = widget[i].offsetTop; //set current top position
		}

		//reset the min-height to measure true height
		for (i = 0; i < widget.length; i++) {
			widget[i].style.minHeight = "0px";
		}
		//Running equalization row by row
		var EqWdgt = 0; //initialize how manu widgets have been done
		var start, end;
		for (i = 1; i < (Rows + 1); i++) {
			var maxHeight = 0;
			// Calculate the max-height
			start = (0 + EqWdgt);
			end = (WdgtInRow[i] + EqWdgt);
			for (j = start; j < end; j++) {
				if (widget[j].offsetHeight > maxHeight) {
					maxHeight = widget[j].offsetHeight;
				}
			}
			// Apply the new max height as min-height
			start = (0 + EqWdgt);
			end = (WdgtInRow[i] + EqWdgt);
			for (j = start; j < end; j++) {
				widget[j].style.minHeight = (maxHeight + 1) + "px";
				widget[j].style.marginBottom = ""; //Remove the zero bot margin in case it was set previously
				if (i == Rows) {
					if (noBotMargin) {
						widget[j].style.marginBottom = "0px"; //remove bottom margin if nobm class present
					}
				}

				EqWdgt = EqWdgt + 1;
			}
		}
	}
}


// full_browser_height

function weaverxBottomFooter() {
	//This function will push the footer to the bottom of the browser by adjusting the container height

	jQuery('#container').css('min-height', ""); //resetting min-height

	var ContHeight = jQuery('#container').height(); //needs to exclude padding as min-height will too

	var PFHeight = 0; //set default postfooter height at zero

	if (jQuery('#inject_postfooter').length) { //If there is a postfooter area get its height
		PFHeight = jQuery('#inject_postfooter').outerHeight(true);
	}

	var BrowserHeight = jQuery(window).height(); //get browser's height

	var WrapperBottom = jQuery('#wrapper').position().top + jQuery('#wrapper').outerHeight(true); //get bottom position of the wrapper

	var EmptySpace = BrowserHeight - WrapperBottom - PFHeight; //calculate empty space

	if (EmptySpace > 0) { //if empty space is positive, push the footer

		//alert ('pushing footer');
		ContHeight = ContHeight + EmptySpace; //New Container Height (only needed for Method A)

		jQuery('#container').css('min-height', ContHeight + "px"); //Method A pushes the footer by extending the container height
	}
}

// called when window resizes

function weaverxResizeEnd() {
	jQuery(".fixedtop").wvrx_fixWvrxFixedTop(); // fix up the fixedtop areas

	var Wa2Eq = jQuery(".widget-eq"); // getting all the containers with the widget-eq class

	jQuery(function ($) {
		for (var i = 0; i < Wa2Eq.length; i++) {
			weaverxWidgetEq('widget', Wa2Eq[i].id); // Execute weaverxWidgetEq on all widget areas with the widget-eq class
		}
	});

	wvrxFlowColor(); // fix Color Flow - must go after the weaverxWidgetEq calls.
}

function weaverxBrowserResizeEnd() {
	// New function for things that need to use the monitoring of  the browser width with #wvrx-page-width

	weaverxScrollbarClass(); // Fixup scroll bar width for expanded areas

	if (jQuery('.wvrx-fullwidth,.wvrx-expand-full').length) { // Only start monitoring if the class is being used
		weaverxFullWidth(); // run full width script
	}
	if (typeof wvrxEndOpts !== 'undefined' && wvrxEndOpts.full_browser_height == '1')
		weaverxBottomFooter(); // fix full height browser

	if (typeof (weaverxUserOnResize) == 'function') // call user function if there
		weaverxUserOnResize();
}

// Invoke scripts

function weaverx_js_update() {
	// need to run weaverxResizeEnd and weaverxBrowserResizeEnd on doc ready for at least some browsers
	// As of October, 2014, these included Safari, Desktop Opera, IE9, and IE8.
	// For other browsers, it doesn't seem needed, but it is harmless to do it anyway.

	weaverxBrowserResizeEnd();
	weaverxResizeEnd();

	if (typeof wvrxEndOpts !== 'undefined') {

		if (wvrxEndOpts.hideTip == '1') {
			jQuery('a[title]').mouseover(function (e) {
				var tip = jQuery(this).attr('title');
				jQuery(this).attr('title', '');
			}).mouseout(function () {
				jQuery(this).attr('title', jQuery('.tipBody').html());
			});
		}

		if (wvrxEndOpts.hFontFamily != '0') {
			var ffamily = 'font-' + wvrxEndOpts.hFontFamily;
			//alert('ffamily:' + ffamily);
			jQuery('.entry-content h1').addClass(ffamily);
			jQuery('.entry-content h2').addClass(ffamily);
			jQuery('.entry-content h3').addClass(ffamily);
			jQuery('.entry-content h4').addClass(ffamily);
			jQuery('.entry-content h5').addClass(ffamily);
			jQuery('.entry-content h6').addClass(ffamily);
		}

		if (wvrxEndOpts.hFontMult != 1) {
			var mult = wvrxEndOpts.hFontMult;
			// these values computed base on original h sizes times multipler determined in footer.php
			jQuery('.entry-content h1').css('font-size', (2.25 * mult) + 'em');
			jQuery('.entry-content h2').css('font-size', (1.875 * mult) + 'em');
			jQuery('.entry-content h3').css('font-size', (1.5 * mult) + 'em');
			jQuery('.entry-content h4').css('font-size', (1.125 * mult) + 'em');
			jQuery('.entry-content h5').css('font-size', (1.0 * mult) + 'em');
			jQuery('.entry-content h6').css('font-size', (0.875 * mult) + 'em');
		}
	}

	// Target your #container, #wrapper etc
	// if ( ! weaver_disable_fitvids )  // one possible solution to disabling FitVids via localize_script in functions.php
	jQuery("#wrapper").fitVids();
	jQuery("#branding").fitVids();

}


// Handle sizing of dynamic containers like Extra menus

//function to allow people to launch their own monitoring

function weaverxMonitorContent(class2Mon) {
	// This function gather the ID of all containers with the given class and executes weaverResizeEnd
	// (flow color and widgetEq) when they change size
	var XtraMenuAc = jQuery(class2Mon); // getting all the containers with the given class
	jQuery(function ($) {
		for (var i = 0; i < XtraMenuAc.length; i++) {
			$('#' + XtraMenuAc[i].id).resizeX(weaverxResizeEnd); //launching monitoring using the ID of the container
		}
	});
}


jQuery(function ($) {		// wrapper for jQuery utils

	$(document).ready(function () {		// stuff to do on .ready
		weaverx_js_update();
	});

	// add dynamic monitoring for these two functions
	$('#wrapper').resizeX(weaverxResizeEnd);
	$('#wvrx-page-width').resizeX(weaverxBrowserResizeEnd);

	// Finds the extra menus using accordion type and launches resizeX using the extra menu container ID for monitoring

	weaverxMonitorContent('.menu-type-accordion');
	weaverxMonitorContent('.extra-menu-xplus.menu-type-standard'); // why was this here?
	weaverxMonitorContent('.dynamic-content');
	weaverxMonitorContent('.header-image'); // need this to handle slow loading header image

//---------------------------------------------------
//Fix On Scroll Script
//---------------------------------------------------
//V4.6 Fixed wvrx-fixedon scroll rules to remove any top margin when fixed
//V4.5 removed global vars, wrapped with $ self-invoking function, changed $ to $
//v4.4 added compatibility with any other fixed top areas
//V4.3 Fixed a few bugs on mixing mix of fixed and fixed on scroll
//V4.1 added compatibility with fixed menu
//v4 of fix on scroll
	/* Default is Stick, no transition
	To define a custom transition, add two CSS rules:
	One with .wvrx-scrollfix-trans  to define initial state and transition values
	One with .wvrx-scrollfix-trans.wvrx-fixonscroll to define final transition state

	For a drop add (no need for final top, this is done by the script)
	.wvrx-scrollfix-trans {transition:top .3s ease;top:-50px;}

	For a custom background color and height change add
	.wvrx-menu-container {transition: background-color .5s ease, padding .5s ease;}
	.wvrx-menu-container.wvrx-fixonscroll {background-color:rgba(100,200,200,.8);padding-top:10px;padding-bottom:10px;}
	*/

// If scroll-fix checked for both menus, but menus don't exist for one or the other

	if ((wvrxOpts.primaryScroll == 'scroll-fix') && (wvrxOpts.secondaryScroll == 'scroll-fix') ) {
		if (! $('#nav-primary').length ) {
			wvrxOpts.primaryScroll = 'none';
		}
		if (! $('#nav-secondary').length ) {
			wvrxOpts.secondaryScroll = 'none';
		}
	}   // fix if a menu is not actually defined

//Primary Only

	if ((wvrxOpts.primaryScroll == 'scroll-fix') && (wvrxOpts.secondaryScroll != 'scroll-fix') && ($('#nav-primary').length)) {
		$(window).scroll(function () {
			var wvrxAdminOffset = 0; //initialize offset for admin bar
			var wvrxFixedOffset = 0;
			var primarySelector = "#nav-primary .wvrx-menu-container"; //Defines the primary selector
			var primaryHeight = $(primarySelector).outerHeight(); //Gathers the primary height
			// Get the height of the WP Admin bar if present.
			if ($('.admin-bar').length) {
				wvrxAdminOffset = $('#wpadminbar').outerHeight();
				if ( $(window).width() < 600 ) {
					wvrxAdminOffset = 0;
				}
			}
			// Check if there are other fixed areas, if so add offset
			$('.wvrx-fixedtop').each(function () {
				wvrxFixedOffset = wvrxFixedOffset + $(this).outerHeight() - 1;
			});
			wvrxAdminOffset = wvrxAdminOffset + wvrxFixedOffset;
			var windowScroll = $(window).scrollTop(); //Collects the amount of scroll
			var primaryPos = $('#nav-primary').offset().top - parseFloat($('body').css('marginTop')) + wvrxFixedOffset;

			if (primaryPos < (windowScroll + wvrxAdminOffset)) {
				$(primarySelector).addClass('wvrx-fixonscroll'); //Fix primary
				//$(primarySelector).css('margin-top',0); // Need to remove top margn, but fix is really in .wvrx-fixonscroll CSS rule
				$('body').css('margin-top', primaryHeight + wvrxFixedOffset); //Add body ossfet to compensate for primary fix
				$(primarySelector).css('top', wvrxAdminOffset + 'px'); //change primary top
			} else {
				$(primarySelector).removeClass('wvrx-fixonscroll'); //Unfix Primary
				$('body').css('margin-top', wvrxFixedOffset); //Remove Body offset as nothing is fixed
				$(primarySelector).css('top', ''); //remove primary top
			}
		});
	}

//Secondary only
	if ((wvrxOpts.secondaryScroll == 'scroll-fix') && (wvrxOpts.primaryScroll != 'scroll-fix') && ($('#nav-secondary').length)) {
		$(window).scroll(function () {
			var wvrxAdminOffset = 0; //initialize offset for admin bar
			var wvrxFixedOffset = 0;
			var secondarySelector = "#nav-secondary .wvrx-menu-container"; //Defines the secondary selector
			var secondaryHeight = $(secondarySelector).outerHeight(); //Gathers the secondary height
			// Get the height of the WP Admin bar if present.
			if ($('.admin-bar').length) {
				wvrxAdminOffset = $('#wpadminbar').outerHeight();
			}
			// Check if there are other fixed areas, if so add offset
			$('.wvrx-fixedtop').each(function () {
				wvrxFixedOffset = wvrxFixedOffset + $(this).outerHeight();
			});
			wvrxAdminOffset = wvrxAdminOffset + wvrxFixedOffset;
			var windowScroll = $(window).scrollTop(); //Collects the amount of scroll
			var secondaryPos = $('#nav-secondary').offset().top - parseFloat($('body').css('marginTop')) + wvrxFixedOffset;

			if (secondaryPos < (windowScroll + wvrxAdminOffset)) {
				$(secondarySelector).addClass('wvrx-fixonscroll'); //Fix secondary
				$('body').css('margin-top', secondaryHeight + wvrxFixedOffset); //Add top margin to account for fixed secondary
				$(secondarySelector).css('top', wvrxAdminOffset + 'px'); //Set secondary top
			} else {
				$(secondarySelector).removeClass('wvrx-fixonscroll'); //Unfix Secondary
				$('body').css('margin-top', wvrxFixedOffset); //Remove body offset
				$(secondarySelector).css('top', ''); //remove secondary top
			}
		});
	}

//Primary & Secondary fixed
	if ((wvrxOpts.primaryScroll == 'scroll-fix') && (wvrxOpts.secondaryScroll == 'scroll-fix')
		&& ($('#nav-primary').length) && ($('#nav-secondary').length)) {
		//Scrool loop
		$(window).scroll(function () {
			var wvrxAdminOffset = 0; //initialize offset for admin bar
			var wvrxFixedOffset = 0;  //iniialize offset for fixed elemenst
			var secondarySelector = "#nav-secondary .wvrx-menu-container"; //Defines the secondary selector
			var secondaryHeight = $(secondarySelector).outerHeight(); //Gathers the secondary height
			var primarySelector = "#nav-primary .wvrx-menu-container"; //Defines the primary selector
			var primaryHeight = $(primarySelector).outerHeight(); //Gathers the primary height
			// Set adjustement for the admin bar. May be able to move out of the scroll loop when inded the weaverjs
			if ($('.admin-bar').length) {
				wvrxAdminOffset = $('#wpadminbar').outerHeight();
			}
			// Check if other area are fixed, if so compute and offset
			$('.wvrx-fixedtop').each(function () {
				wvrxFixedOffset = wvrxFixedOffset + $(this).outerHeight();
			});
			wvrxAdminOffset = wvrxAdminOffset + wvrxFixedOffset;

			var windowScroll = $(window).scrollTop(); //Collects the amount of scroll
			//use parent container for position as when menu gets fixed its position changes
			var secondaryPos = $('#nav-secondary').offset().top - parseFloat($('body').css('marginTop')) + wvrxFixedOffset;
			var primaryPos = $('#nav-primary').offset().top - (parseFloat($('body').css('marginTop')) - secondaryHeight) + wvrxFixedOffset;

			//need 3 stages before second is fixed - before first fixed too - after that
			//Before secondary is fixed
			if (secondaryPos > (windowScroll + wvrxAdminOffset)) {
				$(secondarySelector).removeClass('wvrx-fixonscroll'); //Unfix secondary
				$(primarySelector).removeClass('wvrx-fixonscroll'); //Unfix primary
				$('body').css('margin-top', wvrxFixedOffset); //clear body offset as nothing is fixed
				$(primarySelector).css('top', ''); //remove top on primary
				$(secondarySelector).css('top', ''); //remove top on secondary if admin bar
			}
			//after secondary is fixed but before primary gets fixed
			if ((secondaryPos <= (windowScroll + wvrxAdminOffset)) && (primaryPos > (windowScroll + secondaryHeight + wvrxAdminOffset))) { //use parent container position
				$(secondarySelector).addClass('wvrx-fixonscroll'); //Fix secondary
				$('body').css('margin-top', secondaryHeight + wvrxFixedOffset); //Set body offset to account for fixed secondary
				$(primarySelector).removeClass('wvrx-fixonscroll'); //Unfix primary
				$(primarySelector).css('top', ''); //remove top on primary
				$(secondarySelector).css('top', wvrxAdminOffset + 'px'); //change secondary top
			}
			//after primary is fixed
			if (primaryPos <= (windowScroll + secondaryHeight + wvrxAdminOffset)) {
				$(primarySelector).addClass('wvrx-fixonscroll'); //fix primary
				$(secondarySelector).addClass('wvrx-fixonscroll'); //fix secondary
				$('body').css('margin-top', secondaryHeight + primaryHeight + wvrxFixedOffset); //Set body offset to account for fixed primary & secondary
				$(primarySelector).css('top', (secondaryHeight + wvrxAdminOffset) + 'px'); //change primary top
				$(secondarySelector).css('top', wvrxAdminOffset + 'px'); //change secondary top
			}
		});
	}
});
