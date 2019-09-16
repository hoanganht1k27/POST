<?php

class NewClass {

	//Properties and methods goes here
	public $info = "This is some info";

}

class Person {
	protected $first = "Anh";
	private $name = "Nguyen";
	private $age = 17;
}

class Pet extends Person{
	public function owner() {
		$a = $this -> first;
		return $a;
	}
}

// $object = new NewClass;
// var_dump($object);

?>