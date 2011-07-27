<?php
/*
Plugin Name: Super Search
Plugin URI: http://www.canhaswebsite.com/super-search
Description: This plugin lets your users search for posts in specific categories and child categories
Author: mc2w
Version: 1.2
Author URI: http://www.wiflba.com
*/

/* Adding some variables and menu pages to wordpress */
add_option('ss_show_children', '0', '', 'yes');
add_option('ss_easy_mode', '1', '', 'yes');
add_option('ss_manual_cats', '', '', 'yes');
add_option('ss_template_mode', '0', '', 'yes');
add_option('ss_template', '<%formstart%><%fullselect%><%textbox%><%submitbutton%><%formend%>', '', 'yes');
add_action('admin_menu','modify_menu');
add_option('ss_exclude_child', '0', '', 'yes');

include('settings_page.php');
include('functions.php');

/* Makes the settings page visible in Wordpress */
function modify_menu(){
	add_options_page('Super Search Settings', 'Super Search', 8, 'supersearch', 'ssoptions');
}

class SSWIDGET extends WP_Widget {
	function SSWidget() {
		parent::WP_Widget(false, $name = 'Super Search Block');
	}
	
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
			if ($title){
				echo $before_title . $title . $after_title;
			}
		supersearch();
		echo $after_widget;
	}    
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	function form($instance) {
		$title = esc_attr($instance['title']); ?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</label>
		</p>
		<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("SSWIDGET");'));

function supersearch(){
	ss_full_output();
}

?>