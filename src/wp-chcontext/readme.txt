=== WP-CHContext ===
Contributors: mwerla
Donate link: 
Tags: cultural heritage,Europeana,digital libraries,FBC,related links
Requires at least: 3.4
Tested up to: 3.6
Stable tag: 1.1
License: EUPL v.1.1 (GPLv2 compatible)
License URI: https://joinup.ec.europa.eu/software/page/eupl/licence-eupl

Widget showing a list of links to free cultural heritage materials based on tags of currently displayed post or on predefined element of the website.

== Description ==

WP-CHContext is a WordPress plugin providing widget with the functionality based on [CHContext project](https://github.com/psnc-dl/chcontext). It is able to provide a list of links to cultural heritage materials based on tags of currently displayed post, or predefined item of the website (via given JQuery HTML selector).

The plugin supports three data sources:

* [Europeana](http://europeana.eu/) (with API key)
* [Digital Public Library of America](http://dp.la/) (with API key)
* [Polish Digital Libraries Federation](http://fbc.pionier.net.pl/) (without API key)

There is also possibility to define your own data provider(s) too. The widget look is customizable via CSS.

Check [our wiki](https://github.com/psnc-dl/wp-chcontext/wiki/CHContext-WordPress-Plugin-Description) for more information.

== Installation ==

To install the plugin manually please do the following steps:

1. Deactivate any previous version of WP-CHContext plugin through the 'Plugins' menu in your WordPress.
1. Delete any previous version of WP-CHContext in the /wp-content/plugins/ directory (save custom.css and custom.js files if you modified them).
1. Upload the entire wp-chcontext folder to the /wp-content/plugins/ directory (and add your custom.css and custom.js files if you modified them previously).

Then, after installation:

1. Activate the WP-CHContext plugin through the 'Plugins' menu in WordPress.
1. Insert an instance of CHContext widget using the Widgets option in the Appearence menu of your WordPress administrator panel.
1. Configure the plugin according to the [manual available here](https://github.com/psnc-dl/wp-chcontext/wiki/Installation-and-Configuration#configuration).


== Changelog ==

= 1.1 =
* Support for queries templates allowing to easily determine search scope.
* CHContext script is now included in the plugin instead of linking to remote file.

= 1.0 =
* First public release.