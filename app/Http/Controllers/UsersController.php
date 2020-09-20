<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\SearchUserRequest;
use App\Http\Requests\Api\CreateUserRequest;
use App\Repositories\Merchant\MerchantsRepositoryInterface;
use App\Repositories\User\UsersRepositoryInterface;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lang;

class UsersController extends ApiController
{
    protected $merchantRepository;
    protected $usersRepository;

    /**
     * UsersController constructor.
     *
     * @param MerchantsRepositoryInterface $merchantsRepository - Data repository
     * @param UsersRepositoryInterface     $usersRepository     - Data repository
     */
    public function __construct(
        MerchantsRepositoryInterface $merchantsRepository,
        UsersRepositoryInterface $usersRepository
    ) {
        $this->merchantsRepository = $merchantsRepository;
        $this->usersRepository = $usersRepository;
    }

    /**
     * Get User
     *
     * @param SearchUserRequest $request - Request validator
     *
     * @return \App\Http\Resources\UserResource
     */
    public function index(SearchUserRequest $request): UserResource
    {
        $merchant = $this->merchantsRepository->getByToken(
            $request->header('X-Access-Token')
        );

        $user = $this->usersRepository->getByUserCode(
            $merchant->id,
            $request->header('X-User-Code')
        );

        return new UserResource($user);
    }

    /**
     * Create user.
     *
     * @param CreateUserRequest $request  - incoming request
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $merchant = $this->merchantsRepository->getByToken(
            $request->header('X-Access-Token')
        );

        $data = $request->validated();
        $data['merchant_id'] = $merchant->id;

        $this->usersRepository->createUser($data);

        return response()->json(['status' => Lang::get('messages.users.store_success')]);
    }

    /**
     * Delete user.
     *
     * @param int     $id      - user id
     * @param Request $request - Incoming request
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        $merchant = $this->merchantsRepository->getByToken(
            $request->header('X-Access-Token')
        );

        $user = $this->usersRepository->getByUserCode(
            $merchant->id,
            $request->header('X-User-Code')
        );

        $effective_user = $this->usersRepository->getById($id);

        if (!$effective_user) {
            return response()->json([
                'success' => false,
                'message' => Lang::get('messages.user.not_found')
            ]);
        }

        if ($effective_user->user_id != $user->id) {
            return response()->json([
                'success' => false,
                'message' => Lang::get('messages.user.not_allowed')
            ]);
        }

        $this->usersRepository->deleteUser($id);

        return response()->json([
            'success' => true,
            'message' => Lang::get('messages.users.user_deleted')
        ]);
    }
}
