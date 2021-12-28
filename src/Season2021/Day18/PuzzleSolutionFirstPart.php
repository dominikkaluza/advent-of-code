<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day18;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;
use Nette\Utils\Json;
use Tree\Node\Node;
use Tree\Visitor\PostOrderVisitor;

final class PuzzleSolutionFirstPart implements PuzzleSolution
{
    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');
        $numbers = $input->mapLines(function ($line) {
            return Json::decode($line, Json::FORCE_ARRAY);
        });

        $numbersCount = count($numbers);

        $tree = $this->buildTree($numbers[0]);

        $magnitudes = [$this->getMagnitude($tree)];

        for ($i = 1; $i < $numbersCount; $i++) {
            $add = $this->buildTree($numbers[$i]);

            $newRoot = new Node();
            $newRoot->addChild($tree);
            $newRoot->addChild($add);

            $tree = $newRoot;

            $magnitudes[] = $this->getMagnitude($tree);

            do {
                $split = false;

                /** @var Node[] $yield */
                $visitor = new PostOrderVisitor();
                $yield = $tree->accept($visitor);

                foreach ($yield as $node) {
                    // explode
                    if ($node->getDepth() === 4 && !$node->isLeaf() && count($node->getChildren()) > 0) {
                        // left
                        $parent = $node->getParent();
                        $visited = [$node];

                        while (true) {
                            $visited[] = $parent;
                            $leftChild = $parent->getChildren()[0];

                            if (!in_array($leftChild, $visited, true)) {
                                break;
                            }

                            if ($parent->isRoot()) {
                                break;
                            }

                            $parent = $parent->getParent();
                        }

                        $leftNeighbour = $leftChild;
                        if(!in_array($leftNeighbour, $visited, true)) {
                            while ($leftNeighbour !== null && !is_numeric($leftNeighbour->getValue())) {
                                $leftNeighbour = $leftNeighbour->getChildren()[1];
                            }

                            $leftNeighbour->setValue($leftNeighbour->getValue() + $node->getChildren()[0]->getValue());
                        }


                        // right
                        $parent = $node->getParent();
                        $visited = [$node];

                        while (true) {
                            $visited[] = $parent;
                            $rightChild = $parent->getChildren()[1];

                            if (!in_array($rightChild, $visited, true)) {
                                break;
                            }

                            if ($parent->isRoot()) {
                                break;
                            }

                            $parent = $parent->getParent();
                        }

                        $rightNeighbour = $rightChild;
                        if(!in_array($rightNeighbour, $visited, true)) {
                            while ($rightNeighbour !== null && !is_numeric($rightNeighbour->getValue())) {
                                $rightNeighbour = $rightNeighbour->getChildren()[0];
                            }

                            $rightNeighbour->setValue($rightNeighbour->getValue() + $node->getChildren()[1]->getValue());
                        }

                        $node->removeAllChildren();
                        $node->setValue(0);

                        $magnitudes[] = $this->getMagnitude($tree);
                    }
                }

                /** @var Node[] $yield */
                $visitor = new PostOrderVisitor();
                $yield = $tree->accept($visitor);

                foreach ($yield as $node) {
                    if ($node->isLeaf() && $node->getValue() >= 10) {
                        $split = true;

                        $node->addChild(new Node((int)round($node->getValue() / 2, 0, PHP_ROUND_HALF_DOWN)));
                        $node->addChild(new Node((int)round($node->getValue() / 2, 0, PHP_ROUND_HALF_UP)));
                        $node->setValue(null);

                        $magnitudes[] = $this->getMagnitude($tree);

                        break;
                    }
                }
            } while ($split);
        }

        return new IntegerResult((int)$this->getMagnitude($tree)); // 445
    }


    private function buildTree(array $number): Node
    {
        $tree = new Node();

        if (!is_array($number)) {
            $tree->setValue($number);
        }

        foreach ($number as $nested) {
            $nestedNode = new Node();

            if (!is_array($nested)) {
                $nestedNode->setValue($nested);
                $nested = [];
            }

            foreach ($nested as $nested2) {
                $nestedNode2 = new Node();

                if (!is_array($nested2)) {
                    $nestedNode2->setValue($nested2);
                    $nested2 = [];
                }

                foreach ($nested2 as $nested3) {
                    $nestedNode3 = new Node();

                    if (!is_array($nested3)) {
                        $nestedNode3->setValue($nested3);
                        $nested3 = [];
                    }

                    foreach ($nested3 as $nested4) {
                        $nestedNode4 = new Node();

                        if (!is_array($nested4)) {
                            $nestedNode4->setValue($nested4);
                            $nested4 = [];
                        }

                        foreach ($nested4 as $nested5) {
                            $nestedNode5 = new Node();

                            if (!is_array($nested5)) {
                                $nestedNode5->setValue($nested5);
                                $nestedNode4->addChild($nestedNode5);
                            }
                        }

                        $nestedNode3->addChild($nestedNode4);
                    }

                    $nestedNode2->addChild($nestedNode3);
                }

                $nestedNode->addChild($nestedNode2);
            }

            $tree->addChild($nestedNode);
        }

        return $tree;
    }


    private function getMagnitude(Node $node)
    {
        if ($node->getValue() !== null) {
            return $node->getValue();
        }

        return 3 * ($this->getMagnitude($node->getChildren()[0]))
            + 2 * ($this->getMagnitude($node->getChildren()[1]));
    }
}
