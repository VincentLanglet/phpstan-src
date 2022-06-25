<?php declare(strict_types = 1);

namespace PHPStan\File;

use function file_get_contents;
use function is_file;
use function stream_resolve_include_path;

class FileReader
{

	public static function read(string $fileName): string
	{
		$path = $fileName;

		if (!is_file($path)) {
			$path = stream_resolve_include_path($fileName);

			if ($path === false) {
				throw new CouldNotReadFileException($fileName);
			}
		}
		$contents = @file_get_contents($path);
		if ($contents === false) {
			throw new CouldNotReadFileException($fileName);
		}

		return $contents;
	}

}
