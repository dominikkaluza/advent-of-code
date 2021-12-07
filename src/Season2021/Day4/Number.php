<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day4;

final class Number
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var bool
     */
    private $isMarked = false;


    public function __construct(string $number)
    {
        $this->number = $number;
    }


    public function getNumber(): string
    {
        return $this->number;
    }


    public function mark(): void
    {
        $this->isMarked = true;
    }


    public function isMarked(): bool
    {
        return $this->isMarked;
    }
}
