<?php declare(strict_types = 1);

namespace AdventOfCode\Leaderboard;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LeaderBoardCommand extends Command
{
    private const COLORS = [
        'Vojtěch Havránek' => 'red',
        'Dominik Voda' => 'blue',
        'Dominik Kaluža' => 'green',
        'Petr Jirouš' => 'yellow',
        'mbukovy' => 'magenta',
        'Jan Prokop' => 'cyan',
    ];


    public function configure(): void
    {
        $this->setName('leaderboard');
    }


    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $json = Json::decode(FileSystem::read(__DIR__ . '/leaderboard.json'), Json::FORCE_ARRAY);

        $days = [];

        foreach ($json['members'] as $member) {
            foreach ($member['completion_day_level'] as $key => $completionDay) {
                $days[$key][1][$member['name']] = $completionDay['1']['get_star_ts'] ?? -1;
                $days[$key][2][$member['name']] = $completionDay['2']['get_star_ts'] ?? -1;
            }
        }

        ksort($days);

        foreach ($days as $key => $day) {
            for ($i = 1; $i <= 2; $i++) {
                asort($day[$i]);

                $day[$i] = array_filter($day[$i], function ($ts): bool {
                    return $ts !== -1;
                });

                $day[$i] = array_map(
                    function ($name): string {
                        $exploded = explode(' ', $name);
                        $paddedName = mb_str_pad($exploded[1] ?? $name, 10, ' ', STR_PAD_RIGHT);

                        $color = self::COLORS[$name] ?? 'white';

                        return "<fg=$color>$paddedName</>";
                    },
                    array_keys($day[$i])
                );

                $names = implode(' ', $day[$i]);

                $paddedDay = str_pad((string)($key), 2, ' ', STR_PAD_LEFT);

                $output->write("$paddedDay | $i | $names\n");
            }
        }

        return 0;
    }
}

function mb_str_pad($input, $pad_length, $pad_string, $pad_style, $encoding = "UTF-8")
{
    return str_pad($input, strlen($input) - mb_strlen($input, $encoding) + $pad_length, $pad_string, $pad_style);
}
