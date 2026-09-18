<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Controllers;

use Heritage\Http\Request;
use Heritage\Http\JsonResponse;
use Ugarit\Artifacts\Geography\DTOs\SaveGovernorateDTO;
use Ugarit\Artifacts\Geography\Http\Responders\GeographyResponder;
use Ugarit\Artifacts\Geography\Services\UseCases\IndexGovernoratesUseCase;
use Ugarit\Artifacts\Geography\Services\UseCases\SaveGovernorateUseCase;

class GovernorateController
{
    public function __construct(
        private readonly GeographyResponder $responder
    ) {}

    public function index(int $countryId, IndexGovernoratesUseCase $useCase): JsonResponse
    {
        return $this->responder->toResponse($useCase->handle($countryId));
    }

    public function store(Request $request, SaveGovernorateUseCase $useCase): JsonResponse
    {
        $dto = SaveGovernorateDTO::fromArray($request->all());

        return $this->responder->toResponse($useCase->handle($dto), 201);
    }
}
