# Sujiko's solution
Version 1.0.0

## Sujiko
Created in 2010, Sujiko was the first of the puzzles created by Kobayaashi Studios to feature in the puzzle pages of national newspapers.

Beginning in the Times and the Telegraph in 2011, Sujiko has gone from strength to strength, and now – twelve years later – features in newspapers and magazines around the UK, and internationally.

## Rules

- You have a square table with rows and columns. The number of cells is 9.
- You have to set all numbers from 1 to 9 in the cells. Every number must be used once.
- Every four cells with numbers in the table, which can be combined as a square, have the sum.
- Every table with numbers has three groups and their sums:
  - the first group sum describes the sum of two numbers,
  - the second group sum describes the sum of three numbers,
  - the third group sum describes the sum of four numbers;

## Conclusions

- The number of initial combinations is 9! or 362880.
- The game has some other rules which increase combinations:
  - Every initial combination can be used in a non-unique group combination.
  - The number of combinations for groups 1, 2, 3 is (9! / (9-2)!) * (9! / (9-3)!) * (9! / (9-4)!) = 109734912
  - The final number of games is 109734912 * 362880 = 39820604866560
  - Groups and their sums help you to figure out how to set all the numbers, but for every 109734912 group's combination, the sum for every square in the table is the same.

## Installation

### Requirements
- Docker

```shell
git clone https://github.com/sergeygardner/sujiko.git
cd sujiko
docker compose up -d
docker exec -ti sujiko-php sh
```

## Examples:

```shell
./bin/sujiko simple:solver:solve --maxNumber=9 --groupSum=10 --groupSum=8 --groupSum=27 --group1=3 --group1=8 --group2=1 --group2=4 --group2=7 --group3=2 --group3=5 --group3=6 --group3=9 --tuple1=19 --tuple2=28 --tuple3=10 --tuple4=22
+---+---+---+
| 5 | 8 | 7 |
| 2 | 4 | 9 |
| 1 | 3 | 6 |
+---+---+---+
./bin/sujiko simple:solver:solve --maxNumber=9 --groupSum=4 --groupSum=18 --groupSum=23 --group1=4 --group1=7 --group2=1 --group2=3 --group2=6 --group3=2 --group3=5 --group3=8 --group3=9 --tuple1=24 --tuple2=29 --tuple3=14 --tuple4=19
+---+---+---+
| 6 | 9 | 7 |
| 1 | 8 | 5 |
| 3 | 2 | 4 |
+---+---+---+
```

## Tests

```shell
XDEBUG_MODE=coverage vendor/phpunit/phpunit/phpunit --log-junit=report/phpunit-report.xml --coverage-cobertura report/phpuint-covergae.xml --coverage-clover report/phpunit-clover.xml --coverage-text --color=never
```

## Pint

```shell
./vendor/bin/pint
```

## PHPStan

```shell
./vendor/bin/phpstan
```


### Summary

- All tests cover 100% of the code
- PHPStan is passed on level 9

## ToDo
- Create a new feature for making a game