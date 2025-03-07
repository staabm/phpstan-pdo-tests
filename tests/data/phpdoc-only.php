<?php
/**
 * @return PdoStatementType<int, object{userid: int<0, 4294967295>, email: string}&stdClass>
 */

use function PHPStan\Testing\assertType;

foreach ($results as $resultRow) {
    // ❌ Actual   :'array<int|string, mixed>'
    assertType(\stdClass::class, $resultRow);
}
