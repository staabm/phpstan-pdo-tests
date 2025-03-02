<?php

namespace AllenJB\PHPStanPdoTests\Data;

use function PHPStan\Testing\assertType;

class InDifferentClass
{
    public function processStar(\PDO $pdo): void
    {
        $repo = new InDifferentClassRepository();
        $results = $repo->queryStar($pdo);
        foreach ($results as $resultRow) {
            // ❌ Actual   :'array<int|string, mixed>'
            assertType(\stdClass::class, $resultRow);
        }
    }

    public function processColumnList(\PDO $pdo): void
    {
        $repo = new InDifferentClassRepository();
        $results = $repo->queryColumnList($pdo);
        foreach ($results as $resultRow) {
            // ❌ Actual   :'array<int|string, mixed>'
            assertType(\stdClass::class, $resultRow);
        }
    }

    public function processSingleStar(\PDO $pdo): void
    {
        $repo = new InDifferentClassRepository();
        $result = $repo->singleStar($pdo);
        // ✔️ Works as expected
        assertType(\stdClass::class . '|null', $result);
    }

    public function processSingleColumnList(\PDO $pdo): void
    {
        $repo = new InDifferentClassRepository();
        $result = $repo->singleColumnList($pdo);
        // ✔️ Works as expected
        assertType(\stdClass::class . '|null', $result);
    }
}