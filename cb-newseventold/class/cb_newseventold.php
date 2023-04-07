<?php

class CB_Newseventold{
	private $dir;
	private $assets_dir;
	private $assets_url;
	private $token;
	private $file;

	/**
	 * Constructor function.
	 * 
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function __construct( $file ) {
		
		// add name to the taxonomy
		$this->postPlaceholder = "OLd News Adn Events";
		// add slug for post and taxonomy
		$this->postSlug = "newseventold";					
		// add editor name in array like 'title', 'editor', 'thumbnail','excerpt'
		$this->addEditors = array('title', 'editor', 'thumbnail','excerpt');
		$this->dir = dirname( $file );
		$this->file = $file;
		$this->version = '1.1';
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $file ) ) );	
		$this->addHooks();
	}

	/**
	 * Default options
	 * 
	 * @access private
	 * @return array
	 */
	private function getDefaultOptions(){
		return array();
	}

	/**
	 * Get Options
	 * 
	 * @access private
	 * @return array
	 */
	private function getOptions(){
		return get_option("cb_".$this->postSlug, $this->getDefaultOptions());
	}

	/**
	 * Convert item options to string
	 * 
	 * @access private
	 * @return string
	 */
	private function itemsOptionsToString($options){
		return implode(', ', $options);
	}


	/**
	 * Register various hooks
	 * 
	 * @access private
	 * @return void
	 */
	private function addHooks(){
		
		//Plugin Activation
		register_activation_hook($this->file, array(&$this, 'hookActivation'));
		
		//Plugin Deactivation
		register_deactivation_hook($this->file, array(&$this, 'hookDeactivation'));

		//WP Init
		add_action('init', array(&$this, 'hookRegisterPostType'));

		if ( is_admin() ) {

			add_action('admin_menu', array(&$this, 'hookAdminMenu'), 20);
			add_action('admin_print_styles', array(&$this, 'hookAdminPrintStyles'), 10);

			add_filter('enter_title_here', array(&$this, 'hookEnterTitleHere'));

		}

	}

	/**
	 * Hook: init
	 * 
	 * register post type
	 *
	 * @access public
	 * @return void
	 */
	public function hookRegisterPostType(){

		$labels = array(
			'name' => $this->postPlaceholder,
			'singular_name' => $this->postPlaceholder,
			'add_new' => 'Add '.$this->postPlaceholder,
			'add_new_item' => 'Add New '.$this->postPlaceholder,
			'edit_item' => 'Edit '.$this->postPlaceholder,
			'new_item' => 'New '.$this->postPlaceholder,
			'all_items' => 'All '.$this->postPlaceholder,
			'view_item' => 'View '.$this->postPlaceholder,
			'search_items' => 'Search '.$this->postPlaceholder,
			'not_found' =>  'No  found'.$this->postPlaceholder,
			'not_found_in_trash' => 'No found in trash'.$this->postPlaceholder,
			'parent_item_colon' => '',
			'menu_name' => $this->postPlaceholder
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => $this->postSlug ),
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => true,
			'supports' => $this->addEditors,
			'menu_position' => 45,
		);

		register_post_type( "cb_".$this->postSlug, $args);

		register_taxonomy(
			$this->postSlug."_type" ,
			 "cb_".$this->postSlug,
			array(
				'label' => 'Add '.$this->postPlaceholder.' Types',
				'rewrite' => array('slug' => $this->postSlug."_type"),
				'hierarchical' => true,
				'public' => true,
				'show_ui' => true
			)
		);
	}

	/**
	 * Hook: enter_title_here
	 * 
	 * register post type
	 *
	 * @access public
	 * @return void
	 */
	public function hookEnterTitleHere($title){
		$screen = get_current_screen();

		if(  "cb_".$this->postSlug == $screen->post_type ) {
			$title = 'Enter'.$this->postPlaceholder.'Here';
		}

		return $title;
	}

	/**
	 * Hook: admin_print_styles
	 * 
	 * @access public
	 * @return void
	 */
	public function hookAdminPrintStyles(){
		wp_register_style("cb_".$this->postSlug.'-admin', $this->assets_url.'/css/admin.css', array(), $this->version);
		wp_enqueue_style("cb_".$this->postSlug.'-admin');
	}

	/**
	 * Hook: admin_menu
	 * 
	 * @access public
	 * @return void
	 */
	public function hookAdminMenu(){
	}

	/**
	 * Hook: register_activation_hook
	 * 
	 * @access public
	 * @return void
	 */
	public function hookActivation(){
		update_option("cb_".$this->postSlug, $this->getDefaultOptions());
	}

	/**
	 * Hook: register_deactivation_hook
	 * 
	 * @access public
	 * @return void
	 */
	public function hookDeactivation(){
		delete_option("cb_".$this->postSlug);
	}

}

?>

<style>
	.acf-field.acf-field-date-picker {display: inline-block;width: 49%;}
	
</style>