<?php

declare(strict_types=1);

namespace App\Repositories\Merchant;

use ArrayAccess;
use App\Models\Merchant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * An interface for the MerchantsRepository.
 *
 * @package Merchants
 */
interface MerchantsRepositoryInterface
{
    /**
     * Retrieve all merchants.
     *
     * @return ArrayAccess
     */
    public function getAll(): ArrayAccess;

    /**
     * Retrieve merchants that correspond to the criteria.
     *
     * @param array $searchCriteria - list of criteria to search by.
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchMerchants(array $searchCriteria): LengthAwarePaginator;

    /**
     * Retrieve merchant by Id.
     *
     * @param int $id - id of merchant
     *
     * @return Merchant
     */
    public function getById(int $id): Merchant;

    /**
     * Retrieve total count of merchants.
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Retrieve merchant by Api Token.
     *
     * @param int $apiToken - Api Token of merchant
     *
     * @return Merchant
     */
    public function getByToken($apiToken): Merchant;

    /**
     * Update merchant with provided parameters.
     *
     * @param int   $id         - id of merchant
     * @param array $parameters - properties to update
     *
     * @return void
     */
    public function updateMerchant(int $id, array $parameters): void;

    /**
     * Create merchant with provided parameters.
     *
     * @param array $parameters - properties
     *
     * @return void
     */
    public function createMerchant(array $parameters): void;

    /**
     * Delete merchant with provided parameters.
     *
     * @param int $id - id of merchant
     *
     * @return void
     */
    public function deleteMerchant(int $id): void;
}
