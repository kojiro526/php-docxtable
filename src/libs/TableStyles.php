<?php
/**
 * Created by PhpStorm.
 * User: sasaki
 * Date: 2017/07/08
 * Time: 0:24
 */

namespace PhpDocxtable\libs;

class TableStyles {

	private $table_styles = array();

	public function add($table_style){
		array_push($this->table_styles, $table_style);
	}

	public function getStyles(){
		return $this->table_styles;
	}
}