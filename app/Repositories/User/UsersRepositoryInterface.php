<?php

declare(strict_types=1);

namespace App\Repositories\User;

use ArrayAccess;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * An interface for the UsersRepository.
 *
 * @package Users
 */
interface UsersRepositoryInterface
{
    /**
     * Retrieve all users.
     *
     * @return ArrayAccess
     */
    public function getAll(): ArrayAccess;

    /**
     * Retrieve users that correspond to the criteria.
     *
     * @param array $searchCriteria - list of criteria to search by.
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchUsers(array $searchCriteria): LengthAwarePaginator;

    /**
     * Retrieve user by Id.
     *
     * @param int $id - id of user
     *
     * @return User
     */
    public function getById(int $id): User;

    /**
     * Retrieve total count of users.
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Retrieve user by User Code.
     *
     * @param string $accessToken - Merchant Access token
     * @param string $userCode - User Code of user
     *
     * @return User
     */
    public function getByUserCode(int $merchantId, string $userCode): User;

    /**
     * Update user with provided parameters.
     *
     * @param int   $id         - id of user
     * @param array $parameters - properties to update
     *
     * @return void
     */
    public function updateUser(int $id, array $parameters): void;

    /**
     * Create user with provided parameters.
     *
     * @param array $parameters - properties
     *
     * @return void
     */
    public function createUser(array $parameters): void;

    /**
     * Delete user with provided parameters.
     *
     * @param int $id - id of user
     *
     * @return void
     */
    public function deleteUser(int $id): void;
}
