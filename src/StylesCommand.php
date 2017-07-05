<?php
namespace PhpDocxtable;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StylesCommand extends Command
{
	protected function configure(){
		$this->setName('styles')
		->setDescription('Listing table styles in docx')
		->setDefinition(array(
			new InputOption('file' ,'f', InputOption::VALUE_REQUIRED, 'Path to docx file')
		));
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$file_path = $input->getOption('file');
		if(empty($file_path)){
			die('Path to docx file is required' . "\n");
		}

		if($path = realpath($file_path)){
			$zip = new \ZipArchive();
			$res = $zip->open($path);
			if(!$res){
				die('Cannot open zip file.');
			}
			
			$fp = $zip->getStream('word/styles.xml');
			$xml = '';
			while(!feof($fp)){
				$xml .= fgets($fp);
			}
			fclose($fp);
			
			$dom = new \DOMDocument();
			$dom->loadXML($xml);
			if( $dom->firstChild->nodeName != 'w:styles' ){
				echo $dom->firstChild->nodeName . "\n";
			}

			$styles = $dom->getElementsByTagName('style');
			$count = 1;
			for( $i=0; $i < $styles->length; $i++){
				$node = $styles->item($i);
				if($node->attributes->getNamedItem('type')->nodeValue == 'table'){
					echo $count . ":\n";
					echo ' styleId: ';
					echo $node->attributes->getNamedItem('styleId')->nodeValue . "\n";
					echo ' name: ';
					echo $node->getElementsByTagName('name')->item(0)->attributes->getNamedItem('val')->nodeValue . "\n";
					$count++;
				}
			}
			
			$zip->close();
		}else{
			die('Docx file not found.');
		}
	}
}