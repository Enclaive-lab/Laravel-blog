<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Override;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    #[Override]
    public function getPublishedPaginated(?string $search, int $perPage): LengthAwarePaginator
    {
        $query = Post::where('is_published', 1);

        $search = trim((string)$search);
        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('published_at', 'desc')->paginate($perPage)->withQueryString();
    }


    #[Override]
    public function findPublishedBySlugOrFail(string $slug): Post
    {
        return Post::query()->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
    }
    #[Override]
    public function getPaginated(int $perPage): PaginationLengthAwarePaginator
    {
        return Post::latest()->paginate($perPage);
    }


    #[Override]
    public function allApi(): Collection
    {
        return Post::where('is_published', true)->latest()->get();
    }


    #[Override]
    public function findApi(int $id): ?Post
    {
        return Post::find($id);
    }

    #[Override]
    public function createApi(array $data): Post
    {
        return Post::create($data);
    }


    #[Override]
    public function updateApi(Post $post, array $data): Post
    {
        $post->update($data);
        return $post;
    }



    #[Override]
    public function softDelete(Post $post): bool
    {
        return $post->delete();
    }

    #[Override]
    public function findTrashed(int $id): ?Post
    {
        return Post::onlyTrashed()->find($id);
    }

    #[Override]
    public function restore(int $id): ?Post
    {
        $post = Post::onlyTrashed()->find($id);
        if (!$post) return null;

        $post->restore();
        return $post;
    }

    #[Override]
    public function forceDelete(int $id): bool
    {
        $post = Post::onlyTrashed()->find($id);
        if (!$post) return false;

        return $post->forceDelete();
    }

    #[Override]
    public function getTrashed(): Collection
    {
        return Post::onlyTrashed()->get();
    }
}
