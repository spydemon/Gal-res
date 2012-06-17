<?php 
class AdminContent {
	protected $_name;
	protected $_value;

	public function __construct($array) {
	$this->hydrate($array);
	}

	protected function hydrate($array) {
		foreach ($array as $name => $value) {
			//If this object use this attribut.
			$setter = 'set'.ucfirst($name);
			if (method_exists($this, $setter))
					//We initialise it.
					$this->$setter($value);
		}
	}
	
	protected function setVar_name($name) {
		$this->_name = $name;
	}

	public function getVar_name() {
		return $this->_name;
	}

	public function setVar_value($value) {
		$this->_value = $value;
	}

	public function getVar_value($value) {
		return $this->_value;
	}
}
