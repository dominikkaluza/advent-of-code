<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day5;

final class Line
{
    private $x1;

    private $y1;

    private $x2;

    private $y2;


    public function __construct(string $line)
    {
        $points = explode(' -> ', $line);
        $start = explode(',', $points[0]);
        $end = explode(',', $points[1]);

        $this->x1 = (int)$start[0];
        $this->y1 = (int)$start[1];
        $this->x2 = (int)$end[0];
        $this->y2 = (int)$end[1];
    }


    public function isHorizontalOrVertical(): bool
    {
        return $this->x1 === $this->x2 || $this->y1 === $this->y2;
    }


    /**
     * @return Point[]
     */
    public function getPoints(): array
    {
        if (!$this->isHorizontalOrVertical()) {
            $points = [];

            $dx = $this->x1 < $this->x2 ? 1 : -1;
            $dy = $this->y1 < $this->y2 ? 1 : -1;

            $x = $this->x1;
            $y = $this->y1;
            while($x !== $this->x2 + $dx) {
                $points[] = new Point($x, $y);
                $x += $dx;
                $y += $dy;
            }

//            var_dump($points);
            return $points;
        }

        $x1 = min($this->x1, $this->x2);
        $x2 = max($this->x1, $this->x2);
        $y1 = min($this->y1, $this->y2);
        $y2 = max($this->y1, $this->y2);

        $points = [];
        for ($i = $x1; $i <= $x2; $i++) {
            for ($j = $y1; $j <= $y2; $j++) {
                $points[] = new Point($i, $j);
            }
        }

        return $points;
    }
}
