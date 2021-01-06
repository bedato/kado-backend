<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Style;
use App\Http\Resources\StyleResource;
use App\Http\Resources\StylesResourceCollection;
use App\Http\Requests\Api\SearchStylesRequest;
use App\Repositories\Style\StylesRepositoryInterface;

class StylesController extends ApiController
{
    private $stylesRepository;
    private $style;

    /**
     * StylesController constructor.
     *
     * @param StylesRepositoryInterface $stylesRepository
     */
    public function __construct(StylesRepositoryInterface $stylesRepository)
    {
        $this->repository = $stylesRepository;
        $this->style = new Style();
    }

    /**
     * Get styles list
     *
     * @return \App\Http\Resources\StylesResourceCollection
     */
    public function index(SearchStylesRequest $request): StylesResourceCollection
    {
        $styles = $this->repository->searchStyles(
            $request->validated()
        );

        return new StylesResourceCollection($styles);
    }

    /**
     * Get specific style by id.
     *
     * @return \App\Http\Resources\StyleResource
     */
    public function show(int $id): StyleResource
    {
        return new StyleResource($this->repository->getById($id));
    }
}
