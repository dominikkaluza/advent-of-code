<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day16;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionSecondPart implements PuzzleSolution
{
    const BINARY_MAP = [
        '0' => '0000',
        '1' => '0001',
        '2' => '0010',
        '3' => '0011',
        '4' => '0100',
        '5' => '0101',
        '6' => '0110',
        '7' => '0111',
        '8' => '1000',
        '9' => '1001',
        'A' => '1010',
        'B' => '1011',
        'C' => '1100',
        'D' => '1101',
        'E' => '1110',
        'F' => '1111',
    ];


    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $hex = $input->getLines()[0];
//        $hex = 'C200B40A82'; // 3
//        $hex = '04005AC33890'; // 54
//        $hex = '880086C3E88112'; // 7
//        $hex = 'CE00C43D881120'; // 9
//        $hex = 'D8005AC2A8F0'; // 1
//        $hex = 'F600BC2D8F'; // 0
//        $hex = '9C005AC2F8F0'; // 0
//        $hex = '9C0141080250320F1802104A08'; // 1

        $chars = str_split($hex);
        $binaryString = '';
        foreach ($chars as $char) {
            $binaryString .= self::BINARY_MAP[$char];
        }

        $packet = $binaryString;

        echo "Starting packet: $packet\n";
        $result = $this->resolvePacket(['packet' => $packet])['number'];

        return new IntegerResult($result);
    }



    private function resolvePacket($packet): array
    {
        $packet = $packet['packet'] ?? $packet;
        $packetVersion = bindec(substr($packet, 0, 3));
        $packetTypeId = bindec(substr($packet, 3, 3));
        $packet = substr($packet, 6);

        echo "Resolving packet: $packet | version: $packetVersion | typeId: $packetTypeId\n";

        // literal value
        if ($packetTypeId === 4) {
            echo "Resolving literal packet: $packet\n";

            $numberBits = '';
            while (true) {
                $group = substr($packet, 0, 5);

                $numberBits .= substr($group, 1);

                $packet = substr($packet, 5);

                if (str_starts_with($group, '0')) {
                    break;
                }
            }

            $number = bindec($numberBits);
            echo "Resolved literal packet | number: $number | rest: $packet\n";

            return ['packet' => $packet, 'number' => $number];
        }

        // operator
        $lengthTypeId = substr($packet, 0, 1);
        $packet = substr($packet, 1);

        $subpacketResults = [];

        if ($lengthTypeId === '0') {
            $subpacketLength = bindec(substr($packet, 0, 15));
            $subpacket = substr($packet, 15, $subpacketLength);

            echo "Processing operator packet 0: $packet | length: $subpacketLength | subpacket: $subpacket\n";

            while ($subpacket !== '') {
                $resolvedSubPacket = $this->resolvePacket($subpacket);
                $subpacket = $resolvedSubPacket['packet'];
                $subpacketResults[] = $resolvedSubPacket['number'];
            }

            $packet = substr($packet, 15 + $subpacketLength);

            echo "Processed operator packet 0: $packet\n";
        } else {
            $subpacketCount = bindec(substr($packet, 0, 11));
            $packet = substr($packet, 11);

            echo "Processing operator packet 1: $packet | count: $subpacketCount | subpacket: $packet\n";

            for ($i = 0; $i < $subpacketCount; $i++) {
                $resolvedSubPacket = $this->resolvePacket($packet);
                $packet = $resolvedSubPacket['packet'];
                $subpacketResults[] = $resolvedSubPacket['number'];
            }

            echo "Processed operator packet 1: $packet\n";
        }

        $number = 0;
        switch ($packetTypeId) {
            case 0: {
                $number = array_sum($subpacketResults);
                break;
            }
            case 1: {
                $number = array_product($subpacketResults);
                break;
            }
            case 2: {
                $number = min($subpacketResults);
                break;
            }
            case 3: {
                $number = max($subpacketResults);
                break;
            }
            case 5: {
                $number = $subpacketResults[0] > $subpacketResults[1] ? 1 : 0;
                break;
            }
            case 6: {
                $number = $subpacketResults[0] < $subpacketResults[1] ? 1 : 0;
                break;
            }
            case 7: {
                $number = $subpacketResults[0] === $subpacketResults[1] ? 1 : 0;
                break;
            }
        }

        return ['packet' => $packet, 'number' => $number];
    }
}
