<?php

declare(strict_types=1);

namespace App\Repositories\Style;

use ArrayAccess;
use App\Models\Style;

class StylesRepository implements StylesRepositoryInterface
{
    protected $styles;

    /**
     * StylesRepository constructor.
     *
     * @param Style $styles - instantiate Model
     */
    public function __construct(Style $styles)
    {
        $this->styles = $styles;
    }

    /**
     * Retrieve all styles.
     *
     * @return ArrayAccess<Style>
     */
    public function getAll(): ArrayAccess
    {
        return $this->styles->all();
    }

    /**
     * Retrieve styles that correspond to criteria.
     *
     * @return ArrayAccess<Style>
     */
    public function searchStyles(array $searchCriteria): ArrayAccess
    {
        $search = $this->styles->query();

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
     * Retrieve Style by Id.
     *
     * @return Style
     */
    public function getById(int $id): Style
    {
        return $this->styles->findOrFail($id);
    }

    /**
     * Retrieve total count of styles.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->styles->count();
    }

    /**
     * Update style with provided parameters.
     *
     * @param int   styleId     - id of the record.
     * @param array $parameters - data to update the record with.
     *
     * @return void
     */
    public function updateStyle(int $styleId, array $parameters): void
    {
        $styles = $this->getById($styleId);

        $styles->update($parameters);
    }

    /**
     * Create style with provided parameters.
     *
     * @param array $parameters - data to create record.
     *
     * @return void
     */
    public function createStyle(array $parameters): void
    {
        $this->styles->create($parameters);
    }

    /**
     * Delete style with provided parameters.
     *
     * @param int $styleId - id of record to delete.
     *
     * @return void
     */
    public function deleteStyle(int $styleId): void
    {
        $this->styles->destroy($styleId);
    }
}
