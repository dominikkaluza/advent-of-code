<?php declare(strict_types = 1);

namespace AdventOfCode\Season2015\Day6;

final class Instruction
{
    public const TURN_ON = 'turn on';
    public const TOGGLE = 'toggle';
    public const TURN_OFF = 'turn off';

    private string $type = '';

    private int $x1;

    private int $y1;

    private int $x2;

    private int $y2;


    public function __construct(string $line)
    {
        $matches = null;
        preg_match('/^([A-Z ]+)[ ]([0-9]+)[,]([0-9]+)[A-Z ]+([0-9]+)[,]([0-9]+)$/i', $line, $matches);
//        var_dump($matches);
        $this->type = $matches[1];
        $this->x1 = (int)$matches[2];
        $this->y1 = (int)$matches[3];
        $this->x2 = (int)$matches[4];
        $this->y2 = (int)$matches[5];
    }


    public function getType(): string
    {
        return $this->type;
    }


    public function getX1(): int
    {
        return $this->x1;
    }


    public function getY1(): int
    {
        return $this->y1;
    }


    public function getX2(): int
    {
        return $this->x2;
    }


    public function getY2(): int
    {
        return $this->y2;
    }
}
