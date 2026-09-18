<?php

declare(strict_types=1);

namespace Ugarit\Artifacts\Geography\Http\Controllers;

use Heritage\Http\Request;
use Heritage\Http\JsonResponse;
use Ugarit\Artifacts\Geography\DTOs\SaveCountryDTO;
use Ugarit\Artifacts\Geography\Http\Responders\GeographyResponder;
use Ugarit\Artifacts\Geography\Services\UseCases\IndexCountriesUseCase;
use Ugarit\Artifacts\Geography\Services\UseCases\SaveCountryUseCase;
use Ugarit\Artifacts\Geography\Services\UseCases\ShowCountryUseCase;

class CountryController
{
    public function __construct(
        private readonly GeographyResponder $responder
    ) {}

    public function index(IndexCountriesUseCase $useCase): JsonResponse
    {
        return $this->responder->toResponse($useCase->handle());
    }

    public function show(string $iso, ShowCountryUseCase $useCase): JsonResponse
    {
        return $this->responder->toResponse($useCase->handle($iso));
    }

    public function store(Request $request, SaveCountryUseCase $useCase): JsonResponse
    {
        $dto = SaveCountryDTO::fromArray($request->all());

        return $this->responder->toResponse($useCase->handle($dto), 201);
    }
}
