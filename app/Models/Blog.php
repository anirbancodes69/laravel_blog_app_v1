<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Blog extends Model
{
    use HasFactory;

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withCount([
            'comments' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])->orderByDesc('comments_count');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvg(
            [
                'comments' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
            ],
            'rating'
        )->orderBy('comments_avg_rating', 'desc');
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if ($from != null && $to == null) {
            $query->where('created_at', '>=', $from);
        } else if ($from == null && $to != null) {
            $query->where('created_at', '<=', $to);
        } else if ($from != null && $to != null) {
            $query->whereBetween('created_at', [$from, $to]);
        } else {
            $query->where('created_at', '>=', now()->subDays(30));
        }
    }

    public function scopeMinComments(Builder $query, int $minReview)
    {
        return $query->having('comments_count', '>=', $minReview);
    }


    public function scopePopularLastMonth(Builder $query): Builder | QueryBuilder
    {
        return $query->popular(now()->subMonth(), now())
            ->highestRated(now()->subMonth(), now())
            ->minComments(2);
    }

    public function scopePopularLast6Month(Builder $query): Builder | QueryBuilder
    {
        return $query->popular(now()->subMonth(6), now())
            ->highestRated(now()->subMonth(6), now())
            ->minComments(5);
    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder | QueryBuilder
    {
        return $query->highestRated(now()->subMonth(), now())
            ->popular(now()->subMonth(), now())
            ->minComments(2);
    }

    public function scopeHighestRatedLast6Month(Builder $query): Builder | QueryBuilder
    {
        return $query->highestRated(now()->subMonth(6), now())
            ->popular(now()->subMonth(6), now())
            ->minComments(5);
    }
}
