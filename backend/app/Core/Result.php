<?php

namespace App\Core;

use Exception;

/** @template T */
class Result
{
    /** @var bool */
    private $is_success;

    /** @var bool */
    private $is_failure;

    /** @var ErrorMessageBag */
    private $errors;

    /** @var T|null */
    private $value;

    private function __construct(bool $is_success, $errors, $value = null)
    {
        if (is_array($errors)) {
            $errors = new ErrorMessageBag($errors);
        } else if (!($errors instanceof ErrorMessageBag)) {
            $errors = new ErrorMessageBag();
        }

        if ($is_success && $errors->isNotEmpty()) {
            throw new Exception('InvalidOperation: A result cannot be successful and contain errors');
        }

        if (!$is_success && $errors->isEmpty()) {
            throw new Exception('InvalidOperation: A failing result needs to contain a error messages');
        }

        $this->is_success = $is_success;
        $this->is_failure = !$is_success;
        $this->errors = $errors;
        $this->value = $value;
    }

    /**
     * @template U
     *
     * @param U|null $value
     *
     * @return Result<U>
     */
    public static function ok($value = null): Result
    {
        return new Result(true, null, $value);
    }


    /**
     * @param ErrorMessageBag|array|string $errors
     *
     * @return Result<mixed>
     */
    public static function fail($errors): Result
    {
        if ($errors instanceof ErrorMessageBag) {
            return new Result(false, $errors);
        }

        if (is_array($errors)) {
            return new Result(false, $errors);
        }

        if (is_string($errors)) {
            return new Result(false, [$errors]);
        }

        throw new Exception('InvalidOperation: Error message must be either a string, array, or ErrorMessageBag instance');
    }

    /**
     * Returns the first unsuccessful Result, else returns a single successful Result
     *
     * @param Result<mixed>[] $results
     *
     * @return Result<void> returns successful Result
     */
    public static function combine(array $results): Result
    {
        $allPassing = collect($results)->every(function (Result $result) {
            return $result->isSuccessful();
        });

        if ($allPassing) {
            return Result::ok();
        }

        $messageBag = collect($results)
            ->map(function (Result $result) {
                return $result->getErrorMessageBag();
            })
            ->reduce(function ($accumulator, ErrorMessageBag $currentBag) {
                if ($accumulator !== null) {
                    return $accumulator->merge($currentBag);
                }

                return $currentBag;
            });

        return Result::fail($messageBag);
    }

    /**
     * @return T
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return ErrorMessageBag
     */
    public function getErrorMessageBag()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors->all();
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        if ($this->is_success) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isFailure(): bool
    {
        if ($this->is_failure) {
            return true;
        }

        return false;
    }
}
