<?php

namespace ArrayIsListUnset;

use function PHPStan\Testing\assertType;

class Foo {
	/**
	 * @param array{bool, bool, bool} $array
	 * @param int<0, 1> $key
	 */
	public function test(array $array, int $key) {
		assertType('int<0, 1>', $key);
		assertType('true', array_is_list($array));

		$array[$key] = false;
		assertType('true', array_is_list($array));
	}
}
