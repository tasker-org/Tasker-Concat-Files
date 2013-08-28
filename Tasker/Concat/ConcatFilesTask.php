<?php
/**
 * Class ConcatFilesTask
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 28.08.13
 */
namespace Tasker\Concat;

use Tasker\InvalidStateException;
use Tasker\Setters\IRootPathSetter;
use Tasker\Tasks\ITaskService;
use Tasker\Utils\FileSystem;

class ConcatFilesTask implements ITaskService, IRootPathSetter
{

	/** @var  string */
	private $root;

	/** @var IConcatFiles  */
	private $concatFiles;

	/**
	 * @param IConcatFiles $concatFiles
	 */
	function __construct(IConcatFiles $concatFiles = null)
	{
		if($concatFiles === null) {
			$concatFiles = new ConcatFiles;
		}

		$this->concatFiles = $concatFiles;
	}


	/**
	 * @param array $config
	 * @return array|int|mixed
	 * @throws \Tasker\InvalidStateException
	 */
	public function run(array $config)
	{
		$results = array();
		if(count($config)) {
			foreach ($config as $dest => $sources) {
				if(!is_string($dest)) {
					throw new InvalidStateException('Destination must be valid path');
				}

				$files = $this->concatFiles->getFiles($sources);
				$content = $this->concatFiles->getFilesContent($files, $this->root);
				$result = FileSystem::write($this->root . DIRECTORY_SEPARATOR . $dest, $content);
				if($result === false) {
					$results[] = 'File "' . $dest . '" cannot be concatenated.';
				}else{
					$results[] = 'File "' . $dest . '" was concatenated. ' . count($files) . ' files included.';
				}
			}
		}

		return $results;
	}

	/**
	 * @param string $root
	 * @return $this
	 */
	public function setRootPath($root)
	{
		$this->root = (string) $root;
		return $this;
	}
}