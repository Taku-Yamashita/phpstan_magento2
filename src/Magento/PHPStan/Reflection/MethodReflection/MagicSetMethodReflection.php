<?php

namespace Magento\PHPStan\Reflection\MethodReflection;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\Native\NativeParameterReflection;
use PHPStan\Reflection\ParametersAcceptor;
use PHPStan\Reflection\PassedByReference;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;

class MagicSetMethodReflection implements MethodReflection
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var ClassReflection
     */
    private $declaringClass;

    /**
     * MagicMethodReflection constructor.
     *
     * @param string $name
     * @param ClassReflection $declaringClass
     */
    public function __construct(string $name, ClassReflection $declaringClass)
    {
        $this->name = $name;
        $this->declaringClass = $declaringClass;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->declaringClass;
    }

    public function isStatic(): bool
    {
        return false;
    }

    public function isPrivate(): bool
    {
        return false;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrototype(): ClassMemberReflection
    {
        return $this;
    }

    /**
     * @return ParametersAcceptor[]
     */
    public function getVariants(): array
    {
        return [new FunctionVariant(
            [new NativeParameterReflection(
                'value',
                true,
                new MixedType(),
                PassedByReference::createNo(),
                false)
            ],
            false,
            new ObjectType($this->declaringClass->getName())
        )];
    }
}
