<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Repositories\Post\PostsRepositoryInterface;
use App\Repositories\User\UsersRepositoryInterface;
use App\Repositories\Merchant\MerchantsRepositoryInterface;
use App\Http\Requests\Api\SearchPostsRequest;
use App\Http\Requests\Api\CreatePostRequest;
use App\Http\Resources\PostResourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lang;

class PostsController extends ApiController
{
    protected $postsRepository;
    protected $usersRepository;
    protected $merchantsRepository;
    protected $post;

    /**
     * PostsController constructor.
     *
     * @param PostsRepositoryInterface $postsRepository - data
     * @param UsersRepositoryInterface $usersRepository - data
     * @param MerchantsRepositoryInterface $merchantsRepository - data
     */
    public function __construct(
        PostsRepositoryInterface $postsRepository,
        UsersRepositoryInterface $usersRepository,
        MerchantsRepositoryInterface $merchantsRepository
    ) {
        $this->postsRepository = $postsRepository;
        $this->usersRepository = $usersRepository;
        $this->merchantsRepository = $merchantsRepository;
        $this->post = new Post();
    }

    /**
     * Get posts
     *
     * @param SearchPostsRequest $request  - incoming request
     *
     * @return \App\Http\Resources\PostResourceCollection
     */
    public function index(SearchPostsRequest $request): PostResourceCollection
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

        $post = $this->postsRepository->searchPosts($data);

        return new PostResourceCollection($post);
    }

    /**
     * Create post.
     *
     * @param CreatePostRequest $request  - incoming request
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function store(CreatePostRequest $request): JsonResponse
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

        $this->postsRepository->createPost($data);

        return response()->json([
            'success' => true,
            'message' => Lang::get('messages.post.store_success')
        ]);
    }

    /**
     * Delete post.
     *
     * @param int     $id      - Post id
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

        $post = $this->postsRepository->getById($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => Lang::get('messages.post.not_found')
            ]);
        }

        if ($post->user_id != $user->id) {
            return response()->json([
                'success' => false,
                'message' => Lang::get('messages.post.not_allowed')
            ]);
        }

        $this->postsRepository->deletePost($id);

        return response()->json([
            'success' => true,
            'message' => Lang::get('messages.posts.deleted')
        ]);
    }
}
