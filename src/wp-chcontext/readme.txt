=== WP-CHContext ===
Contributors: mwerla
Donate link: 
Tags: cultural heritage, Europeana, digital libraries, FBC, DPLA, PCSS, PSNC, related, links, widget, sidebar
Requires at least: 3.4
Tested up to: 3.6
Stable tag: 1.1
License: EUPL v.1.1 (GPLv2 compatible)
License URI: https://joinup.ec.europa.eu/software/page/eupl/licence-eupl

Widget showing a list of links to free cultural heritage materials based on tags of currently displayed post or on predefined element of the website.

== Description ==

WP-CHContext is a WordPress plugin providing widget with the functionality based on [CHContext project](https://github.com/psnc-dl/chcontext). It is able to provide a list of links to cultural heritage materials based on tags of currently displayed post, or predefined item of the website (via given JQuery HTML selector).

The plugin supports three data sources:

<ul>
<li><a href="http://europeana.eu/">Europeana</a> (with API key)</li>
<li><a href="http://dp.la/">Digital Public Library of America</a> (with API key)</li>
<li><a href="http://fbc.pionier.net.pl/">Polish Digital Libraries Federation</a> (without API key)</li>
</ul>

There is also a possibility to define your own data provider. The widget look is customizable via CSS.

Check <a href="https://github.com/psnc-dl/wp-chcontext/wiki/CHContext-WordPress-Plugin-Description">our wiki</a> for more information.

== Installation ==

To install the plugin manually please do the following steps:

1. Deactivate any previous version of WP-CHContext plugin through the 'Plugins' menu in your WordPress.
2. Delete any previous version of WP-CHContext in the /wp-content/plugins/ directory (save custom.css and custom.js files if you modified them).
3. Upload the entire wp-chcontext folder to the /wp-content/plugins/ directory (and add your custom.css and custom.js files if you modified them previously).

Then, after installation:

1. Activate the WP-CHContext plugin through the 'Plugins' menu in WordPress.
2. Insert an instance of CHContext widget using the Widgets option in the Appearence menu of your WordPress administrator panel.
3. Configure the plugin according to the <a href="https://github.com/psnc-dl/wp-chcontext/wiki/Installation-and-Configuration#configuration">manual available here</a>.

== Screenshots ==

1. Widget configuration panel.
2. Widget embedded in example blog (top one in the right column).

== Changelog ==

= 1.1 - 2013/09/10  =
* Support for queries templates allowing to easily determine search scope.
* CHContext script is now included in the plugin instead of linking to remote file.

= 1.0 - 2013/08/28 =
* First public release.

== Upgrade Notice ==

Remember to backup any modifications you made to custom.css and custom.js files before updating!
