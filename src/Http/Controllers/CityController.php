<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Controllers;

use Heritage\Http\Request;
use Heritage\Http\JsonResponse;
use Ugarit\Artifacts\Geography\DTOs\SaveCityDTO;
use Ugarit\Artifacts\Geography\Http\Responders\GeographyResponder;
use Ugarit\Artifacts\Geography\Services\UseCases\IndexCitiesUseCase;
use Ugarit\Artifacts\Geography\Services\UseCases\SaveCityUseCase;

class CityController
{
    public function __construct(
        private readonly GeographyResponder $responder
    ) {}

    public function index(int $governorateId, IndexCitiesUseCase $useCase): JsonResponse
    {
        return $this->responder->toResponse($useCase->handle($governorateId));
    }

    public function store(Request $request, SaveCityUseCase $useCase): JsonResponse
    {
        $dto = SaveCityDTO::fromArray($request->all());

        return $this->responder->toResponse($useCase->handle($dto), 201);
    }
}
