<?php

namespace Magento\PHPStan\Reflection;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use Magento\PHPStan\Reflection\MethodReflection\MagicGetMethodReflection;
use Magento\PHPStan\Reflection\MethodReflection\MagicSetMethodReflection;

class MagicMethodReflectionExtension implements MethodsClassReflectionExtension
{
    /**
     * @param ClassReflection $classReflection
     * @param string $methodName
     * @return bool
     */
    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        $dataObject =
            $classReflection->getName() === 'Magento\Framework\DataObject' ||
            $classReflection->isSubclassOf('Magento\Framework\DataObject');

        return $dataObject && in_array(substr($methodName, 0, 3), ['get', 'set']);
    }

    /**
     * @param ClassReflection $classReflection
     * @param string $methodName
     * @return MethodReflection
     */
    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        if(substr($methodName, 0, 3) === 'get'){
            return new MagicGetMethodReflection($methodName, $classReflection);
        }
        if(substr($methodName, 0, 3) === 'set'){
            return new MagicSetMethodReflection($methodName, $classReflection);
        }
    }
}
