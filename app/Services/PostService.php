<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Override;

class PostService implements PostServiceInterface
{

    public function __construct(
        private PostRepositoryInterface $postRepository
    ) {}

    #[Override]
    public function getAllApi(): Collection
    {
        $items = Cache::remember('posts_all', 60, function () {
            return $this->postRepository->allApi()
                ->map(fn(Post $post) => $post->getAttributes())->all();
        });

        return new Collection(array_map(fn(array $attributes) => (new Post)->newFromBuilder($attributes), $items));
    }

    #[Override]
    public function getTrashed(): Collection
    {
        $items = Cache::remember('posts_trash', 60, function () {
            return $this->postRepository->getTrashed()
                ->map(fn(Post $post) => $post->getAttributes())->all();
        });

        $posts = new Collection(array_map(fn(array $attributes) => (new Post)->newFromBuilder($attributes), $items));

        return $posts->filter(fn(Post $post) => (int) $post->user_id === (int) auth()->id())->values();
    }

    #[Override]
    public function getByIdApi(int $id): ?Post
    {
        $attributes = Cache::remember("post_{$id}", 60, function () use ($id) {
            $post = $this->postRepository->findApi($id);

            if (!$post) {
                throw new ApiException("Post with ID {$id} not found", 404);
            }

            return $post->getAttributes();
        });

        return $attributes === null ? null : (new Post)->newFromBuilder($attributes);
    }

    #[Override]
    public function createApi(array $data): Post
    {

        $data['slug'] = (Str::slug($data['title']) ?: 'post') . '-' . Str::uuid();
        $data['user_id'] = auth()->id();
        return $this->postRepository->createApi($data);
    }


    #[Override]
    public function updateApi(int $id, array $data): ?Post
    {
        $post = $this->postRepository->findApi($id);
        if (!$post) return null;

        abort_unless(auth()->check() && (int) $post->user_id === (int) auth()->id(), 403);
        unset($data['user_id']);
        $data['slug'] = (Str::slug($data['title']) ?: 'post') . '-' . Str::uuid();

        $updatedPost  = $this->postRepository->updateApi($post, $data);

        return $updatedPost;
    }


    #[Override]
    public function softDeleteApi(int $id): bool
    {
        $post = $this->postRepository->findApi($id);

        if (!$post) return false;
        abort_unless(auth()->check() && (int) $post->user_id === (int) auth()->id(), 403);
        return $this->postRepository->softDelete($post);
    }

    #[Override]
    public function restoreApi(int $id): ?Post
    {
        $post = $this->postRepository->findTrashed($id);

        if (!$post) return null;

        abort_unless(auth()->check() && (int) $post->user_id === (int) auth()->id(), 403);

        return $this->postRepository->restore($id);
    }

    #[Override]
    public function forceDeleteApi(int $id): bool
    {
        $post = $this->postRepository->findTrashed($id);
        if (!$post) return false;

        abort_unless(auth()->check() && (int) $post->user_id === (int) auth()->id(), 403);

        $deleted = $this->postRepository->forceDelete($id);

        if ($deleted && $post->image) {
            $path = $post->image;
            DB::afterCommit(function () use ($path): void {
                Storage::disk('public')->delete($path);
            });
        }

        return $deleted;
    }
}
