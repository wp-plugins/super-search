<?php
/* Admin Page Get */
function ssoptions(){ 
    $catmode = get_option('ss_easy_mode');   
    $ezmode = get_option('ss_show_children');
	$mancats = get_option('ss_manual_cats');
	
	$categories = get_categories();


    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST['hidden'] == 'Y' ) {
        // Read their posted value
        $ezmode = $_POST['child'];
		$catmode = $_POST['easy'];
		$mancats = $_POST['cat'];
		sort($mancats);

        // Save the posted value in the database
        update_option( 'ss_show_children', $ezmode );
		update_option( 'ss_easy_mode', $catmode);
		update_option( 'ss_manual_cats', $mancats);

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong>Your Settings Have Been Saved!</strong></p></div>
<?php

    }?>
<div class="wrap">
<h2>Super Search Settings</h2>
<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="hidden" value="Y">

<!-- Easy vs Manual -->

<div style="background-color: #fdfdfb; border: 1px solid #e8e6dd;-moz-border-radius: 5px;
-webkit-border-radius: 5px; margin: 0 0 5px 0; padding: 3px 5px;">
<strong>Easy category setup, or manually select them?</strong>

<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />

<p style="margin: 0px;">
<?php if($catmode == 1){ ?>

<input type="radio" name="easy" value="1" checked /><label>Easy Categories</label>
<input type="radio" name="easy" value="0" /><label>Manually Select</label></p>

<?php }else{ ?>

<input type="radio" name="easy" value="1" /><label>Easy Categories</label>
<input type="radio" name="easy" value="0" checked/><label>Manually Select</label></p>

<?php } ?>

<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />

<p style="margin: 0px;">
Easy categories mode will allow you to quickly setup the categories using two presets: with subcategories, or without subcategories. If this doesn't work for you, choose manual mode and choose which categories you would like to appear in the drop-down list.
</p>

</div>

<!-- End Easy vs Manual -->


<!-- Easy Mode Selection -->

<div style="background-color: #fdfdfb; border: 1px solid #e8e6dd;-moz-border-radius: 5px;
-webkit-border-radius: 5px; margin: 0 0 5px 0; padding: 3px 5px;">
<strong>Easy Mode</strong>

<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />

<p style="margin: 0px;">
<?php if($ezmode == 1){ ?>

<input type="radio" name="child" value="1" checked /><label>Include Child Categories</label>
<input type="radio" name="child" value="0" /><label>Parent Categories Only</label></p>

<?php }else{ ?>

<input type="radio" name="child" value="1" /><label>Include Child Categories</label>
<input type="radio" name="child" value="0" checked/><label>Parent Categories Only</label></p>

<?php } ?>

<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />

<p style="margin: 0px;">
If you have decided to use the "Easy" mode for category selection, these options let you decide if you'd like to have child categories included or not. If you chose manual selection mode, these options will not affect the outcome of the drop-down.
</p>

</div>

<!-- End Easy Mode -->

<!-- Manual Selection -->

<div style="background-color: #fdfdfb; border: 1px solid #e8e6dd;-moz-border-radius: 5px;
-webkit-border-radius: 5px; margin: 0 0 5px 0; padding: 3px 5px;">
<strong>Manual Category Selection</strong>

<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />

<p style="margin: 0px;">
<?php if(empty($mancats)){
	foreach($categories as $cat){
		echo '<input type="checkbox" name="cat[]" value="'.$cat->name.'" checked /><label>'.$cat->name.'</label><br />';
		}
	}else{
	foreach($categories as $cat){
		if(in_array($cat->name, $mancats)){
			echo '<input type="checkbox" name="cat[]" value="'.$cat->name.'" checked /><label>'.$cat->name.'</label><br />';
		}else{
			echo '<input type="checkbox" name="cat[]" value="'.$cat->name.'" /><label>'.$cat->name.'</label><br />';
		}
	}
}
?>
<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />

<p style="margin: 0px;">
If you have selected "Manual Category Selection" mode above, you can use these options to decide which categories you would like to show up, and which ones you wouldn't. It's all up to you!
</p>

</div>

<!-- End Manual Selection -->


<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p>

</form>
</div>

<?php
}
?>