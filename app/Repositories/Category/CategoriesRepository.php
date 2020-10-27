<?php

declare(strict_types=1);

namespace App\Repositories\Category;

use ArrayAccess;
use App\Models\Category;

class CategoriesRepository implements CategoriesRepositoryInterface
{
    protected $categories;

    /**
     * CategoriesRepository constructor.
     *
     * @param Category $categories - instantiate Model
     */
    public function __construct(Category $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Retrieve all categories.
     *
     * @return ArrayAccess<Category>
     */
    public function getAll(): ArrayAccess
    {
        return $this->categories->all();
    }

    /**
     * Retrieve categories that correspond to criteria.
     *
     * @return ArrayAccess<Category>
     */
    public function searchCategories(array $searchCriteria): ArrayAccess
    {
        $search = $this->categories->query();

        $sortBy = null;
        $sortRule = null;
        $perPage = null;
        $offset = null;
        $page = 1;

        if (array_key_exists('page', $searchCriteria)) {
            $page = $searchCriteria['page'];
            unset($searchCriteria['page']);
        }

        if (array_key_exists('sort_by', $searchCriteria) && array_key_exists('sort_rule', $searchCriteria)) {
            $sortBy = $searchCriteria['sort_by'];
            $sortRule = $searchCriteria['sort_rule'];

            unset($searchCriteria['sort_by']);
            unset($searchCriteria['sort_rule']);
        }

        if (array_key_exists('per_page', $searchCriteria)) {
            $perPage = (int) $searchCriteria['per_page'];
            unset($searchCriteria['per_page']);
        }

        if (array_key_exists('random', $searchCriteria)) {
            if ($searchCriteria['random'] == 1) {
                $search = $search->inRandomOrder();
            }
            unset($searchCriteria['random']);
        }

        if (array_key_exists('category', $searchCriteria)) {
            $search = $search->where('category', $searchCriteria['category']);
            unset($searchCriteria['category']);
        }

        if (array_key_exists('category_id', $searchCriteria)) {
            $search = $search->where('category_id', $searchCriteria['category_id']);
            unset($searchCriteria['category_id']);
        }

        if ($offset) {
            $search = $search->where('id', '>=', $offset);
        }

        $result = $search->where($searchCriteria);
        $result = $result->skip($perPage * ($page - 1))->take($perPage);

        if ($sortBy && $sortRule) {
            $result = $result->orderBy($sortBy, $sortRule);
        }

        return $result->paginate($perPage);
    }

    /**
     * Retrieve Category by Id.
     *
     * @return Category
     */
    public function getById(int $id): Category
    {
        return $this->categories->findOrFail($id);
    }

    /**
     * Retrieve total count of categories.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->categories->count();
    }

    /**
     * Update category with provided parameters.
     *
     * @param int   categoryId     - id of the record.
     * @param array $parameters - data to update the record with.
     *
     * @return void
     */
    public function updateCategory(int $categoryId, array $parameters): void
    {
        $categories = $this->getById($categoryId);

        $categories->update($parameters);
    }

    /**
     * Create category with provided parameters.
     *
     * @param array $parameters - data to create record.
     *
     * @return void
     */
    public function createCategory(array $parameters): void
    {
        $this->categories->create($parameters);
    }

    /**
     * Delete category with provided parameters.
     *
     * @param int $categoryId - id of record to delete.
     *
     * @return void
     */
    public function deleteCategory(int $categoryId): void
    {
        $this->categories->destroy($categoryId);
    }
}
