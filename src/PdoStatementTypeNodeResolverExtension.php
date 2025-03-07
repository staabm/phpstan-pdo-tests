<?php

namespace MyApp\PHPStan;

use PHPStan\Analyser\NameScope;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDoc\TypeNodeResolverAwareExtension;
use PHPStan\PhpDoc\TypeNodeResolverExtension;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

class PdoStatementTypeNodeResolverExtension implements TypeNodeResolverExtension, TypeNodeResolverAwareExtension
{

    private TypeNodeResolver $typeNodeResolver;

    public function setTypeNodeResolver(TypeNodeResolver $typeNodeResolver): void
    {
        $this->typeNodeResolver = $typeNodeResolver;
    }

    public function resolve(TypeNode $typeNode, NameScope $nameScope): ?Type
    {
        if (!$typeNode instanceof GenericTypeNode) {
            // returning null means this extension is not interested in this node
            return null;
        }

        $typeName = $typeNode->type;
        if ($typeName->name !== 'PdoStatementType') {
            return null;
        }

        $arguments = $typeNode->genericTypes;
        if (count($arguments) !== 2) {
            return null;
        }

        $keyType = $this->typeNodeResolver->resolve($arguments[0], $nameScope);
        $valueType = $this->typeNodeResolver->resolve($arguments[1], $nameScope);

        return new GenericObjectType(\Iterator::class, [$keyType, $valueType]);
    }

}