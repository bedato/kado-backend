<?php

declare(strict_types=1);

namespace App\Repositories\Shape;

use ArrayAccess;
use App\Models\Shape;

interface ShapesRepositoryInterface
{
    /**
     * Retrieve all shapes.
     *
     * @return ArrayAccess<Shape>
     */
    public function getAll(): ArrayAccess;

    /**
     * Retrieve shapes that correspond to criteria.
     *
     * @return ArrayAccess<Shape>
     */
    public function searchShapes(array $searchCriteria): ArrayAccess;

    /**
     * Retrieve shapes by Id.
     *
     * @return Shape
     */
    public function getById(int $id): Shape;

    /**
     * Retrieve total count of shapes.
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Update shape with provided parameters.
     *
     * @return void
     */
    public function updateShape(int $id, array $parameters): void;

    /**
     * Create shape with provided parameters.
     *
     * @return void
     */
    public function createShape(array $parameters): void;

    /**
     * Delete shape with provided parameters.
     *
     * @return void
     */
    public function deleteShape(int $id): void;
}
