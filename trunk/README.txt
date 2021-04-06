=== DynamicTags ===
Contributors: rtowebsites
Donate link: https://www.rto.de/
Tags: elementor, dynamic tags
Requires at least: 5.0
Tested up to: 5.7
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds some useful dynamic-tags for elementor

== Description ==

Dynamic Tags is an Elementor addon that adds some useful dynamic tags.

The plugin requires Elementor Pro since it uses Dynamic Tags to set the comparison conditions.

It provides the following tags:

= Text-Tags =
- Cookies (you can select between all setted cookies)
- Session (you can select between all setted session keys)
- Current-Language (returns current language from WPML or Polylang)
- Current-Url (returns the actually called url)
- NumberPostsQuery (return number of posts with a custom query)
- PodsExtended (supports yes/no fields of pods)
- Server Vars (returns content of $_SERVER PHP-Variable)
- User/Author Image (returns the user/author image-url or false if not found)
- User Role (returns a comma-separated list of current user roles)
- WidgetContent (returns content of a widget selected by widget-id)

= Post Tags =
- Post Content
- Post Parent
- Post Status
- Post Type

= Yes/no tags =
- Are Comments allowed
- Current User Can (can check, for example if user can edit_posts)
- Is author of post
- Is feed
- Is Frontpage
- Is Home
- Is Post in category
- Is Post in list
- Is Singular

== Screenshots ==


== Changelog ==
= 1.2 =
* Add session

= 1.1 =
* Fix issues
* Add option to render post-content without wp-filters

= 1.0 =
* Release

`<?php code(); // goes in backticks ?>`