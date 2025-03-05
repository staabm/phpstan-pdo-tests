<?php

namespace AllenJB\PHPStanPdoTests\Data;

use function PHPStan\Testing\assertType;

class InSameMethod
{
    public function queryStar(\PDO $pdo): void
    {
        $results = $pdo->query("SELECT * FROM users");
        foreach ($results as $resultRow) {
            // ✔️ Works as expected
            assertType('object{userid: int<0, 4294967295>, email: string, password_hash: string}&stdClass', $resultRow);
        }
    }

    public function queryColumnList(\PDO $pdo): void
    {
        $results = $pdo->query("SELECT userid, email FROM users");
        foreach ($results as $resultRow) {
            // ✔️ Works as expected
            assertType('object{userid: int<0, 4294967295>, email: string}&stdClass', $resultRow);
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
