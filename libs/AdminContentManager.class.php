<?php
class AdminContentManager {
	protected $_db;

	public function __construct($db) {
		$this->setBd($db);
	}

	public function setBd(PDO $db) {
		$this->_db = $db;
	}

	public function getList() {
		$list = array();
		$querry = $this->_db->query('SELECT * FROM galeres_admin');
		while ($data = $querry->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new AdminContent($data);
		}
		return $list;
	}
}
