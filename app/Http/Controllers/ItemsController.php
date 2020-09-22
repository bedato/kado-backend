<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemsResourceCollection;
use App\Http\Requests\Api\SearchItemsRequest;
use App\Repositories\Item\ItemsRepositoryInterface;

class ItemsController extends ApiController
{
    private $itemsRepository;
    private $item;

    /**
     * ItemsController constructor.
     *
     * @param ItemsRepositoryInterface $itemsRepository
     */
    public function __construct(ItemsRepositoryInterface $itemsRepository)
    {
        $this->repository = $itemsRepository;
        $this->item = new Item();
    }

    /**
     * Get items list
     *
     * @return \App\Http\Resources\ItemsResourceCollection
     */
    public function index(SearchItemsRequest $request): ItemsResourceCollection
    {
        $items = $this->repository->searchItems(
            $request->validated()
        );

        return new ItemsResourceCollection($items);
    }

    /**
     * Get specific item by id.
     *
     * @return \App\Http\Resources\ItemResource
     */
    public function show(int $id): ItemResource
    {
        return new ItemResource($this->repository->getById($id));
    }
}
