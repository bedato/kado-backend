<?php

declare (strict_types = 1);

namespace App\Repositories\Outfit;

use App\Models\Outfit;
use ArrayAccess;

interface OutfitsRepositoryInterface
{
    /**
     * Retrieve all outfits.
     *
     * @return ArrayAccess<Outfit>
     */
    public function getAll(): ArrayAccess;

    /**
     * Retrieve outfits that correspond to criteria.
     *
     * @return ArrayAccess<Outfit>
     */
    public function searchOutfits(array $searchCriteria): ArrayAccess;

    /**
     * Retrieve outfits by Id.
     *
     * @return Outfit
     */
    public function getById(int $id): Outfit;

    /**
     * Retrieve outfit by Id.
     *
     * @param int $userId - id of the user to search by.
     *
     * @return Outfit
     */
    public function getByUserId(int $userId): ArrayAccess;

    /**
     * Retrieve total count of outfits.
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Update outfits with provided parameters.
     *
     * @return void
     */
    public function updateOutfit(int $id, array $parameters): void;

    /**
     * Create outfit with provided parameters.
     *
     * @return void
     */
    public function createOutfit(array $parameters): void;

    /**
     * Delete outfit with provided parameters.
     *
     * @return void
     */
    public function deleteOutfit(int $id): void;
}
