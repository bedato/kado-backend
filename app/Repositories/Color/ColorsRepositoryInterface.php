<?php

declare(strict_types=1);

namespace App\Repositories\Color;

use ArrayAccess;
use App\Models\Color;

interface ColorsRepositoryInterface
{
    /**
     * Retrieve all colors.
     *
     * @return ArrayAccess<Color>
     */
    public function getAll(): ArrayAccess;

    /**
     * Retrieve colors that correspond to criteria.
     *
     * @return ArrayAccess<Color>
     */
    public function searchColors(array $searchCriteria): ArrayAccess;

    /**
     * Retrieve colors by Id.
     *
     * @return Color
     */
    public function getById(int $id): Color;

    /**
     * Retrieve total count of colors.
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Update color with provided parameters.
     *
     * @return void
     */
    public function updateColor(int $id, array $parameters): void;

    /**
     * Create color with provided parameters.
     *
     * @return void
     */
    public function createColor(array $parameters): void;

    /**
     * Delete color with provided parameters.
     *
     * @return void
     */
    public function deleteColor(int $id): void;
}
