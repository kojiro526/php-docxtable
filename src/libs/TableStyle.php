<?php
/**
 * Created by PhpStorm.
 * User: sasaki
 * Date: 2017/07/08
 * Time: 0:26
 */

namespace PhpDocxtable\libs;

class TableStyle {

	private $id = null;
	private $name = null;

	public function __construct($id, $name)
	{
		$this->id = $id;
		$this->name = $name;
	}

	public function getId(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}
}