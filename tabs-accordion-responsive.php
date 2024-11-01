<?php 
/**
 * Plugin Name: Tabs Accordion Responsive
 * Plugin URI: http://pluginlyspeaking.com/plugins/tabs-accordion-responsive/
 * Description: Build your table, select a pre-built layout and display it thanks to a shortcode.
 * Author: PluginlySpeaking
 * Version: 1.0
 * Author URI: http://www.pluginlyspeaking.com
 * License: GPL2
 */

add_action( 'wp_enqueue_scripts', 'pstar_add_script' );

function pstar_add_script() {
	wp_enqueue_style( 'pstar_css', plugins_url('css/pstar.css', __FILE__));
}

// Enqueue admin styles
add_action( 'admin_enqueue_scripts', 'pstar_add_admin_style' );
function pstar_add_admin_style() {
	wp_enqueue_style( 'pstar_admin_css', plugins_url('css/pstar_admin.css', __FILE__));
	wp_enqueue_style( 'pstar_admin_tabs_css', plugins_url('css/pstar_admin_tabs.css', __FILE__));
	wp_enqueue_script('wp-ajax-response');	
	wp_enqueue_script('tiny_mce');	
	wp_enqueue_script('jquery');	
	wp_enqueue_script('jquery-ui-tabs');	
}

// Check for the PRO version
add_action( 'admin_init', 'pstar_free_pro_check' );
function pstar_free_pro_check() {
    if (is_plugin_active('pluginlyspeaking-tabsaccordionresponsive-pro/pluginlyspeaking-tabsaccordionresponsive-pro.php')) {

        function my_admin_notice(){
        echo '<div class="updated">
                <p>Tabs Accordion <strong>PRO</strong> version is activated.</p>
				<p>Tabs Accordion <strong>FREE</strong> version is deactivated.</p>
              </div>';
        }
        add_action('admin_notices', 'my_admin_notice');

        deactivate_plugins(__FILE__);
    }
}

function pstar_create_type() {
  register_post_type( 'pstar_type',
    array(
      'labels' => array(
        'name' => 'Tabs Accordion',
        'singular_name' => 'Tabs Accordion'
      ),
      'public' => true,
      'has_archive' => false,
      'hierarchical' => false,
      'supports'           => array( 'title' ),
      'menu_icon'    => 'dashicons-plus',
    )
  );
}

add_action( 'init', 'pstar_create_type' );


function pstar_admin_css() {
    global $post_type;
    $post_types = array( 
                        'pstar_type',
                  );
    if(in_array($post_type, $post_types))
    echo '<style type="text/css">#edit-slug-box, #post-preview, #view-post-btn{display: none;}</style>';
}

function pstar_remove_view_link( $action ) {

    unset ($action['view']);
    return $action;
}

add_filter( 'post_row_actions', 'pstar_remove_view_link' );
add_action( 'admin_head-post-new.php', 'pstar_admin_css' );
add_action( 'admin_head-post.php', 'pstar_admin_css' );

function pstar_check($cible,$test){
  if($test == $cible){return ' checked="checked" ';}
}

add_action('add_meta_boxes','pstar_init_advert_metabox');

function pstar_init_advert_metabox(){
  add_meta_box('pstar_advert_metabox', 'Upgrade to PRO Version', 'pstar_add_advert_metabox', 'pstar_type', 'side', 'low');
}

function pstar_add_advert_metabox($post){	
	?>
	
	<ul style="list-style-type:disc;padding-left:20px;">
		<li>More layouts</li>
		<li>More settings</li>
		<li>Use your theme's font</li>
		<li>Device restriction</li>
		<li>User restriction</li>
	</ul>
	<a style="text-decoration: none;display:inline-block; background:#33b690; padding:8px 25px 8px; border-bottom:3px solid #33a583; border-radius:3px; color:white;" target="_blank" href="http://pluginlyspeaking.com/plugins/tabs-accordion-responsive/">See all PRO features</a>
	<span style="display:block;margin-top:14px; font-size:13px; color:#0073AA; line-height:20px;">
		<span class="dashicons dashicons-tickets"></span> Code <strong>TAR10OFF</strong> (10% OFF)
	</span>
	<?php 
	
}

add_action('add_meta_boxes','pstar_init_layout_metabox');

function pstar_init_layout_metabox(){
  add_meta_box('pstar_layout_metabox', 'Select your Tabs', 'pstar_add_layout_metabox', 'pstar_type', 'normal');
}

