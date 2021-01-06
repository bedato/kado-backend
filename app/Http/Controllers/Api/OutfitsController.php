<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateOutfitRequest;
use App\Http\Requests\Api\SearchOutfitsRequest;
use App\Http\Resources\OutfitResource;
use App\Http\Resources\OutfitsResourceCollection;
use App\Models\Outfit;
use App\Repositories\Merchant\MerchantsRepositoryInterface;
use App\Repositories\Outfit\OutfitsRepositoryInterface;
use App\Repositories\User\UsersRepositoryInterface;
use Illuminate\Http\JsonResponse;

class OutfitsController extends ApiController
{
    private $outfitsRepository;
    private $outfit;
    protected $usersRepository;
    protected $merchantRepository;

    /**
     * OutfitsController constructor.
     *
     * @param OutfitsRepositoryInterface $outfitsRepository
     * @param UsersRepositoryInterface     $usersRepository
     * @param MerchantsRepositoryInterface $merchantsRepository - Data repository
     */
    public function __construct(
        OutfitsRepositoryInterface $outfitsRepository,
        UsersRepositoryInterface $usersRepository,
        MerchantsRepositoryInterface $merchantsRepository
    ) {
        $this->repository = $outfitsRepository;
        $this->usersRepository = $usersRepository;
        $this->merchantsRepository = $merchantsRepository;
        $this->outfit = new Outfit();
    }

    /**
     * Get outfits list
     *
     * @return \App\Http\Resources\OutfitsResourceCollection
     */
    public function index(SearchOutfitsRequest $request): OutfitsResourceCollection
    {
        $outfits = $this->repository->searchOutfits(
            $request->validated()
        );

        return new OutfitsResourceCollection($outfits);
    }

    /**
     * Store outfit.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(CreateOutfitRequest $request): JsonResponse
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
        $data['items_id'] = $user->items;

        $this->repository->createOutfit($data);

        return response()->json('Outfit created successfully');
    }

    /**
     * Get specific outfit by id.
     *
     * @return \App\Http\Resources\OutfitResource
     */
    public function show(int $id): OutfitResource
    {
        return new OutfitResource($this->repository->getById($id));
    }
}