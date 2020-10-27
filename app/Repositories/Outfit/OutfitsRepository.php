<?php

declare (strict_types = 1);

namespace App\Repositories\Outfit;

use App\Models\Outfit;
use ArrayAccess;

class OutfitsRepository implements OutfitsRepositoryInterface
{
    protected $outfits;

    /**
     * OutfitsRepository constructor.
     *
     * @param Outfit $outfits - instantiate Model
     */
    public function __construct(Outfit $outfits)
    {
        $this->outfits = $outfits;
    }

    /**
     * Retrieve all outfits.
     *
     * @return ArrayAccess<Outfit>
     */
    public function getAll(): ArrayAccess
    {
        return $this->outfits->all();
    }

    /**
     * Retrieve outfits that correspond to criteria.
     *
     * @return ArrayAccess<Outfit>
     */
    public function searchOutfits(array $searchCriteria): ArrayAccess
    {
        $search = $this->outfits->query();

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

        if ($offset) {
            $search = $search->where('id', '>=', $offset);
        }

        $result = $search->where($searchCriteria);
        $result = $result->skip($perPage * ($page - 1))->take($perPage);

        if ($sortBy && $sortRule) {
            $result = $result->orderBy($sortBy, $sortRule);
        }

        return $result->with('items')->paginate($perPage);
    }

    /**
     * Retrieve Outfit by Id.
     *
     * @return Outfit
     */
    public function getById(int $id): Outfit
    {
        return $this->outfits->with('items')->findOrFail($id);
    }

    /**
     * Retrieve outfit by user Id.
     *
     * @param int $userId - id of the record to retrieve
     *
     * @return ArrayAccess
     */
    public function getByUserId(int $userId): ArrayAccess
    {
        return $this->outfits->where('user_id', $userId)->get();
    }

    /**
     * Retrieve total count of outfits.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->outfits->count();
    }

    /**
     * Update outfit with provided parameters.
     *
     * @param int   outfitId     - id of the record.
     * @param array $parameters - data to update the record with.
     *
     * @return void
     */
    public function updateOutfit(int $outfitId, array $parameters): void
    {
        $outfits = $this->getById($outfitId);

        $outfits->update($parameters);
    }

    /**
     * Create outfits with provided parameters.
     *
     * @param array $parameters - data to create record.
     *
     * @return void
     */
    public function createOutfit(array $parameters): void
    {
        $this->outfits->create($parameters);
    }

    /**
     * Delete outfit with provided parameters.
     *
     * @param int $outfitId - id of record to delete.
     *
     * @return void
     */
    public function deleteOutfit(int $outfitId): void
    {
        $this->outfits->destroy($outfitId);
    }
}
