<?php

use staabm\PHPStanDba\QueryReflection\PdoMysqlQueryReflector;
use staabm\PHPStanDba\QueryReflection\QueryReflection;
use staabm\PHPStanDba\QueryReflection\QueryReflector;
use staabm\PHPStanDba\QueryReflection\RuntimeConfiguration;

require_once __DIR__ . '/vendor/autoload.php';

$config = (new RuntimeConfiguration())
    ->analyzeWriteQueries(true)
    ->defaultFetchMode(QueryReflector::FETCH_TYPE_CLASS);

$host = getenv('DBA_HOST') ?: '127.0.0.1';
$user = getenv('DBA_USER') ?: 'root';
$password = getenv('DBA_PASSWORD') ?: 'root';
$dbname = getenv('DBA_DATABASE') ?: 'phpstan_dba';

$options = [];
$pdo = new PDO(sprintf('mysql:dbname=%s;host=%s', $dbname, $host), $user, $password, $options);
$reflector = new PdoMysqlQueryReflector($pdo);

QueryReflection::setupReflector($reflector, $config);
