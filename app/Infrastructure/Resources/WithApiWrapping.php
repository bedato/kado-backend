<?php

declare(strict_types=1);

namespace App\Infrastructure\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait WithApiWrapping
{
    public function getDefaultMetaProperties($request)
    {
        $meta = [];

        if ($this->resource instanceof LengthAwarePaginator) {
            $meta['results'] = $this->resource->count();
        }

        $meta['method'] = $request->getMethod();
        $meta['endpoint'] = $request->getRequestUri();

        return $meta;
    }

    public function getRequestDuration($request)
    {
        if (!defined('LARAVEL_START')) {
            // On some environments like testing, we may not
            // have real HTTP queries, so this variable
            // may be undefined
            return 0;
        }

        return microtime(true) - LARAVEL_START;
    }

    public function with($request)
    {
        return [
            'success' => true,
            'meta' => $this->getDefaultMetaProperties($request),
            'errors' => (object) [],
            'duration' => $this->getRequestDuration($request),
        ];
    }
}
