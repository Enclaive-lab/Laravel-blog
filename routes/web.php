<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', fn() => redirect()->route('blog.index'));

Route::prefix('admin')->as('admin.')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
  Route::resource('posts', AdminPostController::class);
  Route::get('users', [UserController::class, 'index'])->name('users.index');
  Route::post('users/{userId}', [UserController::class, 'updateRole'])->name('users.update.role');
});


Route::prefix('blog')->as('blog.')->group(function () {
  Route::get('/', [PostController::class, 'index'])->name('index');

  Route::get('/{post:slug}', [PostController::class, 'show'])->name('show');
});

Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
  Route::post('/login', [AuthController::class, 'login'])->name('login.post');

  Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
  Route::post('/register', [AuthController::class, 'register'])->name('register.post');

  Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
  Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
  Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
  Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
  Route::get('/email/verify', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
      return redirect()->route('blog.index');
    }

    return view('auth.verify-email');
  })->name('verification.notice');


  Route::get('/email/verify/{id}/{hash}', function (
    EmailVerificationRequest $request
  ) {
    $request->fulfill();
    return redirect('/');
  })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

  Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
      return redirect()->route('blog.index');
    }

    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Ссылка для подтверждения отправлена!');
  })->middleware('throttle:6,1')->name('verification.send');

  Route::middleware('verified')->group(function () {
    Route::get('/admin', function () {
      return 'Админка';
    });
  });
});
