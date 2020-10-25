<?php

declare(strict_types=1);

namespace App\Repositories\Item;

use App\Models\User;
use App\Models\Category;
use ArrayAccess;
use App\Models\Item;

class ItemsRepository implements ItemsRepositoryInterface
{
    protected $items;
    protected $categories;

    /**
     * ItemsRepository constructor.
     *
     * @param Item $items - instantiate Model
     * @param Category $categories - instantiate Model
     */
    public function __construct(Item $items, Category $categories)
    {
        $this->items = $items;
        $this->categories = $categories;
    }

    /**
     * Retrieve all items.
     *
     * @return ArrayAccess<Item>
     */
    public function getAll(): ArrayAccess
    {
        return $this->items->all();
    }

    /**
     * Retrieve all items.
     *
     */
    public function getFiltered(int $userId)
    {
        $categories = $this->categories->select('category_id')->distinct()->get()->pluck('category_id');
        $suggestedItems = collect($categories)->map(function($category) use($userId) {
            return $this->items->where('user_id', $userId)
            ->where('category_id', $category)
                ->inRandomOrder()
                ->first();
        });
        return $suggestedItems;
    }

    /**
     * Retrieve items that correspond to criteria.
     *
     * @return ArrayAccess<Item>
     */
    public function searchItems(array $searchCriteria): ArrayAccess
    {
        $search = $this->items->query();

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


        if (array_key_exists('user_id', $searchCriteria)) {
            $search = $search->where('user_id', $searchCriteria['user_id']);
            unset($searchCriteria['user_id']);
        }

        if (array_key_exists('category', $searchCriteria)) {
            $search = $search->where('category', $searchCriteria['category']);
            unset($searchCriteria['category']);
        }

        if (array_key_exists('category_id', $searchCriteria)) {
            $search = $search->where('category_id', $searchCriteria['category_id']);
            unset($searchCriteria['category_id']);
        }

        if (array_key_exists('season', $searchCriteria)) {
            $search = $search->where('season', $searchCriteria['season']);
            unset($searchCriteria['season']);
        }

        if (array_key_exists('color', $searchCriteria)) {
            $search = $search->where('color', $searchCriteria['color']);
            unset($searchCriteria['color']);
        }

        if (array_key_exists('style', $searchCriteria)) {
            $search = $search->where('style', $searchCriteria['style']);
            unset($searchCriteria['style']);
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
     * Retrieve Item by Id.
     *
     * @return Item
     */
    public function getById(int $id): Item
    {
        return $this->items->findOrFail($id);
    }

    /**
     * Retrieve item by user Id.
     *
     * @param int $userId - id of the record to retrieve
     *
     * @return ArrayAccess
     */
    public function getByUserId(int $userId): ArrayAccess
    {
        return $this->items->where('user_id', $userId)->get();
    }

    /**
     * Retrieve total count of items.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->items->count();
    }

    /**
     * Update item with provided parameters.
     *
     * @param int   itemId     - id of the record.
     * @param array $parameters - data to update the record with.
     *
     * @return void
     */
    public function updateItem(int $itemId, array $parameters): void
    {
        $items = $this->getById($itemId);

        $items->update($parameters);
    }

    /**
     * Create item with provided parameters.
     *
     * @param array $parameters - data to create record.
     *
     * @return void
     */
    public function createItem(array $parameters): void
    {
        $this->items->create($parameters);
    }


    /**
     * Delete item with provided parameters.
     *
     * @param int $itemId - id of record to delete.
     *
     * @return void
     */
    public function deleteItem(int $itemId): void
    {
        $this->items->destroy($itemId);
    }
}
