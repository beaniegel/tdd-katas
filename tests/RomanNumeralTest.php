<?php

declare(strict_types=1);

use jellybean\RomanNumeral;
use PHPUnit\Framework\TestCase;

/** @covers \jellybean\RomanNumeral */
class RomanNumeralTest extends TestCase
{
    private RomanNumeral $romanNumeral;

    protected function setUp(): void
    {
        parent::setUp();

        $this->romanNumeral = new RomanNumeral();
    }

    public function invalidInputProvider(){
        return [
            [-593],
            [-1],
            [0],
            [4000],
            [820112]
        ];
    }

    /**
     * @dataProvider invalidInputProvider
     */
    public function testException(int $invalidInput)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->romanNumeral->fromInteger($invalidInput);
    }

    /**
     * @dataProvider invalidInputProvider
     */
    public function testExceptionMessage(int $invalidInput)
    {
        $this->expectExceptionMessage('Integer should be higher than 0 and lower than 4000');

        $this->romanNumeral->fromInteger($invalidInput);
    }

    public function digitsUnderTenProvider()
    {
        return [
            [1, 'I'],
            [2, 'II'],
            [3, 'III'],
            [4, 'IV'],
            [5, 'V'],
            [6, 'VI'],
            [7, 'VII'],
            [8, 'VIII'],
            [9, 'IX'],
        ];
    }

    public function digitsAsTensProvider()
    {
        return [
            [10, 'X'],
            [20, 'XX'],
            [30, 'XXX'],
            [40, 'XL'],
            [50, 'L'],
            [60, 'LX'],
            [70, 'LXX'],
            [80, 'LXXX'],
            [90, 'XC']
        ];
    }

    public function digitsAsHundredsProvider()
    {
        return [
            [100, 'C'],
            [200, 'CC'],
            [300, 'CCC'],
            [400, 'CD'],
            [500, 'D'],
            [600, 'DC'],
            [700, 'DCC'],
            [800, 'DCCC'],
            [900, 'CM']
        ];
    }

    public function digitsAsThousandsProvider()
    {
        return [
            [1000, 'M'],
            [2000, 'MM'],
            [3000, 'MMM']
        ];
    }
    
    /**
     * @dataProvider digitsUnderTenProvider
     * @dataProvider digitsAsTensProvider
     * @dataProvider digitsAsHundredsProvider
     * @dataProvider digitsAsThousandsProvider
     */
    public function testRomanNumerals(int $input, string $expected) {
        $numeral = $this->romanNumeral->fromInteger($input);
        $this->assertSame($expected, $numeral);
    }
}