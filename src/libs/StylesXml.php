<?php
/**
 * Created by PhpStorm.
 * User: sasaki
 * Date: 2017/07/08
 * Time: 0:18
 */

namespace PhpDocxtable\libs;

class StylesXml {

	private $dom = null;

	public function __construct($dom)
	{
		if( $dom->firstChild->nodeName != 'w:styles' ){
			throw new \InvalidArgumentException( 'This is not a styles.xml' );
		}
		$this->dom = $dom;
	}

	public function getTableStyles(){
		$table_styles = new TableStyles();

		$styles = $this->dom->getElementsByTagName('style');
		for( $i=0; $i < $styles->length; $i++){
			$node = $styles->item($i);
			if($node->attributes->getNamedItem('type')->nodeValue == 'table'){
				$table_styles->add(
					new TableStyle(
						$node->attributes->getNamedItem('styleId')->nodeValue,
						$node->getElementsByTagName('name')->item(0)->attributes->getNamedItem('val')->nodeValue
					)
				);
			}
		}

		return $table_styles;
	}
}