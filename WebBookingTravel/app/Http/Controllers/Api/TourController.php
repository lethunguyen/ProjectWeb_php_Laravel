<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TourController extends Controller
{
    public function index()
    {
        return response()->json(
            Tour::with('images', 'category')->orderByDesc('tourID')->paginate(10)
        );
    }

    public function show($id)
    {
        $tour = Tour::with('images', 'category')->where('tourID', $id)->firstOrFail();
        return response()->json($tour);
    }

    /**
     * GET /api/v1/tours/destinations
     * Returns unique departurePoint with tour count.
     */
    public function destinations()
    {
        $query = Tour::query();
        $table = (new Tour)->getTable();
        $useDestCol = Schema::hasColumn($table, 'departurePoint');
        if ($useDestCol) {
            $items = $query
                ->selectRaw('departurePoint, COUNT(*) as count')
                ->whereNotNull('departurePoint')
                ->groupBy('departurePoint')
                ->orderByDesc('count')
                ->limit(200)
                ->get()
                ->map(fn($r) => [
                    'departurePoint' => $r->departurePoint,
                    'count' => (int) $r->count,
                ]);
        } else {
            // Fallback: group by title to still provide selectable list
            $items = $query
                ->selectRaw('title as departurePoint, COUNT(*) as count')
                ->groupBy('departurePoint')
                ->orderByDesc('count')
                ->limit(200)
                ->get()
                ->map(fn($r) => [
                    'departurePoint' => $r->departurePoint,
                    'count' => (int) $r->count,
                ]);
        }

        // Secondary fallback: if still empty, return all distinct titles as single-count entries
        if (($items?->count() ?? 0) === 0) {
            $titles = $query->select('title')->limit(200)->pluck('title')->filter()->unique();
            $items = $titles->map(fn($t) => ['departurePoint' => $t, 'count' => 1])->values();
        }

        return response()->json($items ?? []);
    }

    /**
     * GET /api/v1/tours/pickup-points
     * Returns flat pickupPoint list (distinct).
     */
    public function pickupPoints()
    {
        $query = Tour::query();
        $table = (new Tour)->getTable();
        $hasPickup = Schema::hasColumn($table, 'pickupPoint');

        if ($hasPickup) {
            $items = $query->whereNotNull('pickupPoint')
                ->distinct()
                ->orderBy('pickupPoint')
                ->limit(300)
                ->pluck('pickupPoint')
                ->values();
        } else {
            // Fallback: derive pseudo pickup list from first words of tour names (demo) limited
            $raw = $query->selectRaw('title as name')
                ->limit(300)->pluck('name')->filter();
            $items = $raw->map(function ($n) {
                $parts = preg_split('/\s+/', trim($n));
                return $parts[0] ?? $n; // first token
            })->unique()->values();
        }

        if (($items?->count() ?? 0) === 0) {
            // Last resort: return first 5 raw titles for debugging front-end visibility
            $debug = $query->select('title')->limit(5)->pluck('title')->filter();
            if ($debug->count()) $items = $debug->values();
        }

        return response()->json($items ?? []);
    }
}
