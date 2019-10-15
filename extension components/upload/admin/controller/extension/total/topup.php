<?php
class ControllerExtensionTotalTopup extends Controller {

	public function index() {
		$this->load->language('extension/total/topup');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/topup');

		$this->getList();
	}

	public function listHistory() {
		$this->load->language('extension/total/topup');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/topup');

		$this->getListHistory();
	}

	public function add() {
		$this->load->language('extension/total/topup');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/topup');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') /*&& $this->validateForm()*/ {
			$this->model_extension_module_topup->addTopup($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('extension/total/topup');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/topup');
		//print_r($this->request->get['topup_id']);

		if ($this->request->server['REQUEST_METHOD'] == 'POST') /*&& /*$this->validateForm()*/ {
			$this->model_extension_module_topup->updateTopup($this->request->get['topup_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('extension/total/topup');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/topup');

		if (isset($this->request->post['selected']) /*&& $this->validateDelete()*/) {
			foreach ($this->request->post['selected'] as $topup_id) {
				$this->model_extension_module_topup->deleteTopup($topup_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['topup_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->request->get['voucher_id'])) {
			$data['voucher_id'] = $this->request->get['voucher_id'];
		} else {
			$data['voucher_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}

		if (isset($this->error['from_name'])) {
			$data['error_from_name'] = $this->error['from_name'];
		} else {
			$data['error_from_name'] = '';
		}

		if (isset($this->error['from_email'])) {
			$data['error_from_email'] = $this->error['from_email'];
		} else {
			$data['error_from_email'] = '';
		}

		if (isset($this->error['to_name'])) {
			$data['error_to_name'] = $this->error['to_name'];
		} else {
			$data['error_to_name'] = '';
		}

		if (isset($this->error['to_email'])) {
			$data['error_to_email'] = $this->error['to_email'];
		} else {
			$data['error_to_email'] = '';
		}

		if (isset($this->error['amount'])) {
			$data['error_amount'] = $this->error['amount'];
		} else {
			$data['error_amount'] = '';
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

		if (!isset($this->request->get['topup_id'])) {
			$data['action'] = $this->url->link('extension/total/topup/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/total/topup/edit', 'user_token=' . $this->session->data['user_token'] . '&topup_id=' . $this->request->get['topup_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['topup_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
			$topup_info = $this->model_extension_module_topup->getTopupById($this->request->get['topup_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['code'])) {
			$data['code'] = $this->request->post['code'];
		} elseif (!empty($topup_info)) {
			$data['code'] = $topup_info['code'];
		} else {
			$data['code'] = '';
		}

		if (isset($this->request->post['customer_id'])) {
			$data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($topup_info)) {
			$data['customer_id'] = $topup_info['customer_id'];
		} else {
			$data['customer_id'] = '';
		}

		// if (isset($this->request->post['from_email'])) {
		// 	$data['from_email'] = $this->request->post['from_email'];
		// } elseif (!empty($topup_info)) {
		// 	$data['from_email'] = $topup_info['from_email'];
		// } else {
		// 	$data['from_email'] = '';
		// }

		// if (isset($this->request->post['to_name'])) {
		// 	$data['to_name'] = $this->request->post['to_name'];
		// } elseif (!empty($topup_info)) {
		// 	$data['to_name'] = $topup_info['to_name'];
		// } else {
		// 	$data['to_name'] = '';
		// }

		// if (isset($this->request->post['to_email'])) {
		// 	$data['to_email'] = $this->request->post['to_email'];
		// } elseif (!empty($topup_info)) {
		// 	$data['to_email'] = $topup_info['to_email'];
		// } else {
		// 	$data['to_email'] = '';
		// }

		// $this->load->model('extension/total/topup_theme');

		// $data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

		// if (isset($this->request->post['voucher_theme_id'])) {
		// 	$data['voucher_theme_id'] = $this->request->post['voucher_theme_id'];
		// } elseif (!empty($topup_info)) {
		// 	$data['voucher_theme_id'] = $topup_info['voucher_theme_id'];
		// } else {
		// 	$data['voucher_theme_id'] = '';
		// }

		// if (isset($this->request->post['message'])) {
		// 	$data['message'] = $this->request->post['message'];
		// } elseif (!empty($topup_info)) {
		// 	$data['message'] = $topup_info['message'];
		// } else {
		// 	$data['message'] = '';
		// }

		if (isset($this->request->post['amount'])) {
			$data['amount'] = $this->request->post['amount'];
		} elseif (!empty($topup_info)) {
			$data['amount'] = $topup_info['amount'];
		} else {
			$data['amount'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($topup_info)) {
			$data['status'] = $topup_info['status'];
		} else {
			$data['status'] = true;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/total/topup_form', $data));
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'v.date_added';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
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
		$data['route_topup_history'] = $this->url->link('extension/total/topup/listHistory', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['vouchers'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		//$voucher_total = $this->model_extension_module_topup->getTotalVouchers();

		$results = $this->model_extension_module_topup->getAllTopups();

		foreach ($results as $result) {
			// if ($result['order_id']) {	
			// 	$order_href = $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $result['order_id'] . $url, true);
			// } else {
			// 	$order_href = '';
			// }
			
			$data['vouchers'][] = array(
				'topup_id' => $result['topup_id'],
				'code'       => $result['code'],
				'customer_id'       => $result['customer_id'],
				'updated_date'         => date($this->language->get('date_format_short'), strtotime($result['updated_date'])),
				//'theme'      => $result['theme'],
				'amount'     => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'created_date' => date($this->language->get('date_format_short'), strtotime($result['created_date'])),
				'edit'       => $this->url->link('extension/total/topup/edit', 'user_token=' . $this->session->data['user_token'] . '&topup_id=' . $result['topup_id'] . $url, true)
				//'order'      => $order_href
			);
		}

		$data['user_token'] = $this->session->data['user_token'];

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

		$data['sort_code'] = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . '&sort=v.code' . $url, true);
		$data['sort_from'] = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . '&sort=v.from_name' . $url, true);
		$data['sort_to'] = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . '&sort=v.to_name' . $url, true);
		$data['sort_theme'] = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . '&sort=theme' . $url, true);
		$data['sort_amount'] = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . '&sort=v.amount' . $url, true);
		$data['sort_status'] = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . '&sort=v.status' . $url, true);
		$data['sort_date_added'] = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . '&sort=v.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		//$pagination->total = $voucher_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		//$data['results'] = sprintf($this->language->get('text_pagination'), ($voucher_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($voucher_total - $this->config->get('config_limit_admin'))) ? $voucher_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $voucher_total, ceil($voucher_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/total/topup_list', $data));
	}

	protected function getListHistory() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'v.date_added';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
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

		$data['breadcrumbs'][] = array(
			'text' => 'Topup History',
			'href' => $this->url->link('extension/total/topup/listhistory', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('extension/total/topup/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/total/topup/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['history'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		//$voucher_total = $this->model_extension_module_topup->getTotalVouchers();

		$results = $this->model_extension_module_topup->getAllTopupHistories();

		foreach ($results as $result) {
			// if ($result['order_id']) {	
			// 	$order_href = $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $result['order_id'] . $url, true);
			// } else {
			// 	$order_href = '';
			// }
			
			$data['history'][] = array(
				'topup_history__id'	    => $result['topup_history_id'],
				'topup_id'       	=> $result['topup_id'],
				'created_by'   => $result['created_by'],
				'transaction_reference'  => $result['transaction_reference'],
				//'theme'      => $result['theme'],
				'amount'        => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'mode'     	=> $result['mode'],
				'created_date'  => date($this->language->get('date_format_short'), strtotime($result['created_date'])),
				//'edit'       	=> $this->url->link('extension/total/topup/edit', 'user_token=' . $this->session->data['user_token'] . '&topup_id=' . $result['topup_history_id'] . $url, true)
				//'order'      => $order_href
			);
		}

		$data['user_token'] = $this->session->data['user_token'];

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

		$data['sort_code'] = $this->url->link('extension/total/topup/listhistory', 'user_token=' . $this->session->data['user_token'] . '&sort=v.code' . $url, true);
		$data['sort_from'] = $this->url->link('extension/total/topup/listhistory', 'user_token=' . $this->session->data['user_token'] . '&sort=v.from_name' . $url, true);
		$data['sort_to'] = $this->url->link('extension/total/topup/listhistory', 'user_token=' . $this->session->data['user_token'] . '&sort=v.to_name' . $url, true);
		$data['sort_theme'] = $this->url->link('extension/total/topup/listhistory', 'user_token=' . $this->session->data['user_token'] . '&sort=theme' . $url, true);
		$data['sort_amount'] = $this->url->link('extension/total/topup/listhistory', 'user_token=' . $this->session->data['user_token'] . '&sort=v.amount' . $url, true);
		$data['sort_status'] = $this->url->link('extension/total/topup/listhistory', 'user_token=' . $this->session->data['user_token'] . '&sort=v.status' . $url, true);
		$data['sort_date_added'] = $this->url->link('extension/total/topup/listhistory', 'user_token=' . $this->session->data['user_token'] . '&sort=v.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		//$pagination->total = $voucher_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/total/topup', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		//$data['results'] = sprintf($this->language->get('text_pagination'), ($voucher_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($voucher_total - $this->config->get('config_limit_admin'))) ? $voucher_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $voucher_total, ceil($voucher_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/total/topup_history', $data));
	}

	public function install(){
		$this->load->model('extension/module/topup');
        $this->model_extension_module_topup->installDatabase();        
	}

	public function uninstall() {
    
        $this->load->model('extension/module/topup');
        $this->model_extension_module_topup->uninstallDatabase(); 
	}
}