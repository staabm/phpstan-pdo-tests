<?php

namespace AllenJB\PHPStanPdoTests\Data;

use function PHPStan\Testing\assertType;

class MethodsInSameClass
{
    protected function query(PDO $pdo): \PDOStatement
    {
        return $pdo->query("SELECT * FROM users");
    }

    public function processResults(PDO $pdo): void
    {
        $results = $this->query($pdo);
        foreach ($results as $resultRow) {
            assertType(\stdClass::class, $resultRow);
        }
    }
}