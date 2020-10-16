<?php

declare(strict_types=1);

namespace App\Repositories\Category;

use ArrayAccess;
use App\Models\Category;

interface CategoriesRepositoryInterface
{
    /**
     * Retrieve all categories.
     *
     * @return ArrayAccess<Category>
     */
    public function getAll(): ArrayAccess;

    /**
     * Retrieve Categories that correspond to criteria.
     *
     * @return ArrayAccess<Category>
     */
    public function searchCategories(array $searchCriteria): ArrayAccess;

    /**
     * Retrieve Categories by Id.
     *
     * @return Category
     */
    public function getById(int $id): Category;

    /**
     * Retrieve total count of Categories.
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Update Category with provided parameters.
     *
     * @return void
     */
    public function updateCategory(int $id, array $parameters): void;

    /**
     * Create Category with provided parameters.
     *
     * @return void
     */
    public function createCategory(array $parameters): void;

    /**
     * Delete Category with provided parameters.
     *
     * @return void
     */
    public function deleteCategory(int $id): void;
}
