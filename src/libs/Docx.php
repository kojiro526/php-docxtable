<?php
namespace PhpDocxtable\libs;

class Docx {

	private $file_path = null;

	public function __construct($file_path)
	{
		if(empty($file_path)) throw new \InvalidArgumentException("'file_path' is required");
		$this->file_path = $file_path;
	}

	public function getStyleXml(){
		if(empty($path = realpath($this->file_path)))
			throw new \Exception("Invalid file_path. file_path=" . $this->file_path);

		$zip = new \ZipArchive();
		$res = $zip->open($path);
		if(!$res){
			throw new \Exception('Failed to open zip file.');
		}

		$fp = $zip->getStream('word/styles.xml');
		$xml = '';
		while(!feof($fp)){
			$xml .= fgets($fp);
		}
		fclose($fp);
		$zip->close();

		$dom = new \DOMDocument();
		$dom->loadXML($xml);

		return new StylesXml($dom);
	}
}