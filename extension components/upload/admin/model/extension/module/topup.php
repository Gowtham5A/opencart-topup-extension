<?php
class ModelExtensionModuleTopup extends Model {

	public function getAllTopups() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "topup` WHERE 1");
		return $query->rows;
	}

	public function getTopupByUserId($user_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "topup` WHERE customer_id = '" . (int)$user_id . "'");
		return $query->row;
	}

	// public function getVouchers($data = array()) {
	// 	$sql = "SELECT v.voucher_id, v.order_id, v.code, v.from_name, v.from_email, v.to_name, v.to_email, (SELECT vtd.name FROM " . DB_PREFIX . "voucher_theme_description vtd WHERE vtd.voucher_theme_id = v.voucher_theme_id AND vtd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS theme, v.amount, v.status, v.date_added FROM " . DB_PREFIX . "voucher v";

	// 	$sort_data = array(
	// 		'v.code',
	// 		'v.from_name',
	// 		'v.to_name',
	// 		'theme',
	// 		'v.amount',
	// 		'v.status',
	// 		'v.date_added'
	// 	);

	// 	if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
	// 		$sql .= " ORDER BY " . $data['sort'];
	// 	} else {
	// 		$sql .= " ORDER BY v.date_added";
	// 	}

	// 	if (isset($data['order']) && ($data['order'] == 'DESC')) {
	// 		$sql .= " DESC";
	// 	} else {
	// 		$sql .= " ASC";
	// 	}

	// 	if (isset($data['start']) || isset($data['limit'])) {
	// 		if ($data['start'] < 0) {
	// 			$data['start'] = 0;
	// 		}

	// 		if ($data['limit'] < 1) {
	// 			$data['limit'] = 20;
	// 		}

	// 		$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
	// 	}

	// 	$query = $this->db->query($sql);

	// 	return $query->rows;
	// }

	public function getTopupById($topup_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "topup WHERE topup_id = '" . (int)$topup_id . "'");
		return $query->row;
	}

	public function addTopup($data) {
		//$customer_info = $this->getCustomer($customer_id);

		//if ($customer_info) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "topup SET code = '" . (int)$data['code'] . "', customer_id = '" . (int)$data['customer_id'] . "', status = '" . (int)$data['status'] . "', amount = '" . (int)$data['amount'] . "', created_date = NOW(), updated_date = NOW()");

			$topup_id = $this->db->getLastId();

			$this->db->query("INSERT INTO " . DB_PREFIX . "topup_history SET topup_id = '" . (int)$topup_id . "', amount = '" . (int)$data['amount'] . "', mode ='1', created_date = NOW()");
		//}
	}

	public function updateTopup($topup_id,$data) {
		//$customer_info = $this->getCustomer($customer_id);

		//if ($customer_info) {
			$this->db->query("UPDATE " . DB_PREFIX . "topup SET amount = '" . (int)$data['amount'] . "', updated_date = NOW(), status = '" . (int)$data['status'] . "', customer_id = '" . (int)$data['customer_id'] . "' WHERE topup_id = '" . (int)$topup_id . "'");

			//$topup_id = $this->db->getLastId();

			$this->db->query("INSERT INTO " . DB_PREFIX . "topup_history SET topup_id = '" . (int)$topup_id . "', amount = '" . (int)$data['amount'] . "', mode ='1', created_date = NOW()");
		//}
	}

	public function deleteTopup($topup_id) {
		//$customer_info = $this->getCustomer($customer_id);

		//if ($customer_info) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "topup WHERE topup_id = '" . (int)$topup_id . "'");
		//}
	}

	public function getAllTopupHistories() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "topup_history` WHERE 1");
		return $query->rows;
	}

	public function getTopupHistoryByUserId($customer_id) {
		$customer_info = $this->getCustomer($customer_id);

		if ($customer_info) {
			$topup_id = $this->db->query("SELECT topup_id FROM `" . DB_PREFIX . "topup` WHERE customer_id = '" . (int)$customer_id . "'");
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "topup_history` WHERE topup_id = '" . (int)$topup_id . "'");
			return $query;
		}
	}

	public function addTopupHistory($customer_id,$topup_id,$amount,$created_by) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "topup_history SET topup_id = '" . (int)$topup_id . "', amount = '" . (float)$amount . "', mode ='1', transaction_reference = '', created_date = NOW(), created_by = '" . (int)$created_by . "'");
	}

	public function getTopupHistoryByTopupId($topup_id) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "topup_history` WHERE topup_id = '" . (int)$topup_id . "'");
		return $query;
	}

	public function installDatabase() {
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oc_topup` ( `topup_id` INT NOT NULL AUTO_INCREMENT , `code` INT(20) NOT NULL , `customer_id` INT NOT NULL , `amount` INT NOT NULL , `status` INT NOT NULL DEFAULT '1' , `created_date` DATE NOT NULL , `updated_date` DATE NOT NULL , PRIMARY KEY (`topup_id`), UNIQUE `code` (`code`)) ENGINE = InnoDB");

		$this->db->query("CREATE TABLE IF NOT EXISTS`" . DB_PREFIX . "oc_topup_history` ( `topup_history_id` INT NOT NULL AUTO_INCREMENT , `topup_id` INT NOT NULL , `amount` INT NOT NULL , `mode` TINYINT NOT NULL , `transaction_reference` INT NOT NULL , `created_date` DATE NOT NULL , `created_by` INT NOT NULL , PRIMARY KEY (`topup_history_id`)) ENGINE = InnoDB");
    }

    public function uninstallDatabase() {
    	$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "topup`");

    	$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "topup_history`");
    }  
}