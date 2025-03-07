<?php

namespace AllenJB\PHPStanPdoTests\Data;

class InDifferentClassRepository
{
    public function queryStar(\PDO $pdo): \PDOStatement
    {
        return $pdo->query("SELECT * FROM users");
    }

    /**
     * @return iterable<object{userid: int<0, 4294967295>, email: string}&stdClass>
     */
    public function queryColumnList(\PDO $pdo): \PDOStatement
    {
        return $pdo->query("SELECT userid, email FROM users");
    }

    public function singleStar(\PDO $pdo): ?\stdClass
    {
        $results = $pdo->query("SELECT * FROM users");
        $result = $results->fetch();
        return ($result !== false ? $result : null);
    }

    public function singleColumnList(\PDO $pdo): ?\stdClass
    {
        $results = $pdo->query("SELECT userid, email FROM users");
        $result = $results->fetch();
        return ($result !== false ? $result : null);
    }
}