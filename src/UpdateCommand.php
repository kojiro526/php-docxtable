<?php
namespace PhpDocxtable;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Comodojo\Zip\Zip;

class UpdateCommand extends Command
{

	protected function configure()
	{
		$this->setName('update')
			->setDescription('Update table styles in docx')
			->setDefinition(array(
			new InputOption('file', 'f', InputOption::VALUE_REQUIRED, 'Path to docx file'),
			new InputOption('output', 'o', InputOption::VALUE_REQUIRED, 'Path to new docx file'),
			new InputOption('style', 's', InputOption::VALUE_REQUIRED, 'Style id')
		));
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$file_path = $input->getOption('file');
		if (! ($input_file = realpath($file_path))) {
			die('Docx file not found.' . "\n");
		}
		$output_path = $input->getOption('output');
		$style = $input->getOption('style');
		
		//$tmp_dir = tempnam(sys_get_temp_dir(), 'docxtable');
		$tmp_dir = sys_get_temp_dir();
		$tmp_dir = $tmp_dir . DIRECTORY_SEPARATOR . uniqid();
		mkdir($tmp_dir);

		// docxファイルを解凍
		$zip = new \ZipArchive();
		$res = $zip->open($input_file);
		if(!$res){
			die('Cannnot open docx file.' . "\n");
		}
		$zip->extractTo($tmp_dir);
		
		// word本文のxmlを開く
		$doc_path = $tmp_dir . DIRECTORY_SEPARATOR . 'word' . DIRECTORY_SEPARATOR . 'document.xml';
		$dom = new \DOMDocument();
		$dom->load($doc_path);
		
		// テーブルのスタイルを指定のスタイルに変更
		$tbl_styles = $dom->getElementsByTagName('tblStyle');
		for($i=0; $i < $tbl_styles->length; $i++){
			$node = $tbl_styles->item($i);
			$node->attributes->getNamedItem('val')->nodeValue = $style;
		}
		
		// xmlを保存
		$dom->save($doc_path);
		
		// zip圧縮
		$zip_path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid() . ".zip";
		$zip_creator = Zip::create($zip_path);
		$zip_creator->add($tmp_dir, true);
		$zip_creator->close();
		
		// docxとしてリネーム
		copy($zip_path, $output_path);
		
		$zip->close();
	}
}