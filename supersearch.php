<?php
/*
Plugin Name: Super Search
Plugin URI: http://www.wiflba.com/super-search
Description: This plugin lets your users search for posts in specific categories and child categories
Author: mc2w
Version: 1.0
Author URI: http://www.wiflba.com
*/

/* Adding some variables and menu pages to wordpress */
add_option('ss_show_children', '0', '', 'yes');
add_option('ss_easy_mode', '1', '', 'yes');
add_option('ss_manual_cats', '', '', 'yes');
add_action('admin_menu','modify_menu');

include('settings_page.php');

/* Makes the settings page visible in Wordpress */
function modify_menu(){
	add_options_page('Super Search Settings', 'Super Search', 8, 'supersearch', 'ssoptions');
}

class SSWIDGET extends WP_Widget {
    /** constructor */
    function SSWidget() {
        parent::WP_Widget(false, $name = 'Super Search Block');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title;
						supersearch();
					echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <?php 
    }

} // class SSWIDGET

add_action('widgets_init', create_function('', 'return register_widget("SSWIDGET");'));



function supersearch(){?>
	<?php
	$ezmode = get_option('ss_easy_mode');
	$children = get_option('ss_show_children');
	if($ezmode == 1){
		if($children == 0){
			nochildren();
		}else{
			children();
		}
	}else{
		manualmode();
	}
	?>
	<?php
}

function nochildren(){
	/* Defining basic variables */
	$categories = get_categories();

	/* Heh, I don't need to use mysql anymore! */

	/* Now we get to generate the necessary html! */
	?>
	<form action="<?php bloginfo('wpurl'); ?>" method="get">
	<select name="cat" id="ss_dropdown">
	<option value="" selected="selected">Select a Category</option>
	<?php
	foreach($categories as $category){
		if($category->parent == 0){
			echo '<option value="'.$category->term_id.'">'.$category->name.'</option>';
		}
	}
	?>
	</select>
	<input id="ss_searchbox" type="text" value="Search for..." onfocus="if(this.value=='Search for...'){this.value=''}" onblur="if(this.value==''){this.value='Search for...'}" name="s" />
	<input type="submit" value="Search" />
	</form>
<?php
}

function children(){
	/* Defining basic variables */
	$categories = get_categories();

	/* Heh, I don't need to use mysql anymore! */

	/* Now we get to generate the necessary html! */
	?>
	<form action="<?php bloginfo('wpurl'); ?>" method="get">
	<select name="cat" id="ss_dropdown">
	<option value="" selected="selected">Select a Category</option>
	<?php
	foreach($categories as $category){
			echo '<option value="'.$category->term_id.'">'.$category->name.'</option>';
	}
	?>
	</select>
	<input id="ss_searchbox" type="text" value="Search..." onfocus="if(this.value=='Search...'){this.value=''}" onblur="if(this.value==''){this.value='Search...'}" name="s" />
	<input type="submit" value="Search" />
	</form>
<?php
}

function manualmode(){
	/* Defining basic variables */
	$categories = get_categories();
	$mancats = get_option('ss_manual_cats');

	/* Heh, I don't need to use mysql anymore! */

	/* Now we get to generate the necessary html! */
	?>
	<form action="<?php bloginfo('wpurl'); ?>" method="get">
	<select name="cat" id="ss_dropdown">
	<option value="" selected="selected">Select a Category</option>
	<?php
	foreach($categories as $category){
		if(in_array($category->name, $mancats)){
			echo '<option value="'.$category->term_id.'">'.$category->name.'</option>';
		}
	}
	?>
	</select>
	<input id="ss_searchbox" type="text" value="Search..." onfocus="if(this.value=='Search...'){this.value=''}" onblur="if(this.value==''){this.value='Search...'}" name="s" />
	<input type="submit" value="Search" />
	</form>
<?php
}