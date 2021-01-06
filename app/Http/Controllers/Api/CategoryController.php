<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoriesResourceCollection;
use App\Http\Requests\Api\SearchCategoriesRequest;
use App\Repositories\Category\CategoriesRepositoryInterface;

class CategoryController extends ApiController
{
    private $categoriesRepository;
    private $category;

    /**
     * CategoriesController constructor.
     *
     * @param CategoriesRepositoryInterface $categoriesRepository
     */
    public function __construct(CategoriesRepositoryInterface $categoriesRepository)
    {
        $this->repository = $categoriesRepository;
        $this->category = new Category();
    }

    /**
     * Get categories list
     *
     * @return \App\Http\Resources\CategoriesResourceCollection
     */
    public function index(SearchCategoriesRequest $request): CategoriesResourceCollection
    {
        $categories = $this->repository->searchCategories(
            $request->validated()
        );

        return new CategoriesResourceCollection($categories);
    }

    /**
     * Get specific category by id.
     *
     * @return \App\Http\Resources\CategoryResource
     */
    public function show(int $id): CategoryResource
    {
        return new CategoryResource($this->repository->getById($id));
    }
}
