<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Controllers;

use Heritage\Http\Request;
use Heritage\Http\JsonResponse;
use Ugarit\Artifacts\Geography\DTOs\SaveLocationDTO;
use Ugarit\Artifacts\Geography\Http\Responders\GeographyResponder;
use Ugarit\Artifacts\Geography\Services\UseCases\IndexLocationsUseCase;
use Ugarit\Artifacts\Geography\Services\UseCases\SaveLocationUseCase;

class LocationController
{
    public function __construct(
        private readonly GeographyResponder $responder
    ) {}

    public function index(IndexLocationsUseCase $useCase): JsonResponse
    {
        return $this->responder->toResponse($useCase->handle());
    }

    public function store(Request $request, SaveLocationUseCase $useCase): JsonResponse
    {
        $dto = SaveLocationDTO::fromArray($request->all());

        return $this->responder->toResponse($useCase->handle($dto), 201);
    }
}
