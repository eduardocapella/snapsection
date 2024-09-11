=== SnapSection ===
Contributors: eduardocapella
Donate link: https://snapsection.com/donate
Tags: section, blog, share section, share page URL, share post URL
Requires at least: 5.8
Tested up to: 6.6.1
Stable tag: 1.1.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

SnapSection allows users to swiftly share specific sections from your article or blog post.

## Description
SnapSection allows users to share specific sections from your article or blog post swiftly.

It appends the `id` attribute of the SnapSection element (the default one is `h2`, but you can also select `h1`, `h3`, `h4`, or `.cwss-element`) to your page's URL. Consequently, any user who clicks the link will be directed to this specific section of your page or post.

## How does it work?
SnapSection scans every `h3` (third-level heading) element across your website's pages and posts, checking for an `id`. If it doesn't find one, it generates an `id` based on the `h3` text.

Once an `id` is assigned, users can share the link to a specific `h3` by hovering over it and clicking the displayed icon. Users who access the shared URL will be directed to the corresponding section of your post or article.


=== Frequently Asked Questions ===
## Frequently Asked Questions

= How do I use this plugin? =
You just have to activate the plugin and SnapSection will automatically do the job!

= How to uninstall the plugin? =
After deactivating SnapSection, you can uninstall it on your site's plugin list.

= Where can I find the SnapSection settings? =
On your Dashboard > Settings > SnapSection

= Can I see it in action? =
Yes, you can access the [See it in action](https://snapsection.com/see-it-in-action/) page on [the SnapSection website](https://snapsection.com/) to see how it works.


== Changelog ==
## Changelog
= 1.1.0 =

#**What's New?**#
– You can now select which element will receive the SnapSection icon (`h1`, `h2`, `h3`, `h4`, `.cwss-element`). The default is `h2`.
– You can also choose the content types where SnapSection will be active: Posts, Pages, Archives, Front-page, and CPTs. By default, SnapSection is not loaded on Admin or Search Pages.
– The Message Ballon class is now `.cwss-message-balloon`.

#**Fixes:**#
– The icon size is now calculated based on its parent element's font size.
– The background color is set to transparent, and other CSS properties are adjusted to avoid conflicts with theme styling.


= 1.0.0 =
* Plugin released.


== Upgrade Notice ==
## Upgrade Notice


== Screenshots ==
## Screenshots
1. When clicking the SnapSection icon, a confirmation message is displayed.
2. In the Settings Page, you can select the icon the icon, its color, and make a fine adjustment on the icon size. 