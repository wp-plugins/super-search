<?php
/* Admin Page Get */
function ssoptions(){
$catmode = get_option('ss_easy_mode');
$ezmode = get_option('ss_show_children');
$mancats = get_option('ss_manual_cats');
$categories = get_categories();
$tempmode = get_option('ss_template_mode');
$temp = get_option('ss_template');
$exchild = get_option('ss_exclude_child');

	if(isset($_POST['hidden'])){
		if( $_POST['hidden'] == 'Y' ) {
			$ezmode = $_POST['child'];
			$catmode = $_POST['easy'];
			$mancats = $_POST['cat'];
			$tempmode = $_POST['tmode'];
			$temp = $_POST['temp'];
			if (get_magic_quotes_gpc()){
				$temp = stripslashes($temp);
			}
			$exchild = $_POST['exchild'];
			sort($mancats);
			
			update_option( 'ss_show_children', $ezmode);
			update_option( 'ss_easy_mode', $catmode);
			update_option( 'ss_manual_cats', $mancats);
			update_option( 'ss_template_mode', $tempmode);
			update_option( 'ss_template', $temp);
			update_option('ss_exclude_child', $exchild);
			
			// Put an options updated message on the screen
			?><div class="updated"><p><strong>Your Settings Have Been Saved!</strong></p></div><?php }} ?>
			
<div class="wrap">
<h2>Super Search Settings</h2>
<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="hidden" value="Y">

<!-- Easy vs Manual -->
<div style="background-color: #fdfdfb; border: 1px solid #e8e6dd;-moz-border-radius: 5px; -webkit-border-radius: 5px; margin: 0 0 5px 0; padding: 3px 5px;">
<strong>Easy category setup, or manually select them?</strong>
<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />

<p style="margin: 0px;">
<?php if($catmode == 1){ ?>
<input type="radio" name="easy" value="1" checked />
<label>Easy Categories</label>
<input type="radio" name="easy" value="0" />
<label>Manually Select</label>
</p>

<?php }else{ ?>
<input type="radio" name="easy" value="1" />
<label>Easy Categories</label>
<input type="radio" name="easy" value="0" checked/>
<label>Manually Select</label>
</p>
<?php } ?>
<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />
<p style="margin: 0px;">Easy categories mode will allow you to quickly setup the categories using two presets: with subcategories, or without subcategories. If this doesn't work for you, choose manual mode and choose which categories you would like to appear in the drop-down list.</p>
</div>
<!-- End Easy vs Manual -->

<!-- Exclude child -->
<div style="background-color: #fdfdfb; border: 1px solid #e8e6dd;-moz-border-radius: 5px; -webkit-border-radius: 5px; margin: 0 0 5px 0; padding: 3px 5px;">
<strong>Exclude Child Categories From Results?</strong>
<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />

<p style="margin: 0px;">
<?php if($exchild == 1){ ?>
<input type="radio" name="exchild" value="1" checked />
<label>Exclude Child Categories</label>
<input type="radio" name="exchild" value="0" />
<label>Include Child Categories</label>
</p>

<?php }else{ ?>
<input type="radio" name="exchild" value="1" />
<label>Exclude Child Categories</label>
<input type="radio" name="exchild" value="0" checked/>
<label>Include Child Categories</label>
</p>
<?php } ?>
<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />
<p style="margin: 0px;">Enabling this will prevent posts from child categories from showing up from results. Please note that if a post is in both the parent category being searched for AND one of its child categories, it will NOT show up.</p>
</div>
<!-- Exclude child -->


<!-- Easy Mode Selection -->
<div style="background-color: #fdfdfb; border: 1px solid #e8e6dd;-moz-border-radius: 5px; -webkit-border-radius: 5px; margin: 0 0 5px 0; padding: 3px 5px;">
<strong>Easy Mode</strong>
<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />
<p style="margin: 0px;">
<?php if($ezmode == 1){ ?>
<input type="radio" name="child" value="1" checked />
<label>Include Child Categories</label>
<input type="radio" name="child" value="0" />
<label>Exclude Child Categories</label>
</p>

<?php }else{ ?>
<input type="radio" name="child" value="1" />
<label>Include Child Categories</label>
<input type="radio" name="child" value="0" checked/>
<label>Exclude Child Categories</label>
</p>
<?php } ?>
<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />
<p style="margin: 0px;">If you have decided to use the "Easy" mode for category selection, these options let you decide if you'd like to have child categories included or not. If you chose manual selection mode, these options will not affect the outcome of the drop-down.</p>
</div>
<!-- End Easy Mode -->


<!-- Manual Selection -->
<div style="background-color: #fdfdfb; border: 1px solid #e8e6dd;-moz-border-radius: 5px; -webkit-border-radius: 5px; margin: 0 0 5px 0; padding: 3px 5px;">
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
} ?>
</p>
<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />
<p style="margin: 0px;">If you have selected "Manual Category Selection" mode above, you can use these options to decide which categories you would like to show up, and which ones you wouldn't. It's all up to you!</p>
</div>
<!-- End Manual Selection -->


<hr>

<!-- Templating Options -->
<div style="background-color: #fdfdfb; border: 1px solid #e8e6dd;-moz-border-radius: 5px; -webkit-border-radius: 5px; margin: 0 0 5px 0; padding: 3px 5px;">
<strong>Do you want to use the default template, or make your own?</strong>
<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />
<p style="margin: 0px;">
<?php if($tempmode == 0){ ?>
<input type="radio" name="tmode" value="0" checked />
<label>Use the Default Template</label>
<input type="radio" name="tmode" value="1" />
<label>Make my Own</label>
</p>

<?php }else{ ?>
<input type="radio" name="tmode" value="0" />
<label>Use the Default Template</label>
<input type="radio" name="tmode" value="1" checked/>
<label>Make my Own</label>
</p>
<?php } ?>
<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />

<p style="margin: 0px;">
<textarea name="temp" rows="5" cols="100"><?php echo $temp; ?></textarea>
</p>
<hr color="#e8e6dd" size="1px" style="margin: 3px 0; padding: 0px;" />

<p style="margin: 0px;">To edit the template, there are various quick codes to use:<br />
<strong><%formstart%></strong> - Creates the beginning &lt;form&gt; tag<br />
<strong><%formend%></strong> - Closes the &lt;form&gt; tag<br />
<strong><%fullselect%></strong> - Creates the select and options tags using the default classes<br />
<strong><%selectstart%></strong> - Creates opening &lt;select&gt; tags with the default classes (if you want to create your own select manually, set its name to "cat")<br />
<strong><%selectend%></strong> - Closes the &lt;select&gt; tag<br />
<strong><%options%></strong> - Adds the &lt;option&gt; tags into the select tag<br />
<strong><%textbox%></strong> - Creates the text box input tag with the default class (use the name of "s" if you want to create your own textbox manually)<br />
<strong><%submitbutton%></strong> - Creates the submit button tag<br />
</p>
</div>

<!-- End Templating Options -->

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p>

</form>
</div>
<?php } ?>