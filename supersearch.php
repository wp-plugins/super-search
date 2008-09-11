<?php
/*
Plugin Name: Super Search
Plugin URI: http://www.wiflba.com/super-search
Description: This plugin lets your users search for posts in specific categories and child categories
Author: mc2w
Version: 0.2
Author URI: http://www.wiflba.com
*/

function supersearch(){
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
?>