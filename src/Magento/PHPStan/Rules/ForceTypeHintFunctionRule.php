<?php
declare(strict_types=1);

namespace Magento\PHPStan\Rules;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

/**
 * Class BannedNodesRule
 * for BannedNodesRule
 */
class ForceTypeHintFunctionRule implements Rule
{
    public function getNodeType(): string
    {
        return \PhpParser\Node\FunctionLike::class;
    }

    /**
     * @param Node $node
     * @param Scope $scope
     * @return array
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [sprintf(
                'Please add PHPDoc to %s() function.'
            ,$node->name->toString())];
        }

        return [];
    }
}