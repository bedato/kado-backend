<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemsResourceCollection;
use App\Http\Requests\Api\SearchItemsRequest;
use App\Http\Requests\Api\CreateItemRequest;
use App\Repositories\Item\ItemsRepositoryInterface;
use App\Repositories\User\UsersRepositoryInterface;
use App\Repositories\Merchant\MerchantsRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ItemsController extends ApiController
{
    private $itemsRepository;
    private $item;
    protected $usersRepository;
    protected $merchantRepository;

    /**
     * ItemsController constructor.
     *
     * @param ItemsRepositoryInterface $itemsRepository
     * @param UsersRepositoryInterface     $usersRepository
     * @param MerchantsRepositoryInterface $merchantsRepository - Data repository
     */
    public function __construct(
        ItemsRepositoryInterface $itemsRepository,
        UsersRepositoryInterface $usersRepository,
        MerchantsRepositoryInterface $merchantsRepository
    ) {
        $this->repository = $itemsRepository;
        $this->usersRepository = $usersRepository;
        $this->merchantsRepository = $merchantsRepository;
        $this->item = new Item();
    }

    /**
     * Get items list
     *
     * @param SearchItemsRequest $request  - incoming request
     *
     * @return \App\Http\Resources\ItemsResourceCollection
     */
    public function index(SearchItemsRequest $request)//: ItemsResourceCollection
    {
        $data = $request->validated();

        $merchant = $this->merchantsRepository->getByToken(
            $request->header('X-Access-Token')
        );

        $user = $this->usersRepository->getByUserCode(
            $merchant->id,
            $request->header('X-User-Code')
        );

        $data['user_id'] = $user->id;

        $items = $this->repository->getFiltered($user->id);
        return ($items);

        return new ItemsResourceCollection($items);
    }

    /**
     * Store item.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(CreateItemRequest $request): JsonResponse
    {
        $merchant = $this->merchantsRepository->getByToken(
            $request->header('X-Access-Token')
        );

        $user = $this->usersRepository->getByUserCode(
            $merchant->id,
            $request->header('X-User-Code')
        );

        $data = $request->validated();
        $data['user_id'] = $user->id;

        $this->repository->createItem($data);

        return response()->json('messages.items.store_success');
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
