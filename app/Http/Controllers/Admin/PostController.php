<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Service\PostService;

class PostController extends Controller
{

    public function __construct(
        private  PostService $service,
        private  PostRepositoryInterface $repository
    ) {}

    public function index(Request $request): View
    {
        $posts = $this->repository->getPaginated(4);

        return view('admin.posts.index', compact('posts'));
    }


    public function create(): View
    {
        return view('admin.posts.create');
    }


    public function store(StorePostRequest $request): RedirectResponse
    {


        $this->service->create($request->validated());

        return redirect()->route('admin.posts.index')->with('succes', 'Пост успешно создан!');
    }



    public function show(Post $post): View
    {
        return view('admin.posts.show', compact('post'));
    }

    
    public function edit(Post $post): View
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->service->update($post, $request->validated());



        return redirect()->route('admin.posts.index')->with('success', "Пост успешно обновлён!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->service->delete($post);

        return redirect()->route('admin.posts.index')->with('success', "Пост успешно удалён!");
    }
}
