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

    public function singleDigitsProvider()
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

    public function simpleTwoDigitsProvider()
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

    public function simpleThreeDigitsProvider()
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

    public function simpleFourDigitsProvider()
    {
        return [
            [1000, 'M'],
            [2000, 'MM'],
            [3000, 'MMM']
        ];
    }

    public function advancedTwoDigitsProvider()
    {
        return [
            [24, 'XXIV'],
            [39, 'XXXIX'],
            [47, 'XLVII'],
            [51, 'LI'],
            [65, 'LXV']
        ];
    }

    public function advancedThreeDigitsProvider()
    {
        return [
            [324, 'CCCXXIV'],
            [470, 'CDLXX'],
            [502, 'DII'],
            [784, 'DCCLXXXIV'],
            [999, 'CMXCIX']
        ];
    }

    public function advancedFourDigitsProvider()
    {
        return [
            [1401, 'MCDI'],
            [2026, 'MMXXVI'],
            [2514, 'MMDXIV'],
            [3888, 'MMMDCCCLXXXVIII'],
            [3999, 'MMMCMXCIX']
        ];
    }

    /**
     * @dataProvider singleDigitsProvider
     * @dataProvider simpleTwoDigitsProvider
     * @dataProvider simpleThreeDigitsProvider
     * @dataProvider simpleFourDigitsProvider
     * @dataProvider advancedTwoDigitsProvider
     * @dataProvider advancedThreeDigitsProvider
     * @dataProvider advancedFourDigitsProvider
     */
    public function testRomanNumerals(int $input, string $expected) {
        $numeral = $this->romanNumeral->fromInteger($input);
        $this->assertSame($expected, $numeral);
    }
}