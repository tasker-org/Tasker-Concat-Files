<?php
/**
 * Class ConcatFiles
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 28.08.13
 */
namespace Tasker\Concat;

use Tasker\Utils\FileSystem;
use Tasker\InvalidStateException;

class ConcatFiles
{

	/**
	 * @param string|array $sources
	 * @param string $rootPath
	 * @return string
	 */
	public function concatenate($sources, $rootPath)
	{
		return $this->getFilesContent($this->getFiles($sources), $rootPath);
	}

	/**
	 * @param array $files
	 * @param $rootPath
	 * @return string
	 */
	public function getFilesContent(array $files, $rootPath)
	{
		$content = '';
		if(count($files)) {
			foreach ($files as $file) {
				$content .= FileSystem::read((string) $rootPath . DIRECTORY_SEPARATOR . $file);
			}
		}

		return $content;
	}

	/**
	 * @param $sources
	 * @return array
	 * @throws \Tasker\InvalidStateException
	 */
	public function getFiles($sources)
	{
		if(is_string($sources)) {
			$sources = array($sources);
		}

		if(count($sources)) {
			$files = array();
			foreach ($sources as $source) {
				$files = array_merge($files, $this->parsePattern($source));
			}

			return $files;
		}
	}

	/**
	 * @param $pattern
	 * @return array
	 */
	public function parsePattern($pattern)
	{
		return (array) glob((string) $pattern);
	}

}