<?php
namespace PhpDocxtable;

use PhpDocxtable\libs\Docx;
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
			$docx = new Docx($path);
			$style_xml = $docx->getStyleXml();
			$table_styles = $style_xml->getTableStyles();

			// コンソールに取得結果を表示
			foreach ($table_styles->getStyles() as $i => $table_style){
				echo sprintf("%d:\n", $i + 1);
				echo ' styleId: ';
				echo $table_style->getId() . "\n";
				echo ' name: ';
				echo $table_style->getName() . "\n";
			}
		}else{
			die('Docx file not found.');
		}
	}
}