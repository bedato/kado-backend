<?php

declare(strict_types=1);

namespace App\Repositories\User;

use ArrayAccess;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * UsersRepository
 *
 * UsersRepository is a class that interacts with the users data.
 *
 * @category Base_API
 * @package  Users
 * @author   David Ciulla <dave@5degrees.ch>
 * @license  Proprietary https://5degrees.ch
 * @link     https://5degrees.ch
 */
class UsersRepository implements UsersRepositoryInterface
{
    protected $user;

    /**
     * UsersRepository constructor.
     *
     * @param User $user - instantiate Model
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Retrieve all users.
     *
     * @return ArrayAccess
     */
    public function getAll(): ArrayAccess
    {
        return $this->user->all();
    }

    /**
     * Retrieve users that correspond to the criteria.
     *
     * @param array $searchCriteria - list of criteria to search by.
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchUsers(array $searchCriteria): LengthAwarePaginator
    {
        $search = $this->user->query();

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
     * Retrieve user by User Code.
     *
     * @param string $accessToken - Merchant Access token
     * @param string $userCode - User Code of user
     *
     * @return User
     */
    public function getByUserCode(int $merchantId, string $userCode): User
    {
        return $this->user->where('merchant_id', $merchantId)
            ->where('user_code', $userCode)
            ->firstOrFail();
    }

    /**
     * Retrieve user by Id.
     *
     * @param int $id - id of user
     *
     * @return User
     */
    public function getById(int $id): User
    {
        return $this->user->findOrFail($id);
    }

    /**
     * Retrieve total count of users.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->user->count();
    }

    /**
     * Update user with provided parameters.
     *
     * @param int   $id         - id of user
     * @param array $parameters - properties to update
     *
     * @return void
     */
    public function updateUser(int $id, array $parameters): void
    {
        $user = $this->getById($id);

        $user->update($parameters);
    }

    /**
     * Create user with provided parameters.
     *
     * @param array $parameters - properties
     *
     * @return void
     */
    public function createUser(array $parameters): void
    {
        $this->user->create($parameters);
    }

    /**
     * Delete user with provided parameters.
     *
     * @param int $id - id of user
     *
     * @return void
     */
    public function deleteUser(int $id): void
    {
        $this->user->destroy($id);
    }
}
