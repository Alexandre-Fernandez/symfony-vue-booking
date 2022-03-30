<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Exception\DeserializationException;
use ApiPlatform\Core\Validator\ValidatorInterface;

final class InputDataTransformer implements DataTransformerInterface
{
    public function __construct(private ValidatorInterface $validator) {}

    public function transform($data, string $to, array $context = []): object
    {
        if (!$data instanceof $context["input"]["class"]) throw new DeserializationException(
			'Cannot deserialize "' . $context["input"]["class"] . '".'
		);
        $this->validator->validate($data);
        return $data;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if (!isset($context["input"]["class"])) return false;
        return is_array($data);
    }
}