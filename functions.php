<?php

#output child categories
function ss_get_child($parent){
$active = get_option('ss_exclude_child');
$args = array(
    'type'                     => 'post',
    'child_of'                 => $parent,
    'parent'                   => '',
    'orderby'                  => 'name',
    'order'                    => 'ASC',
    'hide_empty'               => 1,
    'hierarchical'             => 1,
    'exclude'                  => '',
    'include'                  => '',
    'number'                   => '',
    'taxonomy'                 => 'category',
    'pad_counts'               => false );
	
$categories = get_categories($args);
$return = "";
if($active == 1){
foreach($categories as $cat){
	$return .= ",-".$cat->term_id;
}
}
return $return;
}


#generate options for the forum
function ss_get_options($echo){
$catmode = get_option('ss_easy_mode');   
$ezmode = get_option('ss_show_children');
$mancats = get_option('ss_manual_cats');
$categories = get_categories();
$output = "";
if(empty($mancats)){
	$catmode == 1;
}

#check if the user checked "easy mode"
if ($catmode == 1){

	#if they did, check if they chose to include child cats
	if($ezmode == 0) {
	
		#output without child cats
		foreach($categories as $category){
			if ($category->parent == 0){
				$child = ss_get_child($category->term_id);
				$output .= '<option value="'.$category->term_id.$child.'">'.$category->name.'</option>\n';
			}
		}
	} else {
		
		#output with child cats
		foreach($categories as $category){
			$child = ss_get_child($category->term_id);
			$output .= '<option value="'.$category->term_id.$child.'">'.$category->name.'</option>\n';
		}
	}
} else {
	#output the manually selected cats
	foreach($categories as $category){
		if(in_array($category->name, $mancats)){
			$child = ss_get_child($category->term_id);
			$output .= '<option value="'.$category->term_id.$child.'">'.$category->name.'</option>\n';
		}
	}
}
	if($echo == 1){
		echo $output;
	} else {
		return $output;
	}
}


#generate full form output
function ss_full_output(){
$templatemode = get_option('ss_template_mode');

#check if user made a custom template
if ($templatemode == 0){
?>
	<form action="<?php bloginfo('wpurl'); ?>" method="get">
	<select name="cat" id="ss_dropdown">
	<option value="" selected="selected">Select a Category</option>
<?php
	ss_get_options("1");
?>
	</select>
	<input id="ss_searchbox" type="text" value="Search for..." onfocus="if(this.value=='Search for...'){this.value=''}" onblur="if(this.value==''){this.value='Search for...'}" name="s" />
	<input type="submit" value="Search" />
	</form>
<?php
} else {
	$template = get_option('ss_template');
	$options = ss_get_options("0");
	$url = get_option('siteurl');
	$formstart = "<form action='".$url."' method='get'>";
	$fullselect = '<select name="cat" id="ss_dropdown"><option value="" selected="selected">Select a Category</option>'.$options.'</select>';
	$find = array('<%formstart%>', '<%formend%>', '<%fullselect%>', '<%selectstart%>', '<%options%>', '<%selectend%>', '<%textbox%>', '<%submitbutton%>');
	$replace = array( $formstart, '</form>', $fullselect, '<select name="cat" id="ss_dropdown">', $options, '</select>', '<input id="ss_searchbox" type="text" value="Search for..." onfocus="if(this.value==\'Search for...\'){this.value=\'\'}" onblur="if(this.value==\'\'){this.value=\'Search for...\'}" name="s" />', '<input type="submit" value="Search" />');
	$template = str_replace($find, $replace, $template);
	echo $template;
}
}