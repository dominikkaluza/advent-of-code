<?php declare(strict_types = 1);

namespace AdventOfCode\Season2021\Day16;

use AdventOfCode\IntegerResult;
use AdventOfCode\LinesInput;
use AdventOfCode\PuzzleSolution;
use AdventOfCode\Result;

final class PuzzleSolutionFirstPart implements PuzzleSolution
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

    private $versionNumberSum = 0;


    public function getResult(): Result
    {
        $input = new LinesInput(__DIR__ . '/input.txt');

        $hex = $input->getLines()[0];
//        $hex = 'D2FE28'; // 2021
//        $hex = '38006F45291200'; // 10 20
//        $hex = 'EE00D40C823060'; // 1 2 3
//        $hex = '8A004A801A8002F478'; // 16
//        $hex = '620080001611562C8802118E34'; // 12
//        $hex = 'C0015000016115A2E0802F182340'; // 23
//        $hex = 'A0016C880162017C3686B18A3D4780'; // 31

        $chars = str_split($hex);
        $binaryString = '';
        foreach ($chars as $char) {
            $binaryString .= self::BINARY_MAP[$char];
        }

        $packet = $binaryString;

        echo "Starting packet: $packet\n";
        $this->resolvePacket($packet);

        return new IntegerResult($this->versionNumberSum);
    }


    private function resolvePacket($packet): string
    {
        $packetVersion = bindec(substr($packet, 0, 3));
        $packetTypeId = bindec(substr($packet, 3, 3));
        $packet = substr($packet, 6);

        echo "Resolving packet: $packet | version: $packetVersion | typeId: $packetTypeId\n";

        $this->versionNumberSum += $packetVersion;

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

            return $packet;
        }

        // operator
        $lengthTypeId = substr($packet, 0, 1);
        $packet = substr($packet, 1);

        if ($lengthTypeId === '0') {
            $subpacketLength = bindec(substr($packet, 0, 15));
            $subpacket = substr($packet, 15, $subpacketLength);

            echo "Processing operator packet 0: $packet | length: $subpacketLength | subpacket: $subpacket\n";

            while ($subpacket !== '') {
                $subpacket = $this->resolvePacket($subpacket);
            }

            $packet = substr($packet, 15 + $subpacketLength);

            echo "Processed operator packet 0: $packet\n";
        } else {
            $subpacketCount = bindec(substr($packet, 0, 11));
            $packet = substr($packet, 11);

            echo "Processing operator packet 1: $packet | count: $subpacketCount | subpacket: $packet\n";

            for ($i = 0; $i < $subpacketCount; $i++) {
                $packet = $this->resolvePacket($packet);
            }

            echo "Processed operator packet 1: $packet\n";
        }

        return $packet;
    }

    // 01100010000000001000000000000000000101100001000101010110001011001000100000000010000100011000111000110100
    // VVVTTTILLLLLLLLLLL00000000000000000101100001000101010110001011001000100000000010000100011000111000110100
    //                   VVVTTTILLLLLLLLLLLLLLL0001000101010110001011
    //                                         VVVTTTAAAAAVVVTTTBBBBB

    // 100010100000000001001010100000000001101010000000000000101111010001111000
    // VVVTTTILLLLLLLLLLLVVVTTTILLLLLLLLLLLVVVTTTILLLLLLLLLLLLLLLVVVTTTAAAAA

    // 1100000000000001010100000000000000000001011000010001010110100010111000001000000000101111000110000010001101000000
    // VVVTTTILLLLLLLLLLLLLLLVVVTTTILLLLLLLLLLLLLLLVVVTTTAAAAAVVVTTTBBBBBVVVTTTILLLLLLLLLLLVVVTTTCCCCCVVVTTTDDDDD
}
