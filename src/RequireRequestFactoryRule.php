<?php

declare(strict_types=1);

namespace Worksome\PhpstanRequestFactories;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Worksome\RequestFactories\RequestFactory;

/**
 * @implements Rule<Class_>
 */
readonly class RequireRequestFactoryRule implements Rule
{
    /** @param  array<int, string>  $excludedRequestClasses */
    public function __construct(
        private string $requestsNamespace,
        private string $factoriesNamespace,
        private array $excludedRequestClasses = [],
    ) {
    }

    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @param Class_ $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->namespacedName === null) {
            return [];
        }

        $className = $node->namespacedName->toString();

        if (! str_starts_with($className, $this->requestsNamespace)) {
            return [];
        }

        if (! in_array(Request::class, class_parents($className) ?: [], true)) {
            return [];
        }

        if (in_array($className, $this->excludedRequestClasses)) {
            return [];
        }

        return $this->checkForCorrespondingFactory($className);
    }

    public function checkForCorrespondingFactory(string $className): array
    {
        $subName = Str::after($className, "{$this->requestsNamespace}\\");
        $factoryName = sprintf('%s\%sFactory', $this->factoriesNamespace, $subName);

        if (class_exists($factoryName) && in_array(RequestFactory::class, class_parents($factoryName) ?: [], true)) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                "Request \"{$className}\" does not have a corresponding Request Factory at \"{$factoryName}\"."
            )->build()
        ];
    }
}
