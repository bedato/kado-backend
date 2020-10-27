<?php

declare (strict_types = 1);

namespace App\Repositories\Merchant;

use App\Models\Merchant;
use ArrayAccess;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

/**
 * MerchantsRepository
 *
 * MerchantsRepository is a class that interacts with the merchants data.
 *
 * @category Base_API
 * @package  Merchants
 */
class MerchantsRepository implements MerchantsRepositoryInterface
{
    protected $merchant;

    /**
     * MerchantsRepository constructor.
     *
     * @param Merchant $merchant - instantiate Model
     */
    public function __construct(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

    /**
     * Retrieve all merchants.
     *
     * @return ArrayAccess
     */
    public function getAll(): ArrayAccess
    {
        return $this->merchant->all();
    }

    /**
     * Retrieve merchants that correspond to the criteria.
     *
     * @param array $searchCriteria - list of criteria to search by.
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchMerchants(array $searchCriteria): LengthAwarePaginator
    {
        $search = $this->merchant->query();

        $sortBy = null;
        $sortRule = null;
        $perPage = config('constants.pagination_default_limit');
        $offset = null;
        $page = 1;

        if (array_key_exists('page', $searchCriteria)) {
            $page = $searchCriteria['page'];
            unset($searchCriteria['page']);
        }

        if (
            array_key_exists('sort_by', $searchCriteria)
            && array_key_exists('sort_rule', $searchCriteria)
        ) {
            $sortBy = $searchCriteria['sort_by'];
            $sortRule = $searchCriteria['sort_rule'];

            unset($searchCriteria['sort_by']);
            unset($searchCriteria['sort_rule']);
        }

        if (array_key_exists('per_page', $searchCriteria)) {
            $perPage = $searchCriteria['per_page'];
            unset($searchCriteria['per_page']);
        }

        if (array_key_exists('random', $searchCriteria)) {
            if ($searchCriteria['random'] == 1) {
                $search = $search->inRandomOrder();
            }
            unset($searchCriteria['random']);
        }

        if (array_key_exists('email', $searchCriteria)) {
            $search = $search->where('email', 'LIKE', '%' . $searchCriteria['email'] . '%');
            unset($searchCriteria['email']);
        }

        if (array_key_exists('api_token', $searchCriteria)) {
            $search = $search->where('api_token', $searchCriteria['api_token']);
            unset($searchCriteria['api_token']);
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
     * Retrieve merchant by Api Token.
     *
     * @param int $apiToken - Api Token of merchant
     *
     * @return Merchant
     */
    public function getByToken($apiToken): Merchant
    {
        return Merchant::where('api_token', $apiToken)->firstOrFail();
    }

    /**
     * Retrieve merchant by Id.
     *
     * @param int $id - id of merchant
     *
     * @return Merchant
     */
    public function getById(int $id): Merchant
    {
        return $this->merchant->findOrFail($id);
    }

    /**
     * Retrieve total count of merchants.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->merchant->count();
    }

    /**
     * Update merchant with provided parameters.
     *
     * @param int   $id         - id of merchant
     * @param array $parameters - properties to update
     *
     * @return void
     */
    public function updateMerchant(int $id, array $parameters): void
    {
        $merchant = $this->getById($id);

        if ($parameters['password']) {
            $parameters['password'] = bcrypt($parameters['password']);
        }

        $merchant->update($parameters);
    }

    /**
     * Create merchant with provided parameters.
     *
     * @param array $parameters - properties
     *
     * @return void
     */
    public function createMerchant(array $parameters): void
    {
        $parameters['password'] = bcrypt($parameters['password']);
        $parameters['api_token'] = md5(uniqid(Str::random(), true));

        $this->merchant->create($parameters);
    }

    /**
     * Delete merchant with provided parameters.
     *
     * @param int $id - id of merchant
     *
     * @return void
     */
    public function deleteMerchant(int $id): void
    {
        $this->merchant->destroy($id);
    }
}
