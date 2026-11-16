<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService
    ) {}

    public function index(): View
    {

        $users = $this->userService->getPaginated(10);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, int $userId): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::enum(UserRole::class)],
        ]);

        User::findOrFail($userId);
        $role = UserRole::from($data['role']);
        $this->userService->changeRole($userId, $role);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Роль сохранена', 'role' => $role->value]);
        }

        return redirect()->back()->with('message', 'Роль сохранена');
    }
}
