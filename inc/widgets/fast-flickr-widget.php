<?php
/*
Plugin Name: Fast Flickr Widget
Plugin URI: http://www.matbra.com/code/fast-flickr-widget/
Description: Display up to 20 of your latest Flickr submissions in your sidebar.
Author: Matheus Bratfisch
Version: 1.4.1
Author URI: http://www.matbra.com

/*  Copyright 2012  Matheus Bratfisch  (matheusbrat@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class FastFlickrWidget extends WP_Widget {

	private $flickr_api_key = "34f640e021222748a726874d873d0c3b";
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'fastFlickrWidget', // Base ID
			'Shopera - Fast Flickr Widget', // Name
			array( 'description' => __( 'Flickr Images', 'shopera' ), ) // Args
		);
		wp_enqueue_script('thickbox', null,  array('jquery'));
		wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');
	}

	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$this->generateFrontEnd($args, $instance);
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']         = strip_tags( $new_instance['title'] );
		$instance['username']      = strip_tags($new_instance['username']);
		$instance['view']          = strip_tags($new_instance['view']);
		$instance['before_item']   = $new_instance['before_item'];
		$instance['after_item']    = $new_instance['after_item'];
		$instance['before_widget'] = $new_instance['before_widget'];
		$instance['after_widget']  = $new_instance['after_widget'];
		$instance['items']         = intval($new_instance['items']);
		$instance['more_title']    = strip_tags($new_instance['more_title']);
		$instance['tags']          = strip_tags($new_instance['tags']);
		$instance['target']        = strip_tags($new_instance['target']);
		$instance['show_titles']   = strip_tags($new_instance['show_titles']);
		$instance['thickbox']      = strip_tags($new_instance['thickbox']);
		$instance['random']        = strip_tags($new_instance['random']);
		$instance['random_tag']    = strip_tags($new_instance['random_tag']);
		$instance['javascript']    = strip_tags($new_instance['javascript']);

		if (!empty($instance["username"]) && $instance["username"] != $old_instance["username"]) {
			if (strpos($instance["username"], "http://api.flickr.com/services/feeds") === false) {
				$url_gett = wp_remote_get("https://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key=".$this->flickr_api_key."&username=".urlencode($instance["username"])."&format=php_serial");
				$str = wp_remote_retrieve_body($url_gett);
				$flickr_response = unserialize($str);

				if ( isset($flickr_response['user']['id']) ) {
					$instance["user_id"] = $flickr_response['user']['id'];
				} else {
					$instance["user_id"] = '';
				}
			} else {
				$newoptions["error"] = "";
			}
		} else { 
			$instance["user_id"] = $old_instance["user_id"];
		}
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
			$title 			 	  = $instance[ 'title' ];
			$username 	 	 	  = $instance[ 'username' ];
			$view 			 	  = $instance[ 'view' ];
			$before_item 	 	  = $instance[ 'before_item' ];
			$after_item 	 	  = $instance[ 'after_item' ];
			$before_flickr_widget = $instance[ 'before_widget' ];
			$after_flickr_widget  = $instance[ 'after_widget' ];
			$items				  = $instance[ 'items' ];
			$more_title 		  = $instance[ 'more_title' ];
			$tags 				  = $instance[ 'tags' ];
			$target 			  = $instance[ 'target' ];
			$show_titles 		  = $instance[ 'show_titles' ];
			$thickbox 			  = $instance[ 'thickbox' ];
			$random 			  = $instance[ 'random' ];
			$randomTag 			  = $instance[ 'random_tag' ];
			$javascript 		  = $instance[ 'javascript' ];
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e("Fast Flickr Title:", 'shopera'); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr($title) ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php _e("Flickr RSS URL or Screen name:", 'shopera'); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr($username); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'view' ) ); ?>"><?php _e("Thumbnail, square or medium?", 'shopera'); ?>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'view' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'view' ) ); ?>">
			<option value="_t" <?php echo ($view=="_t" ? "selected=\"selected\"" : "");?>>Thumbnail</option>
			<option value="_s" <?php echo ($view=="_s" ? "selected=\"selected\"" : "");?>>Square</option>
			<option value="_m" <?php echo ($view=="_m" ? "selected=\"selected\"" : "");?>>Small</option>
			<option value="" <?php echo ($view=="" ? "selected=\"selected\"" : "");?>>Medium</option>
		</select>
		</label></p>
	
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'before_item' ) ); ?>"><?php _e("Before item:", 'shopera'); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'before_item' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'before_item' ) ); ?>" type="text" value="<?php echo esc_attr($before_item); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'after_item' ) ); ?>"><?php _e("After item:", 'shopera'); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'after_item' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'after_item' ) ); ?>" type="text" value="<?php echo esc_attr($after_item); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'before_widget' ) ); ?>"><?php _e("Before widget:", 'shopera'); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'before_widget' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'before_widget' ) ); ?>" type="text" value="<?php echo esc_attr($before_flickr_widget); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'after_widget' ) ); ?>"><?php _e("After widget:", 'shopera'); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'after_widget' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'after_widget' ) ); ?>" type="text" value="<?php echo esc_attr($after_flickr_widget); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'items' ) ); ?>"><?php _e("How many items?", 'shopera'); ?> <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'items' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'items' ) ); ?>"><?php for ( $i = 1; $i <= 20; ++$i ) echo "<option value=\"$i\" ".($items==$i ? "selected=\"selected\"" : "").">$i</option>"; ?></select></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'more_title' ) ); ?>"><?php _e("More link anchor text:", 'shopera'); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'more_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_title' ) ); ?>" type="text" value="<?php echo esc_attr($more_title); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>"><?php _e("Filter by tags (comma seperated):", 'shopera'); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tags' ) ); ?>" type="text" value="<?php echo esc_attr($tags); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><input id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" type="checkbox" value="checked" <?php echo $target; ?> /> <?php _e("Target: _blank", 'shopera'); ?></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'show_titles' ) ); ?>"><input id="<?php echo esc_attr( $this->get_field_id( 'show_titles' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_titles' ) ); ?>" type="checkbox" value="checked" <?php echo $show_titles; ?> /> <?php _e("Display titles", 'shopera'); ?></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'thickbox' ) ); ?>"><input id="<?php echo esc_attr( $this->get_field_id( 'thickbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thickbox' ) ); ?>" type="checkbox" value="checked" <?php echo $thickbox; ?> /> <?php _e("Use Thickbox", 'shopera'); ?></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>"><input id="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'random' ) ); ?>" type="checkbox" value="checked" <?php echo $random; ?> /> <?php _e("Random pick", 'shopera'); ?></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'random_tag' ) ); ?>"><input id="<?php echo esc_attr( $this->get_field_id( 'random_tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'random_tag' ) ); ?>" type="checkbox" value="checked" <?php echo $randomTag; ?> /> <?php _e("Use random tag (needs random pick enable)", 'shopera'); ?></label></p>
		<?php 
	}
	private function retrieve_random_tag($flickrid, $maxcount=20) { 
        
		$params = array(
			'api_key' => $this->flickr_api_key,
			'method'  => 'flickr.tags.getListUserPopular',
			'count'   => $maxcount,
			'user_id' => $flickrid,
			'format'  => 'php_serial',
		);

		$encoded_params = array();

		// Loop through parameters and encode
		foreach ($params as $k => $v){

			// Encode parameters for the url of the API call
			$encoded_params[] = urlencode($k).'='.urlencode($v);

		}

		// Call the API and decode the response

		$url = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);		

		// Fetch the info

		$url_gettt = wp_remote_get($url);
		$rsp = wp_remote_retrieve_body($url_gettt);

		$rsp_obj = unserialize($rsp);

		$tags = array();
		if (isset($rsp_obj['who']['tags']['tag'])) {
			$tags = $rsp_obj['who']['tags']['tag'];
		}
		shuffle($tags);
		$tagNumber = rand(0,count($tags));
        return $tags[$tagNumber]['_content'];
	}
	
	private function generateFrontEnd($args, $instance) {
			extract($args);
				
			$title 			 	  = $instance[ 'title' ];
			$username 	 		  = $instance[ 'username' ];
			$view 			 	  = $instance[ 'view' ];
			$before_item 	 	  = $instance[ 'before_item' ];
			$after_item 	 	  = $instance[ 'after_item' ];
			$before_flickr_widget = $instance[ 'before_widget' ];
			$after_flickr_widget  = $instance[ 'after_widget' ];
			$items				  = $instance[ 'items' ];
			$more_title 		  = $instance[ 'more_title' ];
			$tags 				  = $instance[ 'tags' ];
			$target 			  = $instance[ 'target' ];
			$show_titles 		  = $instance[ 'show_titles' ];
			$thickbox 			  = $instance[ 'thickbox' ];
			$random 			  = $instance[ 'random' ];
			$randomTag 			  = $instance[ 'random_tag' ];
			$javascript 		  = $instance[ 'javascript' ];
			$user_id			  = $instance[ 'user_id' ];
			$randomTagText		  = '';
			$out 				  = '';
				
			$target      = ($target == "checked") ? "target=\"_blank\"" : "";
			$show_titles = ($show_titles == "checked") ? true : false;
			$thickbox    = ($thickbox == "checked") ? true : false;
			$tags        = (strlen($tags) > 0) ? "&tags=" . urlencode($tags) : "";
			$random      = ($random == "checked") ? true : false;
			$randomTag   = ($randomTag == "checked") ? true : false; 

			if($random == true && $randomTag == true) {
				$randomTagText = $this->retrieve_random_tag($user_id);
				$tags = "&tags=" . urlencode($randomTagText) . "&tagmode=any";
			}
			$javascript = ($javascript == "checked") ? true : false;
					
			if ($javascript) $flickrformat = "json"; else $flickrformat = "php_serial";
					
			if (empty($items) || $items < 1 || $items > 20) $items = 3;
			// Screen name or RSS in $username?
			if (!empty($username) && strpos("http://api.flickr.com/services/feeds", $username) === false)
				$url = "https://api.flickr.com/services/feeds/photos_public.gne?id=".urlencode($user_id)."&format=".$flickrformat."&lang=en-us".$tags;
			else
				$url = $username."&format=".$flickrformat.$tags;
					
			// Output via php or javascript?
			if (!$javascript) {
				$url_get = wp_remote_get($url);
				$url_body = wp_remote_retrieve_body($url_get);
				$photos = unserialize($url_body);
				if (!empty($photos["items"]) && $random) shuffle($photos["items"]);

				if ($photos) {
					$flickr_home = $photos["url"];
					foreach($photos["items"] as $key => $value) {
						if (--$items < 0) break;
						
						$photo_title = $value["title"];
						$photo_link  = $value["url"];
						preg_match("/<img[^>]* src=\"([^\"]*)\"[^>]*>/", $value["description"], $regs);
						$photo_url         = $regs[1];
						$photo_description = str_replace("\n", "", strip_tags($value["description"]));
						
						//$photo_url      = $value["media"]["m"];
						$photo_medium_url = str_replace("_m.jpg", ".jpg", $photo_url);
						$photo_url        = str_replace("_m.jpg", "$view.jpg", $photo_url);
						
						$thickbox_attrib = ($thickbox) ? "class=\"thickbox\" rel=\"flickr-gallery\" title=\"$photo_title: $photo_description &raquo;\"" : "";
						$href            = ($thickbox) ? $photo_medium_url : $photo_link;
						
						$photo_title = ($show_titles) ? "<div class=\"qflickr-title\">$photo_title</div>" : "";
						$out .= $before_item . "<a $thickbox_attrib $target href=\"$href\"><img vspace=\"2\" hspace=\"5\" class=\"flickr_photo\" alt=\"$photo_description\" title=\"$photo_description\" src=\"$photo_url\" width=\"75\" height=\"75\" /></a>$photo_title" . $after_item;
					}
					if($randomTagText != "") { 
						$out .= "<br /> Used tag: " . $randomTagText . "<br />";
					}
				} else	{
					$out = "Something went wrong with the Flickr feed! Please check your configuration and make sure that the Flickr username or RSS feed exists";
				}			
			} else {
				$out = "<script type=\"text/javascript\" src=\"$url\"></script>";
			}
			?>
			
				<?php echo $before_widget.$before_flickr_widget; ?>
					<?php if(!empty($title)) { $title = apply_filters('widget_title', $title); echo $before_title . $title . $after_title; } ?>
					<?php echo $out ?>
					<?php if (!empty($more_title) && !$javascript) echo "<a href=\"" . strip_tags($flickr_home) . "\">$more_title</a>"; ?>
				<?php echo $after_flickr_widget.$after_widget; ?>
			
			<?php
	}

} // class Foo_Widget
add_action( 'widgets_init', create_function( '', 'register_widget( "FastFlickrWidget" );' ) );
