<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',\App\Livewire\Frontend\IndexComponent::class)->name('home');
Route::get('forbidden', function () {
    return view('error.forbidden');
})->name('forbidden');
Route::get('/dashboard', function () {
    $user = auth()->user();
    return view($user->user_type === 1 ? 'admin.index' : ($user->user_type === 2 ? 'frontend.index' : 'welcome'));
})->middleware(['auth', 'verified'])->name('dashboard');





Route::group(['middleware' => ['auth', 'check_user:1'], 'as' => 'admin.'], function () {
    Route::resource('blank-page', \App\Http\Controllers\BasicController::class);
    Route::resource('profile', \App\Http\Controllers\ProfileController::class);
    Route::resource('setting', \App\Http\Controllers\SettingController::class);
    Route::resource('blog', \App\Http\Controllers\backend\BlogController::class);
    Route::post('blog_ckeditor', [\App\Http\Controllers\backend\BlogController::class, 'ckeditor'])->name('blog.ckeditor');
    Route::post('blog_remove_image', [\App\Http\Controllers\backend\BlogController::class, 'removeImage'])->name('blog.removeImage');
});

Route::group(['middleware' => ['auth', 'check_user:2'], 'prefix' => 'user', 'as' => 'user.'], function () {


});




// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
