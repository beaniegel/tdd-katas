<?php


use jellybean\StringCalculator;
use PHPUnit\Framework\TestCase;

/** @covers \jellybean\StringCalculator */
class StringCalculatorTest extends TestCase
{
    private StringCalculator $calculator;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculator = new StringCalculator();
    }

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
        $actual = $this->calculator->add($input);

        self::assertSame($expected, $actual);
    }

    public function invalidInputProvider()
    {
        return [
            ["just,some,words"],
            ["end of line".PHP_EOL],
            ["&*(@&#$%#%@$#:<{}["],
            ["ALSO,TEST,C4PS"],
            ["125^93^385^0212"]
        ];
    }

    /**
     * @dataProvider invalidInputProvider
     */
    public function testException(string $invalidInput): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('String should only contain numbers separated by a comma');

        $this->calculator->add($invalidInput);
    }
}
