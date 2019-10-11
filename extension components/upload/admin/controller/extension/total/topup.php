<?php
class ControllerExtensionTotalTopup extends Controller {

	public function index() {
		$this->load->language('extension/total/topup');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/total/topup');

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'c.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('extension/total/topup/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/total/topup/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		// $data['zones'] = array();

		// $filter_data = array(
		// 	'sort'  => $sort,
		// 	'order' => $order,
		// 	'start' => ($page - 1) * $this->config->get('config_limit_admin'),
		// 	'limit' => $this->config->get('config_limit_admin')
		// );

		// $zone_total = $this->model_localisation_zone->getTotalZones();

		// $results = $this->model_localisation_zone->getZones($filter_data);

		// foreach ($results as $result) {
		// 	$data['zones'][] = array(
		// 		'zone_id' => $result['zone_id'],
		// 		'country' => $result['country'],
		// 		'name'    => $result['name'] . (($result['zone_id'] == $this->config->get('config_zone_id')) ? $this->language->get('text_default') : null),
		// 		'code'    => $result['code'],
		// 		'edit'    => $this->url->link('extension/total/topup/edit', 'user_token=' . $this->session->data['user_token'] . '&zone_id=' . $result['zone_id'] . $url, true)
		// 	);
		// }

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_country'] = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . '&sort=c.name' . $url, true);
		$data['sort_name'] = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . '&sort=z.name' . $url, true);
		$data['sort_code'] = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . '&sort=z.code' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		//$pagination->total = $zone_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/total/topup_list', $data));
	}

	public function install(){
		$this->load->model('extension/total/topup');
        $this->model_extension_total_topup->installDatabase();        
	}

	public function uninstall() {
    
        $this->load->model('extension/total/topup');
        $this->model_extension_total_topup->uninstallDatabase(); 
	}
}