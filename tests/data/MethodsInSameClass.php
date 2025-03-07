<?php

namespace AllenJB\PHPStanPdoTests\Data;

use function PHPStan\Testing\assertType;

class MethodsInSameClass
{
    /**
     * @return PdoStatementType<int, object{userid: int<0, 4294967295>, email: string, password_hash: string}&stdClass}&stdClass>
     */
    protected function query(\PDO $pdo): \PDOStatement
    {
        return $pdo->query("SELECT * FROM users");
    }

    public function processResults(\PDO $pdo): void
    {
        $results = $this->query($pdo);
        foreach ($results as $resultRow) {
            // ❌ Actual   :'array<int|string, mixed>'
            assertType('object{userid: int<0, 4294967295>, email: string, password_hash: string}&stdClass', $resultRow);
        }
    }
}