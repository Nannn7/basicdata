<?php

    use Illuminate\Support\Facades\Route;
    use Modules\Basicdata\Http\Controllers\BranchController;
    use Modules\Basicdata\Http\Controllers\CurrencyController;
    use Modules\Basicdata\Http\Controllers\HolidayCalendarController;

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

            Route::resource('mata-uang', CurrencyController::class, [
                'names' => [
                    'index'   => 'currency.index',
                    'show'    => 'currency.show',
                    'create'  => 'currency.create',
                    'store'   => 'currency.store',
                    'edit'    => 'currency.edit',
                    'update'  => 'currency.update',
                    'destroy' => 'currency.destroy',
                ],
            ]);


            Route::name('branch.')->prefix('cabang')->group(function () {
                Route::get('restore/{id}', [BranchController::class, 'restore'])->name('restore');
                Route::get('datatables', [BranchController::class, 'dataForDatatables'])->name('datatables');
                Route::get('export', [BranchController::class, 'export'])->name('export');
                Route::post('delete-multiple', [BranchController::class, 'deleteMultiple'])->name('deleteMultiple');
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

            Route::group(['prefix' => 'holidaycalendar', 'as' => 'holidaycalendar.'], function () {
                Route::get('/', [HolidayCalendarController::class, 'index'])->name('index');
                Route::get('/create', [HolidayCalendarController::class, 'create'])->name('create');
                Route::post('/', [HolidayCalendarController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [HolidayCalendarController::class, 'edit'])->name('edit');
                Route::put('/{id}', [HolidayCalendarController::class, 'update'])->name('update');
                Route::delete('/{id}', [HolidayCalendarController::class, 'destroy'])->name('destroy');
                Route::get('/datatables', [HolidayCalendarController::class, 'dataForDatatables'])->name('datatables');
                Route::get('/export', [HolidayCalendarController::class, 'export'])->name('export');
            });
        });
    });
