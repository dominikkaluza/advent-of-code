<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day2;

final class Instruction
{
    /**
     * @var string
     */
    private $direction;

    /**
     * @var int
     */
    private $value;


    public function __construct(string $inputLine)
    {
        $exploded = explode(' ', $inputLine);
        $this->direction = $exploded[0];
        $this->value = (int)$exploded[1];
    }


    public function getDirection(): string
    {
        return $this->direction;
    }


    public function getValue(): int
    {
        return $this->value;
    }


    public function isForward(): bool
    {
        return $this->direction === 'forward';
    }


    public function isUp(): bool
    {
        return $this->direction === 'up';
    }


    public function isDown(): bool
    {
        return $this->direction === 'down';
    }
}
