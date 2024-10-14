=== Weaver Xtreme Theme ===

Contributors: wpweaver
Author URI: http://weavertheme.com/about
Theme URI: http://weavertheme.com
Tags: custom-header, custom-colors, custom-background, custom-menu, theme-options, left-sidebar, right-sidebar, fixed-width, three-columns, two-columns, black, blue, brown, green, orange, red, tan, dark, white, light,translation-ready, rtl-language-support, editor-style
Copyright: Weaver Xtreme Theme - Copyright 2014-2024 Bruce E Wampler
Requires at least: 7.4
Tested up to: 6.6
Stable tag: 6.6

== Description ==

Weaver Xtreme is an advanced Theme platform that supports extensive customization by the user,
as well as full responsive design for mobile devices.

== Licenses ==

* License: GNU General Public License v3 or later
* License URI: //www.gnu.org/licenses/gpl-3.0.html
* Weaver Xtreme has been derived from the Weaver II Theme, licensed
under GPL V2. The source code for Weaver Xtreme is available at
http://wordpress.org/themes/weaver-xtreme
* Images: All images included with Weaver Xtreme are either original works of the author which
have been placed into the public domain, or have been derived from other public domain sources,
and thus need no license. (This does not include the images provided with any of the
below listed scripts and libraries. Those images are covered by their respective licenses.)
* Weaver Xtreme also includes several scripts and libraries that are covered under the terms
of their own licenses in the listed files in the Weaver Xtreme theme distribution:
** Yetii - Yet ( E )Another Tab Interface Implementation - license in /js/yetii/yetii.js ( BSD )
** Some Customizer code inspired by Make Theme - GNU General Public License v2 or later
** Save, Restore code inspired by Customizer Export / Import plugin, GPL V2 or later
** Accordion, jQuery Plugin - license in /js/accordion/LICENSE ( New BSD )
** jscolor, JavaScript Color Picker - license in /js/jscolor/jscolor.js ( GLGPL )
** html5 IE lib - license in /js/htm5.js ( MIT )
** FitVids - WTFPL
** javascript-detect-element-resize - MIT
** Genericons - GPL V2
** Alpha Color Picker - GPL V2
** Selected GPL compatible Google Fonts - mostly SIL Open Font (2022)
** theme scripts - original to this theme, covered by GPL

== Acknowledgements ==

Way back in 2010, the original version of Weaver was developed by Bruce Wampler. Over time,
the original "2010 Weaver" evolved into Weaver, then Weaver II, and now this version,
Weaver Xtreme. This latest version could not have been developed without the considerable
contributions of the Weaver Forum moderators, scrambler, Gillian, and Joerg. These
great people did extensive testing, provided feedback, and contributed both ideas and code.
My sincere thanks to them all, as well as many other Weaver users who also contributed
with testing and feature suggestions. Continued development of Weaver Xterme could not
happen without the great participation in the Weaver Xtreme Forum.
Weaver's PHP code formatted using IntelliJ Idea's PHP formatter.

== Changelog ==

= Version 1.00 =
* First release on WP.org repository

= Version 6.2 =
* Update to WP 6.2. Weaver Xtreme version numbering will now follow WP version, with subversions as necessary (e.g. 6.2.1)
* New: MAJOR CHANGE! The theme now self-hosts the open source Google fonts for GDPR and WP compliance
* NOTE: If you have installed a self-host Google fonts plugin such as OMGF, you can now uninstall it
* NOTE: Font files are not loaded by browsers until used, so this will generally speed up font loading
* Change: Theme CSS now included inline for front-end CSS settings as well as for Block Editor styling
* New: An option for more modern "Menu Only Header Design"
* New: Login on main menu bar option
* New: Three new sub-themes designed for modern fixed menu only at the top: Ahead, Ahead Dark, and Ahead Light
* Updated: All older subthemes have been updated. Most now are full-width design, and don't use previous extended width styling
* Updated: Theme screen shot and description for WP Theme picker
* Change: Theme Styling support for Classic Editor only supported when Weaver Theme Support plugin installed
* Tweaks: Styling on main menu bar items
* Tweak: Only loads admin files if user is logged in
* Fix: Some editor (both classic and block) styling to match theme settings more closely
* Fix: Changed CSS rules for spacing after block images and cover images
* Fix: Z index problem with Primary and Secondary fixed-top menus
* Fix: Corrected display of lists in block editor to include left margins
* Fix: numerous code style updates
* Fix: problem if no Featured Image set when attempting to use Parallax BG for posts
* Fix: some PHP 8 code incompatibility in Audio post template
* Fix: descriptions that have been missing from Customizer HTML Injection areas are now there
* Fix: added additional validation to translatable strings - mostly in Customizer interface
* Fix: added validation for Author name and description
* Removed: Obsolete "Core Site Layout and Styling" section from "What" interface

= Version 6.2.0.1 =
* Fix: added check for invalid user input for widget area column widths
* Fix: styling issues in Dashboard Weaver Xtreme Admin page

= Version 6.2.0.2 =
* Fix: Unused .wxt file in subthemes list.
* Fix: Problem with post hide date display option
* Fix: Infinite-Scroll PHP 7 issue

= Version 6.2.1 =
* New: Add outline font option for titles
* New: Huge font size choice
* New: For Weaver Xtreme Plus 6.2 - Integrated font family selectors in Customizer
* New: For Weaver Xtreme Plus 6.2 - Grid Sub-menus for Primary and Secondary
* Revised: Some revised information in Customizer for font usage
* Revised: Demo child theme
* Fix: Some PHP 8.2+ incompatibilities

= Version 6.2.1.1 =
* Fix: undefined function in What Customizer interface
* Fix: Problem when some Custom CSS rules were defined - displayed CSS on page view
* Fix: All Custom CSS fields now refresh Customizer view instead of auto-update due to switch to all inline CSS.

= Version 6.2.1.2 =
* Tweaks: minor code tweaks
* Fix: problem with CSS minifier

= Version 6.2.1.3 =
* Fix: CSS cache update not recognized by Legacy interface.

= Version 6.2.1.4 =
* Fix: Issue when host PHP memory limit set to none (-1). Fix issue with Customizer memory limit message.

= Version 6.2.1.5 =
* Fix: Problem with including non-Plus Google Fonts on Multi-site.

= Version 6.2.1.6 =
* Fix: Add new option "Disable Generated CSS Caching" in Admin > Admin Options for rare MySQL / Javascript bug
* Fix: Adjusted z-index for header/menu search button

= Version 6.2.1.7 =
* Tweak: Version label in option settings displays
* Fix: Multi-Site read file access issue

= Version 6.3.0 =
* WP Version 6.3 Compatible

= Version 6.3.1
* Update: change "Weaver Xtreme 4" title to "Weaver Xtreme" on per page/post options title.

= Version 6.4 =
* WP Version 6.4 version Compatible
* Fix: z-index for .custom-logo-on-menu, .wvrx-menu-left/right.
* Fix: support for the essentially unused RAW page and per page/post support 'page-head-code' custom field removed.
       Note: if you have used this feature, your header layout might be changed on individual pages.
       There is no available work around.

= Version 6.4.1 =
* Fix: PHP version incompatibility - type problem with newest versions of PHP

= Version 6.5.1 =
* WP Version 6.5 compatible
* Update: WordPress had failed theme library update
* Update: removed widget shortcode from recommended plugins

= Version 6.6 =
* WP Version 6.6 compatible
* Update: wp database autoload options for API default
* Update: WP-CLI PHP type problem
