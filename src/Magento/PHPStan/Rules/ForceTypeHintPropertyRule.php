<?php
declare(strict_types=1);

namespace Magento\PHPStan\Rules;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;

/**
 * Class BannedNodesRule
 * for BannedNodesRule
 */
class ForceTypeHintPropertyRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\PropertyProperty::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$scope->isInClass()) {
            throw new ShouldNotHappenException();
        }

        $propertyName = $node->name->toString();
        $propertyReflection = $scope->getClassReflection()->getNativeProperty($propertyName);
        if (!$propertyReflection->getDocComment()) {
            return [sprintf(
                'Please add PHPDoc to %s property.'
            ,$propertyName)];
        }

        return [];
    }
}