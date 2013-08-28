<?php
/**
 * Class IConcatFiles
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 28.08.13
 */
namespace Tasker\Concat;

interface IConcatFiles
{

	/**
	 * @param array $files
	 * @param string $rootPath
	 * @return string
	 */
	public function getFilesContent(array $files, $rootPath);

	/**
	 * @param string|array $sources
	 * @return array
	 */
	public function getFiles($sources);

	/**
	 * @param string $pattern
	 * @return array
	 */
	public function parsePattern($pattern);
}