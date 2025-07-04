<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Exception\WrongArgumentTypeDomainException;
use App\Domain\Exception\WrongContextDomainException;
use App\Infrastructure\Bag\OptionsBag;
use App\Infrastructure\Response\ResponseInterface;
use RuntimeException;
use Throwable;

/**
 *
 */
final class ContextChangerService implements ContextChangerServiceInterface
{
    /**
     * @var array<string, array<string, class-string>>
     */
    private readonly array $contexts;

    /**
     * @param array<int, string> $arguments
     */
    public function __construct(public readonly array $arguments)
    {
        $this->contexts = [
            'Simple' => [
                'Solver' => SimpleSolverContext::class,
                'Index' => SimpleSolverContext::class,
            ],
        ];
    }

    /**
     * @return void
     */
    public function switch(): void
    {
        try {
            [$context, $className, $action] = $this->ensureRoute();
            $context   = ucfirst($context);
            $className = ucfirst($className);

            if (! isset($this->contexts[$context][$className])) {
                throw new WrongContextDomainException(
                    sprintf(
                        'Context "%s" or class "%s" does not exist!',
                        $context,
                        $className,
                    ),
                );
            }

            $response = new ($this->contexts[$context][$className])($this->prepareARGV())->{$action}();

            if ($response instanceof ResponseInterface) {
                $response->render();
            }
        } catch (Throwable $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * @return array<int, string>
     */
    private function ensureRoute(): array
    {
        return array_replace(
            ['Simple', 'Index', 'List'],
            explode(':', $this->arguments[1] ?? 'simple:index:index', 3),
        );
    }

    /**
     * @return ConsoleOptionService
     *
     * @throws WrongArgumentTypeDomainException
     */
    private function prepareARGV(): ConsoleOptionService
    {
        $optionsBag = array_reduce(
            $this->arguments,
            $this->argumentsReducer(...),
            new OptionsBag(),
        );

        return new ConsoleOptionService(
            options: $optionsBag,
        );
    }

    /**
     * @param OptionsBag $carry
     * @param array<int, string> $matches
     *
     * @return OptionsBag
     *
     * @throws WrongArgumentTypeDomainException
     */
    private function prepareARGVByType(OptionsBag $carry, array $matches): OptionsBag
    {
        $variableName = (string) preg_replace('#\d#', '', $matches[1]);
        $variableCount = (int) str_replace($variableName, '', $matches[1]);

        $carry->{$variableName}[$variableCount] = match (OptionsBag::getArgumentType($variableName)) {
            OptionsBag::TYPE_INT => (int) $matches[2],
            OptionsBag::TYPE_INT_ARRAY => [
                ...($carry->{$variableName}[$variableCount] ?? []),
                (int) $matches[2],
            ],
            default => throw new WrongArgumentTypeDomainException(
                sprintf('Argument [%s] type not supported', $variableName),
            ),
        };

        return $carry;
    }

    /**
     * @param Throwable $e
     * @return void
     */
    private function handleException(Throwable $e): void
    {
        throw new RuntimeException(
            <<<STR
                \033[31mError:\n
                {$e->getMessage()}
                \n\n
                \033[31mTrace:
                \n
                {$e->getTraceAsString()}
                \n
                \033[39m
                STR,
        );
    }

    /**
     * @param OptionsBag $carry
     * @param string $item
     *
     * @return OptionsBag
     */
    private function argumentsReducer(OptionsBag $carry, string $item): OptionsBag
    {
        preg_match('#--([^=]+)=(.+)#', $item, $matches);

        if (count($matches) === 3) {
            $carry = $this->prepareARGVByType(
                $carry,
                $matches,
            );
        }

        return $carry;
    }

}
