=== Easy VBOX7 ===
Contributors: Caspie
Donate link: http://donate.caspie.net/
Tags: vbox, vbox7, video, videos, clip, clips, insert, posts, pages, sidebar
Requires at least: 2.9
Tested up to: 2.9.2
Stable tag: 1.3

Quick and easy way to insert videos from VBOX7.com right into your WordPress blog posts, pages and sidebar.

== Description ==

Quick and easy way to insert videos from VBOX7.com right into your WordPress blog posts, pages and sidebar. VBOX7 is the biggest Bulgarian video portal so far. It already has a few million videos and lot of them have titles or tags in english. So even if you can't read Bulgarian, you can easily use the big search box at the top-right corner of the website (vbox7.com) to find your favorite videos and to embed them right into your posts.

Go to Other Notes for: Default, Recommended and Advanced Usage.
http://wordpress.org/extend/plugins/easy-vbox7/other_notes/

== Installation ==

1. Unzip the file easy-vbox7.zip wherever you want.
2. Upload the extracted folder easy-vbox7 in /wp-content/plugins/ of your Wordpress installation.
3. Activate the Plugin via the Plugins section at your WordPress admin panel.

== Frequently Asked Questions ==

= Casper? =

Yes, but keep in mind that my wordpress.org username is Caspie.

= I want to thank you or send you some feedback? =

Do it via my blog - http://blog.caspie.net/contact/ - enjoy!

= How many videos I can put in my post? =

A lot, but you need Easy VBOX7 1.1 or newer!

== Screenshots ==

1. Easy VBOX7 Usage
2. Easy VBOX7 Widget

== Changelog ==

= 1.3 =
* Added ability to add more than one video ID into the widget video field. Separate with comma: ID1, ID2, ID3 etc.
* Code validation.
* Minor code enhancements.

= 1.2 =
* Added new sidebar widget using the new Widgets API.
* Added new shortcodes using the Shortcode API.
* Minor code enhancements.
* README updates.

= 1.1 =
* Adding multiply videos now works as expected.
* README updates.

= 1.0 =
* Initial Release

== Default Usage ==

1. Visit vbox7.com and play some video.
2. Check out the video URL. It will look something like this - http://vbox7.com/play:89af3669
3. Copy the last URL part (play:89af3669) and insert it in your posts, surrounded with square brackets - [play:89af3669]

== Recommended Usage ==

* Since Easy VBOX7 1.2 you are able to use the new shortcodes
* Enclosing shortcode - example: [vbox7]89af3669[/vbox7]
* Self-closing shortcode - example: [vbox7 id="89af3669" width="450" height="403" autoplay="1"]
* The arguments are optional and 89af3669 is the video ID.

== Advanced Usage ==

* You can specify additional parameters (separated by ":") for custom width and height. The width and height must be integers between 10 and 999.
* The forth parameter with the constant value of 1 is the autoplay option. If you don't want it enabled, just skip it.
* The right syntax is: [play:video_id:width:height:1]
* The parameters width, height and autoplay are optional.
