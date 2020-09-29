<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemsResourceCollection;
use App\Http\Requests\Api\SearchItemsRequest;
use App\Http\Requests\Api\CreateItemRequest;
use App\Repositories\Item\ItemsRepositoryInterface;
use Illuminate\Http\JsonResponse;

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
     * Store item.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(CreateItemRequest $request): JsonResponse
    {
        $this->itemsRepository->createItem($request->validated());

        return Lang::get('admin.items.item_created');
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
