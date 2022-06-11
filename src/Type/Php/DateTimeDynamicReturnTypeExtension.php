<?php declare(strict_types = 1);

namespace PHPStan\Type\Php;

use DateTime;
use DateTimeImmutable;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use function count;
use function date_create;
use function in_array;

class DateTimeDynamicReturnTypeExtension implements DynamicFunctionReturnTypeExtension
{

	public function isFunctionSupported(FunctionReflection $functionReflection): bool
	{
		return in_array($functionReflection->getName(), ['date_create', 'date_create_immutable'], true);
	}

	public function getTypeFromFunctionCall(FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope): Type
	{
		$defaultReturnType = ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();

		if (count($functionCall->getArgs()) < 1) {
			return $defaultReturnType;
		}

		$datetime = $scope->getType($functionCall->getArgs()[0]->value);

		if (!$datetime instanceof ConstantStringType) {
			return $defaultReturnType;
		}

		$isValid = date_create($datetime->getValue()) !== false;

		$className = $functionReflection->getName() === 'date_create' ? DateTime::class : DateTimeImmutable::class;
		return $isValid ? new ObjectType($className) : new ConstantBooleanType(false);
	}

}
