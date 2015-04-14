<?php
class CmsController extends Controller implements IController {
	public $model;
	private $config;
	private $sessions;

	public function __construct($config) {
		$this->load_model('cmsmodel');
		$this->model = new CmsModel();
		$this->config = $config;
	}
	private function get_header() {
		$data = $this->config;
		$data += $this->model->get_menu();
		$data['head'] = array();
		$data['footer_js'] = array();
		$this->sessions = $_SESSION;
		if (isset($_SESSION['success'])) {
			$data['success'] = $_SESSION['success'];
			unset($_SESSION['success']);
		} elseif (isset($_SESSION['errors'])) {
			$data['errors'] = $_SESSION['errors'];
			unset($_SESSION['errors']);
		}
		return $data;
	}

	public function index($request_url = null) {
		$post_id = 0;
		$type = 'start';
		$data = $this->get_header();

		if ($request_url != null) {
			$category_id = $this->model->get_category_id($request_url);
			if ($category_id > 0) {
				$posts = $this->model->get_posts(0, $category_id);
				$this->insert_plugin_in_posts_array_and_update_header_and_footer($posts, $data['head'], $data['footer_js']);
				$data = array_merge($data, $posts);
				$type = 'category';
			} else {
				$post_id = $this->model->get_post_id($request_url);
				if ($post_id == 0) {
					$this->redirect(404);
				} else if ($post_id == $this->config['start_content']) {
					$this->redirect(301, '/');
				} elseif ($post_id > 0) {
					$post = $this->model->get_post($post_id);
					$this->insert_plugin_in_post_and_update_header_and_footer($post, $data['head'], $data['footer_js']);
					$data = array_merge($data, $post);
					$type = 'post';
				}
			}
		} elseif (is_numeric($this->config['start_content']) && $this->config['start_content'] > 0) {
			$post = $this->model->get_post($this->config['start_content']);
			$this->insert_plugin_in_post_and_update_header_and_footer($post, $data['head'], $data['footer_js']);
			$data = array_merge($data, $post);
		} elseif (strncasecmp($this->config['start_content'], 'latest', 6) == 0) {
			$posts = $this->model->get_posts(substr($this->config['start_content'], 6));
			$this->insert_plugin_in_posts_array_and_update_header_and_footer($posts, $data['head'], $data['footer_js']);
			$data = array_merge($data, $posts);
		} else {
			$posts = $this->model->get_posts();
			$this->insert_plugin_in_posts_array_and_update_header_and_footer($posts, $data['head'], $data['footer_js']);
			$data = array_merge($data, $posts);
		}
		$data['request_url'] = $this->config['request_url'];
		$regions = $this->model->get_regions();
		foreach ($regions['regions'] as $name => $reg_array) {
			$pluginified_array = $this->replace_and_insert_plugin($reg_array['region_text'], $this->sessions);
			$regions['regions'][$name]['region_text'] = $pluginified_array['text'];
			if (isset($pluginified_array['css'])) {
				$data['head'] = array_merge($data['head'], $pluginified_array['css']);
			}
			if (isset($pluginified_post_array['js'])) {
				$data['footer_js'] = array_merge($data['footer_js'], $pluginified_array['js']);
			}
		}

		$data += $regions;
		$this->load_theme($this->config['theme'], $data, $type);
	}

	// call by reference
	private function insert_plugin_in_posts_array_and_update_header_and_footer(&$posts, &$head, &$footer_js) {
		foreach ($posts['posts'] as &$post) {
			$this->insert_plugin_in_post_and_update_header_and_footer($post, $head, $footer_js);
		}
		return $posts;
	}

	// call by reference
	private function insert_plugin_in_post_and_update_header_and_footer(&$post, &$head, &$footer_js) {
		$pluginified_post_array = $this->replace_and_insert_plugin($post['post_content'], $this->sessions);
		$post['post_content'] = $pluginified_post_array['text'];
		if (isset($pluginified_post_array['css'])) {
			$head = array_merge($head, $pluginified_post_array['css']);
		}
		if (isset($pluginified_post_array['js'])) {
			$footer_js = array_merge($footer_js, $pluginified_post_array['js']);
		}
	}
}
?>
