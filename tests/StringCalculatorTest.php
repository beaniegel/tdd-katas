<?php


use jellybean\StringCalculator;
use PHPUnit\Framework\TestCase;

/** @covers \jellybean\StringCalculator */
class StringCalculatorTest extends TestCase
{
    public function basicNumberStringProvider() {
        return [
            ["", 0],
            ["1,2,3,4", 10],
            ["2,2,2,2", 8],
            ["10,19", 29],
            ["322,12321,654,2342,234234,12,0,3453,12312", 265650]
        ];
    }

    /** @dataProvider basicNumberStringProvider */
    public function testAdd(string $input, int $expected): void
    {
        $calculator = new StringCalculator();
        $actual = $calculator->add($input);

        self::assertSame($expected, $actual);
    }
}
