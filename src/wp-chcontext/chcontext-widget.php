<?php
/**
 * Plugin Name: WP-CHContext (Widget)
 * Plugin URI: http://wordpress.org/plugins/wp-chcontext/
 * Description: Widget showing a list of links to free cultural heritage materials based on tags of currently displayed post or on predefined element of the website.
 * Version: 1.1
 * Author: Marcin Werla, PSNC Digital Libraries Team
 * Author URI: http://dl.psnc.pl/
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * Licence: https://raw.github.com/psnc-dl/wp-chcontext/master/LICENCE.txt
 */

define("CUSTOM", "Custom");

 
/**
 * Add function to widgets_init that loads the widget.
 * @since 1.0
 */
add_action( 'widgets_init', 'chcontext_load_widgets' );
add_action('init', 'chcontext_init');	

/**
 * Register the widget.
 * 'CHContext_Widget' is the widget class used below.
 *
 * @since 1.0
 */
function chcontext_load_widgets() {
	register_widget( 'CHContext_Widget' );
}

/**
 * Init the widget.
 * 'CHContext_Widget' is the widget class used below.
 *
 * @since 1.0
 */
function chcontext_init() {

 // Register and enqueue JS 
  wp_register_script('chcontext-main', plugins_url('chcontext.min-1.1.0.js', __FILE__ ));
  wp_enqueue_script('chcontext-main');

  wp_register_script('chcontext-custom-js', plugins_url('custom.js', __FILE__ ));
  wp_enqueue_script('chcontext-custom-js');

  
  // Register and enqueue the stylesheet
  wp_register_style('chcontext_custom_css', plugins_url('custom.css', __FILE__ ));
  wp_enqueue_style('chcontext_custom_css');
}



/**
 * Main Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 * @since 1.0
 */
