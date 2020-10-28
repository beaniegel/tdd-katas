<?php

declare(strict_types=1);

use jellybean\RomanNumeral;
use PHPUnit\Framework\TestCase;

/** @covers \jellybean\RomanNumeral */
class RomanNumeralTest extends TestCase
{
    public function invalidInputProvider(): array
    {
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
    public function testException(int $invalidInput): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Integer should be higher than 0 and lower than 4000');

        RomanNumeral::fromInteger($invalidInput);
    }

    public function singleDigitsProvider(): array
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

    public function simpleTwoDigitsProvider(): array
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

    public function simpleThreeDigitsProvider(): array
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

    public function simpleFourDigitsProvider(): array
    {
        return [
            [1000, 'M'],
            [2000, 'MM'],
            [3000, 'MMM']
        ];
    }

    public function advancedTwoDigitsProvider(): array
    {
        return [
            [24, 'XXIV'],
            [39, 'XXXIX'],
            [47, 'XLVII'],
            [51, 'LI'],
            [65, 'LXV']
        ];
    }

    public function advancedThreeDigitsProvider(): array
    {
        return [
            [324, 'CCCXXIV'],
            [470, 'CDLXX'],
            [502, 'DII'],
            [784, 'DCCLXXXIV'],
            [999, 'CMXCIX']
        ];
    }

    public function advancedFourDigitsProvider(): array
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
    public function testRomanNumeral(int $input, string $expected): void
    {
        $numeral = RomanNumeral::fromInteger($input);

        $this->assertSame($input, $numeral->asDigit());
        $this->assertSame($expected, $numeral->getValue());
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
    public function testStringCast(int $input, string $expected): void
    {
        $numeral = RomanNumeral::fromInteger($input);

        $this->assertSame($expected, (string) $numeral);
    }
}