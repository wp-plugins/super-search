<?php
/*
Plugin Name: Super Search
Plugin URI: http://www.wiflba.com/super-search
Description: This plugin lets your users search for posts in specific categories and child categories
Author: mc2w
Version: 0.3
Author URI: http://www.wiflba.com
*/

/* Adding some variables and menu pages to wordpress */
add_option('ss_show_children', '0', '', 'yes');
add_option('ss_enable_js', '0', '', 'yes');
add_action('admin_menu','modify_menu');

/* Makes the settings page visible in Wordpress */
function modify_menu(){
	add_options_page('Super Search Settings', 'Super Search', 8, 'supersearch', 'ssoptions');
}

/* Now lets make us an admin page :) */
function ssoptions(){    
    $opt_val = get_option('child');

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST['hidden'] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST['child'];

        // Save the posted value in the database
        update_option( 'ss_show_children', $opt_val );

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong>Your Settings Have Been Saved!</strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo '<h2>Super Search Settings</h2>';

    // options form
    
    ?>

<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="hidden" value="Y">

<p><strong>Include Child Categories?</strong><br />
<?php if ($opt_val == 0){ ?>
<input type="radio" name="child" value="0" checked />No<br />
<input type="radio" name="child" value="1" />Yes
<?php }else{ ?>
<input type="radio" name="child" value="0" />No<br />
<input type="radio" name="child" value="1" checked />Yes
<?php } ?>
</p>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p>

</form>
</div>

<?php
}



function supersearch(){
	$children = get_option('ss_show_children');
	if($children == 0){
		nochildren();
	}else{
		children();
	}
}

function nochildren(){
	/* Defining basic variables */
	$categories = get_categories();

	/* Heh, I don't need to use mysql anymore! */

	/* Now we get to generate the necessary html! */
	?>
	<form action="<?php bloginfo('wpurl'); ?>" method="get">
	<select name="cat" id="cat">
	<option selected="selected">Select a Category</option>
	<?php
	foreach($categories as $category){
		if($category->parent == 0){
			echo '<option value="'.$category->term_id.'">'.$category->name.'</option>';
		}
	}
	?>
	</select>
	<input type="text" value="Search..." onfocus="if(this.value=='Search...'){this.value=''}" onblur="if(this.value==''){this.value='Search...'}" name="s" />
	<input type="submit" value="Go!" />
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
	<select name="cat" id="cat">
	<option selected="selected">Select a Category</option>
	<?php
	foreach($categories as $category){
			echo '<option value="'.$category->term_id.'">'.$category->name.'</option>';
	}
	?>
	</select>
	<input type="text" value="Search..." onfocus="if(this.value=='Search...'){this.value=''}" onblur="if(this.value==''){this.value='Search...'}" name="s" />
	<input type="submit" value="Go!" />
	</form>
<?php
}
?>