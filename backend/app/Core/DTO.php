<?php

namespace App\Core;

use ReflectionClass;
use ReflectionProperty;

abstract class DTO
{
    /**
     * @param array<mixed> $attributes An associative array of Key => Value pairs. Values may be anything.
     */
    public function __construct(array $attributes)
    {
        $reflect = new ReflectionClass($this);

        $attrs = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);

        foreach ($attrs as $property) {
            $name = $property->getName();

            if (isset($attributes[$name])) {
                $this->{$name} = $attributes[$name];
            }
        }
    }

    public function toArray(): array
    {
        $reflect = new ReflectionClass($this);

        $attrs = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);

        $arr = [];

        foreach ($attrs as $property) {
            $propertyName = $property->getName();
            $propertyValue = $property->getValue($this);

            if ($propertyValue instanceof DTO) {
                $arr[$propertyName] = $propertyValue->toArray();
            } else {
                $arr[$propertyName] = $propertyValue;
            }
        }

        return $arr;
    }
}
