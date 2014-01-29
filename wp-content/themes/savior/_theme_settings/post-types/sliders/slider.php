<?php
define('SLIDER_CACHE_DIR', dirname(__FILE__) . '/cache');

function timthumb_writable_folder() {
	$message = '<strong>Warning!</strong> You need to make the &ldquo;Timthumb Cache&rdquo; folder writable before the slider images will work properly.<br /><strong>Location:</strong> '.SLIDER_CACHE_DIR;
	echo '<div class="message updated"><p>' . $message . '</p></div>';
}

if (!is_writable(SLIDER_CACHE_DIR)) {
	if (is_admin()) {
		add_action('admin_notices', 'timthumb_writable_folder');
	}
	return;
}

# Use a class as a namespace to prevent conflicts
class CustomSlider {
	var $settings,
		$url,
		$post_id;

	static $registed_post_types = array();

	/*
		Default settings - may be changed when creating an instance of the class.
		See the class constructor.
	*/
	var $defaults = array(
		'post_type_name'     => 'custom-slider',
		'post_type_settings' => array(),
		'strings'            => array(
			'no-title' => 'Slide Title Goes Here'
		),
		'animations'         => array('random', 'fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInRight', 'bounceIn', 'bounceInDown', 'bounceInUp', 'bounceInLeft', 'bounceInRight', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'fadeInLeftBig', 'fadeInRightBig', 'fadeInUpBig', 'fadeInDownBig', 'flipInX', 'flipInY', 'lightSpeedIn')
	);

	/*
		Init the slider functionality

		The $args array lets you change certain settings.
		Look at the $default_settings array before to see the keys.
	*/
	function __construct($args = null) {
		# Replace the additional settings if provided
		if(is_array($args)) {
			$this->settings = $this->defaults + $args;
		} else {
			$this->settings = $this->defaults;
		}

		if(isset(self::$registed_post_types[$this->settings['post_type_name']])) {
			wp_die('Trying to register a post type twice!');
		} else {
			array_push(self::$registed_post_types, $this->settings['post_type_name']);
		}

		# Add actions that will be performed later
		add_action('after_setup_theme',               array($this, 'register_post_type'));
		add_action('add_meta_boxes',     array($this, 'attach_metaboxes'));
		add_action('save_post',          array($this, 'save'));
		add_action('init',               array($this, 'enqueue_scripts_styles'));
		add_action('wp_ajax_cs_img_add', array($this, 'ajax_upload'));
		add_action('admin_footer',       array($this, 'plupload_settings'));

		# Prepare the location of the slider's folder to enable movement accross folders
		$path = dirname(__FILE__);
		$path = str_replace('\\', '/', $path);
		$path = str_replace(str_replace('\\', '/', ABSPATH), '', $path);
		$path = trailingslashit(site_url()) . $path;
		$path = trailingslashit($path);

		$this->url = $path;
	}

	/*
		Registers the slider post type.

		If you need to change the post type's settings, pass the changes as an item of the $args array on initialization
	*/
	function register_post_type() {
		$args = array(
			'labels' => array(
				'name'               => __('Sliders','savior'),
				'singular_name'      => __('Slider','savior'),
				'add_new'            => __('Add New','savior'),
				'add_new_item'       => __('Add new Slider','savior'),
				'view_item'          => __('View Slider','savior'),
				'edit_item'          => __('Edit Slider','savior'),
				'new_item'           => __('New Slider','savior'),
				'view_item'          => __('View Slider','savior'),
				'search_items'       => __('Search Sliders','savior'),
				'not_found'          => __('No Sliders found','savior'),
				'not_found_in_trash' => __('No Sliders found in Trash','savior'),
			),
			'public'        => false,
			'show_ui'       => true,
			'hierarchical'  => true,
			'supports'      => array('title'),
			'menu_icon'     => $this->url . 'images/pt_icon.png',
			'menu_position' => '25.3',
		);

		$args += $this->settings['post_type_settings'];

		register_post_type(
			$this->settings['post_type_name'],
			$args
		);		
	}

	/*
		Sorts an array of items by given order
	*/
	function order_items($items, $order) {
		$ordered = array();
		$order = explode(',', $order);

		foreach($order as $o) {
			if(strpos($o, 'prototype') !== false || $o == '%d%' || $o == '%e%') {
				continue;
			}

			if(isset($items[$o])) {
				if(isset($items[$o]['items_order'])) {
					$item = $items[$o];
					$item['items'] = $this->order_items($item['items'], $item['items_order']);
					$ordered[] = $item;
				} else {
					$ordered[] = $items[$o];					
				}
			}
		}

		return $ordered;
	}

