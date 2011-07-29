<?

	class Testimonial_Statements extends Backend_Controller {
		public $implement = 'Db_ListBehavior, Db_FormBehavior';
		public $list_model_class;
		public $list_record_url;
		public $form_model_class;
		public $form_not_found_message;
		public $form_redirect;
		
		public $form_edit_save_flash = 'The record has been successfully saved';
		public $form_create_save_flash = 'The record has been successfully added';
		public $form_edit_delete_flash = 'The record has been successfully deleted';
		public $form_edit_save_auto_timestamp = true;
		
		public $list_search_enabled = true;
		public $list_search_fields;
		public $list_search_prompt;
		public $list_no_setup_link = false;
		public $list_no_interaction = false;
		public $list_no_sorting = false;
		public $list_columns = array();
		public $list_custom_body_cells;
		public $list_custom_head_cells;
		
		public $strings = array(
			'model_title' => 'Statement',
			'model_name' => 'statement',
			'model_code' => 'testimonial_statement',
			'model_class' => 'Testimonial_Statement',
			'controller_table_name' => 'testimonial_statements',
			'controller_code' => 'testimonial_statements',
			'controller_name' => 'statements',
			'controller_title' => 'Statements',
			'controller_url' => '/testimonial/statements',
			'controller_class' => 'Testimonial_Statements',
			'module_name' => 'testimonial',
			'module_title' => 'Testimonial Statements',
			'module_path' => '/modules/testimonial'
		);
		
		protected $required_permissions = array('testimonial:manage_statements');

		public function __construct() {
			$this->form_preview_title = "Testimonial Statements";
			$this->form_create_title = "New {$this->strings['model_title']}";
			$this->form_edit_title = "Edit {$this->strings['model_title']}";
			$this->form_model_class = $this->strings['model_class'];
			$this->list_model_class = $this->strings['model_class'];
			$this->form_not_found_message = 'Record not found';
			$this->list_search_fields = array('@title');
			$this->list_search_prompt = "find {$this->strings['model_name']} by title";
		
			parent::__construct();
			
			$this->app_tab = $this->strings['module_name'];
			$this->app_module_name = $this->strings['module_title'];
			$this->app_page = $this->strings['controller_table_name'];
			$this->list_record_url = url($this->strings['controller_url'] . '/edit/');
			$this->form_redirect = url($this->strings['controller_url'] . '/');

			if(Phpr::$router->action == 'reorder') {
				$this->list_record_url = null;
				$this->list_search_enabled = false;
				$this->list_no_interaction = true;
				$this->list_columns = array('title', 'slug', 'is_enabled');
				$this->list_custom_body_cells = PATH_APP . "{$this->strings['module_path']}/controllers/{$this->strings['controller_code']}/_body_cells.htm";
				$this->list_custom_head_cells = PATH_APP . "{$this->strings['module_path']}/controllers/{$this->strings['controller_code']}/_head_cells.htm";
			}
		}
		
		public function index() {
			$this->app_page_title = $this->strings['controller_title'];
		}
		
		public function reorder() {
			$this->app_page_title = "Manage {$this->strings['model_title']} Order";
		}
		
		public function listOverrideSortingColumn($sorting_column) {
			if(Phpr::$router->action === 'reorder') {
				$result = array('field' => 'sort_order', 'direction' => 'asc');
				
				return (object)$result;
			}

			return $sorting_column;
		}
		
		protected function reorder_onSetOrders() {
			try {
				Press_Article::set_orders(post('ids'), post('sort_orders'));
			}
			catch(Exception $ex) {
				Phpr::$response->ajaxReportException($ex, true, true);
			}
		}
	}