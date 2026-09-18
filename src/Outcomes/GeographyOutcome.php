<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Outcomes;

readonly class GeographyOutcome
{
    public function __construct(
        public bool $successful,
        public mixed $data = null,
        public ?string $message = null,
        public array $errors = [],
        public array $actions = [],
    ) {}

    public static function success(mixed $data = null, ?string $message = null, array $actions = []): self
    {
        return new self(
            successful: true,
            data: $data,
            message: $message,
            actions: $actions
        );
    }

    public static function failure(string $message, array $errors = []): self
    {
        return new self(
            successful: false,
            message: $message,
            errors: $errors
        );
    }

    public function toArray(): array
    {
        return [
            'success' => $this->successful,
            'data' => $this->data,
            'message' => $this->message,
            'errors' => $this->errors,
            'actions' => $this->actions,
        ];
    }
}
