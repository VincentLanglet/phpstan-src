<?php declare(strict_types = 1);

namespace Bug13036;

class Foo
{
	public function getLanguage(string $languageCode): string
	{
		$languages = [
			'en' => 'English',
			'de' => 'German',
		];

		$languageCode = trim(strtoupper($languageCode));

		return $languages[$languageCode];
	}
}
