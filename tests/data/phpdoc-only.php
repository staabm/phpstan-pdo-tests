<?php
/**
 * @var iterable<stdClass> $results
 */

use function PHPStan\Testing\assertType;

foreach ($results as $resultRow) {
    // ❌ Actual   :'array<int|string, mixed>'
    assertType(\stdClass::class, $resultRow);
}
