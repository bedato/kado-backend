<?php

declare(strict_types=1);

namespace App\Repositories\Post;

use ArrayAccess;
use App\Models\Outfit;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class PostsRepository implements PostsRepositoryInterface
{
    protected $post;

    /**
     * PostsRepository constructor
     *
     * @param Post $post - data model
     **/
    public function __construct(
        Post $post
    ) {
        $this->post = $post;
    }

    /**
     * Retrieve posts that correspond to the criteria
     *
     * @param array $searchCriteria - criteria for search
     *
     * @return ArrayAccess
     **/
    public function searchPosts(array $searchCriteria): ArrayAccess
    {
        $search = $this->post->query();

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

        if (array_key_exists('outfit_id', $searchCriteria)) {
            $search = $search->where('outfit_id', $searchCriteria['outfit_id']);
            unset($searchCriteria['outfit_id']);
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

        return $result->with('outfit')->paginate($perPage);
    }

    /**
     * Retrieve post by Id.
     *
     * @param int $postId - id of the record to retrieve
     *
     * @return Post
     */
    public function getById(int $postId): Post
    {
        return $this->post->with('outfit')->findOrFail($postId);
    }

    /**
     * Retrieve post by Id.
     *
     * @param int $userId - id of the record to retrieve
     *
     * @return ArrayAccess
     */
    public function getByUserId(int $userId): ArrayAccess
    {
        return $this->post->where('user_id', $userId)->get();
    }

    /**
     * Create post with provided parameters.
     *
     * @param array $parameters - data to create record
     *
     * @return void
     */
    public function createPost(array $parameters): void
    {
        $this->post->create($parameters);
    }

    /**
     * Delete post with provided parameters.
     *
     * @param int $postId - id for record to be deleted
     *
     * @return void
     */
    public function deletePost(int $postId): void
    {
        $this->post->destroy($postId);
    }
}
