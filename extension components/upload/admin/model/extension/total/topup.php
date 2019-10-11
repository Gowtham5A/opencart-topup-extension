<?php
class ModelExtensionTotalTopup extends Controller {

	public function getAllTopups() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "topup` WHERE 1");
		return $query;
	}

	public function getTopupByUserId($user_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "topup` WHERE customer_id = '" . (int)$user_id . "'");
		return $query->row;
	}


	public function getTopupById($topup_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "topup WHERE user_id = '" . (int)$topup_id . "'");
		return $query->row;
	}

	public function addTopup($customer_id, $amount = '', $code, $created_by, $status) {
		$customer_info = $this->getCustomer($customer_id);

		if ($customer_info) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "topup SET code = '', customer_id = '" . (int)$customer_id . "', amount = '" . (float)$amount . "', created_date = NOW(), updated_date = NOW()");

			$topup_id = $this->db->getLastId();

			$this->db->query("INSERT INTO " . DB_PREFIX . "topup_history SET topup_id = '" . (int)$topup_id . "', amount = '" . (float)$amount . "', mode ='1', transaction_reference = '', created_date = NOW(), created_by = '" . (int)$created_by . "'");
		}
	}

	public function updateTopup($customer_id,$created_by) {
		$customer_info = $this->getCustomer($customer_id);

		if ($customer_info) {
			$this->db->query("UPDATE " . DB_PREFIX . "topup SET amount = '" . (float)$amount . "', updated_date = NOW(), status = '" . (int)$status . "' WHERE customer_id = '" . (int)$customer_id . "'");

			$topup_id = $this->db->getLastId();

			$this->db->query("INSERT INTO " . DB_PREFIX . "topup_history SET topup_id = '" . (int)$topup_id . "', amount = '" . (float)$amount . "', mode ='1', transaction_reference = '', created_date = NOW(), created_by = '" . (int)$created_by . "'");
		}
	}

	public function deleteTopup($customer_id) {
		$customer_info = $this->getCustomer($customer_id);

		if ($customer_info) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "topup WHERE customer_id = '" . (int)$customer_id . "'");
		}
	}

	public function getAllTopupHistories() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "topup_history` WHERE 1");
		return $query;
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
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "topup` ( `topup_id` INT NOT NULL AUTO_INCREMENT , `code` INT(20) NOT NULL , `customer_id` INT NOT NULL , `amount` INT NOT NULL , `status` INT NOT NULL DEFAULT '1' , `created_date` DATE NOT NULL , `updated_date` DATE NOT NULL , PRIMARY KEY (`topup_id`), UNIQUE `code` (`code`)) ENGINE = InnoDB");

		$this->db->query("CREATE TABLE IF NOT EXISTS`" . DB_PREFIX . "topup_history` ( `topup_history_id` INT NOT NULL AUTO_INCREMENT , `topup_id` INT NOT NULL , `amount` INT NOT NULL , `mode` TINYINT NOT NULL , `transaction_reference` INT NOT NULL , `created_date_` INT NOT NULL , `created_by` INT NOT NULL , PRIMARY KEY (`topup_history_id`)) ENGINE = InnoDB");
    }

    public function uninstallDatabase() {
    	$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "topup`");

    	$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "topup_history`");
    }  
}