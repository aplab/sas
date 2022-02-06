<?php declare(strict_types=1);


namespace App\Tests\Service;

use App\Service\PasswordGenerator;
use Exception;
use PHPUnit\Framework\TestCase;

class PasswordGeneratorTest extends TestCase
{
    /**
     * @param array $param_set
     * @throws Exception
     * @dataProvider provideParamSets
     */
    public function testPassword(... $param_set) : void
    {
        $generator = new PasswordGenerator();
        $generator->debug = true;
        dump($param_set);
        $result = $generator->generatePassword(... $param_set);
        dump($result);
        // assert that your calculator added the numbers correctly!
        $this->assertEquals($generator->getLastPassLength(), strlen($result));
        dump(str_repeat('=', 80));
    }

    /**
     * @return array
     */
    public function provideParamSets() : array
    {
        return [
            [],
            [PasswordGenerator::ALGORITHM_VCVDDVCV],
            [PasswordGenerator::ALGORITHM_CVCVCDCVCVC],
            [PasswordGenerator::ALGORITHM_CVCVCDCVCVC, false, 50],
            [PasswordGenerator::ALGORITHM_RANDOM_EXTENDED, false, 100],
            [PasswordGenerator::ALGORITHM_RANDOM_EXTENDED, true, 100],
            [PasswordGenerator::ALGORITHM_RANDOM, true, 100],
            [PasswordGenerator::ALGORITHM_RANDOM, false, 100],

        ];
    }
}