class CHContext_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function CHContext_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'chcontext', 'description' => __('CHContext widget that displays links to cultural heritage items from various sources, related to the post tags.', 'chcontext') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'chcontext-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'chcontext-widget', __('CHContext Widget', 'chcontext'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$selector = $instance['query_selector'];
		$template = $instance['query_template'];
		$result_count = $instance['result_count'];
		$APIKey = $instance['API_key'];
		$provider = $instance['provider'];
		$customProvider = $instance['custom_function_name'];
		$showThumbs = isset( $instance['show_thumbs'] ) ? $instance['show_thumbs'] : false;
		$showThumbsStr = ($showThumbs) ? 'true' : 'false';

		$query = "";
		if(isset($selector) && (strlen($selector) >0) ) {
			//we have selector, that's good.
		} else {
			//no selector - we need to get query from tags
			global $post;	
			$t = wp_get_post_tags($post->ID);
			if ($t) {
				foreach($t as $tag) {
					if(strlen($query) > 0)
						$query = $query.' OR ';
					$query = $query.'('.$tag->name.')'; 
				}
			}
			if(strlen($query) == 0) return;
		}

		
		/* Before widget (defined by themes). */
		echo "\n".$before_widget."\n";
	?>
		<div id="<?php echo $id ?>" 
			class="chcontext-widget-wrapper" 
		<?php if(CUSTOM==$provider) { ?>
			data-customSearchProvider="<?php echo $customProvider ?>" 
		<?php } else { ?>
			data-searchProvider="<?php echo $provider ?>" 
		<?php } ?>
			data-resultCount="<?php echo $result_count ?>" 
			data-show-img="<?php echo $showThumbsStr ?>" 
		<?php 
		if(isset($APIKey) && (strlen($APIKey) >0) ) { 
			echo ' data-apikey="'.$APIKey.'"';
		}
		
		if(isset($selector) && (strlen($selector) >0) ) {
			//If there is selector pass it to the chcontext
			echo ' data-queryselector="'.$selector.'"';
			//If there is also template  pass it too - chcontext.js will do the merge 
			if(isset($template) && (strlen($template) >0) ) {
				echo ' data-query="'.$template.'"';
			}
		} else {
			//If there was no selector, but there is a template, do the merge of template and tags manually
			if(isset($template) && (strlen($template) >0) ) {
				$query = str_replace('$$', $query, $template);						
			}
			//and pass the final query to the chcontext
			echo ' data-query="'.$query.'"';
		}			
		?>
			>
	<?php
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title."\n";
	?>

		</div>
		<?php
		/* After widget (defined by themes). */
		echo "\n".$after_widget."\n";
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['query_selector'] = strip_tags( $new_instance['query_selector'] );
		$instance['query_template'] = strip_tags( $new_instance['query_template'] );
		$instance['result_count'] = strip_tags( $new_instance['result_count'] );
		$instance['show_thumbs'] = isset( $new_instance['show_thumbs'] );

		$instance['provider'] = strip_tags( $new_instance['provider'] );

		$instance['API_key'] = strip_tags( $new_instance['API_key'] );

		$instance['custom_function_name'] = strip_tags( $new_instance['custom_function_name'] );
		
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Related heritage', 'chcontext'), 'query_selector' => '', 'query_template' => '', 'custom_function_name' => '', 'result_count' => 5, 'API_key' => '', 'provider' => 'FBC+', 'show_thumbs' => true);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
		

		<!-- Widget Title: Text Input -->		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Result count: Listbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'result_count' ); ?>"><?php _e('Number of results:', 'chcontext'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'result_count' ); ?>" name="<?php echo $this->get_field_name( 'result_count' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( '1' == $instance['result_count'] ) echo 'selected="selected"'; ?>>1</option>
				<option <?php if ( '2' == $instance['result_count'] ) echo 'selected="selected"'; ?>>2</option>
				<option <?php if ( '3' == $instance['result_count'] ) echo 'selected="selected"'; ?>>3</option>
				<option <?php if ( '4' == $instance['result_count'] ) echo 'selected="selected"'; ?>>4</option>
				<option <?php if ( '5' == $instance['result_count'] ) echo 'selected="selected"'; ?>>5</option>
				<option <?php if ( '10' == $instance['result_count'] ) echo 'selected="selected"'; ?>>10</option>
				<option <?php if ( '15' == $instance['result_count'] ) echo 'selected="selected"'; ?>>15</option>
				<option <?php if ( '20' == $instance['result_count'] ) echo 'selected="selected"'; ?>>20</option>
				<option <?php if ( '25' == $instance['result_count'] ) echo 'selected="selected"'; ?>>25</option>
			</select>
		</p>

		<!-- Show thumbnails?: Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_thumbs'], true ); ?> id="<?php echo $this->get_field_id( 'show_thumbs' ); ?>" name="<?php echo $this->get_field_name( 'show_thumbs' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_thumbs' ); ?>"><?php _e('Show thumbnails?', 'chcontext'); ?></label>
		</p>

		<!-- Query Selector: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'query_selector' ); ?>"><?php _e('Query selector (jQuery syntax, empty = use post tags):', 'chcontenxt'); ?></label>
			<input id="<?php echo $this->get_field_id( 'query_selector' ); ?>" name="<?php echo $this->get_field_name( 'query_selector' ); ?>" value="<?php echo $instance['query_selector']; ?>" style="width:100%;" />
		</p>
	
		<!-- Query Template: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'query_template' ); ?>"><?php _e('Query template (put \'$$\' as placeholder for query content):', 'chcontenxt'); ?></label>
			<input id="<?php echo $this->get_field_id( 'query_template' ); ?>" name="<?php echo $this->get_field_name( 'query_template' ); ?>" value="<?php echo $instance['query_template']; ?>" style="width:100%;" />
		</p>

	
		<!-- Provider: Listbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'provider' ); ?>"><?php _e('Data provider:', 'chcontext'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'provider' ); ?>" name="<?php echo $this->get_field_name( 'provider' ); ?>" class="widefat" style="width:100%;">
			</select>
		</p>

		<!-- API Key: Text Input -->
		<p id="<?php echo $this->get_field_id( 'API_key' ); ?>-para">
			<label for="<?php echo $this->get_field_id( 'API_key' ); ?>"><?php _e('API Key (if required by provider):', 'chcontenxt'); ?></label>
			<input id="<?php echo $this->get_field_id( 'API_key' ); ?>" name="<?php echo $this->get_field_name( 'API_key' ); ?>" value="<?php echo $instance['API_key']; ?>" style="width:100%;" />
		</p>

		<!-- Custom function name: Text Input -->
		<p id="<?php echo $this->get_field_id( 'custom_function_name' ); ?>-para">
			<label for="<?php echo $this->get_field_id( 'custom_function_name' ); ?>"><?php _e('Name of the JS function for custom data provider:', 'chcontenxt'); ?></label>
			<input id="<?php echo $this->get_field_id( 'custom_function_name' ); ?>" name="<?php echo $this->get_field_name( 'custom_function_name' ); ?>" value="<?php echo $instance['custom_function_name']; ?>" style="width:100%;" />
		</p>

		<a href="https://github.com/psnc-dl/wp-chcontext/wiki/Installation-and-Configuration"><em>Configuration guide</em></a>
		
			<script type='text/javascript'>
				//Method for configuring optional fields visibility
				function setupFormFieldsVisibility<?php echo $this->number;?>() {			
					var select = document.getElementById("<?php echo $this->get_field_id( 'provider' ); ?>");					
					var checkedName = select.options[select.selectedIndex].value;
					var providers = PSNC.chcontext.searchProviders;
					for(index in providers) {
						if (providers[index].name == checkedName) {							
							if(providers[index].requiresKey) {
								jQuery("#<?php echo $this->get_field_id( 'API_key' ); ?>-para").show();
							} else {
								jQuery("#<?php echo $this->get_field_id( 'API_key' ); ?>-para").hide();
							} 
							jQuery("#<?php echo $this->get_field_id( 'custom_function_name' ); ?>-para").hide();
							return;
						}
					}
					//If we are here, then "Custom" search provider must be selected.
					jQuery("#<?php echo $this->get_field_id( 'API_key' ); ?>-para").hide();
					jQuery("#<?php echo $this->get_field_id( 'custom_function_name' ); ?>-para").show();					
				}
				
				//Initial configuration of data providers list
				var checked = "<?php echo $instance['provider'];?>";							
				var select = document.getElementById("<?php echo $this->get_field_id( 'provider' ); ?>");				
				var providers = PSNC.chcontext.searchProviders;
				for(index in providers) {
					select.options[select.options.length] = new Option(providers[index].name, providers[index].name);
					if (providers[index].name == checked) {
						select.options[select.options.length-1].selected="selected";
					}
				}
				select.options[select.options.length] = new Option('<?php echo CUSTOM;?>', '<?php echo CUSTOM;?>');
				if ('<?php echo CUSTOM;?>' == checked) {
					select.options[select.options.length-1].selected="selected";
				}
				
				//Initial visibility setup
				setupFormFieldsVisibility<?php echo $this->number;?>();
				
				//Support for dynamic visibility changes
				jQuery( "#<?php echo $this->get_field_id( 'provider' ); ?>" ).change(function() {
					setupFormFieldsVisibility<?php echo $this->number;?>();
				});
								
			</script>
		
	<?php
	}
}

?>