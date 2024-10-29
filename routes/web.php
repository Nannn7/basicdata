<?php

    use Illuminate\Support\Facades\Route;
    use Modules\Basicdata\Http\Controllers\BranchController;
    use Modules\Basicdata\Http\Controllers\CurrencyController;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::middleware(['auth'])->group(function () {
        Route::name('basicdata.')->prefix('basic-data')->group(function () {
            Route::name('currency.')->prefix('mata-uang')->group(function () {
                Route::get('restore/{id}', [CurrencyController::class, 'restore'])->name('restore');
                Route::get('datatables', [CurrencyController::class, 'dataForDatatables'])->name('datatables');
                Route::get('export', [CurrencyController::class, 'export'])->name('export');
            });

            Route::name('branch.')->prefix('cabang')->group(function () {
                Route::get('restore/{id}', [BranchController::class, 'restore'])->name('restore');
                Route::get('datatables', [BranchController::class, 'dataForDatatables'])->name('datatables');
                Route::get('export', [BranchController::class, 'export'])->name('export');
            });

            Route::resource('cabang', BranchController::class, [
                'names' => [
                    'index'   => 'branch.index',
                    'show'    => 'branch.show',
                    'create'  => 'branch.create',
                    'store'   => 'branch.store',
                    'edit'    => 'branch.edit',
                    'update'  => 'branch.update',
                    'destroy' => 'branch.destroy',
                ],
            ]);
        });
    });
