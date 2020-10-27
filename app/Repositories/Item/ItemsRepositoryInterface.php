<?php

declare(strict_types=1);

namespace App\Repositories\Item;

use ArrayAccess;
use App\Models\Item;

interface ItemsRepositoryInterface
{
    /**
     * Retrieve all items.
     *
     * @return ArrayAccess<Item>
     */
    public function getAll(): ArrayAccess;

    /**
     * Retrieve items that correspond to criteria.
     *
     * @return ArrayAccess<Item>
     */
    public function searchItems(array $searchCriteria): ArrayAccess;

    /**
     * Retrieve items by Id.
     *
     * @return Item
     */
    public function getById(int $id): Item;

    public function getFiltered(int $userId);

    /**
     * Retrieve item by Id.
     *
     * @param int $userId - id of the user to search by.
     *
     * @return Item
     */
    public function getByUserId(int $userId): ArrayAccess;

    /**
     * Retrieve total count of items.
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Update item with provided parameters.
     *
     * @return void
     */
    public function updateItem(int $id, array $parameters): void;

    /**
     * Create item with provided parameters.
     *
     * @return void
     */
    public function createItem(array $parameters): void;


    /**
     * Delete item with provided parameters.
     *
     * @return void
     */
    public function deleteItem(int $id): void;
}