function pstar_add_layout_metabox($post){
	
	$prefix = '_pstar_';
	$tabs_layout = get_post_meta($post->ID, $prefix.'tabs_layout',true);	
	$primary_color = get_post_meta($post->ID, $prefix.'primary_color',true);	
	$secondary_color = get_post_meta($post->ID, $prefix.'secondary_color',true);
	$corners = get_post_meta($post->ID, $prefix.'corners',true);
	$tabs_content_borders = get_post_meta($post->ID, $prefix.'tabs_content_borders',true);	
	$tabs_content_border_color = get_post_meta($post->ID, $prefix.'tabs_content_border_color',true);	
	$tabs_content_color = get_post_meta($post->ID, $prefix.'tabs_content_color',true);
	
	?>
		
	<h2 class="pstar_admin_title">Choose your layout</h2>
	
	<ul id="custom_layout_list_1" class="pstar_w_li_31 pstar_ul_layout">
		<li>
			<input type="radio" id="tabs_layout_11" name="tabs_layout" value="pstar_layout_11" <?php echo (empty($tabs_layout)) ? 'checked="checked"' : pstar_check($tabs_layout,'pstar_layout_11'); ?>>
			<label for="tabs_layout_11">
				<img src="<?php echo plugins_url('img/tabs_layout/layout_11.PNG', __FILE__); ?>" > 
			</label><br>
			<span class="pstar_desc"> Inline - Full background</span>
		</li>
		<li>
			<input type="radio" id="tabs_layout_12" name="tabs_layout" value="pstar_layout_12" <?php echo (empty($tabs_layout)) ? '' : pstar_check($tabs_layout,'pstar_layout_12'); ?>>
			<label for="tabs_layout_12">
				<img src="<?php echo plugins_url('img/tabs_layout/layout_12.PNG', __FILE__); ?>" > 
			</label><br>
			<span class="pstar_desc"> Inline - Underline</span>
		</li>
		<li>
			<input type="radio" id="tabs_layout_16" name="tabs_layout" value="pstar_layout_16" <?php echo (empty($tabs_layout)) ? '' : pstar_check($tabs_layout,'pstar_layout_16'); ?>>
			<label for="tabs_layout_16">
				<img src="<?php echo plugins_url('img/tabs_layout/layout_16.PNG', __FILE__); ?>" >
			</label><br>
			<span class="pstar_desc"> Upside/Down - Topline</span>
		</li>
	</ul>
	
	<h2 class="pstar_admin_title">Layout styling</h2>
	
	<table class="pstar_table_100_3td">
		<tr class="pstar_show_corners">
			<td class="pstar_td_label">
				<label for="corners">Do you want rounded corners ? </label>
			</td>
			<td class="pstar_td_thin">
				<input type="radio" id="corners_yes" name="corners" value="5px" <?php echo (empty($corners)) ? '' : pstar_check($corners,'5px'); ?>> Yes 
				<input type="radio" id="corners_no" name="corners" value="2px" <?php echo (empty($corners)) ? 'checked="checked"' : pstar_check($corners,'2px'); ?>> No	
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td class="pstar_td_label">
				<label for="primary_color" class="pstar_table_31_l" >Primary Color : </label>
			</td>
			<td class="pstar_td_thin">
				<input id="primary_color" name="primary_color" type="text" value="<?php echo (empty($primary_color)) ? '#000000' : $primary_color; ?>" class="pstar_colorpicker" />	
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td class="pstar_td_label">
				<label for="secondary_color" class="pstar_table_31_l" >Secondary Color : </label>
			</td>
			<td class="pstar_td_thin">
				<input id="secondary_color" name="secondary_color" type="text" value="<?php echo (empty($secondary_color)) ? '#dd9933' : $secondary_color; ?>" class="pstar_colorpicker" />
			</td>
			<td>
			</td>
		</tr>
	</table>
	
	<h2 class="pstar_admin_title">Tabs content styling</h2>
	
	<table class="pstar_table_100_3td">
		<tr>
			<td class="pstar_td_label">
				<label for="tabs_content_borders">Do you want borders ? </label>
			</td>
			<td class="pstar_td_thin">
				<input type="radio" id="tabs_content_borders_yes" name="tabs_content_borders" value="yes" <?php echo (empty($tabs_content_borders)) ? 'checked="checked"' : pstar_check($tabs_content_borders,'yes'); ?>> Yes 
				<input type="radio" id="tabs_content_borders_no" name="tabs_content_borders" value="no" <?php echo (empty($tabs_content_borders)) ? '' : pstar_check($tabs_content_borders,'no'); ?>> No
			</td>
			<td>
				<div id="pstar_border_color">
					<label for="tabs_content_border_color" class="pstar_label_colorpicker" >Border Color : </label>
					<input id="tabs_content_border_color" name="tabs_content_border_color" type="text" value="<?php echo (empty($tabs_content_border_color)) ? '#000000' : $tabs_content_border_color; ?>" class="pstar_colorpicker" />
				</div>
			</td>
		</tr>	
		<tr>
			<td class="pstar_td_label">
				<label for="tabs_content_color" class="pstar_table_31_l" >Background Color : </label>
			</td>
			<td class="pstar_td_thin">
				<input id="tabs_content_color" name="tabs_content_color" type="text" value="<?php echo (empty($tabs_content_color)) ? '#FFFFFF' : $tabs_content_color; ?>" class="pstar_colorpicker" />
			</td>
			<td>
			</td>
		</tr>
	</table>
	
	
	<script type="text/javascript">
		$=jQuery.noConflict();
		jQuery(document).ready( function($) {
			if($('#tabs_content_borders_yes').is(':checked')) {
				$('#pstar_border_color').show();
			} 
			if($('#tabs_content_borders_no').is(':checked')) {
				$('#pstar_border_color').hide();
			} 
			
			$('input[name=tabs_content_borders]').live('change', function(){
				if($('#tabs_content_borders_yes').is(':checked')) {
					$('#pstar_border_color').show();
				} 
				if($('#tabs_content_borders_no').is(':checked')) {
					$('#pstar_border_color').hide();
				} 
			});			
		});
	</script>

	<?php 	
}

