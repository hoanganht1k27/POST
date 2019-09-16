<?php

class Person {
	public $name;
	public $eyeColor;
	public $age;

	public function __construct($name, $eyeColor, $age) {
		$this -> name = $name;
		$this -> eyeColor = $eyeColor;
		$this -> age = $age;
	}

	public function setName($newName) {
		$this -> name = $newName;
	}
}

?>