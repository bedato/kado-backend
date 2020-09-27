<?php

declare(strict_types=1);

namespace App\Repositories\Shape;

use ArrayAccess;
use App\Models\Shape;

class ShapesRepository implements ShapesRepositoryInterface
{
    protected $shapes;

    /**
     * ShapesRepository constructor.
     *
     * @param Shape $shapes - instantiate Model
     */
    public function __construct(Shape $shapes)
    {
        $this->shapes = $shapes;
    }

    /**
     * Retrieve all shapes.
     *
     * @return ArrayAccess<Shape>
     */
    public function getAll(): ArrayAccess
    {
        return $this->shapes->all();
    }

    /**
     * Retrieve shapes that correspond to criteria.
     *
     * @return ArrayAccess<Shape>
     */
    public function searchShapes(array $searchCriteria): ArrayAccess
    {
        $search = $this->shapes->query();

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
     * Retrieve Shape by Id.
     *
     * @return Shape
     */
    public function getById(int $id): Shape
    {
        return $this->shapes->findOrFail($id);
    }

    /**
     * Retrieve total count of shapes.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->shapes->count();
    }

    /**
     * Update shape with provided parameters.
     *
     * @param int   shapeId     - id of the record.
     * @param array $parameters - data to update the record with.
     *
     * @return void
     */
    public function updateShape(int $shapeId, array $parameters): void
    {
        $shapes = $this->getById($shapeId);

        $shapes->update($parameters);
    }

    /**
     * Create shape with provided parameters.
     *
     * @param array $parameters - data to create record.
     *
     * @return void
     */
    public function createShape(array $parameters): void
    {
        $this->shapes->create($parameters);
    }

    /**
     * Delete shape with provided parameters.
     *
     * @param int $shapeId - id of record to delete.
     *
     * @return void
     */
    public function deleteShape(int $shapeId): void
    {
        $this->shapes->destroy($shapeId);
    }
}
