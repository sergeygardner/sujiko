<?php

namespace App\Application\Tool;

/**
 *
 */
final readonly class PopulateTool
{
    /**
     * @param array<int, int> $arguments
     *
     * @return array<int, array<int|string, int>>
     */
    public function arguments(array $arguments): array
    {
        $cases = [];

        foreach ($arguments as $key => $argument) {
            $todo = $arguments;

            unset($todo[$key]);

            $todo = array_values($todo);

            $cases = [
                ...$cases,
                ...$this->place($argument, ...$todo),
            ];
        }

        return $cases;
    }

    /**
     * @param int $number
     * @param int ...$arguments
     *
     * @return array<int, array<int|string, int>>
     */
    private function place(int $number, int ...$arguments): array
    {
        if (count($arguments) === 1) {
            return [
                [
                    $number,
                    ...$arguments,
                ],
            ];
        }

        $cases = [];

        foreach ($arguments as $key => $argument) {
            $todo = $arguments;

            unset($todo[$key]);

            $todo = array_values($todo);

            $results = $this->place(
                $argument,
                ...$todo,
            );

            foreach ($results as $result) {
                $cases = [
                    ...$cases,
                    [
                        $number,
                        ...array_values($result),
                    ],
                ];
            }
        }

        return $cases;
    }
}
