<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use RuntimeException;

class FakeStoreClient
{
    private const BASE_URL = 'https://fakestoreapi.com/products';

    /**
     * Fetch products from the Fake Store API.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function fetchProducts(int $limit = 10): Collection
    {
        $response = Http::timeout(10)->get(self::BASE_URL, [
            'limit' => $limit,
        ]);

        if (!$response->successful()) {
            throw new RuntimeException('Failed to fetch products from Fake Store API.');
        }

        $data = $response->json();

        if (!is_array($data)) {
            throw new RuntimeException('Unexpected response structure from Fake Store API.');
        }

        return collect($data)
            ->map(function ($item): array {
                return [
                    'name' => $item['title'] ?? 'Unknown Product',
                    'price' => (float) ($item['price'] ?? 0),
                    'stock' => (int) ($item['rating']['count'] ?? 0),
                    'description' => $item['description'] ?? null,
                ];
            });
    }
}