function pstar_colorpicker_enqueue() {
    global $typenow;
    if( $typenow == 'pstar_type' ) {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'pstar_colorpicker', plugin_dir_url( __FILE__ ) . 'js/pstar_colorpicker.js', array( 'wp-color-picker' ) );
    }
}
add_action( 'admin_enqueue_scripts', 'pstar_colorpicker_enqueue' );

add_action('wp_ajax_dynamic_wp_editor', function(){
    wp_editor( '', $_POST['dynamic_id'],      $settings = array( 'tinymce'=>true, 'textarea_name'=>'content', 'wpautop' =>false,   'media_buttons' => true ,   'teeny' => false, 'quicktags'=>true, )   );    exit;
});

add_action('add_meta_boxes','pstar_init_table_metabox');

function pstar_init_table_metabox(){
  add_meta_box('pstar_table_metabox', 'Build your tabs', 'pstar_add_table_metabox', 'pstar_type', 'normal');
}

function pstar_add_table_metabox($post){
	
	$prefix = '_pstar_';
	$order_list = get_post_meta($post->ID, $prefix.'order',true);
	$order = explode(',',$order_list);
	if($order_list != "")
	{
		foreach ($order as $k => $thing) {
			${"content_" . $thing} = get_post_meta($post->ID, $prefix.'content_'.$thing.'',true);
			${"tab_title_" . $thing} = get_post_meta($post->ID, $prefix.'tab_title_'.$thing.'',true);
			${"icon_title_" . $thing} = get_post_meta($post->ID, $prefix.'icon_title_'.$thing.'',true);
		}
	}
	?>
	<a id="pstar_add_tab" class="button" style="margin-top: 0px; margin-bottom: 15px;" href="javascript:void(0);">Add a tab</a>	
	<br>
	<div id="tabs" class="pstar_tabs">
		<?php
		if($order_list != "")
		{
			?>
			<ul class="pstar_tabs_ul">
				<?php
				foreach ($order as $k => $thing) {
				?>					
					<li class="pstar_tabs_li"><a class="title_tabs" href="#tabs-<?php echo $thing; ?>">Tab <?php echo $thing; ?></a><a id="<?php echo $thing; ?>" class="delete_tabs"><img class="delete_img_tabs"title="Remove the Tab" src="<?php echo plugins_url('img/tabs_delete.png', __FILE__); ?>" width="10" height="10" /></a></li>
				<?php					
				}
				?>	
			</ul>
			
			<?php
			foreach ($order as $k => $thing) {
			?>					
				<div id="tabs-<?php echo $thing; ?>" class="pstar_tabs_div">
					<div class="pstar_label_input_tabs" ><label for="tab_title_<?php echo $thing; ?>" >Tab title : </label>
					<input type="text" name="tab_title_<?php echo $thing; ?>" value="<?php echo ${"tab_title_" . $thing}; ?>" /></div><br>
					
					<div class="pstar_label_input_tabs" ><label for="icon_title_<?php echo $thing; ?>" >Tab icon : </label>
					<input type="text" id="pstar_media_icon_title_<?php echo $thing; ?>" name="icon_title_<?php echo $thing; ?>" value="<?php echo ${"icon_title_" . $thing}; ?>" />
					<input type="button" id="icon_title_<?php echo $thing; ?>" class="button icon-title-button" value="Choose an image" /></div><br>
					
					<?php wp_editor( htmlspecialchars_decode(${"content_" . $thing}), 'pstar_content_'.$thing , array( 'textarea_name' => 'content_'.$thing )); ?>
				</div>
			<?php				
			}
		}else{
		?>

			<ul class="pstar_tabs_ul">
				<li class="pstar_tabs_li"><a class="title_tabs" href="#tabs-1">Tab 1</a><a id="1" class="delete_tabs delete_hidden"><img class="delete_img_tabs"title="Remove the Tab" src="<?php echo plugins_url('img/tabs_delete.png', __FILE__); ?>" width="10" height="10" /></a></li>
				<li class="pstar_tabs_li"><a class="title_tabs" href="#tabs-2">Tab 2</a><a id="2" class="delete_tabs"><img class="delete_img_tabs"title="Remove the Tab" src="<?php echo plugins_url('img/tabs_delete.png', __FILE__); ?>" width="10" height="10" /></a></li>
				<li class="pstar_tabs_li"><a class="title_tabs" href="#tabs-3">Tab 3</a><a id="3" class="delete_tabs"><img class="delete_img_tabs"title="Remove the Tab" src="<?php echo plugins_url('img/tabs_delete.png', __FILE__); ?>" width="10" height="10" /></a></li>
			</ul>
			<div id="tabs-1" class="pstar_tabs_div">
				<div class="pstar_label_input_tabs" ><label for="tab_title_1" >Tab title : </label>
				<input type="text" name="tab_title_1" value="" /></div><br>
				
				<div class="pstar_label_input_tabs" ><label for="icon_title_1" >Tab icon : </label>
				<input type="text" id="pstar_media_icon_title_1" name="icon_title_1" value="" />
				<input type="button" id="icon_title_1" class="button icon-title-button" value="Choose an image" /></div><br>
				
				<?php wp_editor( '', 'pstar_content_1', array( 'textarea_name' => 'content_1' )); ?>
			</div>
			<div id="tabs-2" class="pstar_tabs_div">				
				<div class="pstar_label_input_tabs" ><label for="tab_title_2" >Tab title : </label>
				<input type="text" name="tab_title_2" value="" /></div><br>
				
				<div class="pstar_label_input_tabs" ><label for="icon_title_2" >Tab icon : </label>
				<input type="text" id="pstar_media_icon_title_2" name="icon_title_2" value="" />
				<input type="button" id="icon_title_2" class="button icon-title-button" value="Choose an image" /></div><br>
				
				<?php wp_editor( '', 'pstar_content_2', array( 'textarea_name' => 'content_2' )); ?>
			</div>
			<div id="tabs-3" class="pstar_tabs_div">
				<div class="pstar_label_input_tabs" ><label for="tab_title_3" >Tab title : </label>
				<input type="text" name="tab_title_3" value="" /></div><br>
				
				<div class="pstar_label_input_tabs" ><label for="icon_title_3" >Tab icon : </label>
				<input type="text" id="pstar_media_icon_title_3" name="icon_title_3" value="" />
				<input type="button" id="icon_title_3" class="button icon-title-button" value="Choose an image" /></div><br>
				
				<?php wp_editor( '', 'pstar_content_3', array( 'textarea_name' => 'content_3' )); ?>
			</div>

		<?php
		}
		?>				
	</div>
	
	<input id="pstar_hidden_order" name="order" type="hidden" value="<?php echo $order_list; ?>"/>

	<script type="text/javascript">// <![CDATA[
	$=jQuery.noConflict();
	jQuery(document).ready(function($){

		var tabs = $( "#tabs" ).tabs();
		tabs.find( ".ui-tabs-nav" ).sortable({
		  axis: "x",
		  update: function (e, ui) {
				  var current_order = "";
				 $(".delete_tabs").each(function(i){
					  current_order+= ( current_order == "" ? "" : "," )+this.id;
				 });
				 $('#pstar_hidden_order').val(current_order);
			},
		  stop: function() {
			tabs.tabs( "refresh" );
		  }
		});
		
		 var current_order = "";
		 $(".delete_tabs").each(function(i){
			  current_order+= ( current_order == "" ? "" : "," )+this.id;
		 });
		$('#pstar_hidden_order').val(current_order);
		
		$('.wp-core-ui.wp-editor-wrap.html-active').removeClass('html-active').addClass('tmce-active');

		//suppresion champ
		function remove_chose(){
			$('.delete_tabs').on('click',function(){
				var id_to_delete = $(this).attr('id');
				$(this).parent().remove();
				$("#tabs-" + id_to_delete).remove();

				tinymce.execCommand('mceRemoveEditor', false, "pstar_content_" + id_to_delete);
				
				var current_order = "";
				 $(".delete_tabs").each(function(i){
					  current_order+= ( current_order == "" ? "" : "," )+this.id;
				 });
				 $('#pstar_hidden_order').val(current_order);
			});
		}
		remove_chose();

		//ajout champ
		$('#pstar_add_tab').on('click',function(){
			var all_id = $(".pstar_tabs_div").map(function () {
				return this.id.replace( /^\D+/g, '');
			}).get();
			
			var highest = all_id[0]; // note: don't do this if the array could be empty
			for(var i = 0; i < all_id.length; i++) {
				if(highest<all_id[i]) highest = all_id[i];
			}
			var new_highest = parseInt(highest, 10) + 1;
			$('.pstar_tabs_li:last').clone().appendTo('.pstar_tabs_ul');
			$('.pstar_tabs_li:last').removeClass( "ui-tabs-active ui-state-active" );
			$('.pstar_tabs_li:last a.delete_tabs').removeClass( "delete_hidden" );
			$('.pstar_tabs_div:last').clone().appendTo('.pstar_tabs');
			$('.pstar_tabs_div:last').empty();
			$('.pstar_tabs_li:last').attr("aria-labelledby","ui-id-" + new_highest);
			$('.pstar_tabs_li:last a.title_tabs').attr("href","#tabs-" + new_highest);
			$('.pstar_tabs_li:last a.title_tabs').attr("id","ui-id-" + new_highest);
			$('.pstar_tabs_li:last a.title_tabs').text("Tab " + new_highest);
			$('.pstar_tabs_li:last a.delete_tabs').attr("id", new_highest);
			$('.pstar_tabs_div:last').attr("id","tabs-" + new_highest);
			$('.pstar_tabs_div:last').append('<div class="pstar_label_input_tabs" ><label for="tab_title_' + new_highest + '" >Tab title : </label>' +
				'<input type="text" name="tab_title_' + new_highest + '" value="" /></div><br>' +				
				'<div class="pstar_label_input_tabs" ><label for="icon_title_' + new_highest + '" >Tab icon : </label>' +
				'<input type="text" id="pstar_media_icon_title_' + new_highest + '" name="icon_title_' + new_highest + '" value="" />' +
				'<input type="button" id="icon_title_' + new_highest + '" class="button icon-title-button" value="Choose an image" /></div><br>');
			
			var tabs = $( "#tabs" ).tabs();
			tabs.tabs( "refresh" );

			jQuery.post(ajaxurl,
				{ action: "dynamic_wp_editor",     dynamic_id: "pstar_content_" + new_highest}, 
				function(response,status){ 
					$(response).appendTo('.pstar_tabs_div:last');
					quicktags({id : "pstar_content_" + new_highest});
					tinymce.execCommand( 'mceAddEditor', false, "pstar_content_" + new_highest );
					$('#pstar_content_' + new_highest).attr('name','content_' + new_highest)
				}
			);	
			
			var current_order = "";
			 $(".delete_tabs").each(function(i){
				  current_order+= ( current_order == "" ? "" : "," )+this.id;
			 });
			 $('#pstar_hidden_order').val(current_order);
			
			remove_chose();
		});	
		
	});

	// ]]></script>
	<?php
}	

