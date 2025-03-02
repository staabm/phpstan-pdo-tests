<?php

namespace AllenJB\PHPStanPdoTests\Data;

use function PHPStan\Testing\assertType;

class InSameMethod
{
    public function queryStar(\PDO $pdo): void
    {
        $results = $pdo->query("SELECT * FROM users");
        foreach ($results as $resultRow) {
            // ❌ Actual   :'array<int, stdClass>'
            assertType(\stdClass::class, $resultRow);
        }
    }

    public function queryColumnList(\PDO $pdo): void
    {
        $results = $pdo->query("SELECT userid, email FROM users");
        foreach ($results as $resultRow) {
            // ❌ Actual   :'array<int, stdClass>'
            assertType(\stdClass::class, $resultRow);
        }
    }

    public function singleStar(\PDO $pdo): ?\stdClass
    {
        $results = $pdo->query("SELECT * FROM users");
        $result = $results->fetch();
        // ✔️ Works as expected
        assertType(\stdClass::class . '|false', $result);
        return ($result !== false ? $result : null);
    }

    public function singleColumnList(\PDO $pdo): ?\stdClass
    {
        $results = $pdo->query("SELECT userid, email FROM users");
        $result = $results->fetch();
        // ✔️ Works as expected
        assertType(\stdClass::class . '|false', $result);
        return ($result !== false ? $result : null);
    }
}
