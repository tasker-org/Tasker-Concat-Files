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

				$files = $this->getFileSources($sources);
				$result = FileSystem::write($dest, $this->getFilesContent($files));
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
	 * @param array $files
	 * @return string
	 */
	protected function getFilesContent(array $files)
	{
		$content = '';
		if(count($files)) {
			foreach ($files as $file) {
				$content .= FileSystem::read($this->root . DIRECTORY_SEPARATOR . $file);
			}
		}

		return $content;
	}

	/**
	 * @param $sources
	 * @return array
	 * @throws \Tasker\InvalidStateException
	 */
	protected function getFileSources($sources)
	{
		if(is_string($sources)) {
			$sources = array($sources);
		}

		if(is_array($sources)) {
			$files = array();
			foreach ($sources as $source) {
				$files = array_merge($files, $this->parsePatter($source));
			}

			return $files;
		}

		throw new InvalidStateException('Sources configuration must be array or string.');
	}

	/**
	 * @param $pattern
	 * @return array
	 */
	protected function parsePatter($pattern)
	{
		return (array) glob((string) $pattern);
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