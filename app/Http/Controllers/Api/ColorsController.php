<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Color;
use App\Http\Resources\ColorResource;
use App\Http\Resources\ColorsResourceCollection;
use App\Http\Requests\Api\SearchColorsRequest;
use App\Repositories\Color\ColorsRepositoryInterface;

class ColorsController extends ApiController
{
    private $colorsRepository;
    private $color;

    /**
     * ColorsController constructor.
     *
     * @param ColorsRepositoryInterface $colorsRepository
     */
    public function __construct(ColorsRepositoryInterface $colorsRepository)
    {
        $this->repository = $colorsRepository;
        $this->color = new Color();
    }

    /**
     * Get colors list
     *
     * @return \App\Http\Resources\ColorsResourceCollection
     */
    public function index(SearchColorsRequest $request): ColorsResourceCollection
    {
        $colors = $this->repository->searchColors(
            $request->validated()
        );

        return new ColorsResourceCollection($colors);
    }

    /**
     * Get specific color by id.
     *
     * @return \App\Http\Resources\ColorResource
     */
    public function show(int $id): ColorResource
    {
        return new ColorResource($this->repository->getById($id));
    }
}
