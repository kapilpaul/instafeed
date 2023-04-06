# Instagram API Feed
Contributors: Kapil Paul

Donate link: https://kapilpaul.me

Tags: instagram, feed, insta-feed

Requires at least: 5.0

Tested up to: 5.9.2

Stable tag: trunk

Requires PHP: 5.6

License: GPLv2 or later

License URI: https://www.gnu.org/licenses/gpl-2.0.html

## Description
This plugin will display an Instagram feed using the Instagram API.

## Installation

WordPress comes with the upload method to install plugins which is not available in WordPress.org.

If you have the zip file of this plugin (inside zip folder you will get a plugin zip file), you need to go to WordPress admin area and visit Plugins » Add New page.

After that, click on the ‘Upload Plugin’ button on top of the page.

This will reveal the plugin upload form. Here you need to click on the ‘Choose File’ button and select the plugin file you have in your computer.

After you have selected the file, you need to click on the ‘Install Now’ button.

WordPress will now upload the plugin file from your computer and install it for you. You will see a success message after the installation is finished.

Once installed, you need to click on the Activate Plugin link to start using the plugin.

## Supported Actions

<pre>
# File location: ./includes/functions.php:93:
do_action( 'iaf_before_template_part', $template_name, $template_path, $located, $args );

-------------------------------------------------------------------------------------------

# File location: ./includes/functions.php:97:
do_action( 'iaf_after_template_part', $template_name, $template_path, $located, $args );

-------------------------------------------------------------------------------------------

# File location: ./includes/Frontend/Shortcode.php:71:
do_action( 'iaf_after_render_shortcode', $feeds_html, $attrs, $feeds );

-------------------------------------------------------------------------------------------

# File location: ./includes/Frontend/Shortcode.php:85:
do_action( 'iaf_after_render_shortcode', $feeds_html, $attrs, $feeds );
</pre>

## Supported Filters

<pre>
# File location: ./includes/functions.php:47:
apply_filters( 'iaf_set_template_path', $template_path, $template, $args );

-------------------------------------------------------------------------------

# File location: ./includes/functions.php:59:
apply_filters( 'iaf_get_template_part', $template, $slug, $name );

-------------------------------------------------------------------------------

# File location: ./includes/functions.php:139:
apply_filters( 'iaf_locate_template', $template, $template_name, $template_path );

-------------------------------------------------------------------------------

# File location: ./includes/functions.php:165:
apply_filters( 'iaf_get_settings', $settings );

-------------------------------------------------------------------------------

# File location: ./includes/functions.php:183:
apply_filters( 'iaf_is_widget_enabled', $widget_enabled );

-------------------------------------------------------------------------------

# File location: ./includes/functions.php:201:
apply_filters( 'iaf_get_instagram_access_token', $instagram_access_token );

-------------------------------------------------------------------------------

# File location: ./includes/functions.php:218:
apply_filters( 'iaf_get_instagram_username', $instagram_username );

-------------------------------------------------------------------------------

# File location: ./includes/Frontend/Shortcode.php:58:
apply_filters( 'iaf_shortcode_attrs', $attrs );

-------------------------------------------------------------------------------

# File location: ./includes/Frontend/Shortcode.php:87:
apply_filters( 'iaf_render_shortcode_html', $feeds_html );

-------------------------------------------------------------------------------

# File location: ./includes/Admin/Menu.php:81:
apply_filters( 'iaf_admin_localize_script', $localize_data );

-------------------------------------------------------------------------------

# File location: ./includes/Widgets/InstagramFeedWidget.php:116:
apply_filters( 'widget_title', $title );

-------------------------------------------------------------------------------

# File location: ./includes/Widgets/InstagramFeedWidget.php:151:
apply_filters( 'iaf_widget_title', $title );

-------------------------------------------------------------------------------

# File location: ./includes/Widgets/InstagramFeedWidget.php:153:
# File location: ./includes/Widgets/InstagramFeedWidget.php:180:
apply_filters( 'iaf_widget_fields', $widget_fields );

</pre>

## Changelog

= 1.0.0 =

-   Initial release
