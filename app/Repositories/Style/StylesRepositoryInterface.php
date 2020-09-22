<?php

declare(strict_types=1);

namespace App\Repositories\Style;

use ArrayAccess;
use App\Models\Style;

interface StylesRepositoryInterface
{
    /**
     * Retrieve all styles.
     *
     * @return ArrayAccess<Style>
     */
    public function getAll(): ArrayAccess;

    /**
     * Retrieve styles that correspond to criteria.
     *
     * @return ArrayAccess<Style>
     */
    public function searchStyles(array $searchCriteria): ArrayAccess;

    /**
     * Retrieve styles by Id.
     *
     * @return Style
     */
    public function getById(int $id): Style;

    /**
     * Retrieve total count of styles.
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Update style with provided parameters.
     *
     * @return void
     */
    public function updateStyle(int $id, array $parameters): void;

    /**
     * Create style with provided parameters.
     *
     * @return void
     */
    public function createStyle(array $parameters): void;

    /**
     * Delete style with provided parameters.
     *
     * @return void
     */
    public function deleteStyle(int $id): void;
}
