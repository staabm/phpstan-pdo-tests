<?php

use PHPStan\Testing\TypeInferenceTestCase;
use staabm\PHPStanDba\QueryReflection\QueryReflection;
use staabm\PHPStanDba\QueryReflection\QueryReflector;

class TypeInferenceTest extends TypeInferenceTestCase
{
    /**
     * @return iterable<mixed>
     */
    public static function dataFileAsserts(): iterable
    {
        yield from self::gatherAssertTypes(__DIR__ . '/data/InSameMethod.php');
        yield from self::gatherAssertTypes(__DIR__ . '/data/MethodsInSameClass.php');
        yield from self::gatherAssertTypes(__DIR__ . '/data/InDifferentClass.php');
        yield from self::gatherAssertTypes(__DIR__ . '/data/phpdoc-only.php');
    }

    public function testDefaultFetchMode(): void
    {
        $dbaConfig = QueryReflection::getRuntimeConfiguration();
        $this->assertSame( QueryReflector::FETCH_TYPE_CLASS, $dbaConfig->getDefaultFetchMode());
    }

    /**
     * @dataProvider dataFileAsserts
     */
    public function testFileAsserts(
        string $assertType,
        string $file,
        mixed ...$args
    ): void
    {
        $this->assertFileAsserts($assertType, $file, ...$args);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/../phpstan.neon'];
    }
}