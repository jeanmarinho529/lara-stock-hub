<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('importar', [UserController::class, 'importForm']);
// Route::post('importar', [UserController::class, 'import']);
Route::match(['get', 'post'], 'importar', [UserController::class, 'import']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('importar', [UserController::class, 'import']);
});

Route::get('/produtos/{id}', function ($id) {
    return Product::where('slug', $id)->get();
});

Route::get('vendas', Sale::class);





require __DIR__.'/auth.php';
