<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Outfit;
use App\Http\Resources\OutfitResource;
use App\Http\Resources\OutfitsResourceCollection;
use App\Http\Requests\Api\SearchOutfitsRequest;
use App\Http\Requests\Api\CreateOutfitRequest;
use App\Repositories\Outfit\OutfitsRepositoryInterface;
use Illuminate\Http\JsonResponse;

class OutfitsController extends ApiController
{
    private $outfitsRepository;
    private $outfit;

    /**
     * OutfitsController constructor.
     *
     * @param OutfitsRepositoryInterface $outfitsRepository
     */
    public function __construct(OutfitsRepositoryInterface $outfitsRepository)
    {
        $this->repository = $outfitsRepository;
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
        $this->outfitsRepository->createOutfit($request->validated());

        return Lang::get('admin.outfits.outfit_created');
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
