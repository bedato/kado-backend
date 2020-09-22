<?php

declare(strict_types=1);

namespace App\Repositories\Item;

use ArrayAccess;
use App\Models\Item;

class ItemsRepository implements ItemsRepositoryInterface
{
    protected $items;

    /**
     * ItemsRepository constructor.
     *
     * @param Item $items - instantiate Model
     */
    public function __construct(Item $items)
    {
        $this->items = $items;
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

        if (array_key_exists('country_code', $searchCriteria)) {
            $search = $search->where('country_code', $searchCriteria['country_code']);
            unset($searchCriteria['country_code']);
        }
        if (array_key_exists('global_ranking', $searchCriteria)) {
            $search = $search->where('global_ranking', $searchCriteria['global_ranking']);
            unset($searchCriteria['global_ranking']);
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
