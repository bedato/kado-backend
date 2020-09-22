<?php

declare(strict_types=1);

namespace App\Repositories\Color;

use ArrayAccess;
use App\Models\Color;

class ColorsRepository implements ColorsRepositoryInterface
{
    protected $colors;

    /**
     * ColorsRepository constructor.
     *
     * @param Color $colors - instantiate Model
     */
    public function __construct(Color $colors)
    {
        $this->colors = $colors;
    }

    /**
     * Retrieve all colors.
     *
     * @return ArrayAccess<Color>
     */
    public function getAll(): ArrayAccess
    {
        return $this->colors->all();
    }

    /**
     * Retrieve colors that correspond to criteria.
     *
     * @return ArrayAccess<Color>
     */
    public function searchColors(array $searchCriteria): ArrayAccess
    {
        $search = $this->colors->query();

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

        if (array_key_exists('country_code', $searchCriteria)) {
            $search = $search->where('country_code', $searchCriteria['country_code']);
            unset($searchCriteria['country_code']);
        }
        if (array_key_exists('global_ranking', $searchCriteria)) {
            $search = $search->where('global_ranking', $searchCriteria['global_ranking']);
            unset($searchCriteria['global_ranking']);
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
     * Retrieve Color by Id.
     *
     * @return Color
     */
    public function getById(int $id): Color
    {
        return $this->colors->findOrFail($id);
    }

    /**
     * Retrieve total count of colors.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->colors->count();
    }

    /**
     * Update color with provided parameters.
     *
     * @param int   colorId     - id of the record.
     * @param array $parameters - data to update the record with.
     *
     * @return void
     */
    public function updateColor(int $colorId, array $parameters): void
    {
        $colors = $this->getById($colorId);

        $colors->update($parameters);
    }

    /**
     * Create color with provided parameters.
     *
     * @param array $parameters - data to create record.
     *
     * @return void
     */
    public function createColor(array $parameters): void
    {
        $this->colors->create($parameters);
    }

    /**
     * Delete color with provided parameters.
     *
     * @param int $colorId - id of record to delete.
     *
     * @return void
     */
    public function deleteColor(int $colorId): void
    {
        $this->colors->destroy($colorId);
    }
}
