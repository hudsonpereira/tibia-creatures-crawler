<?php namespace Dishark\TibiaCrawler;

use Dishark\TibiaCrawler\Interfaces\TibiaCrawlerInterface;

class TibiaBRCrawler implements TibiaCrawlerInterface
{
	protected $urlBase;

	protected $savePath;

	public function __construct($urlBase = 'http://www.tibiabr.com/Criaturas/', $savePath = 'images/')
	{
		$this->urlBase = $urlBase;
		$this->savePath = $savePath;
	}

	/**
	 * Downloads all gifs and store them in alphabetically ordered folders
	 */
	public function download()
	{
		foreach (range('A', 'Z') as $letter) 
		{
			$contents = file_get_contents($this->urlBase . $letter);

			preg_match_all('/http:\/\/[^ ]+criaturas[^ ]+.gif/', $contents, $matches);

			$current_image_path = $this->savePath . $letter . '/';

			if(! is_dir($current_image_path))
			{
				mkdir($current_image_path, 0755, true);
			}

			foreach ($matches[0] as $match) 
			{
				preg_match('/[a-z]+.gif/', $match, $filename);

				if(! file_exists($current_image_path . $filename[0]))
				{
					echo 'Downloading ' . $filename[0] . PHP_EOL;

					file_put_contents($current_image_path . $filename[0], file_get_contents($match));	

					echo 'Done.' . PHP_EOL;
				}
				
			}
		}
	}
}