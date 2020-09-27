<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Shape;
use App\Http\Resources\ShapeResource;
use App\Http\Resources\ShapesResourceCollection;
use App\Http\Requests\Api\SearchShapesRequest;
use App\Repositories\Shape\ShapesRepositoryInterface;

class ShapesController extends ApiController
{
    private $shapesRepository;
    private $shape;

    /**
     * ShapesController constructor.
     *
     * @param ShapesRepositoryInterface $shapesRepository
     */
    public function __construct(ShapesRepositoryInterface $shapesRepository)
    {
        $this->repository = $shapesRepository;
        $this->shape = new Shape();
    }

    /**
     * Get shapes list
     *
     * @return \App\Http\Resources\ShapesResourceCollection
     */
    public function index(SearchShapesRequest $request): ShapesResourceCollection
    {
        $shapes = $this->repository->searchShapes(
            $request->validated()
        );

        return new ShapesResourceCollection($shapes);
    }

    /**
     * Get specific shape by id.
     *
     * @return \App\Http\Resources\ShapeResource
     */
    public function show(int $id): ShapeResource
    {
        return new ShapeResource($this->repository->getById($id));
    }
}
