<?php

declare(strict_types=1);

namespace App\Repositories\Post;

use App\Models\Post;
use ArrayAccess;
use Illuminate\Database\Eloquent\Collection;

interface PostsRepositoryInterface
{
    /**
     * Retrieve posts that correspond to the criteria.
     *
     * @param array $searchCriteria - criteria for search
     *
     * @return ArrayAccess
     */
    public function searchPosts(array $searchCriteria): ArrayAccess;

    /**
     * Retrieve post by Id.
     *
     * @param int $postId - id of the record to retrieve
     *
     * @return Post
     */
    public function getById(int $postId): Post;

    /**
     * Retrieve post by Id.
     *
     * @param int $userId - id of the user to search by.
     *
     * @return Post
     */
    public function getByUserId(int $userId): ArrayAccess;

    /**
     * Create post with provided parameters.
     *
     * @param array $parameters - data to create record
     *
     * @return void
     */
    public function createPost(array $parameters): void;

    /**
     * Delete posts with provided parameters.
     *
     * @param int $postId - id for record to be deleted
     *
     * @return void
     */
    public function deletePost(int $postId): void;
}