	/*
		Adds slashes recursively
	*/
	function add_slashes($item) {
		if(is_array($item)) {
			$done = array();
			foreach($item as $key => $val) {
				$done[$key] = $this->add_slashes($val);
			}
			return $done;
		} elseif(is_string($item)) {
			return addslashes($item);
		} else {
			return $item;
		}
	}

	/*
		Saves the values if there are ones given
	*/
	function save($post_id) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if(get_post_type($post_id) != $this->settings['post_type_name']) {
			return;
		}

		$fields = array('slider_type', 'slides', 'obo_slides');
		
		foreach($fields as $field) {
			if(isset($_POST[$field])) {
				$value = $_POST[$field];

				if(isset($_POST[$field . '_order'])) {
					$value = $this->order_items($value, $_POST[$field . '_order']);
				}

				update_post_meta($post_id, '_' . $field, $value);
			}
		}
	}

	/*
		Attach the meta boxes to the post type
	*/
	function attach_metaboxes() {
		add_meta_box(
			$this->settings['post_type_name'] . '-settings-box',
			'Slider Settings',
			array($this, 'display_main_box'),
			$this->settings['post_type_name'],
			'normal',
			'high'
		);

		add_meta_box(
			$this->settings['post_type_name'] . '-obo-box',
			'Add Slides',
			array($this, 'display_obo_box'),
			$this->settings['post_type_name'],
			'normal',
			'high'
		);

		add_meta_box(
			$this->settings['post_type_name'] . '-default-box',
			'Add Slides',
			array($this, 'display_default_box'),
			$this->settings['post_type_name'],
			'normal',
			'high'
		);
	}

	/*
		Displays the main metabox
	*/
	function display_main_box($post) {
		add_action('admin_footer', array($this, 'init_js'), 100);

		if($post->post_type == $this->settings['post_type_name']) {
			$current = get_post_meta($post->ID, '_slider_type', true);
		} else {
			$current = '';
		}

		$options = array(
			'one-by-one'    => 'One-by-one Slider',
			'full-width'    => 'Full Width (Under Header)',
			'behind-header' => 'Full Width (Behind Header)'
		);

		include('tpls/main-box.php');
	}

	/*
		Displays the One-by-one Slides Box
	*/
	function display_obo_box($post) {
		$this->post_id = $_REQUEST['post_id'] = $post->ID;

		$subitem_props = array(
			'title'     => '',
			'top'       => '0',
			'left'      => '0',
			'animation' => 'random',
			'prototype' => true
		);

		$prototype = array(
			'title'     => '',
			'prototype' => '',

			'items' => array(
				'prototype-0' => $subitem_props + array(
					'type'        => 'text',
					'button_text' => '',
					'button_link' => '',
					'content'     => '',
					'width'       => '100'
				),
				'prototype-1' => $subitem_props + array(
					'type'        => 'image',
					'image_id'    => '',
				)
			),
		);

		$items = get_post_meta($post->ID, '_obo_slides', true);

		if(!$items || !is_array($items)) {
			$first_item = $prototype;
			unset($first_item['prototype']);

			$items = array($first_item);
		} else {
			$new_items = array();

			foreach($items as $item) {
				foreach($prototype['items'] as $sub) {
					$item['items'][] = $sub;
				}

				$new_items[] = $item;
			}

			$items = $new_items;
		}

		$items['prototype'] = $prototype;

		include('tpls/obo-box.php');
	}

	/*
		Displays the default slides box
	*/
	function display_default_box($post) {
		$this->post_id = $_REQUEST['post_id'] = $post->ID;

		$prototype = array(
			'title'        => '',
			'image_id'     => '',
			'content'     => '',
			'button_text' => '',
			'button_link' => '',
			'prototype'   => true
		);

		$items = get_post_meta($post->ID, '_slides', true);

		if(!$items || !is_array($items)) {
			$first_item = $prototype;
			unset($first_item['prototype']);

			$items = array($first_item);
		}

		$items['prototype'] = $prototype;

		include('tpls/default-box.php');
	}

	/*
		Renders a <select>
	*/
	function render_selectbox($name, array $options, $current = null) {
		$inner_HTML = '';

		foreach($options as $value => $label) {
			$selected = $value == $current ? ' selected="selected"' : '';

			$inner_HTML .= sprintf(
				'<option value="%s"%s>%s</option>',
				esc_attr($value),
				$selected,
				esc_html($label)
			);
		}

		return sprintf(
			'<select name="%s" id="%s">%s</select>',
			esc_attr($name),
			esc_attr(sanitize_title($name)),
			$inner_HTML
		);
	}

	/*
		Renders a text <input>
	*/
	function render_field($name, $value, $placeholder=null, $class=null) {
		return sprintf(
			'<input type="text" name="%s" id="%s" value="%s" placeholder="%s" class="%s" />',
			esc_attr($name),
			esc_attr(sanitize_title($name)),
			esc_attr($value),
			esc_attr($placeholder),
			esc_attr($class)
		);
	}

	/*
		Prepare an item URL for specified size
	*/
	function get_thumb($src, $w, $h=0, $zc=1) {
		$url = $this->url . 'timthumb.php?src=' . urlencode( get_absolute_file_url( $src ) ) . '&w=' . $w;

		if($h) {
			$url .= "&h=$h";
		}

		$url .= '&zc=1';

		return $url;
	}

	/*
		Links neccessary scripts
	*/
	function enqueue_scripts_styles() {
		wp_enqueue_script('jquery');

		if(is_admin()) {
			wp_enqueue_script('jquery-ui-sortable');

			wp_enqueue_script('plupload');
			wp_enqueue_script('plupload-html5');
			wp_enqueue_script('plupload-flash');
			wp_enqueue_script('plupload-silverlight');
			wp_enqueue_script('plupload-html4');

			wp_enqueue_script('custom-slider-settings', $this->url . 'js/main.js');

			wp_enqueue_style('custom-slider-style', $this->url . 'style.css');
		}
	}

	/*
		Inits the scripts for the current boxes
	*/
	function init_js() { ?>
		<script type="text/javascript">
		jQuery(function() {
			init_slider_settings('<?php echo $this->settings["post_type_name"] ?>', '<?php echo $this->url ?>');
		});
		</script>
	<?php }

	/*
		Collects upload data, creates an attachment and outputs it's info
	*/
	function ajax_upload() {
		# Collect filedata
		$target_dir = SLIDER_CACHE_DIR;
		$wp_upload_dir = wp_upload_dir();

		if(!isset($_POST['image_name'])) {
			echo json_encode(array(
				'success' => false,
				'error'   => 'No image name provided'
			));
			exit;
		}

		$image_name = preg_replace('/[^\w\._\-]+/', '_', $_POST['image_name']);
		$filename = $wp_upload_dir['path'] . '/' . $image_name;

		if( !file_exists($target_dir . '/' . $image_name) ) {
			echo json_encode(array(
				'success' => false,
				'error'   => 'File does not seem to exist'
			));

			die();
		}

		# Check extenstion
		$extenstion = array_pop(explode('.', $filename));
		$available  = array('jpg','jpeg','gif','png');
		if(!in_array($extenstion, $available)) {
			echo json_encode(array(
				'success' => false,
				'error'   => 'Invalid image extension'
			));
			die();			
		}

		# Set a new name for the file
		$rand = substr(md5(microtime()), 0, 10);
		$filename = str_replace($extenstion, $rand . '.' . $extenstion, $filename);

		# Copy the file, now that it's okay
		$original = $target_dir . '/' . $image_name;
		copy($original, $filename);

		# Check the post
		if(!isset($_POST['post_id'])) {
			echo json_encode(array(
				'success' => false,
				'error'   => 'No post ID set'
			));
			exit;
		}

		if( !get_post($_POST['post_id']) ) {
			echo json_encode(array(
				'success' => false,
				'error'   => 'There is no post with the given ID!'
			));
			exit;
		}

		# Try to insert an attachment
		$wp_filetype = wp_check_filetype(basename($filename), null );
		$attachment = array(
			'guid'           => $wp_upload_dir['baseurl'] . _wp_relative_upload_path( $filename ), 
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		$attach_id = wp_insert_attachment( $attachment, $filename, $_POST['post_id'] );

		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		# Check the new src of the image
		$src = wp_get_attachment_image_src($attach_id, 'full');
		$src = $src[0];

		# Output the result
		echo json_encode(array(
			'success'          => true,
			'image_id'         => $attach_id,
			'thumb_path'       => $this->get_thumb($src, 149, 87),
			'small_thumb_path' => $this->get_thumb($src, 79, 87)
		));

		unlink($original);

		die();
	}

	/*
		Outputs PLUpload data in the footer
	*/
	function plupload_settings() {
		$plupload_init = array(
			'runtimes'            => 'html5,silverlight,flash,html4',
			'max_file_size'       => '10mb',
			'url'                 => $this->url . 'upload.php',
			'flash_swf_url'       => includes_url('js/plupload/plupload.flash.swf'),
			'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
			'filters'             => array( array('title' => __( 'Allowed Files','savior' ), 'extensions' => 'jpg,jpeg,gif,png') )
		);

		?>
		<script type="text/javascript">
		cs_plupload_settings = '<?php echo json_encode($plupload_init) ?>';
		</script>
		<?php
	}
}

global $custom_slider;
$custom_slider = new CustomSlider();