add_action( 'admin_enqueue_scripts', 'pstar_icon_title_enqueue' );
function pstar_icon_title_enqueue() {
	global $typenow;
	if( $typenow == 'pstar_type' ) {
		wp_enqueue_media();
 
		// Registers and enqueues the required javascript.
		wp_register_script( 'pstar_media_icon_title-js', plugin_dir_url( __FILE__ ) . 'js/pstar_media_icon_title.js', array( 'jquery' ) );
		wp_localize_script( 'pstar_media_icon_title-js', 'pstar_media_icon_title_js',
			array(
				'title' => __( 'Choose or Upload an image'),
				'button' => __( 'Use this file'),
			)
		);
		wp_enqueue_script( 'pstar_media_icon_title-js' );
	}
}

add_action('save_post','pstar_save_metabox');
function pstar_save_metabox($post_id){
	
	$prefix = '_pstar_';
	
	//Metabox Settings
	if(isset($_POST['tabs_layout'])){
		update_post_meta($post_id, $prefix.'tabs_layout', sanitize_text_field($_POST['tabs_layout']));
	}
	if(isset($_POST['corners'])){
		update_post_meta($post_id, $prefix.'corners', sanitize_text_field($_POST['corners']));
	}
	if( isset( $_POST[ 'primary_color' ] ) ) {
		update_post_meta( $post_id, $prefix.'primary_color', sanitize_hex_color($_POST['primary_color']));
	}
	if( isset( $_POST[ 'secondary_color' ] ) ) {
		update_post_meta( $post_id, $prefix.'secondary_color', sanitize_hex_color($_POST['secondary_color']));
	}
	if(isset($_POST['tabs_content_borders'])){
		update_post_meta($post_id, $prefix.'tabs_content_borders', sanitize_text_field($_POST['tabs_content_borders']));
	}
	if(isset($_POST['tabs_content_border_color'])){
		update_post_meta($post_id, $prefix.'tabs_content_border_color', sanitize_hex_color($_POST['tabs_content_border_color']));
	}
	if( isset( $_POST[ 'tabs_content_color' ] ) ) {
		update_post_meta( $post_id, $prefix.'tabs_content_color', sanitize_hex_color($_POST['tabs_content_color']));
	}
	if(isset($_POST['order'])){
		update_post_meta($post_id, $prefix.'order', sanitize_text_field($_POST['order']));
	}
	if ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) {
		$order_list = get_post_meta($post_id, $prefix.'order',true);
		$order = explode(',',$order_list);
		foreach ($order as $k => $thing) {
			if( isset($_POST['content_'.$thing.'']))
			{
				update_post_meta( $post_id, $prefix.'content_'.$thing.'', wp_kses_post($_POST['content_'.$thing.'']));
			}
			if( isset($_POST['tab_title_'.$thing.'']))
			{
				update_post_meta( $post_id, $prefix.'tab_title_'.$thing.'', sanitize_text_field($_POST['tab_title_'.$thing.'']));
			}			
			if( isset($_POST['icon_title_'.$thing.'']))
			{
				update_post_meta( $post_id, $prefix.'icon_title_'.$thing.'', esc_url($_POST['icon_title_'.$thing.'']));
			}
		}	
	}	
}

