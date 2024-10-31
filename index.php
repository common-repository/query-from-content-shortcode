<?php
/*
 * Plugin Name: query from content
 * Description: List custom search results for posts, pages and custom post types inside your post content via shortcode and WP_Query.
 * Verson: 1.0
 * Author: Brandon Buster
 * License: GPLv2 or later
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

For a copy of the GNU General Public License write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

add_shortcode('qfc', 'query_from_content_sc');
function query_from_content_sc($atts, $header = '') {
		
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post_thumbnail' );
	        add_image_size( 'content_query', 150, 150 );
	}
	
	//omitt any user specified post as well as current post
	$atts['exclude']  .= ',' . get_the_id();
	//remove commas from CSS class attribute
	
	global $wpdb;
	wp_reset_query();
	$result = '';

	#this is the array we will insert into our query method, likely using array_merge to override defaults with user defined vals while retaining untouched defaults
	/*
	 * Entire list of WP_Query parameters are available to use
	 * Pagination parameters have been omitted as they are unlikely of use
	 */
	$allowed_query_atts = array(
		'p'						=> '',
		'name'					=> '',
		'page_id'				=> '',
		'page_name'				=> '',
		'post_parent'			=> '',
		'post__in'				=> '',
		'post__not_in'			=> '',
	    'numberposts'     		=> 5,
	    'offset'          		=> 0,
		'cat'			  		=> '',
	    'category_name'   		=> '',
		'category__and'	  		=> '',
		'category__in'	  		=> '',
		'category__not_in'		=> '',
		'tag'					=> '',
		'tag_id'				=> '',
		'tag__and'				=> '',
		'tag__in'				=> '',
		'tag__not_in'			=> '',
		'tag_slug__and'			=> '',
		'tag_slug__in'			=> '',
		'tax_query'				=> '',
		'taxonomy'				=> '',
		'field'					=> '',
		'terms'					=> '',
		'include_children'		=> '',
		'operator'				=> '',
	    'orderby'         		=> 'post_date',
	    'order'           		=> 'DESC',
	    'include'         		=> '',
	    'exclude'         		=> '',
	    'meta_key'        		=> '',
	    'meta_value'      		=> '',
		'meta_value_num'		=> '',
		'meta_compare'			=> '',
		'meta_query'			=> '',
	    'post_type'       		=> 'post',
	    'post_mime_type'  		=> '',
	    'post_parent'     		=> '',
	    'post_status'     		=> 'publish', 
		'author'	  	  		=> '',
		'author_name'	  		=> '',
		'offset'				=> '',
		'ignore_sticky_posts'	=> '',
		'year' 					=> '',
		'monthnum'				=> '',
		'w'						=> '',
		'day'					=> '',
		'hour'					=> '',
		'posts_distinct'		=> '',
		'posts_groupby'			=> '',
		'posts_join'			=> '',
		'post_limits'			=> '',
		'posts_orderby'			=> '',
		'posts_where'			=> '',
		'posts_join_paged'		=> '',
		'posts_where_paged'		=> '',
		'posts_clauses'			=> ''						
	);
	
	#filter user entered atts and set defaults if needed
	#relieves the needs to use merge_array and empty() checks to remove atts not requested by user or set by defaults
	
	//$options = shortcode_atts($allowed_query_atts, $atts);
	$options = wp_parse_args($atts, $allowed_query_atts); #does exact same thing as shortcode_atts()

	$shortcode_posts = get_posts($options);
	
	//if no posts show, nothing. if user can edit posts, show notice.
	if(!$shortcode_posts) {
		if(current_user_can('edit_others_posts')) {
			return '<div style="padding: 5px; border: 1px solid yellow; background: yellow; border-radius: 4px;">You have no post results related to the criteria you gave the Query from Content Shortcode.<br /> <span style="color:red;">Note: You are only seeing this notice if you have editorial permissions.</span></div>';
		} else {
			return '';
		}
	}
	
	//apply user defined CSS class
	if(!empty($atts['class'])) {
		//remove commas if user has added them
		$atts['class'] = str_replace(',', ' ', $atts['class']);
		$class = 'class="' . $atts['class'] . ' content-query-shortcode"';
	} else {
		$class = 'content-query-shortcode';
	}
	
	if(!empty($atts['id'])) {
		//remove commas if user has added them
		$atts['id'] = str_replace(',', ' ', $atts['id']);
		$id = 'id="' . $atts['id'] . '"';
	} else {
		$id = '';
	}

	/*
	 * Begin formatting the search results
	 */
	$result .= "<ul $id $class style=\"list-style: none; \" >";
	$result .= "<h2>$header</h2>"; 
	foreach($shortcode_posts as $shortcode_post) {
		
		//are we outputting a featured image?
		if(has_post_thumbnail($shortcode_post->ID) && ($atts['thumb'] == true || $atts['thumb'] == 'yes')) {
			$thumb = '<span style="float: left; margin-right: 5px;">' . get_the_post_thumbnail($shortcode_post->ID, 'content_query' ) . '</span>';
		} else {
			$thumb = '';
		}
		
		//are we outputting an excerpt?
		if($atts['excerpt'] == true ) {
			$excerpt = '<p>' . get_the_excerpt($shortcode_post->ID) . '</p>';
		} else {
			$excerpt = '';
		}
		
		//display content
		$result .= '<li style="clear: both">' . $thumb . '<strong><a href="' . get_permalink($shortcode_post->ID) . '">' . $shortcode_post->post_title . '</a></strong>' . $excerpt . '</li>';
	}
	
	//reset query in case any other plugins need it
	wp_reset_query();

	return $result . '</ul>';
}
