<?php declare(strict_types=1);

namespace Bug6173;

use function PHPStan\Testing\assertType;

class HelloWorld
{
	/**
	 * @param int[] $ids1
	 * @param int[] $ids2
	 */
	public function sayHello(array $ids1, array $ids2): bool
	{
		$res = [];
		foreach ($ids1 as $id) {
			$res[$id]['foo'] = $id;
		}

		foreach ($ids2 as $id) {
			$res[$id]['bar'] = $id;
		}

		foreach ($res as $r) {
			assertType('array{foo?: int, bar?: int}', $r);

			return isset($r['foo']);
		}

		return false;
	}
}