add_action( 'manage_pstar_type_posts_custom_column' , 'pstar_custom_columns', 10, 2 );

function pstar_custom_columns( $column, $post_id ) {
    switch ( $column ) {
	case 'shortcode' :
		global $post;
		$pre_slug = '' ;
		$pre_slug = $post->post_title;
		$slug = sanitize_title($pre_slug);
    	$shortcode = '<span style="border: solid 3px lightgray; background:white; padding:7px; font-size:17px; line-height:40px;">[ps_tabsaccordion name="'.$slug.'"]</strong>';
	    echo $shortcode; 
	    break;
    }
}

function pstar_add_columns($columns) {
    return array_merge($columns, 
              array('shortcode' => __('Shortcode'),
                    ));
}
add_filter('manage_pstar_type_posts_columns' , 'pstar_add_columns');

function pstar_get_wysiwyg_output( $meta_key, $post_id = 0 ) {
    global $wp_embed;

    $post_id = $post_id ? $post_id : get_the_id();

    $content = get_post_meta( $post_id, $meta_key, 1 );
    $content = $wp_embed->autoembed( $content );
    $content = $wp_embed->run_shortcode( $content );
    $content = wpautop( $content );

    return $content;
}

function pstar_shortcode($atts) {
	extract(shortcode_atts(array(
		"name" => ''
	), $atts));
		
	global $post;
    $args = array('post_type' => 'pstar_type', 'numberposts'=>-1);
    $custom_posts = get_posts($args);
	$output = '';
	foreach($custom_posts as $post) : setup_postdata($post);
	$sanitize_title = sanitize_title($post->post_title);
	if ($sanitize_title == $name)
	{
		$postid = get_the_ID();	
	   
		$prefix = '_pstar_';

		$tabs_layout  = get_post_meta($post->ID, $prefix.'tabs_layout',true);
		$corners  = get_post_meta($post->ID, $prefix.'corners',true);
		$primary_color  = get_post_meta($post->ID, $prefix.'primary_color',true);
		$secondary_color  = get_post_meta($post->ID, $prefix.'secondary_color',true);
		$additionnal_class = "pstar_tabs_icon_25";

		if($tabs_layout == 'pstar_layout_11' || $tabs_layout == 'pstar_layout_12')
			$additionnal_class = "pstar_tabs_icon_25";
		if($tabs_layout == 'pstar_layout_16')
			$additionnal_class = "pstar_tabs_icon_50";	

		$order_list = get_post_meta($post->ID, $prefix.'order',true);
		$order = explode(',',$order_list);
		$nb_tabs = count($order);
		
		$tabs_content_borders = get_post_meta($post->ID, $prefix.'tabs_content_borders',true);
		if($tabs_content_borders == "yes")	
		{
			$tabs_content_border_color = get_post_meta($post->ID, $prefix.'tabs_content_border_color',true);
			$tabs_content_borders_style = "border:1px solid ".$tabs_content_border_color.";";
		}else{
			$tabs_content_borders_style = "border:none;";
		}	
		$tabs_content_color = get_post_meta($post->ID, $prefix.'tabs_content_color',true);
		
		foreach ($order as $k => $thing) {
			${"content_" . $thing} = pstar_get_wysiwyg_output($prefix.'content_'.$thing, $post->ID);
			${"tab_title_" . $thing} = get_post_meta($post->ID, $prefix.'tab_title_'.$thing.'',true);
			${"icon_title_" . $thing} = get_post_meta($post->ID, $prefix.'icon_title_'.$thing.'',true);
			if (${"icon_title_" . $thing} == "")
				${"icon_title_" . $thing} = plugins_url('img/filling_space.png', __FILE__);
		}		
			
		$output = '';
		$output .= '<div>';
		$output .= '<style type="text/css">';
			$output .= 'label.pstar_tabs_title:hover {';
				$output .= 'color: '.$primary_color.';';
			$output .= '}';
			foreach ($order as $k => $thing) {
				$output .= '#pstar_controller_'.$thing.':checked ~ #pstar_tabs_wrapper #pstar_section_'.$thing.' main {';
					$output .= 'max-height: initial;';
					$output .= 'opacity: 1;';
					$output .= 'padding: 48px 24px;';
				$output .= '}';
				$output .= '#pstar_controller_'.$thing.':checked ~ #pstar_tabs_list #pstar_tab_'.$thing.' label.pstar_tabs_title .pstar_tabs_icon {';
					$output .= '-webkit-filter: grayscale(0%);';
					$output .= '-moz-filter: grayscale(0%);';
					$output .= '-o-filter: grayscale(0%);';
					$output .= 'filter: grayscale(0%);';
				$output .= '}';
			}
			$output .= '@media all and (max-width: 767px) {';
				foreach ($order as $k => $thing) {
					$output .= '#pstar_menu_controller:checked ~ #pstar_tabs_list #pstar_tab_'.$thing.' {';
						$output .= 'max-height: 46px;';
						$output .= 'opacity: 1;';
					$output .= '}';
					$output .= '#pstar_tabs_list #pstar_tab_'.$thing.' {';
						$output .= 'max-height: 0;';
						$output .= 'overflow-y: hidden;';
						$output .= '-webkit-transition: max-height 200ms;';
						$output .= 'transition: max-height 200ms;';
					$output .= '}';
					$output .= '#pstar_controller_'.$thing.':checked ~ #pstar_tabs_list #pstar_tab_'.$thing.' {';
						$output .= 'max-height: 46px;';
						$output .= 'opacity: 1;';
					$output .= '}';
					$output .= '#pstar_controller_'.$thing.':checked ~ #pstar_tabs_list #pstar_tab_'.$thing.' label.pstar_tabs_title {';
						$output .= 'background-color: '.$primary_color.';'; 
						$output .= 'color: '.$secondary_color.';'; 
					$output .= '}';						
				}
			$output .= '}';
			$output .= '@media all and (min-width: 768px) {';
				$output .= 'ul#pstar_tabs_list li {';
					$output .= 'width:' . (100 / $nb_tabs - 2) . '%;';
				$output .= '}';
				$output .= 'ul#pstar_tabs_list li label.pstar_tabs_title::after {';
					$output .= 'background-color: '.$primary_color.';';
				$output .= '}';		
				
				foreach ($order as $k => $thing) {
					$output .= '#pstar_controller_'.$thing.':checked ~ #pstar_tabs_list #pstar_tab_'.$thing.' {';
						$output .= 'pointer-events: none;';
						$output .= 'cursor: default;';
						$output .= '-webkit-transform: translate3d(0, 1px, 0);';
						$output .= 'transform: translate3d(0, 1px, 0);';
						$output .= 'box-shadow: none;';
					$output .= '}';
					$output .= '#pstar_controller_'.$thing.':checked ~ #pstar_tabs_list #pstar_tab_'.$thing.' label.pstar_tabs_title {';
						switch ($tabs_layout) {
							case "pstar_layout_11":
								$output .= 'background-color: '.$primary_color.';';
								$output .= 'color: '.$secondary_color.';';
								$output .= 'padding-top: 26px;';
								break;
							case "pstar_layout_12":
								$output .= 'background-color: white;';
								$output .= 'color: '.$secondary_color.';';
								$output .= 'padding-top: 26px;';
								break;
							case "pstar_layout_16":
								$output .= 'background-color: white;';
								$output .= 'color: '.$secondary_color.';';
								$output .= 'padding-top: 26px;';
								break;
						}
					$output .= '}';
					$output .= '#pstar_controller_'.$thing.':checked ~ #pstar_tabs_list #pstar_tab_'.$thing.' label.pstar_tabs_title::after {';
						$output .= 'height: 6px;';
					$output .= '}';
					$output .= '#pstar_controller_'.$thing.':checked ~ #pstar_tabs_list #pstar_tab_'.$thing.' label.pstar_tabs_title:hover::after {';
						$output .= 'height: 6px;';
					$output .= '}';
				}
				$output .= 'ul#pstar_tabs_list li{';
					$output .= 'border-top-left-radius:'.$corners.';';
					$output .= 'border-top-right-radius:'.$corners.';';
				$output .= '}';
				$output .= 'ul#pstar_tabs_list li label.pstar_tabs_title {';
					$output .= 'border-top-left-radius:'.$corners.';';
					$output .= 'border-top-right-radius:'.$corners.';';
				$output .= '}';
				switch ($tabs_layout) {
					case "pstar_layout_11":
						$output .= 'ul#pstar_tabs_list li label.pstar_tabs_title::after {';
							$output .= 'border-top-left-radius:'.$corners.';';
							$output .= 'border-top-right-radius:'.$corners.';';
							$output .= 'top:0;';
						$output .= '}';
						$output .= 'ul#pstar_tabs_list li label.pstar_tabs_title:hover::after {';
							$output .= 'border-top-left-radius:'.$corners.';';
							$output .= 'border-top-right-radius:'.$corners.';';
							$output .= 'top:0;';
						$output .= '}';
						break;
					case "pstar_layout_12":
						$output .= 'ul#pstar_tabs_list li label.pstar_tabs_title::after {';
							$output .= 'bottom:0;';
						$output .= '}';
						$output .= 'ul#pstar_tabs_list li label.pstar_tabs_title:hover::after {';
							$output .= 'bottom:0;';
						$output .= '}';
						break;
					case "pstar_layout_16":
						$output .= 'ul#pstar_tabs_list li label.pstar_tabs_title::after {';
							$output .= 'border-top-left-radius:'.$corners.';';
							$output .= 'border-top-right-radius:'.$corners.';';
							$output .= 'top:0;';
						$output .= '}';
						$output .= 'ul#pstar_tabs_list li label.pstar_tabs_title:hover::after {';
							$output .= 'border-top-left-radius:'.$corners.';';
							$output .= 'border-top-right-radius:'.$corners.';';
							$output .= 'top:0;';
						$output .= '}';
						break;
				}
			$output .= '}';
		$output .= '</style>';
		
		
		$count_tab = 0;
		foreach ($order as $k => $thing) {
			if($count_tab == 0){
				$output .= '<input id="pstar_controller_'.$thing.'" class="pstar_controllers" type="radio" name="tab-radios" checked="checked">';
			}else{
				$output .= '<input id="pstar_controller_'.$thing.'" class="pstar_controllers" type="radio" name="tab-radios">';
			}
			$count_tab = 1;
		}
		$output .= '<input id="pstar_menu_controller" class="pstar_controllers" type="checkbox" name="nav-checkbox">';
		$output .= '<ul id="pstar_tabs_list" class="'.$tabs_layout.'">';
		$output .= '<label id="pstar_menu_open" for="pstar_menu_controller"></label>';
		foreach ($order as $k => $thing) {
			$output .= '<li id="pstar_tab_'.$thing.'">';
				$output .= '<label class="pstar_tabs_title pstar_font_not_force" for="pstar_controller_'.$thing.'">';
				if($tabs_layout == 'pstar_layout_11' || $tabs_layout == 'pstar_layout_12')
					$output .= '<img src="'.${"icon_title_" . $thing}.'" class="pstar_tabs_icon '.$additionnal_class.'" alt="" height="25" width="25">';
				if($tabs_layout == 'pstar_layout_16')
					$output .= '<img src="'.${"icon_title_" . $thing}.'" class="pstar_tabs_icon '.$additionnal_class.'" alt="" height="50" width="50"><br>';
				$output .= ' '.${"tab_title_" . $thing}.'</label>';    
			$output .= '</li>';    
		}			
		$output .= '<label id="pstar_menu_close" class="pstar_font_not_force" for="pstar_menu_controller">Close</label>';
		$output .= '</ul>';
		
		$output .= '<article id="pstar_tabs_wrapper" style="'.$tabs_content_borders_style.'background-color:'.$tabs_content_color.';">';
		$output .= '<div class="pstar_tabs_container pstar_font_not_force">';
		foreach ($order as $k => $thing) {				
			$output .= '<section id="pstar_section_'.$thing.'">';
			$output .= '<main>';
			$output .= do_shortcode(${"content_" . $thing});    
			$output .= '</main>';    
			$output .= '</section>';    
		}	
		$output .= '</div>';
		$output .= '</article>';
		$output .= '</div>';		
	}
	endforeach; wp_reset_query();
	return $output;
}
add_shortcode( 'ps_tabsaccordion', 'pstar_shortcode' );


	
?>