<?php

class Images_field extends acf_Field
{
	
	/*--------------------------------------------------------------------------------------
	*
	*	Constructor
	*
	*	@author Elliot Condon
	*	@since 1.0.0
	*	@updated 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function __construct($parent)
	{
    	parent::__construct($parent);
    	
    	$this->name = 'images';
		$this->title = __('Images','acf');
		
		add_action('admin_head-media-upload-popup', array($this, 'popup_head'));
		add_filter('media_send_to_editor', array($this, 'media_send_to_editor'), 15, 2 );
		add_filter('get_media_item_args', array($this, 'allow_img_insertion'));
   	}
   	
   	
   	/*--------------------------------------------------------------------------------------
	*
	*	admin_print_scripts / admin_print_styles
	*
	*	@author Elliot Condon
	*	@since 3.0.1
	* 
	*-------------------------------------------------------------------------------------*/
	
	function allow_img_insertion($vars)
	{
	    $vars['send'] = true;
	    return($vars);
	}
	
   	
   	/*--------------------------------------------------------------------------------------
	*
	*	admin_print_scripts / admin_print_styles
	*
	*	@author Elliot Condon
	*	@since 3.0.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function admin_print_scripts()
	{
		wp_enqueue_script(array(
			'jquery',
			'jquery-ui-core',
			'jquery-ui-tabs',
			'jquery-ui-sortable',

			'thickbox',
			'media-upload',			
		));
	}
	
	function admin_print_styles()
	{
  		wp_enqueue_style(array(
			'thickbox',		
		));
	}
	
	
	/*--------------------------------------------------------------------------------------
	*
	*	admin_head
	*
	*	@author Elliot Condon
	*	@since 2.0.6
	* 
	*-------------------------------------------------------------------------------------*/
	
