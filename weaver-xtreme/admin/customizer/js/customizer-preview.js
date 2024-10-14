/**
 *
 */
var wvrxCustFontMsg = 0;

(function ($) {
	var api = wp.customize;

	function weaverx_refresh_js() {
		// most of the resizing options need to force update of WeaverX JS
		weaverxBottomFooter();

		weaverxFullWidth();
		wvrxFlowColor();
		weaverxOnResize();

		weaverx_js_update();
	}

	// Site Title
	api('blogname', function (value) {
		value.bind(function (to) {
			var content = $('#site-title a');
			if (!content.length) {
				$('#site-title').prepend('<a>' + to + '</a>');
			}
			if (!to) {
				content.remove();
			}
			content.text(to);
		});
	});

	// Tagline
	api('blogdescription', function (value) {
		value.bind(function (to) {
			var content = $('#site-tagline span');
			if (!content.length) {
				$('#site-tagline').append('<span>' + to + '</span>');
			}
			if (!to) {
				$content.remove();
			}
			content.text(to);
		});
	});

	// ---------- Colors

	function weaverxFixTo(to) {
		// This function fixes empty color values to be 'inherit', which is what an empty
		// color value really means in Weaver. Without this fix, a blank color value will
		// revert to the original (default) value, which is not what a blank value really
		// means in Weaver. A blank really means 'inherit' (or technically, none)
		if (!to)
			return 'inherit';
		return to;
	}

	api('weaverx5_settings[body_bgcolor]', function (value) {
		value.bind(function (to) {
			$('body').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[wrapper_color]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[wrapper_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[container_color]', function (value) {
		value.bind(function (to) {
			$('#container').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[container_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#container').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[footer_color]', function (value) {
		value.bind(function (to) {
			$('#header').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[header_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#header').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[site_title_color]', function (value) {
		value.bind(function (to) {
			$('.wrapper #site-title a,.site-title a').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[site_title_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.wrapper #site-title a,.wrapper .site-title a').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[tagline_color]', function (value) {
		value.bind(function (to) {
			$('#site-tagline > span,.site-tagline > span').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[tagline_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#site-tagline > span,.site-tagline > span').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[header_sb_color]', function (value) {
		value.bind(function (to) {
			$('#header-widget-area,.widget-area-header').css('color', weaverxFixTo(to));
		});
		value.bind(function (to) {
			$('.widget-area-header .search-form .search-submit').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[header_sb_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#header-widget-area,.widget-area-header').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[title_tagline_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#title-tagline').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[header_html_color]', function (value) {
		value.bind(function (to) {
			$('#header-html').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[header_html_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#header-html').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[hr_color]', function (value) {
		value.bind(function (to) {
			$('hr').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[content_h_color]', function (value) {
		value.bind(function (to) {
			$('.entry-content h1,.entry-content h2,.entry-content h3,.entry-content h4,.entry-content h5,.entry-content h6').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[content_h_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.entry-content h1,.entry-content h2,.entry-content h3,.entry-content h4,.entry-content h5,.entry-content h6').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[inject_prewrapper_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_prewrapper').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_postfooter_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_postfooter').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_preheader_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_preheader').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_header_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_header').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_postheader_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_postheader').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_container_top_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_container_top').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_postinfobar_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_postinfobar').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_precontent_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_precontent').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_pagecontentbottom_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_pagecontentbottom').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_postpostcontent_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.inject_postpostcontent').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_precomments_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_precomments').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_postcomments_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_postcomments').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_prefooter_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_prefooter').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_presidebar_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_presidebar').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_fixedtop_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_fixedtop').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[inject_fixedbottom_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#inject_fixedbottom').css('background-color', weaverxFixTo(to));
		});
	});


	api('weaverx5_settings[m_primary_top_margin_dec]', function (value) {
		value.bind(function (to) {
			$('.menu-primary .wvrx-menu-container').css('margin-top', to + 'px');
		});
	});
	api('weaverx5_settings[m_primary_bottom_margin_dec]', function (value) {
		value.bind(function (to) {
			$('.menu-primary .wvrx-menu-container').css('margin-bottom', to + 'px');
		});
	});

	api('weaverx5_settings[m_secondary_top_margin_dec]', function (value) {
		value.bind(function (to) {
			$('.menu-secondary .wvrx-menu-container').css('margin-top', to + 'px');
		});
	});
	api('weaverx5_settings[m_secondary_bottom_margin_dec]', function (value) {
		value.bind(function (to) {
			$('.menu-secondary .wvrx-menu-container').css('margin-bottom', to + 'px');
		});
	});

	api('weaverx5_settings[m_extra_top_margin_dec]', function (value) {
		value.bind(function (to) {
			$('.menu-extra .wvrx-menu-container').css('margin-top', to + 'px');
		});
	});
	api('weaverx5_settings[m_extra_bottom_margin_dec]', function (value) {
		value.bind(function (to) {
			$('.menu-extra .wvrx-menu-container').css('margin-bottom', to + 'px');
		});
	});


	api('weaverx5_settings[infobar_color]', function (value) {
		value.bind(function (to) {
			$('#infobar').css('color', weaverxFixTo(to));
		});
		value.bind(function (to) {
			$('#infobar .search-form .search-submit').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[infobar_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#infobar').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[content_color]', function (value) {
		value.bind(function (to) {
			$('#content').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[content_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#content').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[page_title_color]', function (value) {
		value.bind(function (to) {
			$('.page-title').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[page_title_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.page-title').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[archive_title_color]', function (value) {
		value.bind(function (to) {
			$('.archive-title').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[archive_title_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.archive-title').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[content_h_color]', function (value) {
		value.bind(function (to) {
			$('.entry-content h1,.entry-content h2,.entry-content h3,.entry-content h4,.entry-content h5,.entry-content h6').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[content_h_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.entry-content h1,.entry-content h2,.entry-content h3,.entry-content h4,.entry-content h5,.entry-content h6').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[input_color]', function (value) {
		value.bind(function (to) {
			$('input,textarea').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[input_bgcolor]', function (value) {
		value.bind(function (to) {
			$('input,textarea').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[search_color]', function (value) {
		value.bind(function (to) {
			$('.search-field,#header-search .search-field:focus').css('color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[search_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.search-field,#header-search .search-field:focus').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[comment_headings_color]', function (value) {
		value.bind(function (to) {
			$('#comments-title h3, #comments-title h4, #respond h3').css('color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[comment_content_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.commentlist li.comment, #respond').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[comment_submit_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#respond input#submit').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[post_color]', function (value) {
		value.bind(function (to) {
			$('.post-area').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[post_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.post-area').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[stickypost_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.blog .sticky').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[post_title_color]', function (value) {
		value.bind(function (to) {
			$('.wrapper .post-title a').css('color', weaverxFixTo(to));
		});
	});
	//	value.bind( function( to ) { $('.wrapper .post-title a,.wrapper .post-title a:visited').css( 'color', weaverxFixTo( to ) ); } );} );
	api('weaverx5_settings[post_title_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.wrapper .post-title').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[post_info_top_color]', function (value) {
		value.bind(function (to) {
			$('.entry-meta').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[post_info_top_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.entry-meta').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[post_info_bottom_color]', function (value) {
		value.bind(function (to) {
			$('.entry-utility').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[post_info_bottom_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.entry-utility').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[post_author_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#author-info').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[primary_color]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area,.widget-area-primary').css('color', weaverxFixTo(to));
		})
		value.bind(function (to) {
			$('#primary-widget-area .search-form .search-submit').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[primary_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area,.widget-area-primary').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[secondary_color]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area,.widget-area-secondary').css('color', weaverxFixTo(to));
		});
		value.bind(function (to) {
			$('#secondary-widget-area .search-form .search-submit').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[secondary_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area,.widget-area-secondary').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[top_color]', function (value) {
		value.bind(function (to) {
			$('.widget-area-top').css('color', weaverxFixTo(to));
		});
		value.bind(function (to) {
			$('.widget-area-top .search-form .search-submit').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[top_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.widget-area-top').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[bottom_color]', function (value) {
		value.bind(function (to) {
			$('.widget-area-bottom').css('color', weaverxFixTo(to));
		});
		value.bind(function (to) {
			$('.widget-area-bottom .search-form .search-submit').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[bottom_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.widget-area-bottom').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[widget_color]', function (value) {
		value.bind(function (to) {
			$('.widget').css('color', weaverxFixTo(to));
		});
		value.bind(function (to) {
			$('.widget .search-form .search-submit').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[widget_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.widget').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[widget_title_color]', function (value) {
		value.bind(function (to) {
			$('.widget-title').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[widget_title_bgcolor]', function (value) {
		value.bind(function (to) {
			$('.widget-title').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[footer_color]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('color', weaverxFixTo(to));
		});
		value.bind(function (to) {
			$('#colophon .search-form .search-submit').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[footer_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[footer_sb_color]', function (value) {
		value.bind(function (to) {
			$('#footer-widget-area,.widget-area-footer').css('color', weaverxFixTo(to));
		});
		value.bind(function (to) {
			$('.widget-area-footer .search-form .search-submit').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[footer_sb_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#footer-widget-area,.widget-area-footer').css('background-color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[footer_html_color]', function (value) {
		value.bind(function (to) {
			$('#footer-html').css('color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[footer_html_bgcolor]', function (value) {
		value.bind(function (to) {
			$('#footer-html').css('background-color', weaverxFixTo(to));
		});
	});

	// --------------------------------- Typography ---------------------------------

	function weaverxFontSize(val) {
		var cssVal = "inherit";
		switch (val) {
			case "m-font-size":
				cssVal = '1.0em';
				break;
			case "xxs-font-size":
				cssVal = '0.625em';
				break;
			case "xs-font-size":
				cssVal = '0.75em';
				break;
			case "s-font-size":
				cssVal = '0.875em';
				break;
			case "l-font-size":
				cssVal = '1.125em';
				break;
			case "xl-font-size":
				cssVal = '1.25em';
				break;
			case "xxl-font-size":
				cssVal = '1.5em';
				break;
			case "huge-font-size":
				cssVal = '2.0em';
				break;
			case "customA-font-size":
				cssVal = '1.125em';
				break;
			case "customB-font-size":
				cssVal = '1.125em';
				break;
			default:
				break;
		}
		return cssVal;
	}

	function weaverxFontSizeTitle(val) {
		var cssVal = "inherit";
		switch (val) {
			case "m-font-size":
				cssVal = '1.5em';
				break;
			case "xxs-font-size":
				cssVal = '.875em';
				break;
			case "xs-font-size":
				cssVal = '1em';
				break;
			case "s-font-size":
				cssVal = '1.25em';
				break;
			case "l-font-size":
				cssVal = '1.875em';
				break;
			case "xl-font-size":
				cssVal = '2.25em';
				break;
			case "xxl-font-size":
				cssVal = '2.625em';
				break;
			case "huge-font-size":
				cssVal = '3.0em';
				break;
			case "customA-font-size":
				cssVal = '1.875em';
				break;
			case "customB-font-size":
				cssVal = '1.875em';
				break;
			default:
				break;
		}
		return cssVal;

	}

	function weaverxFontSizeHeight(val) {
		var cssVal = "inherit";
		switch (val) {
			case "m-font-size":
				cssVal = '1.555';
				break;
			case "xxs-font-size":
				cssVal = '1.6';
				break;
			case "xs-font-size":
				cssVal = '1.6';
				break;
			case "s-font-size":
				cssVal = '1.3125';
				break;
			case "l-font-size":
				cssVal = '1.555';
				break;
			case "xl-font-size":
				cssVal = '1.5';
				break;
			case "xxl-font-size":
				cssVal = '1.5';
				break;
			case "huge-font-size":
				cssVal = '1.5';
				break;
			case "customA-font-size":
				cssVal = '1.555';
				break;
			case "customB-font-size":
				cssVal = '1.555';
				break;
			default:
				break;
		}
		return cssVal;

	}

	/*
	 * possible alternative implementation of title font sizes
	 function weaverxFixFontSizeTitle( where, to ) {
		//alert('fixFontSize: ' + where + ' : ' + to);
		$(where).removeClass('xxs-font-size-title');
		$(where).removeClass('xs-font-size-title');
		$(where).removeClass('s-font-size-title');
		$(where).removeClass('m-font-size-title');
		$(where).removeClass('l-font-size-title');
		$(where).removeClass('xl-font-size-title');
		$(where).removeClass('xxl-font-size-title');
		if (to != 'default')
			$(where).addClass(to + '-title');
	}
	 */

	function weaverxFontFamily(val) {

		var cssVal = "inherit";
		switch (val) {
			case "sans-serif":
				cssVal = 'Arial, "Helvetica Neue", Helvetica, sans-serif';
				break;
			case "arialBlack":
				cssVal = '"Arial Black", Gadget, Helvetica, sans-serif';
				break;
			case "arialNarrow":
				cssVal = '"Arial Narrow", Arial, sans-serif';
				break;
			case "lucidaSans":
				cssVal = '"Lucida Sans", Geneva, Tahoma, sans-serif';
				break;
			case "trebuchetMS":
				cssVal = '"Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif';
				break;
			case "verdana":
				cssVal = 'Verdana, Geneva, Candara, sans-serif';
				break;
			case "serif":
				cssVal = 'TimesNewRoman, "Times New Roman", Times, Baskerville, Georgia, serif';
				break;
			case "cambria":
				cssVal = 'Cambria, Didot, Georgia, "Times New Roman", "Times Roman", serif';
				break;
			case "garamond":
				cssVal = 'Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", TimesNewRoman, "Times New Roman", serif';
				break;
			case "georgia":
				cssVal = 'Georgia, Times, "Times New Roman", serif';
				break;
			case "lucidaBright":
				cssVal = '"Lucida Bright", "Book Antiqua", Georgia, serif';
				break;
			case "palatino":
				cssVal = '"Palatino Linotype", Palatino, "Lucida Bright", "Book Antiqua", serif';
				break;
			case "monospace":
				cssVal = '"Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace';
				break;
			case "consolas":
				cssVal = 'Consolas, monaco,"Andale Mono", AndaleMono, monospace';
				break;
			case "papyrus":
				cssVal = 'Papyrus, fantasy, cursive, serif';
				break;
			case "comicSans":
				cssVal = '"Comic Sans MS", cursive,serif';
				break;

			// Integrated Google Fonts
			case 'alegreya-sans':
				cssVal = "'Alegreya Sans', sans-serif";
				break;
			case 'alegreya-sans-sc':
				cssVal = "'Alegreya Sans SC', sans-serif";
				break;
			case 'alegreya':
				cssVal = "'Alegreya', serif";
				break;
			case 'alegreya-sc':
				cssVal = "'Alegreya SC', serif";
				break;
			case 'roboto':
				cssVal = "'Roboto', sans-serif";
				break;
			case 'roboto-condensed':
				cssVal = "'Roboto Condensed', sans-serif";
				break;
			case 'roboto-mono':
				cssVal = "'Roboto Mono', monospace";
				break;
			case 'roboto-slab':
				cssVal = "'Roboto Slab', serif";
				break;
			case 'source-sans-pro':
				cssVal = "'Source Sans Pro', sans-serif";
				break;
			case 'source-serif-pro':
				cssVal = "'Source Serif Pro', serif";
				break;
			case 'handlee':
				cssVal = "'Handlee', cursive";
				break;
			case 'inconsolata':
				cssVal = "'Inconsolata', monospace";
				break;
			case 'open-sans':
				cssVal = "'Open Sans', sans-serif";
				break;
			case 'open-sans-condensed':
				cssVal = "'Open Sans Condensed', sans-serif";
				break;
			case 'droid-sans':
				cssVal = "'Droid Sans', sans-serif";
				break;
			case 'droid-serif':
				cssVal = "'Droid Serif', serif";
				break;
			case 'exo-2':
				cssVal = "'Exo 2', sans-serif";
				break;
			case 'lato':
				cssVal = "'Lato', sans-serif";
				break;
			case 'lora':
				cssVal = "'Lora', serif";
				break;
			case 'arvo':
				cssVal = "'Arvo', serif";
				break;
			case 'archivo-black':
				cssVal = "'Archivo Black', sans-serif";
				break;
			case 'ultra':
				cssVal = "'Ultra', serif";
				break;
			case 'tinos':
				cssVal = "'Tinos', serif";
				break;
			case 'arimo':
				cssVal = "'Arimo', serif";
				break;
			case 'vollkorn':
				cssVal = "'Vollkorn', serif";
				break;

				/* PLUS FONTS */

			case 'oswald':
				cssVal = "'Oswald', sans-serif";
				break;
			case 'pt-sans':
				cssVal = "'PT Sans', sans-serif";
				break;
			case 'raleway':
				cssVal = "'Raleway', sans-serif";
				break;
			case 'ubuntu':
				cssVal = "'Ubuntu', sans-serif";
				break;
			case 'montserrat':
				cssVal = "'Montserrat', sans-serif";
				break;
			case 'pt-sans-narrow':
				cssVal = "'PT Sans Narrow', sans-serif";
				break;
			case 'yanone-kaffeesatz':
				cssVal = "'Yanone Kaffeesatz', sans-serif";
				break;
			case 'oxygen':
				cssVal = "'Oxygen', sans-serif";
				break;
			case 'titillium-web':
				cssVal = "'Titillium Web', sans-serif";
				break;
			case 'noto-sans':
				cssVal = "'Noto Sans', sans-serif";
				break;
			case 'dosis':
				cssVal = "'Dosis', sans-serif";
				break;
			case 'bitter':
				cssVal = "'Bitter', serif";
				break;
			case 'merriweather':
				cssVal = "'Merriweather', serif";
				break;
			case 'pt-serif':
				cssVal = "'PT Serif', serif";
				break;
			case 'playfair-display':
				cssVal = "'Playfair Display', serif";
				break;
			case 'rokkitt':
				cssVal = "'Rokkitt', serif";
				break;
			case 'noto-serif':
				cssVal = "'Noto Serif', serif";
				break;
			case 'indie-flower':
				cssVal = "'Indie Flower', cursive";
				break;
			case 'dancing-script':
				cssVal = "'Dancing Script', cursive";
				break;
			case 'droid-sans-mono':
				cssVal = "'Droid Sans Mono', Courier, monospace";
				break;
			case 'ubuntu-mono':
				cssVal = "'Ubuntu Mono', Courier, monospace";
				break;
			case 'nova-mono':
				cssVal = "'Nova Mono', Courier, monospace";
				break;

			case 'default':
			case 'inherit':
				cssVal = 'inherit';
				break;



			default:
				cssVal = "'Handlee', cursive";
				if (wvrxCustFontMsg != 1)
					alert('PLEASE NOTE: Weaver Xtreme Plus Custom Font Family will be temporarily displayed with the Handlee font in the live preview window. You can "Save and Publish" and then refresh the browser page to reload the Customizer to see the actual font.');
				wvrxCustFontMsg = 1;
				break;
		}
		//alert('weaverFontFamily: ' + cssVal);
		return cssVal;

	}

	function weaverxFontWeight(val) {
		var cssVal = "inherit";
		switch (val) {
			case "on":
				cssVal = 'bold';
				break;
			case "off":
				cssVal = 'normal';
				break;
			default:
				break;
		}
		return cssVal;
	}

	function weaverxFontWeightNormal(val) {
		if (val)
			return 'normal';
		else
			return 'bold';
	}

	function weaverxFontStyle(val) {
		var cssVal = "inherit";
		switch (val) {
			case "on":
				cssVal = 'italic';
				break;
			case "off":
				cssVal = 'normal';
				break;
			default:
				break;
		}
		return cssVal;
	}

	// ------ Wrapper
	api('weaverx5_settings[wrapper_font_size]', function (value) {
		value.bind(function (to) {
			var wrapper = $('#wrapper');
			wrapper.css('font-size', weaverxFontSize(to));
			wrapper.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[wrapper_font_family]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[wrapper_bold]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('font-weight', weaverxFontWeight(to));
			$('#wrapper a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[wrapper_italic]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('font-style', weaverxFontStyle(to));
			$('#wrapper a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Container
	api('weaverx5_settings[container_font_size]', function (value) {
		value.bind(function (to) {
			var container = $('#container');
			container.css('font-size', weaverxFontSize(to));
			container.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[container_font_family]', function (value) {
		value.bind(function (to) {
			$('#container').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[container_bold]', function (value) {
		value.bind(function (to) {
			$('#container').css('font-weight', weaverxFontWeight(to));
			$('#container a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[container_italic]', function (value) {
		value.bind(function (to) {
			$('#container').css('font-style', weaverxFontStyle(to));
			$('#container a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Header
	api('weaverx5_settings[header_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#header');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[header_font_family]', function (value) {
		value.bind(function (to) {
			$('#header').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[header_bold]', function (value) {
		value.bind(function (to) {
			$('#header').css('font-weight', weaverxFontWeight(to));
			$('#header a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[header_italic]', function (value) {
		value.bind(function (to) {
			$('#header').css('font-style', weaverxFontStyle(to));
			$('#header a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Site Title (title)
	api('weaverx5_settings[site_title_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#site-title,.site-title');
			header.css('font-size', weaverxFontSizeTitle(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[site_title_font_family]', function (value) {
		value.bind(function (to) {
			$('#site-title,.site-title').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[site_title_normal]', function (value) {
		value.bind(function (to) {
			$('#site-title,.site-title').css('font-weight', weaverxFontWeightNormal(to));
			$('#site-title a,.site-title a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeightNormal(to), 'important');
			});
		});
	});

	api('weaverx5_settings[site_title_italic]', function (value) {
		value.bind(function (to) {
			$('#site-title,.site-title').css('font-style', weaverxFontStyle(to));
			$('#site-title a,.site-title a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Site Tagline (title)
	api('weaverx5_settings[tagline_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#site-tagline,.site-tagline');
			header.css('font-size', weaverxFontSizeTitle(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[tagline_font_family]', function (value) {
		value.bind(function (to) {
			$('#site-tagline,.site-tagline').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[tagline_normal]', function (value) {
		value.bind(function (to) {
			$('#site-tagline,.site-tagline').css('font-weight', weaverxFontWeightNormal(to));
		});
	});

	api('weaverx5_settings[tagline_italic]', function (value) {
		value.bind(function (to) {
			$('#site-tagline,.site-tagline').css('font-style', weaverxFontStyle(to));
		});
	});

	// ------ Header Widget Area
	api('weaverx5_settings[header_sb_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#header-widget-area,.widget-area-header');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[header_sb_font_family]', function (value) {
		value.bind(function (to) {
			$('#header-widget-area,.widget-area-header').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[header_sb_bold]', function (value) {
		value.bind(function (to) {
			$('#header-widget-area,.widget-area-header').css('font-weight', weaverxFontWeight(to));
			$('#header-widget-area a,.widget-area-header a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[header_sb_italic]', function (value) {
		value.bind(function (to) {
			$('#header-widget-area,.widget-area-header').css('font-style', weaverxFontStyle(to));
			$('#header-widget-area a,.widget-area-header a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Header HTML Area
	api('weaverx5_settings[header_html_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#header-html');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[header_html_font_family]', function (value) {
		value.bind(function (to) {
			$('#header-html').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[header_html_bold]', function (value) {
		value.bind(function (to) {
			$('#header-html').css('font-weight', weaverxFontWeight(to));
			$('#header-html a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[header_html_italic]', function (value) {
		value.bind(function (to) {
			$('#header-html').css('font-style', weaverxFontStyle(to));
			$('#header-html a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Primary Menu
	api('weaverx5_settings[m_primary_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.menu-primary .wvrx-menu-container');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[m_primary_font_family]', function (value) {
		value.bind(function (to) {
			$('.menu-primary .wvrx-menu-container').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[m_primary_bold]', function (value) {
		value.bind(function (to) {
			$('.menu-primary .wvrx-menu-container').css('font-weight', weaverxFontWeight(to));
			$('.menu-primary .wvrx-menu-container a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[m_primary_italic]', function (value) {
		value.bind(function (to) {
			$('.menu-primary .wvrx-menu-container').css('font-style', weaverxFontStyle(to));
			$('.menu-primary .wvrx-menu-container a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Secondary Menu
	api('weaverx5_settings[m_secondary_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.menu-secondary .wvrx-menu-container');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[m_secondary_font_family]', function (value) {
		value.bind(function (to) {
			$('.menu-secondary .wvrx-menu-container').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[m_secondary_bold]', function (value) {
		value.bind(function (to) {
			$('.menu-secondary .wvrx-menu-container').css('font-weight', weaverxFontWeight(to));
			$('.menu-secondary .wvrx-menu-container a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[m_secondary_italic]', function (value) {
		value.bind(function (to) {
			$('.menu-secondary .wvrx-menu-container').css('font-style', weaverxFontStyle(to));
			$('.menu-secondary .wvrx-menu-container a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Header Mini Menu
	api('weaverx5_settings[m_header_mini_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#nav-header-mini');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[m_header_mini_font_family]', function (value) {
		value.bind(function (to) {
			$('#nav-header-mini').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[m_header_mini_bold]', function (value) {
		value.bind(function (to) {
			$('#nav-header-mini').css('font-weight', weaverxFontWeight(to));
			$('#nav-header-mini a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[m_header_mini_italic]', function (value) {
		value.bind(function (to) {
			$('#nav-header-mini').css('font-style', weaverxFontStyle(to));
			$('#nav-header-mini a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Info Bar
	api('weaverx5_settings[info_bar_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#infobar');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[info_bar_font_family]', function (value) {
		value.bind(function (to) {
			$('#infobar').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[info_bar_bold]', function (value) {
		value.bind(function (to) {
			$('#infobar').css('font-weight', weaverxFontWeight(to));
			$('#infobar a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[info_bar_italic]', function (value) {
		value.bind(function (to) {
			$('#infobar').css('font-style', weaverxFontStyle(to));
			$('#infobar a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Content
	api('weaverx5_settings[content_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#content');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[content_font_family]', function (value) {
		value.bind(function (to) {
			$('#content').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[content_bold]', function (value) {
		value.bind(function (to) {
			$('#content').css('font-weight', weaverxFontWeight(to));
			$('#content a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[content_italic]', function (value) {
		value.bind(function (to) {
			$('#content').css('font-style', weaverxFontStyle(to));
			$('#content a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Page Title (title)
	api('weaverx5_settings[page_title_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.page-title');
			header.css('font-size', weaverxFontSizeTitle(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[page_title_font_family]', function (value) {
		value.bind(function (to) {
			$('.page-title').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[page_title_normal]', function (value) {
		value.bind(function (to) {
			$('.page-title').css('font-weight', weaverxFontWeightNormal(to));
			$('.page-title a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeightNormal(to), 'important');
			});
		});
	});

	api('weaverx5_settings[page_title_italic]', function (value) {
		value.bind(function (to) {
			$('.page-title').css('font-style', weaverxFontStyle(to));
			$('.page-title a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Archive Title (title)
	api('weaverx5_settings[archive_title_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.archive-title');
			header.css('font-size', weaverxFontSizeTitle(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[archive_title_font_family]', function (value) {
		value.bind(function (to) {
			$('.archive-title').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[archive_title_normal]', function (value) {
		value.bind(function (to) {
			$('.archive-title').css('font-weight', weaverxFontWeightNormal(to));
			$('.archive-title a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeightNormal(to), 'important');
			});
		});
	});

	api('weaverx5_settings[archive_title_italic]', function (value) {
		value.bind(function (to) {
			$('.archive-title').css('font-style', weaverxFontStyle(to));
			$('.archive-title a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Post Specific
	api('weaverx5_settings[post_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.post-area');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[post_font_family]', function (value) {
		value.bind(function (to) {
			$('.post-area').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[post_bold]', function (value) {
		value.bind(function (to) {
			$('.post-area').css('font-weight', weaverxFontWeight(to));
			$('.post-area a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[post_italic]', function (value) {
		value.bind(function (to) {
			$('.post-area').css('font-style', weaverxFontStyle(to));
			$('.post-area a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Post Title (title)
	api('weaverx5_settings[post_title_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.wrapper .post-title a');
			// var header = $('.wrapper .post-title a,.wrapper .post-title a:visited');
			header.css('font-size', weaverxFontSizeTitle(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[post_title_font_family]', function (value) {
		value.bind(function (to) {
			$('.wrapper .post-title a').css('font-family', weaverxFontFamily(to));
			// $('.wrapper .post-title a,.wrapper .post-title a:visited').css( 'font-family', weaverxFontFamily(to) );
		});
	});

	api('weaverx5_settings[post_title_normal]', function (value) {
		value.bind(function (to) {
			$('.wrapper .post-title a').css('font-weight', weaverxFontWeightNormal(to));
			$('.wrapper .post-title a,.wrapper .post-title a:visited').css('font-weight', weaverxFontWeightNormal(to));
		});
	});

	api('weaverx5_settings[post_title_italic]', function (value) {
		value.bind(function (to) {
			$('.wrapper .post-title a').css('font-style', weaverxFontStyle(to));
			// $('.wrapper .post-title a,.wrapper .post-title a:visited').css( 'font-style', weaverxFontStyle(to) );
		});
	});

	// ------ Post Info Top
	api('weaverx5_settings[post_info_top_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.entry-meta');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[post_info_top_font_family]', function (value) {
		value.bind(function (to) {
			$('.entry-meta').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[post_info_top_bold]', function (value) {
		value.bind(function (to) {
			$('.entry-meta').css('font-weight', weaverxFontWeight(to));
			$('.entry-meta a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[post_info_top_italic]', function (value) {
		value.bind(function (to) {
			$('.entry-meta').css('font-style', weaverxFontStyle(to));
			$('.entry-meta a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Post Info Bottom
	api('weaverx5_settings[post_info_bottom_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.entry-utility');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[post_info_bottom_font_family]', function (value) {
		value.bind(function (to) {
			$('.entry-utility').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[post_info_bottom_bold]', function (value) {
		value.bind(function (to) {
			$('.entry-utility').css('font-weight', weaverxFontWeight(to));
			$('.entry-utility a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[post_info_bottom_italic]', function (value) {
		value.bind(function (to) {
			$('.entry-utility').css('font-style', weaverxFontStyle(to));
			$('.entry-utility a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Primary Widget area
	api('weaverx5_settings[primary_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#primary-widget-area,.widget-area-primary');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[primary_font_family]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area,.widget-area-primary').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[primary_bold]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area,.widget-area-primary').css('font-weight', weaverxFontWeight(to));
			$('#primary-widget-area a,.widget-area-primary a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[primary_italic]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area,.widget-area-primary').css('font-style', weaverxFontStyle(to));
			$('#primary-widget-area a,.widget-area-primary a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Secondary Widget area
	api('weaverx5_settings[secondary_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#secondary-widget-area,.widget-area-secondary');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[secondary_font_family]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area,.widget-area-secondary').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[secondary_bold]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area,.widget-area-secondary').css('font-weight', weaverxFontWeight(to));
			$('#secondary-widget-area a,.widget-area-secondary a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[secondary_italic]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area,.widget-area-secondary').css('font-style', weaverxFontStyle(to));
			$('#secondary-widget-area a,.widget-area-secondary a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Top Widget areas
	api('weaverx5_settings[top_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.widget-area-top');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[top_font_family]', function (value) {
		value.bind(function (to) {
			$('.widget-area-top').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[top_bold]', function (value) {
		value.bind(function (to) {
			$('.widget-area-top').css('font-weight', weaverxFontWeight(to));
			$('.widget-area-top a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[top_italic]', function (value) {
		value.bind(function (to) {
			$('.widget-area-top').css('font-style', weaverxFontStyle(to));
			$('.widget-area-top a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Bottom Widget areas
	api('weaverx5_settings[bottom_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.widget-area-bottom');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[bottom_font_family]', function (value) {
		value.bind(function (to) {
			$('.widget-area-bottom').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[bottom_bold]', function (value) {
		value.bind(function (to) {
			$('.widget-area-bottom').css('font-weight', weaverxFontWeight(to));
			$('.widget-area-bottom a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[bottom_italic]', function (value) {
		value.bind(function (to) {
			$('.widget-area-bottom').css('font-style', weaverxFontStyle(to));
			$('.widget-area-bottom a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Widgets
	api('weaverx5_settings[widget_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.widget');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[widget_font_family]', function (value) {
		value.bind(function (to) {
			$('.widget').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[widget_bold]', function (value) {
		value.bind(function (to) {
			$('.widget').css('font-weight', weaverxFontWeight(to));
			$('.widget a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[widget_italic]', function (value) {
		value.bind(function (to) {
			$('.widget').css('font-style', weaverxFontStyle(to));
			$('.widget a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Widget Title (title)
	api('weaverx5_settings[widget_title_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('.widget-title');
			header.css('font-size', weaverxFontSizeTitle(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[widget_title_font_family]', function (value) {
		value.bind(function (to) {
			$('.widget-title').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[widget_title_normal]', function (value) {
		value.bind(function (to) {
			$('.widget-title').css('font-weight', weaverxFontWeightNormal(to));
			$('.widget-title a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeightNormal(to), 'important');
			});
		});
	});

	api('weaverx5_settings[widget_title_italic]', function (value) {
		value.bind(function (to) {
			$('.widget-title').css('font-style', weaverxFontStyle(to));
			$('.widget-title a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Footer
	api('weaverx5_settings[footer_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#colophon');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[footer_font_family]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[footer_bold]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('font-weight', weaverxFontWeight(to));
			$('#colophon a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[footer_italic]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('font-style', weaverxFontStyle(to));
			$('#colophon a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Footer Widget Area
	api('weaverx5_settings[footer_sb_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#footer-widget-area,.widget-area-footer');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[footer_sb_font_family]', function (value) {
		value.bind(function (to) {
			$('#footer-widget-area,.widget-area-footer').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[footer_sb_bold]', function (value) {
		value.bind(function (to) {
			$('#footer-widget-area,.widget-area-footer').css('font-weight', weaverxFontWeight(to));
			$('#footer-widget-area a,.widget-area-footer a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[footer_sb_italic]', function (value) {
		value.bind(function (to) {
			$('#footer-widget-area,.widget-area-footer').css('font-style', weaverxFontStyle(to));
			$('#footer-widget-area a,.widget-area-footer a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// ------ Footer HTML Area
	api('weaverx5_settings[footer_html_font_size]', function (value) {
		value.bind(function (to) {
			var header = $('#footer-html');
			header.css('font-size', weaverxFontSize(to));
			header.css('line-height', weaverxFontSizeHeight(to));
		});
	});

	api('weaverx5_settings[footer_html_font_family]', function (value) {
		value.bind(function (to) {
			$('#footer-html').css('font-family', weaverxFontFamily(to));
		});
	});

	api('weaverx5_settings[footer_html_bold]', function (value) {
		value.bind(function (to) {
			$('#footer-html').css('font-weight', weaverxFontWeight(to));
			$('#footer-html a').each(function () {
				this.style.setProperty('font-weight', weaverxFontWeight(to), 'important');
			});
		});
	});

	api('weaverx5_settings[footer_html_italic]', function (value) {
		value.bind(function (to) {
			$('#footer-html').css('font-style', weaverxFontStyle(to));
			$('#footer-html a').each(function () {
				this.style.setProperty('font-style', weaverxFontStyle(to), 'important');
			});
		});
	});

	// Link Typography: link, ibarlink, contentlink, ilink, wlink, footerlink

	api('weaverx5_settings[link_strong]', function (value) {
		value.bind(function (to) {
			$('a, .wrapper a').css('font-weight', weaverxFontWeight(to));
		});
	});
	api('weaverx5_settings[link_em]', function (value) {
		value.bind(function (to) {
			$('a, .wrapper a').css('font-style', weaverxFontStyle(to));
		});
	});
	api('weaverx5_settings[link_u]', function (value) {
		value.bind(function (to) {
			if (to) $('a, .wrapper a').css('text-decoration', 'underline');
			else $('a, .wrapper a').css('text-decoration', 'none');
		});
	});

	api('weaverx5_settings[contentlink_strong]', function (value) {
		value.bind(function (to) {
			$('.content a').css('font-weight', weaverxFontWeight(to));
		});
	});
	api('weaverx5_settings[contentlink_em]', function (value) {
		value.bind(function (to) {
			$('.content a').css('font-style', weaverxFontStyle(to));
		});
	});
	api('weaverx5_settings[contentlink_u]', function (value) {
		value.bind(function (to) {
			if (to) $('.content a').css('text-decoration', 'underline');
			else $('.content a').css('text-decoration', 'none');
		});
	});

	api('weaverx5_settings[ilink_strong]', function (value) {
		value.bind(function (to) {
			$('.wrapper .entry-meta a, .wrapper .entry-utility a').css('font-weight', weaverxFontWeight(to));
		});
	});
	api('weaverx5_settings[ilink_em]', function (value) {
		value.bind(function (to) {
			$('.wrapper .entry-meta a, .wrapper .entry-utility a').css('font-style', weaverxFontStyle(to));
		});
	});
	api('weaverx5_settings[ilink_u]', function (value) {
		value.bind(function (to) {
			if (to) $('.wrapper .entry-meta a, .wrapper .entry-utility a').css('text-decoration', 'underline');
			else $('a, .wrapper a.wrapper .entry-meta a, .wrapper .entry-utility a').css('text-decoration', 'none');
		});
	});

	api('weaverx5_settings[wlink_strong]', function (value) {
		value.bind(function (to) {
			$('.wrapper .widget a').css('font-weight', weaverxFontWeight(to));
		});
	});
	api('weaverx5_settings[wlink_em]', function (value) {
		value.bind(function (to) {
			$('.wrapper .widget a').css('font-style', weaverxFontStyle(to));
		});
	});
	api('weaverx5_settings[wlink_u]', function (value) {
		value.bind(function (to) {
			if (to) $('.wrapper .widget a').css('text-decoration', 'underline');
			else $('.wrapper .widget a').css('text-decoration', 'none');
		});
	});

	api('weaverx5_settings[ibarlink_strong]', function (value) {
		value.bind(function (to) {
			$('#infobar a').css('font-weight', weaverxFontWeight(to));
		});
	});
	api('weaverx5_settings[ibarlink_em]', function (value) {
		value.bind(function (to) {
			$('#infobar a').css('font-style', weaverxFontStyle(to));
		});
	});
	api('weaverx5_settings[ibarlink_u]', function (value) {
		value.bind(function (to) {
			if (to) $('#infobar a').css('text-decoration', 'underline');
			else $('#infobar a').css('text-decoration', 'none');
		});
	});

	api('weaverx5_settings[footerlink_strong]', function (value) {
		value.bind(function (to) {
			$('.colophon a').css('font-weight', weaverxFontWeight(to));
		});
	});
	api('weaverx5_settings[footerlink_em]', function (value) {
		value.bind(function (to) {
			$('.colophon a').css('font-style', weaverxFontStyle(to));
		});
	});
	api('weaverx5_settings[footerlink_u]', function (value) {
		value.bind(function (to) {
			if (to) $('.colophon a').css('text-decoration', 'underline');
			else $('.colophon a').css('text-decoration', 'none');
		});
	});

	// Borders -------------------------------------------

	// general settings

	api('weaverx5_settings[border_width_int]', function (value) {
		value.bind(function (to) {
			$('.border,.border-bottom').css('border-width', to + 'px');
		});
	});

	api('weaverx5_settings[border_color]', function (value) {
		value.bind(function (to) {
			$('.border,.border-bottom').css('border-color', weaverxFixTo(to));
		});
	});

	function weaverxSetBorder(to, tag) {
		if (to)
			$(tag).addClass('border');
		else
			$(tag).removeClass('border');
	}

	api('weaverx5_settings[wrapper_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#wrapper');
		});
	});

	api('weaverx5_settings[container_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#container');
		});
	});

	api('weaverx5_settings[widget_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '.widget');
		});
	});

	api('weaverx5_settings[primary_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#primary-widget-area,.widget-area-primary');
		});
	});

	api('weaverx5_settings[secondary_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#secondary-widget-area,.widget-area-secondary');
		});
	});

	api('weaverx5_settings[top_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '.widget-area-top');
		});
	});

	api('weaverx5_settings[bottom_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '.widget-area-bottom');
		});
	});

	api('weaverx5_settings[header_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#header');
		});
	});

	api('weaverx5_settings[header_sb_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#header-widget-area,.widget-area-header');
		});
	});

	api('weaverx5_settings[header_html_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#header-html');
		});
	});

	// menus

	api('weaverx5_settings[m_primary_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '.menu-primary .wvrx-menu-container');
		});
	});

	api('weaverx5_settings[m_primary_sub_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '.menu-primary .wvrx-menu ul li a,.menu-primary .wvrx-menu ul.mega-menu li');
		});
	});

	api('weaverx5_settings[m_secondary_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '.menu-secondary .wvrx-menu-container');
		});
	});

	api('weaverx5_settings[m_secondary_sub_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '.menu-secondary .wvrx-menu ul li a,.menu-secondary .wvrx-menu ul.mega-menu li');
		});
	});

	// InfoBar

	api('weaverx5_settings[infobar_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#infobar');
		});
	});

	// Content Area

	api('weaverx5_settings[content_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#content');
		});
	});

	// Post Specific

	api('weaverx5_settings[post_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '.post-area');
		});
	});

	// Footer

	api('weaverx5_settings[footer_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#colophon');
		});
	});

	api('weaverx5_settings[footer_sb_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#footer-widget-area,.widget-area-footer');
		});
	});

	api('weaverx5_settings[footer_html_border]', function (value) {
		value.bind(function (to) {
			weaverxSetBorder(to, '#footer-html');
		});
	});

	// Shadows -------------------------------------------

	function weaverxSetShadow(to, tag) {
		var item = $(tag);
		item.removeClass('shadow-0'); // remove any existing shadow
		item.removeClass('shadow-1');
		item.removeClass('shadow-2');
		item.removeClass('shadow-3');
		item.removeClass('shadow-4');
		item.removeClass('shadow-rb');
		item.removeClass('shadow-lb');
		item.removeClass('shadow-tr');
		item.removeClass('shadow-tl');
		item.removeClass('shadow-custom');
		item.addClass('shadow' + to); // add the new one
	}

	api('weaverx5_settings[wrapper_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#wrapper');
		});
	});

	api('weaverx5_settings[container_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#container');
		});
	});

	api('weaverx5_settings[widget_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '.widget');
		});
	});

	api('weaverx5_settings[primary_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#primary-widget-area,.widget-area-primary');
		});
	});

	api('weaverx5_settings[secondary_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#secondary-widget-area,.widget-area-secondary');
		});
	});

	api('weaverx5_settings[top_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '.widget-area-top');
		});
	});

	api('weaverx5_settings[bottom_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '.widget-area-bottom');
		});
	});

	api('weaverx5_settings[header_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#header');
		});
	});

	api('weaverx5_settings[header_sb_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#header-widget-area,.widget-area-header');
		});
	});

	api('weaverx5_settings[header_html_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#header-html');
		});
	});

	// menus

	api('weaverx5_settings[m_primary_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '.menu-primary .wvrx-menu-container');
		});
	});

	api('weaverx5_settings[m_secondary_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '.menu-secondary .wvrx-menu-container');
		});
	});

	// InfoBar

	api('weaverx5_settings[infobar_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#infobar');
		});
	});

	// Content Area

	api('weaverx5_settings[content_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#content');
		});
	});

	// Post Specific

	api('weaverx5_settings[post_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '.post-area');
		});
	});

	// Footer

	api('weaverx5_settings[footer_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#colophon');
		});
	});

	api('weaverx5_settings[footer_sb_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#footer-widget-area,.widget-area-footer');
		});
	});

	api('weaverx5_settings[footer_html_shadow]', function (value) {
		value.bind(function (to) {
			weaverxSetShadow(to, '#footer-html');
		});
	});

	// Rounded  Corners -------------------------------------------

	function weaverxSetRounded(to, tag) {
		var item = $(tag);
		item.removeClass('rounded-all'); // remove any existing rounded classes
		item.removeClass('rounded-left');
		item.removeClass('rounded-right');
		item.removeClass('rounded-top');
		item.removeClass('rounded-bottom');
		if (to != 'none') {
			$(tag).addClass('rounded' + to); // add the new one
		}
	}

	api('weaverx5_settings[wrapper_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#wrapper');
		});
	});

	api('weaverx5_settings[container_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#container');
		});
	});

	api('weaverx5_settings[widget_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '.widget');
		});
	});

	api('weaverx5_settings[primary_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#primary-widget-area,.widget-area-primary');
		});
	});

	api('weaverx5_settings[secondary_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#secondary-widget-area,.widget-area-secondary');
		});
	});

	api('weaverx5_settings[top_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '.widget-area-top');
		});
	});

	api('weaverx5_settings[bottom_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '.widget-area-bottom');
		});
	});

	api('weaverx5_settings[header_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#header');
		});
	});

	api('weaverx5_settings[header_sb_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#header-widget-area,.widget-area-header');
		});
	});

	api('weaverx5_settings[header_html_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#header-html');
		});
	});

	// menus

	api('weaverx5_settings[m_primary_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '.menu-primary .wvrx-menu-container');
		});
	});

	api('weaverx5_settings[m_secondary_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '.menu-secondary .wvrx-menu-container');
		});
	});

	// InfoBar

	api('weaverx5_settings[infobar_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#infobar');
		});
	});

	// Content Area

	api('weaverx5_settings[content_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#content');
		});
	});

	// Post Specific

	api('weaverx5_settings[post_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '.post-area');
		});
	});

	// Footer

	api('weaverx5_settings[footer_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#colophon');
		});
	});

	api('weaverx5_settings[footer_sb_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#footer-widget-area,.widget-area-footer');
		});
	});

	api('weaverx5_settings[footer_html_rounded]', function (value) {
		value.bind(function (to) {
			weaverxSetRounded(to, '#footer-html');
		});
	});

	// ---------------- SPACING ---------------

	// wrapper

	api('weaverx5_settings[theme_width_int]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('max-width', to + 'px');
			weaverx_refresh_js();
		});
	});

	api('weaverx5_settings[wrapper_padding_T]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[wrapper_padding_B]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[wrapper_padding_L]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[wrapper_padding_R]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[wrapper_margin_T]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[wrapper_margin_B]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});

	// container

	api('weaverx5_settings[container_padding_T]', function (value) {
		value.bind(function (to) {
			$('#container').css('padding-top', to + 'px');
		});
	});
	api('weaverx5_settings[container_padding_B]', function (value) {
		value.bind(function (to) {
			$('#container').css('padding-bottom', to + 'px');
		});
	});
	api('weaverx5_settings[container_padding_L]', function (value) {
		value.bind(function (to) {
			$('#container').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[container_padding_R]', function (value) {
		value.bind(function (to) {
			$('#container').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[container_margin_T]', function (value) {
		value.bind(function (to) {
			$('#container').css('margin-top', to + 'px');
		});
	});
	api('weaverx5_settings[container_margin_B]', function (value) {
		value.bind(function (to) {
			$('#container').css('margin-bottom', to + 'px');
		});
	});
	api('weaverx5_settings[container_width_int]', function (value) {
		value.bind(function (to) {
			//$('#container').each(function(){this.style.setProperty('width', to +'%','important');});
			if (to === 0)
				$('#container').css('width', 'auto');
			else
				$('#container').css('width', to + '%');
			weaverx_refresh_js();
		});
	});

	// widgets

	api('weaverx5_settings[widget_padding_T]', function (value) {
		value.bind(function (to) {
			$('.widget').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[widget_padding_B]', function (value) {
		value.bind(function (to) {
			$('.widget').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[widget_padding_L]', function (value) {
		value.bind(function (to) {
			$('.widget').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[widget_padding_R]', function (value) {
		value.bind(function (to) {
			$('.widget').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[widget_margin_T]', function (value) {
		value.bind(function (to) {
			$('.widget').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[widget_margin_B]', function (value) {
		value.bind(function (to) {
			$('.widget').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});

	// primary widget area

	api('weaverx5_settings[primary_padding_T]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area,.widget-area-primary').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[primary_padding_B]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area,.widget-area-primary').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[primary_padding_L]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area,.widget-area-primary').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[primary_padding_R]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area,.widget-area-primary').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[primary_margin_T]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area,.widget-area-primary').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[primary_margin_B]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area,.widget-area-primary').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});

	// secondary widget area

	api('weaverx5_settings[secondary_padding_T]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area,.widget-area-secondary').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[secondary_padding_B]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area,.widget-area-secondary').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[secondary_padding_L]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area,.widget-area-secondary').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[secondary_padding_R]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area,.widget-area-secondary').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[secondary_margin_T]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area,.widget-area-secondary').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[secondary_margin_B]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area,.widget-area-secondary').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});

	// top widget area

	api('weaverx5_settings[top_padding_T]', function (value) {
		value.bind(function (to) {
			$('.widget-area-top').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[top_padding_B]', function (value) {
		value.bind(function (to) {
			$('.widget-area-top').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[top_padding_L]', function (value) {
		value.bind(function (to) {
			$('.widget-area-top').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[top_padding_R]', function (value) {
		value.bind(function (to) {
			$('.widget-area-top').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[top_margin_T]', function (value) {
		value.bind(function (to) {
			$('.widget-area-top').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[top_margin_B]', function (value) {
		value.bind(function (to) {
			$('.widget-area-top').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[top_width_int]', function (value) {
		value.bind(function (to) {
			if (to === 0)
				$('.widget-area-top').css('width', 'auto');
			else
				$('.widget-area-top').css('width', to + '%');
			weaverx_refresh_js();
		});
	});

	// bottom widget area

	api('weaverx5_settings[bottom_padding_T]', function (value) {
		value.bind(function (to) {
			$('.widget-area-bottom').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[bottom_padding_B]', function (value) {
		value.bind(function (to) {
			$('.widget-area-bottom').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[bottom_padding_L]', function (value) {
		value.bind(function (to) {
			$('.widget-area-bottom').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[bottom_padding_R]', function (value) {
		value.bind(function (to) {
			$('.widget-area-bottom').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[bottom_margin_T]', function (value) {
		value.bind(function (to) {
			$('.widget-area-bottom').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[bottom_margin_B]', function (value) {
		value.bind(function (to) {
			$('.widget-area-bottom').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[bottom_width_int]', function (value) {
		value.bind(function (to) {
			if (to === 0)
				$('.widget-area-bottom').css('width', 'auto');
			else
				$('.widget-area-bottom').css('width', to + '%');
			weaverx_refresh_js();
		});
	});

	// Header

	api('weaverx5_settings[header_padding_T]', function (value) {
		value.bind(function (to) {
			$('#header').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[header_padding_B]', function (value) {
		value.bind(function (to) {
			$('#header').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[header_padding_L]', function (value) {
		value.bind(function (to) {
			$('#header').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[header_padding_R]', function (value) {
		value.bind(function (to) {
			$('#header').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[header_margin_T]', function (value) {
		value.bind(function (to) {
			$('#header').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[header_margin_B]', function (value) {
		value.bind(function (to) {
			$('#header').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[header_width_int]', function (value) {
		value.bind(function (to) {
			if (to === 0)
				$('#header').css('width', 'auto');
			else
				$('#header').css('width', to + '%');
			weaverx_refresh_js();
		});
	});

	// Header Widget Area

	api('weaverx5_settings[header_sb_padding_T]', function (value) {
		value.bind(function (to) {
			$('#header-widget-area,.widget-area-header').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[header_sb_padding_B]', function (value) {
		value.bind(function (to) {
			$('#header-widget-area,.widget-area-header').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[header_sb_padding_L]', function (value) {
		value.bind(function (to) {
			$('#header-widget-area,.widget-area-header').css('padding-left', to + 'px');
		});
	});
	api('weaverx5_settings[header_sb_padding_R]', function (value) {
		value.bind(function (to) {
			$('#header-widget-area,.widget-area-header').css('padding-right', to + 'px');
		});
	});
	api('weaverx5_settings[header_sb_margin_T]', function (value) {
		value.bind(function (to) {
			$('#header-widget-area,.widget-area-header').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[header_sb_margin_B]', function (value) {
		value.bind(function (to) {
			$('#header-widget-area,.widget-area-header').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[header_sb_width_int]', function (value) {
		value.bind(function (to) {
			if (to === 0)
				$('#header-widget-area,.widget-area-header').css('width', 'auto');
			else
				$('#header-widget-area,.widget-area-header').css('width', to + '%');
			weaverx_refresh_js();
		});
	});

	// Header HTML Area

	api('weaverx5_settings[header_html_padding_T]', function (value) {
		value.bind(function (to) {
			$('#header-html').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[header_html_padding_B]', function (value) {
		value.bind(function (to) {
			$('#header-html').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[header_html_padding_L]', function (value) {
		value.bind(function (to) {
			$('#header-html').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[header_html_padding_R]', function (value) {
		value.bind(function (to) {
			$('#header-html').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[header_html_margin_T]', function (value) {
		value.bind(function (to) {
			$('#header-html').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[header_html_margin_B]', function (value) {
		value.bind(function (to) {
			$('#header-html').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[header_html_width_int]', function (value) {
		value.bind(function (to) {
			if (to === 0)
				$('#header-html').css('width', 'auto');
			else
				$('#header-html').css('width', to + '%');
			weaverx_refresh_js();
			//$('#header-html').css( 'max-width', to + '%' );weaverx_refresh_js();
		});
	});

	// Footer

	api('weaverx5_settings[footer_padding_T]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[footer_padding_B]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[footer_padding_L]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[footer_padding_R]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[footer_margin_T]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[footer_margin_B]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[footer_width_int]', function (value) {
		value.bind(function (to) {
			if (to === 0)
				$('#colophon').css('width', 'auto');
			else
				$('#colophon').css('width', to + '%');
			weaverx_refresh_js();
		});
	});

	// Footer Widget Area

	api('weaverx5_settings[footer_sb_padding_T]', function (value) {
		value.bind(function (to) {
			$('#footer-widget-area,.widget-area-footer').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[footer_sb_padding_B]', function (value) {
		value.bind(function (to) {
			$('#footer-widget-area,.widget-area-footer').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[footer_sb_padding_L]', function (value) {
		value.bind(function (to) {
			$('#footer-widget-area,.widget-area-footer').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[footer_sb_padding_R]', function (value) {
		value.bind(function (to) {
			$('#footer-widget-area,.widget-area-footer').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[footer_sb_margin_T]', function (value) {
		value.bind(function (to) {
			$('#footer-widget-area,.widget-area-footer').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[footer_sb_margin_B]', function (value) {
		value.bind(function (to) {
			$('#footer-widget-area,.widget-area-footer').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[footer_sb_width_int]', function (value) {
		value.bind(function (to) {
			if (to === 0)
				$('#footer-widget-area,.widget-area-footer').css('width', 'auto');
			else
				$('#footer-widget-area,.widget-area-footer').css('width', to + '%');
			weaverx_refresh_js();
		});
	});

	// Footer HTML Area

	api('weaverx5_settings[footer_html_padding_T]', function (value) {
		value.bind(function (to) {
			$('#footer-html').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[footer_html_padding_B]', function (value) {
		value.bind(function (to) {
			$('#footer-html').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[footer_html_padding_L]', function (value) {
		value.bind(function (to) {
			$('#footer-html').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[footer_html_padding_R]', function (value) {
		value.bind(function (to) {
			$('#footer-html').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[footer_html_margin_T]', function (value) {
		value.bind(function (to) {
			$('#footer-html').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[footer_html_margin_B]', function (value) {
		value.bind(function (to) {
			$('#footer-html').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[footer_html_width_int]', function (value) {
		value.bind(function (to) {
			//$('#footer-html').css( 'max-width', to + '%' );
			if (to === 0)
				$('#footer-html').css('width', 'auto');
			else
				$('#footer-html').css('width', to + '%');

			weaverx_refresh_js();
		});
	});

	// Info Bar

	api('weaverx5_settings[infobar_padding_T]', function (value) {
		value.bind(function (to) {
			$('#infobar').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[infobar_padding_B]', function (value) {
		value.bind(function (to) {
			$('#infobar').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[infobar_padding_L]', function (value) {
		value.bind(function (to) {
			$('#infobar').css('padding-left', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[infobar_padding_R]', function (value) {
		value.bind(function (to) {
			$('#infobar').css('padding-right', to + 'px');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[infobar_margin_T]', function (value) {
		value.bind(function (to) {
			$('#infobar').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[infobar_margin_B]', function (value) {
		value.bind(function (to) {
			$('#infobar').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[infobar_width_int]', function (value) {
		value.bind(function (to) {
			if (to === 0)
				$('#infobar').css('width', 'auto');
			else
				$('#infobar').css('width', to + '%');
			weaverx_refresh_js();
		});
	});

	// content

	api('weaverx5_settings[content_padding_T]', function (value) {
		value.bind(function (to) {
			$('#content').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[content_padding_B]', function (value) {
		value.bind(function (to) {
			$('#content').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[content_padding_L]', function (value) {
		value.bind(function (to) {
			$('#content').css('padding-left', to + '%');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[content_padding_R]', function (value) {
		value.bind(function (to) {
			$('#content').css('padding-right', to + '%');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[content_margin_T]', function (value) {
		value.bind(function (to) {
			$('#content').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[content_margin_B]', function (value) {
		value.bind(function (to) {
			$('#content').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[space_after_title_dec]', function (value) {
		value.bind(function (to) {
			$('.entry-summary,.entry-content').css('padding-top', to + 'em');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[content_p_list_dec]', function (value) {
		value.bind(function (to) {
			$('#content ul,#content ol').css('margin-bottom', to + 'em');
			weaverx_refresh_js();
		});
	});

	// mini menu

	api('weaverx5_settings[m_header_mini_top_margin_dec]', function (value) {
		value.bind(function (to) {
			$('#nav-header-mini').css('margin-top', to + 'em');
			weaverx_refresh_js();
		});
	});

	// posts

	api('weaverx5_settings[post_padding_T]', function (value) {
		value.bind(function (to) {
			$('.post-area').css('padding-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[post_padding_B]', function (value) {
		value.bind(function (to) {
			$('.post-area').css('padding-bottom', to + 'px'); /* -bottom */
		});
	});
	api('weaverx5_settings[post_padding_L]', function (value) {
		value.bind(function (to) {
			$('.post-area').css('padding-left', to + '%');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[post_padding_R]', function (value) {
		value.bind(function (to) {
			$('.post-area').css('padding-right', to + '%');
			weaverx_refresh_js();
		});
	});
	api('weaverx5_settings[post_margin_T]', function (value) {
		value.bind(function (to) {
			$('.post-area').css('margin-top', to + 'px'); /* -top */
		});
	});
	api('weaverx5_settings[post_margin_B]', function (value) {
		value.bind(function (to) {
			$('.post-area').css('margin-bottom', to + 'px'); /* -bottom */
		});
	});

	api('weaverx5_settings[post_title_bottom_margin_dec]', function (value) {
		value.bind(function (to) {
			$('.post-title').css('margin-bottom', to + 'em');
			weaverx_refresh_js();
		});
	});

	// ------------------- Align ----------------------------

	function weaverxSetAlign(to, tag) {
		var item = $(tag);
		item.removeClass('float-left'); // remove any existing shadow
		item.removeClass('align-enter');
		item.removeClass('float-right');
		item.addClass(to); // add the new one
		weaverx_refresh_js();
	}

	api('weaverx5_settings[container_align]', function (value) {
		value.bind(function (to) {
			weaverxSetAlign(to, '#container');
		});
	});
	api('weaverx5_settings[header_align]', function (value) {
		value.bind(function (to) {
			weaverxSetAlign(to, '#header');
		});
	});
	api('weaverx5_settings[footer_align]', function (value) {
		value.bind(function (to) {
			weaverxSetAlign(to, '#colophon');
		});
	});
	/*api('weaverx5_settings[header_sb_align]', function( value ) {
		value.bind( function( to ) {
			weaverxSetAlign(to, '#header-widget-area,.widget-area-header');
			$('#header-widget-area,.widget-area-header').css('z-index',10);
	} );} ); */
	api('weaverx5_settings[footer_sb_align]', function (value) {
		value.bind(function (to) {
			weaverxSetAlign(to, '#footer-widget-area,.widget-area-footer');
		});
	});

	api('weaverx5_settings[infobar_align]', function (value) {
		value.bind(function (to) {
			weaverxSetAlign(to, '#infobar');
		});
	});

	api('weaverx5_settings[header_html_center_content]', function (value) {
		value.bind(function (to) {
			if (to)
				$('#header-html').css('text-align', 'center');
			else
				$('#header-html').css('text-align', 'left');
		});
	});

	api('weaverx5_settings[footer_html_center_content]', function (value) {
		value.bind(function (to) {
			if (to)
				$('#footer-html').css('text-align', 'center');
			else
				$('#footer-html').css('text-align', 'left');
		});
	});

	api('weaverx5_settings[top_align]', function (value) {
		value.bind(function (to) {
			weaverxSetAlign(to, '.widget-area-top');
		});
	});
	api('weaverx5_settings[bottom_align]', function (value) {
		value.bind(function (to) {
			weaverxSetAlign(to, '.widget-area-bottom');
		});
	});

	api('weaverx5_settings[header_image_align]', function (value) {
		value.bind(function (to) {
			weaverxSetAlign(to, '#branding #header-image img');
		});
	});

	api('weaverx5_settings[header_actual_size]', function (value) {
		value.bind(function (to) {
			//#branding #header-image img,html.ie8 #branding #header-image img {width:auto;}
			if (to)
				$('#branding #header-image img').css('width', 'auto');
			else
				$('#branding #header-image img').css('width', '100%');
		});
	});

	// -------------------- Title / Tagline -----------------

	api('weaverx5_settings[site_title_position_xy_X]', function (value) {
		value.bind(function (to) {
			$('#site-title').each(function () {
				this.style.setProperty('margin-left', to + '%', 'important');
			});
		});
	});
	api('weaverx5_settings[site_title_position_xy_Y]', function (value) {
		value.bind(function (to) {
			$('#site-title').each(function () {
				this.style.setProperty('margin-top', to + '%', 'important');
			});
		});
	});
	api('weaverx5_settings[site_title_max_w]', function (value) {
		value.bind(function (to) {
			$('#site-title').css('max-width', to + '%');
		});
	});
	api('weaverx5_settings[tagline_xy_X]', function (value) {
		value.bind(function (to) {
			$('#site-tagline').each(function () {
				this.style.setProperty('margin-left', to + '%', 'important');
			});
		});
	});
	api('weaverx5_settings[tagline_xy_Y]', function (value) {
		value.bind(function (to) {
			$('#site-tagline').each(function () {
				this.style.setProperty('margin-top', to + '%', 'important');
			});
		});
	});
	api('weaverx5_settings[tagline_xy_X]', function (value) {
		value.bind(function (to) {
			$('#site-tagline').each(function () {
				this.style.setProperty('margin-left', to + '%', 'important');
			});
		});
	});
	api('weaverx5_settings[title_tagline_xy_T]', function (value) {
		value.bind(function (to) {
			$('#title-tagline').css('padding-top', to + 'px');
		});
	});

	api('weaverx5_settings[title_tagline_xy_B]', function (value) {
		value.bind(function (to) {
			$('#title-tagline').css('padding-bottom', to + 'px');
		});
	});

	// HTML Areas

	function weaverxSetHTMLContent(tag, to) {
		var content = $(tag);

		if (!to) {
			content.html(to);
			content.css('display', 'inline');
		} else {
			content.html(to);
			content.each(function () {
				this.style.setProperty('display', 'inline-block', 'important');
			});
		}
	}

	api('weaverx5_settings[header_html_text]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#header-html", to);
		});
	});
	api('weaverx5_settings[footer_html_text]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#footer-html", to);
		});
	});

	api('weaverx5_settings[container_top_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_container_top", to);
		});
	});
	api('weaverx5_settings[prewrapper_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_prewrapper", to);
		});
	});
	api('weaverx5_settings[postfooter_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_postfooter", to);
		});
	});
	api('weaverx5_settings[preheader_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_preheader", to);
		});
	});
	api('weaverx5_settings[header_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_header", to);
		});
	});
	api('weaverx5_settings[postheader_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_postheader", to);
		});
	});
	api('weaverx5_settings[postinfobar_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_postinfobar", to);
		});
	});
	api('weaverx5_settings[precontent_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_precontent", to);
		});
	});
	api('weaverx5_settings[pagecontentbottom_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_pagecontentbottom", to);
		});
	});
	api('weaverx5_settings[postpostcontent_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent(".inject_postpostcontent", to);
		});
	});
	api('weaverx5_settings[precomments_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_precomments", to);
		});
	});
	api('weaverx5_settings[postcomments_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_postcomments", to);
		});
	});
	api('weaverx5_settings[prefooter_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_prefooter", to);
		});
	});
	api('weaverx5_settings[presidebar_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_presidebar", to);
		});
	});
	api('weaverx5_settings[fixedtop_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_fixedtop", to);
		});
	});
	api('weaverx5_settings[fixedbottom_insert]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent("#inject_fixedbottom", to);
		});
	});

	api('weaverx5_settings[m_primary_html_left]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent(".menu-primary .wvrx-menu-left", to);
		});
	});
	api('weaverx5_settings[m_primary_html_right]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent(".menu-primary .wvrx-menu-right", to);
		});
	});

	api('weaverx5_settings[m_secondary_html_left]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent(".menu-secondary .wvrx-menu-left", to);
		});
	});
	api('weaverx5_settings[m_secondary_html_right]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent(".menu-secondary .wvrx-menu-right", to);
		});
	});

	api('weaverx5_settings[m_extra_html_left]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent(".menu-extra .wvrx-menu-left", to);
		});
	});
	api('weaverx5_settings[m_extra_html_right]', function (value) {
		value.bind(function (to) {
			weaverxSetHTMLContent(".menu-extra .wvrx-menu-right", to);
		});
	});

	api('weaverx5_settings[excerpt_more_msg]', function (value) {
		value.bind(function (to) {
			var content = $(".more-msg");
			if (!to) {
				to = wvrxPRE.more_msg;
			}
			content.html(to);
			content.each(function () {
				this.style.setProperty('display', 'inline-block', 'important');
			});
		});
	});

	api('weaverx5_settings[copyright]', function (value) {
		value.bind(function (to) {
			var content = $("#site-info");
			if (!to) {
				to = wvrxPRE.copyright;
			}
			content.html(to);
			content.each(function () {
				this.style.setProperty('display', 'inline-block', 'important');
			});
		});
	});

	//Custom CSS

	function weaverxStyle(select, to, cssid) {
		// generate a CSS+ style rule in the DOM

		var css_plus = $('#wvrx-css-plus'), // the css+ <style> block ID - CSS+ rules are generated to this block for the Preview Window version
			current = css_plus.html(); // the current content of the <style> block

		// build a RegExp for / *-=:cssid:=-* /rule/ *-:cssid:-* /, which is the pattern output for the preview
		// window by generatecss.php.

		var regpat = new RegExp('\\/\\*-=:' + cssid + ':=-\\*\\/([\\s\\S]*?)\\/\\*-:' + cssid + ':-\\*\\/');
		var srch = current.search(regpat);
		var rule;

		if (srch < 0) { // no previous rule generated for this cssid, so create an empty link in the DOM
			css_plus.append('/*-=:' + cssid + ':=-*/ /*-:' + cssid + ':-*/');
		}

		if (to) { // if there is a rule, change any existing matching rule with the new one.
			// replace all the %selector%'s with the main rule.
			rule = '/*-=:' + cssid + ':=-*/' + select + ' ' + to.replace(/%selector%/g, select) + '/*-:' + cssid + ':-*/';
			current = css_plus.html();
			current = current.replace(regpat, rule);
			css_plus.html(current);
		} else { // the user has emptied the rule, so replace it with a blank for future matching
			rule = '/*-=:' + cssid + ':=-*/ /*-:' + cssid + ':-*/';
			current = css_plus.html();
			current = current.replace(regpat, rule);
			css_plus.html(current);
		}
		if (select.search(/,/) >= 0 && to.search(/%selector%/) >= 0) { // force a refresh for these special cases
			wp.customize.preview.send('refresh');
		}
	}

	// There can't be multiple calls for the same option because of the pattern match!
	// Note: any rule requiring multiple selectors (with a ,) will force a refresh IF the user's rule has %selector%

	api('weaverx5_settings[body_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('body', to, "body_bgcolor_css");
		});
	});
	api('weaverx5_settings[wrapper_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#wrapper', to, "wrapper_bgcolor_css");
		});
	});
	api('weaverx5_settings[container_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#container', to, "container_bgcolor_css");
		});
	});
	api('weaverx5_settings[link_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('a,.wrapper a', to, "link_color_css");
		});
	});
	api('weaverx5_settings[link_hover_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('a:hover,.wrapper a:hover', to, "link_hover_color_css");
		});
	});
	api('weaverx5_settings[m_header_mini_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#nav-header-mini ', to, "m_header_mini_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_header_mini_hover_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#nav-header-mini a:hover', to, "m_header_mini_hover_color_css");
		});
	});
	api('weaverx5_settings[infobar_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#infobar', to, "infobar_bgcolor_css");
		});
	});
	api('weaverx5_settings[ibarlink_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#infobar a', to, "ibarlink_color_css");
		});
	});
	api('weaverx5_settings[ibarlink_hover_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#infobar a:hover', to, "ibarlink_hover_color_css");
		});
	});
	api('weaverx5_settings[contentlink_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.content a', to, "contentlink_color_css");
		});
	});
	api('weaverx5_settings[contentlink_hover_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.content a:hover', to, "contentlink_hover_color_css");
		});
	});
	api('weaverx5_settings[post_title_hover_color]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.wrapper .post-title a:hover', to, "post_title_hover_color");
		});
	});
	api('weaverx5_settings[ilink_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.wrapper .entry-meta a,.wrapper .entry-utility a', to, "ilink_color_css");
		});
	});
	api('weaverx5_settings[ilink_hover_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.wrapper .entry-meta a:hover,.wrapper .entry-utility a:hover', to, "ilink_hover_color_css");
		});
	});
	api('weaverx5_settings[wlink_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.wrapper .widget a', to, "wlink_color_css");
		});
	});
	api('weaverx5_settings[wlink_hover_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.wrapper .widget a:hover', to, "wlink_hover_color_css");
		});
	});
	api('weaverx5_settings[footerlink_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.colophon a', to, "footerlink_color_css");
		});
	});
	api('weaverx5_settings[footerlink_hover_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.colophon a:hover', to, "footerlink_hover_color_css");
		});
	});
	api('weaverx5_settings[header_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#header', to, "header_bgcolor_css");
		});
	});
	api('weaverx5_settings[site_title_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.wrapper #site-title a,.site-title a', to, "site_title_bgcolor_css");
		});
	});
	api('weaverx5_settings[tagline_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#site-tagline,.site-tagline', to, "tagline_bgcolor_css");
		});
	});
	api('weaverx5_settings[title_tagline_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#title-tagline', to, "title_tagline_bgcolor_css");
		});
	});
	api('weaverx5_settings[header_sb_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#header-widget-area', to, "header_sb_bgcolor_css");
		});
	});
	api('weaverx5_settings[header_html_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#header-html', to, "header_html_bgcolor_css");
		});
	});

	api('weaverx5_settings[m_primary_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-primary .wvrx-menu-container', to, "m_primary_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_primary_link_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-primary .wvrx-menu > li > a', to, "m_primary_link_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_primary_hover_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-primary .wvrx-menu > li > a:hover', to, "m_primary_hover_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_primary_sub_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-primary .wvrx-menu ul li a,.menu-primary .wvrx-menu ul.mega-menu li', to, "m_primary_sub_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_primary_sub_hover_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-primary .wvrx-menu ul li a:hover', to, "m_primary_sub_hover_bgcolor_css");
		});
	});

	api('weaverx5_settings[m_secondary_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-secondary .wvrx-menu-container', to, "m_secondary_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_secondary_link_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-secondary .wvrx-menu > li > a', to, "m_secondary_link_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_secondary_hover_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-secondary .wvrx-menu > li > a:hover', to, "m_secondary_hover_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_secondary_sub_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-secondary .wvrx-menu ul li a,.menu-secondary .wvrx-menu ul.mega-menu li', to, "m_secondary_sub_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_secondary_sub_hover_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-secondary .wvrx-menu ul li a:hover', to, "m_secondary_sub_hover_bgcolor_css");
		});
	});

	api('weaverx5_settings[m_extra_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-extra .wvrx-menu-container', to, "m_extra_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_extra_link_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-extra .wvrx-menu > li > a', to, "m_extra_link_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_extra_hover_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-extra .wvrx-menu > li > a:hover', to, "m_extra_hover_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_extra_sub_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-extra .wvrx-menu ul li a,.menu-extra .wvrx-menu ul.mega-menu li', to, "m_extra_sub_bgcolor_css");
		});
	});
	api('weaverx5_settings[m_extra_sub_hover_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.menu-extra .wvrx-menu ul li a:hover', to, "m_extra_sub_hover_bgcolor_css");
		});
	});

	api('weaverx5_settings[menubar_curpage_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.weaverx-theme-menu .current_page_item > a,.weaverx-theme-menu .current-menu-item > a,.weaverx-theme-menu .current-cat > a', to, "menubar_curpage_bgcolor_css");
		});
	});

	api('weaverx5_settings[content_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#content', to, "content_bgcolor_css");
		});
	});
	api('weaverx5_settings[page_title_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.page-title', to, "page_title_bgcolor_css");
		});
	});
	api('weaverx5_settings[archive_title_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.archive-title', to, "archive_title_bgcolor_css");
		});
	});
	api('weaverx5_settings[content_h_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.entry-content h1,.entry-content h2,.entry-content h3,.entry-content h4,.entry-content h5,.entry-content h6', to, "content_h_bgcolor_css");
		});
	});
	api('weaverx5_settings[search_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.search-field,#header-search .search-field:focus', to, "search_bgcolor_css");
		});
	});

	api('weaverx5_settings[hr_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('hr', to, "hr_color_css");
		});
	});

	api('weaverx5_settings[comment_headings_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#comments-title h3,#comments-title h4,#respond h3', to, "comment_headings_color_css");
		});
	});
	api('weaverx5_settings[comment_content_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.commentlist li.comment,#respond', to, "comment_content_bgcolor_css");
		});
	});
	api('weaverx5_settings[comment_submit_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#respond input#submit', to, "comment_submit_bgcolor_css");
		});
	});

	api('weaverx5_settings[post_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.post-area', to, "post_bgcolor_css");
		});
	});
	api('weaverx5_settings[stickypost_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.blog .sticky', to, "stickypost_bgcolor_css");
		});
	});
	api('weaverx5_settings[post_title_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.wrapper .post-title', to, "post_title_bgcolor_css");
		});
	});
	api('weaverx5_settings[post_title_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.wrapper .post-title a,.wrapper .post-title a:visited', to, "post_title_color_css");
		});
	});
	api('weaverx5_settings[post_info_top_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.entry-meta', to, "post_info_top_bgcolor_css");
		});
	});
	api('weaverx5_settings[post_info_bottom_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.entry-utility', to, "post_info_bottom_bgcolor_css");
		});
	});
	api('weaverx5_settings[post_author_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#author-info', to, "post_author_bgcolor_css");
		});
	});

	api('weaverx5_settings[widget_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.widget', to, "widget_bgcolor_css");
		});
	});
	api('weaverx5_settings[widget_title_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.widget-title', to, "widget_title_bgcolor_css");
		});
	});
	api('weaverx5_settings[primary_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#primary-widget-area,.widget-area-primary', to, "primary_bgcolor_css");
		});
	});
	api('weaverx5_settings[secondary_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#secondary-widget-area,.widget-area-secondary', to, "secondary_bgcolor_css");
		});
	});
	api('weaverx5_settings[top_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.widget-area-top', to, "top_bgcolor_css");
		});
	});
	api('weaverx5_settings[bottom_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.widget-area-bottom', to, "bottom_bgcolor_css");
		});
	});

	api('weaverx5_settings[footer_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#colophon', to, "footer_bgcolor_css");
		});
	});

	api('weaverx5_settings[footer_sb_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#footer-widget-area,.widget-area-footer', to, "footer_sb_bgcolor_css");
		});
	});

	api('weaverx5_settings[footer_html_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#footer-html', to, "footer_html_bgcolor_css");
		});
	});

	// Injection areas

	api('weaverx5_settings[inject_prewrapper_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_prewrapper', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_postfooter_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_postfooter', to, "content_bgcolor_css");
		});
	});

	// Imgage injection

	api('weaverx5_settings[caption_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.wp-caption p.wp-caption-text,#content .gallery .gallery-caption,.entry-attachment .entry-caption', to, "caption_color_css");
		});
	});

	api('weaverx5_settings[media_lib_border_color_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.container img, .colophon img', to, "media_lib_border_color_css");
		});
	});
	// X Plus Injection

	api('weaverx5_settings[inject_preheader_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_preheader', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_header_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_header', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_postheader_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_postheader', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_container_top_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_container_top', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_postinfobar_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_postinfobar', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_precontent_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_precontent', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_pagecontentbottom_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_pagecontentbottom', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_postpostcontent_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('.inject_postpostcontent', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_precomments_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_precomments', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_postcomments_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_postcomments', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_prefooter_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_prefooter', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_presidebar_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_presidebar', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_fixedtop_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_fixedtop', to, "content_bgcolor_css");
		});
	});

	api('weaverx5_settings[inject_fixedbottom_bgcolor_css]', function (value) {
		value.bind(function (to) {
			weaverxStyle('#inject_fixedbottom', to, "content_bgcolor_css");
		});
	});

	// The main Custom CSS

	api('weaverx5_settings[add_css]', function (value) { // main custom CSS box
		value.bind(function (to) {
			$('#wvrx-global-css').html(to); // replace entire content with new to
		});
	});


	// BG IMAGES

	api('weaverx5_settings[_bg_fullsite_url]', function (value) {
		value.bind(function (to) {
			var site = $('html');
			site.css('background', 'url(' + to + ') no-repeat center center fixed');
			site.css('-webkit-background-size', 'cover');
			site.css('-moz-background-size', 'cover');
			site.css('-o-background-size', 'cover');
			site.css('background-size', 'cover');
			$('body').css('background-color', 'transparent');
		});
	});

	api('weaverx5_settings[_bg_body_url]', function (value) {
		value.bind(function (to) {
			$('body').css('background-image', 'url(' + to + ')');
		});
	});
	api('weaverx5_settings[_bg_wrapper_url]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('background-image', 'url(' + to + ')');
		});
	});
	api('weaverx5_settings[_bg_header_url]', function (value) {
		value.bind(function (to) {
			$('#header').css('background-image', 'url(' + to + ')');
		});
	});
	api('weaverx5_settings[_bg_container_url]', function (value) {
		value.bind(function (to) {
			$('#container').css('background-image', 'url(' + to + ')');
		});
	});
	api('weaverx5_settings[_bg_content_url]', function (value) {
		value.bind(function (to) {
			$('#content').css('background-image', 'url(' + to + ')');
		});
	});
	api('weaverx5_settings[_bg_page_url]', function (value) {
		value.bind(function (to) {
			$('#content .page').css('background-image', 'url(' + to + ')');
		});
	});
	api('weaverx5_settings[_bg_post_url]', function (value) {
		value.bind(function (to) {
			$('#content .type-post').css('background-image', 'url(' + to + ')');
		});
	});
	api('weaverx5_settings[_bg_widgets_primary_url]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area').css('background-image', 'url(' + to + ')');
		});
	});
	api('weaverx5_settings[_bg_widgets_secondary_url]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area').css('background-image', 'url(' + to + ')');
		});
	});
	api('weaverx5_settings[_bg_footer_url]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('background-image', 'url(' + to + ')');
		});
	});

	api('weaverx5_settings[_bg_body_rpt]', function (value) {
		value.bind(function (to) {
			$('body').css('background-repeat', to);
		});
	});
	api('weaverx5_settings[_bg_wrapper_rpt]', function (value) {
		value.bind(function (to) {
			$('#wrapper').css('background-repeat', to);
		});
	});
	api('weaverx5_settings[_bg_header_rpt]', function (value) {
		value.bind(function (to) {
			$('#header').css('background-repeat', to);
		});
	});
	api('weaverx5_settings[_bg_container_rpt]', function (value) {
		value.bind(function (to) {
			$('#container').css('background-repeat', to);
		});
	});
	api('weaverx5_settings[_bg_content_rpt]', function (value) {
		value.bind(function (to) {
			$('#content').css('background-repeat', to);
		});
	});
	api('weaverx5_settings[_bg_page_rpt]', function (value) {
		value.bind(function (to) {
			$('#content .page').css('background-repeat', to);
		});
	});
	api('weaverx5_settings[_bg_post_rpt]', function (value) {
		value.bind(function (to) {
			$('#content .type-post').css('background-repeat', to);
		});
	});
	api('weaverx5_settings[_bg_widgets_primary_rpt]', function (value) {
		value.bind(function (to) {
			$('#primary-widget-area').css('background-repeat', to);
		});
	});
	api('weaverx5_settings[_bg_widgets_secondary_rpt]', function (value) {
		value.bind(function (to) {
			$('#secondary-widget-area').css('background-repeat', to);
		});
	});
	api('weaverx5_settings[_bg_footer_rpt]', function (value) {
		value.bind(function (to) {
			$('#colophon').css('background-repeat', to);
		});
	});

	// Images

	api('weaverx5_settings[media_lib_border_color]', function (value) {
		value.bind(function (to) {
			$('.container img,.colophon img').css('background-color', weaverxFixTo(to));
		});
	});
	api('weaverx5_settings[media_lib_border_int]', function (value) { // and border width
		value.bind(function (to) {
			$('.container img,.colophon img').css('padding', to + 'px');
		});
	});
	api('weaverx5_settings[show_img_shadows]', function (value) { // and border width
		value.bind(function (to) {
			var image = $('.container img,.colophon img');
			if (to) {
				image.css('-webkit-box-shadow', '0 0 4px 2px rgba(0,0,0,0.25)');
				image.css('-moz-box-shadow', '0 0 4px 2px rgba(0,0,0,0.25)');
				image.css('box-shadow', '0 0 4px 2px rgba(0,0,0,0.25)');
			} else {
				image.css('-webkit-box-shadow', 'none');
				image.css('-moz-box-shadow', 'none');
				image.css('box-shadow', 'none');
			}
		});
	});
	api('weaverx5_settings[caption_color]', function (value) {
		value.bind(function (to) {
			$('.wp-caption p.wp-caption-text,#content .gallery .gallery-caption,.entry-attachment .entry-caption').css('color', weaverxFixTo(to));
		});
	});

	api('weaverx5_settings[post_avatar_int]', function (value) { // and border width
		value.bind(function (to) {
			$('.post-avatar img').each(function () {
				this.style.setProperty('max-width', to + 'px', 'important');
			});
			$('.post-avatar img').each(function () {
				this.style.setProperty('width', to + 'px', 'important');
			});
		});
	});

	// underline titles
	api('weaverx5_settings[widget_title_underline_int]', function (value) {
		value.bind(function (to) {
			$('.widget-title').css("border-bottom", to + 'px solid');
		});
	});
	api('weaverx5_settings[page_title_underline_int]', function (value) {
		value.bind(function (to) {
			$('.page-title').css("border-bottom", to + 'px solid');
		});
	});
	api('weaverx5_settings[post_title_underline_int]', function (value) {
		value.bind(function (to) {
			$('.wrapper .post-title').css("border-bottom", to + 'px solid');
		});
	});

	// area max widths
	api('weaverx5_settings[header_max_width_int]', function (value) {
		value.bind(function (to) {
			$('#header').css("max-width", to + 'px');
		});
	});
	api('weaverx5_settings[container_max_width_int]', function (value) {
		value.bind(function (to) {
			$('#container').css("max-width", to + 'px');
		});
	});
	api('weaverx5_settings[footer_max_width_int]', function (value) {
		value.bind(function (to) {
			$('#colophon').css("max-width", to + 'px');
		});
	});

	api('weaverx5_settings[header_image_max_width_dec]', function (value) {
		value.bind(function (to) {
			$('#branding #header-image img').css('max-width', to + '%');
		});
	});

	// base font settings
	api('weaverx5_settings[site_fontsize_int]', function (value) {
		value.bind(function (to) {
			var sizeEm = to * 0.0625; // convert px to em
			var sizeStr = sizeEm.toFixed(5);
			$('body').css('font-size', sizeStr + 'em');
		});
	});

	api('weaverx5_settings[site_line_height_dec]', function (value) {
		value.bind(function (to) {
			var sizeWidget = to * 0.85; // convert px to em
			//var sizeWStr = sizeWidget.toFixed(5);
			//var sizeBody = to.toFixed(5);
			$('body').css('line-height', to);
			$('.widget-area').css('line-height', sizeWidget);
		});
	});

	api('weaverx5_settings[font_letter_spacing_global_dec]', function (value) {
		value.bind(function (to) {
			$('body').css('letter-spacing', to + 'em');
		});
	});
	api('weaverx5_settings[font_word_spacing_global_dec]', function (value) {
		value.bind(function (to) {
			$('body').css('word-spacing', to + 'em');
		});
	});

	// list bullets
	api('weaverx5_settings[widgetlist_bullet]', function (value) {
		value.bind(function (to) {
			var bullet = to;
			if (to === '') bullet = 'disc';
			$('.widget ul').css('list-style-type', bullet);
		});
	});
	api('weaverx5_settings[contentlist_bullet]', function (value) {
		value.bind(function (to) {
			var bullet = to;
			if (to === '') bullet = 'disc';
			$('#content ul').css('list-style-type', bullet);
		});
	});

})(jQuery);

//Remove wait loading message

window.parent.jQuery('#wx-loading').css('display', 'none');
