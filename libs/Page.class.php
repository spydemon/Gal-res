<?php
/****
  This function contain all the structure of the page.
****/

class Page {
	//Database access
	protected $_db;
	//View ressources
	protected $_header;
	protected $_title;
	protected $_menu;
	protected $_footer;
	//Infos admin
	protected $_infos_admin;
	protected $_values_admin;

	public function __construct() {
			//We catch information in the db only if it's already configured.
		if (CONFIG_EXIST) {
			try {
				$this->_db = new PDO('mysql:host=' .BDD_HOSTNAME. ';dbname=' .BDD_BDDNAME, BDD_USERNAME, BDD_PASSWORD);
				$this->_infos_admin = new AdminContentManager($this->_db);
				$this->_values_admin = $this->_infos_admin->getList();

				foreach ($this->_values_admin as $value)
					echo $value->getVar_name(). "<br />";
			}
			catch (Exception $e) {
				echo "A problem with the connection to the database occures:<br />\n";
				echo $e->getMessage(). "<br />\n";
			}
		}
	}
}
