=== Query from Content Shortcode ===
Contributors: bbuster79
Tags: WP_Query, query shortcode, shortcode, related posts, custom query, featured image, custom post types
Requires at least: 3.0
Tested up to: 3.4.2
License: GPLV2 or later
License URI: http://gnu.org/licenses/gpl-2.0.html

Better than a simple "Related Posts" plugin. Feature specific posts and categories inside your post-content using basic shortcode

== Description ==
Query from Content (QFC) is a simple shortcode plugin that allows you to target exactly the posts you're looking for and list them in your post content. Further, you can specify your own header, include your current CSS styles to format the list, specify the number of results, and even display thumbnails and excerpts.

The most basic format of QFC shortcode would look like:

[qfc]Here is a Basic List[/qfc]

The above shortcode would output a header reading "Here is a Basic List", below the header would be included your five latest posts, no formatting, no excerpt, no featured image. To customize your results, we can tell QFC to add some CSS as well as the posts' images and excerpts. That shortcode should be placed inside your post content like so:

[qfc class="some-example-class" id="some-example-id" image="yes" excerpt="yes"]Some Bells and Whistles![/qfc]

Also, you can choose to add more than one CSS class or id to your results by adding id's and classes using a comma seperated list:

[qfc class="some-example-class, another-class" id="some-example-id, another-id" ]We Like CSS![/qfc]

The Query from Content Shortcode can list more than just your most recent blog posts. You can specify tags, categories, post author, pages and even custom post types. 

Here's another quick example. This one specifies a tag, a category, and an author:

[qfc category_name="Italian-recipes" tag="lasagna" author_name="Luigi"]Luigi's Fantastico Lasanga Recipes![/qfc]

QFC reads the shortcode and passes the category, tag and author to the WP_Query class. If you are familiar with WP_Query, you'll recognize the QFC code matches exactly the parameters used with WP_Query. For more advanced users, QFC allows you dynamic access to all the most popular search features provided by WP_Query, just make sure the parameters you enter into the QFC shortcode match the exact spelling of WP_Query parameters.

For more infomation on advanced usage of the Query From Content Shortcode plugin, visit the Wordpress codex page for <a href="https://codex.wordpress.org/Class_Reference/WP_Query">WP_Query</a>.

== Installation == 
If you're downloading the Query From Content Shortcode plugin from you admin interface, all that is required is plugin activation. If you're downloading a zip file to your computer, just drop the contents into the wp-contents/plugins/ directory of your Wordpress installation and then active the plugin from your Plugins page.