	function admin_head()
	{
		?>
		
		<style type="text/css">
		
			/*---------------------------------------------------------------------------------------------
				Images Upload
			---------------------------------------------------------------------------------------------*/
			
			.acf_images_uploader {
				position: relative;
			}
			.acf_images_uploader .images {
				display: none;
			}
			.acf_images_uploader.active .images {
				display: block;
			}
			.acf_images_uploader .image {
				position: relative;
				display: inline-block;
				margin: 2px 14px 14px 2px;
			}
			.acf_images_uploader a.remove_image {
				width: 16px;
				height: 16px;
				background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAgCAYAAAAbifjMAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDowNTgwMTE3NDA3MjA2ODExQjg0MEZBNEZBQzRDOEFEMiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGM0FEQjA1QzIxRjcxMUUwQUNDQURGNUZGMEYxQkZERiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGM0FEQjA1QjIxRjcxMUUwQUNDQURGNUZGMEYxQkZERiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjAyODAxMTc0MDcyMDY4MTE4NEZGRkZGRTJERkVDMDQ5IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjA1ODAxMTc0MDcyMDY4MTFCODQwRkE0RkFDNEM4QUQyIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+QAIvigAAAZxJREFUeNrsVctKw0AUzQRBRSolC23BhdaFEBFMN/YD/IQuXYgfIkWEgnFdyB8I1m9oofsuAyLqsk2gXaSKj9KM97SdMqmaZMCFiBdOZ5g55+amM+eGcc41OZiuL9KwTVgnGNPlPsEj3PMwfIsIkEBAY2xnq1A4ajQaV57n3YZhOAIwxxr2wIloJLFVqVROB4OBx78J7IEDbiQBLezVarULnjLAhWby+owt71vW8XA4fEmbAFxooEWC3VardcMVAxpodaohb5pmUVOMqSa/QD+r2Wx2Q2zU6/VYYblcHo+ZTGaNhhVUMKJ4V62AMQYtw+yw1+s9qv4H0ECLLB3XdduqFUw1nfExHpRKJ6rHCM34GMVFchznMm0CcOWLJGBVq9WzpKts2/Y5uDOdlGBmpmazee37/p0QYo41YSZZwyZZIrFEKBByc3buEh4IrzJZJ39rMuBw4fQ5TNw/z//vB7+xH7RzuVhhsdv92X6ACp7peHzDMDblJyRFEAQgPv2FfiBfZZV+8MkLspmS+oGsYV983mP7AVk40g8+BBgAmK7hjXw4mPUAAAAASUVORK5CYII=) 0 0 no-repeat;
				position: absolute;
				top:0;
				left: 0;
				cursor: pointer;
				margin: -3px 0 0 -3px;
				display: none;
			}
			
			.acf_images_uploader .image:hover a.remove_image {
				display: block;
			}
			
			.acf_images_uploader a.remove_image:hover  {
				background-position: 0% 100%;
			}
			
			.acf_images_uploader img {
			   -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3); 
			   -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3); 
				box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
			}
			
			.acf_images_uploader .acf_add_images {
				clear: both;
			}
			.acf_images_uploader .acf_add_images span {
				display: inline;
			}
			.acf_images_uploader.active .acf_add_images span {
				display: none;
			}
			
		</style>
		
		<script type="text/javascript">
		
		(function($){
		
			$('#poststuff .acf_images_uploader .button').live('click', function(){
				
				// vars
				var div = $(this).closest('.acf_images_uploader');
				var post_id = $('input#post_ID').val();
				var preview_size = div.attr('data-preview_size');
				
				// set global var
				window.acf_div = div;
					
				// show the thickbox
				tb_show('Add Images to field', 'media-upload.php?post_id=' + post_id + '&type=image&acf_type=images&acf_preview_size=' + preview_size + 'TB_iframe=1');
			
				return false;
			});
				
			$('#poststuff .acf_images_uploader .remove_image').live('click', function(){
				
				// vars
				var div = $(this).closest('.acf_images_uploader'),
					values = div.find('input.value').val().split(',');
					index = div.find('.image').index($(this).closest('.image'));
								
				// remove clicked image from DOM
				$(this).closest('.image').remove();
				
				// hide empty container
				if (div.find('.image').length === 0) {
					div.removeClass('active');
				}
				
				// remove clicked image from array 
				values.splice(index, 1);
				values.join();
				
				// update input				
				div.find('input.value').val(values)
								
				return false;
				
			});
			 
			function updateImagesOrder(event, ui) {
			
				// vars 
				var div = $(ui.item).closest('.acf_images_uploader'),
					imagesCollection = div.find('.image'),
					values = [];
				
				// grab all IDs from the new sort order
				imagesCollection.each(function() {
					values.push($(this).attr('data-id'));
				})
				values.join();
				
				// update input	
				div.find('input.value').val(values)
				
				return true;
				
			};
			
			// wait until jQuery UI is available
			$(document).ready(function imagesSortable() {
			
				$('#poststuff .acf_images_uploader .images').sortable({
					update: updateImagesOrder,
					containment: 'parent',
					cursor: 'move'
				});
			
			});
			
		})(jQuery);
		
		</script>
		<?php
	}
	
	
	/*--------------------------------------------------------------------------------------
	*
	*	create_field
	*
	*	@author Elliot Condon
	*	@since 2.0.5
	*	@updated 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function create_field($field)
	{
		// vars
		$class = "";
		$file_src = ""; 
		$preview_size = isset($field['preview_size']) ? $field['preview_size'] : 'medium';
		
		// get images
		if($field['value'] != '' )
		{
			$files = explode(',', $field['value']);
			if($files) $class = "active";
		}
		// html
		echo '<div class="acf_images_uploader ' . $class . '" data-preview_size="' . $preview_size . '">';
		
		// display existing images
		echo '<div class="images">'; 
		if ($files) {
			foreach ($files as $file) {
				$file_src = wp_get_attachment_image_src($file, $preview_size);
				echo '<div class="image" data-id="' . $file . '">';
				echo '<a href="#" class="remove_image"></a>';
				echo '<img src="' . $file_src[0] . '" alt="Image" />';
				echo '</div>';	
			}
		}
		echo '</div>';
		
		echo '<p class="acf_add_images"><span>'.__('No images selected','acf').'. </span><input type="button" class="button" value="'.__('Add Images','acf').'" /></p>';
	
		echo '<input class="value" type="hidden" name="' . $field['name'] . '" value="' . $field['value'] . '" />';
		echo '</div>';
	}
	
	
	/*--------------------------------------------------------------------------------------
	*
	*	create_options
	*
	*	@author Elliot Condon
	*	@since 2.0.6
	*	@updated 2.2.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function create_options($key, $field)
	{	
		// vars
		$field['save_format'] = isset($field['save_format']) ? $field['save_format'] : 'url';
		$field['preview_size'] = isset($field['preview_size']) ? $field['preview_size'] : 'thumbnail';
		
		?>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Return Value",'acf'); ?></label>
			</td>
			<td>
				<?php 
				$this->parent->create_field(array(
					'type'	=>	'radio',
					'name'	=>	'fields['.$key.'][save_format]',
					'value'	=>	$field['save_format'],
					'layout'	=>	'horizontal',
					'choices' => array(
						'url'	=>	'Image URL',
						'id'	=>	'Attachment ID'
					)
				));
				?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Preview Size",'acf'); ?></label>
			</td>
			<td>
				<?php 
				$this->parent->create_field(array(
					'type'	=>	'radio',
					'name'	=>	'fields['.$key.'][preview_size]',
					'value'	=>	$field['preview_size'],
					'layout'	=>	'horizontal',
					'choices' => array(
						'thumbnail'	=>	'Thumbnail',
						'medium'	=>	'Medium',
						'large'		=>	'Large',
						'full'		=>	'Full'
					)
				));
				?>
			</td>
		</tr>

		<?php
	}


	 
	/*---------------------------------------------------------------------------------------------
	 * popup_head - STYLES MEDIA THICKBOX
	 *
	 * @author Elliot Condon
	 * @since 1.1.4
	 * 
	 ---------------------------------------------------------------------------------------------*/
	function popup_head()
	{
		if(isset($_GET["acf_type"]) && $_GET['acf_type'] == 'images')
		{
			$preview_size = isset($arr_postinfo['preview_size']) ? $arr_postinfo['preview_size'] : 'medium';
			
			?>
			<style type="text/css">
				#media-upload-header #sidemenu li#tab-type_url,
				#media-upload-header #sidemenu li#tab-gallery {
					display: none;
				}
				
				#media-items tr.url,
				#media-items tr.align,
				#media-items tr.image_alt,
				#media-items tr.image-size,
				#media-items tr.post_excerpt,
				#media-items tr.post_content,
				#media-items tr.image_alt p,
				#media-items table thead input.button,
				#media-items table thead img.imgedit-wait-spin,
				#media-items tr.submit a.wp-post-thumbnail {
					display: none;
				} 

				.media-item table thead img {
					border: #DFDFDF solid 1px; 
					margin-right: 10px;
				}

			</style>
			<script type="text/javascript">
			(function($){
			
				$(document).ready(function(){
				
					$('#media-items').bind('DOMNodeInserted',function(){
						$('input[value="Insert into Post"]').each(function(){
							$(this).attr('value','<?php _e("Select Image",'acf'); ?>');
						});
					}).trigger('DOMNodeInserted');
					
					$('form#filter').each(function(){
						
						$(this).append('<input type="hidden" name="acf_preview_size" value="<?php echo $preview_size; ?>" />');
						$(this).append('<input type="hidden" name="acf_type" value="images" />');
						
					});
				});
							
			})(jQuery);
			</script>
			<?php
		}
	}
	
	
	/*---------------------------------------------------------------------------------------------
	 * media_send_to_editor - SEND IMAGE TO ACF DIV
	 *
	 * @author Elliot Condon
	 * @since 1.1.4
	 * 
	 ---------------------------------------------------------------------------------------------*/
	 
	function media_send_to_editor($html, $id)
	{
		parse_str($_POST["_wp_http_referer"], $arr_postinfo);
		
		if(isset($arr_postinfo["acf_type"]) && $arr_postinfo["acf_type"] == "images")
		{
			
			$preview_size = isset($arr_postinfo['acf_preview_size']) ? $arr_postinfo['acf_preview_size'] : 'medium';
			
			$file_src = wp_get_attachment_image_src($id, $preview_size);
			$file_src = $file_src[0];
		
			?>
			<script type="text/javascript">
				
				self.parent.acf_div.find('input.value').val(function(i, val) { 

					// seperate IDs by comma. 
					var sep = (val === '') ? '' : ',';
					return val + sep + '<?php echo $id; ?>'
					
				});
				
			 	self.parent.acf_div.find('.acf_add_images').before('<div class="image" data-id="<?php echo $id; ?>"><a href="#" class="remove_image"></a><img src="<?php echo $file_src; ?>" alt="Image" /></div>');
			 	
			 	self.parent.acf_div.addClass('active');
			 	
			 	// reset acf_div and return false
			 	self.parent.acf_div = null;
			 	self.parent.tb_remove();
				
			</script>
			<?php
			exit;
		} 
		else 
		{
			return $html;
		}

	}
	

	/*--------------------------------------------------------------------------------------
	*
	*	get_value_for_api
	*
	*	@author Elliot Condon
	*	@since 3.0.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function get_value_for_api($post_id, $field)
	{
		// vars
		$format = isset($field['save_format']) ? $field['save_format'] : 'url';
		$value = parent::get_value($post_id, $field);
		$return = false;
		
		if(!$value || $value == "")
		{
			return $return;
		}
		
		$value = explode(',', $value);
		
		if($format == 'url')
		{
			if(is_array($value))
			{
				$return = array();
				foreach($value as $v)
				{
					$return[] = wp_get_attachment_url($v);
				}
			}
			else
			{
				$return = array(wp_get_attachment_url($value));
			}
		}
		else {
			if(is_array($value))
			{
				$return = $value;
			}
			else
			{
				$return = array($value);
			}
		}
		return $return;
		
	}

	
	
		
}

?>