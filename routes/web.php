<?php

use Illuminate\Support\Facades\Route;
use Modules\Basicdata\Http\Controllers\BranchController;
use Modules\Basicdata\Http\Controllers\CurrencyController;
use Modules\Basicdata\Http\Controllers\HolidayCalendarController;
use Modules\Basicdata\Http\Controllers\DeveloperController;
use Modules\Basicdata\Http\Controllers\NotarisController;
use Modules\Basicdata\Http\Controllers\MasterNamaDokumenController;

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
            Route::get('datatables', [CurrencyController::class, 'dataForDatatables'])->name('datatables');
            Route::get('export', [CurrencyController::class, 'export'])->name('export');
            Route::post('delete-multiple', [CurrencyController::class, 'deleteMultiple'])->name('deleteMultiple');
        });

        Route::resource('mata-uang', CurrencyController::class, [
            'names' => [
                'index' => 'currency.index',
                'show' => 'currency.show',
                'create' => 'currency.create',
                'store' => 'currency.store',
                'edit' => 'currency.edit',
                'update' => 'currency.update',
                'destroy' => 'currency.destroy',
            ],
        ]);

        Route::name('branch.')->prefix('cabang')->group(function () {
            Route::get('datatables', [BranchController::class, 'dataForDatatables'])->name('datatables');
            Route::get('export', [BranchController::class, 'export'])->name('export');
            Route::post('delete-multiple', [BranchController::class, 'deleteMultiple'])->name('deleteMultiple');
        });

        Route::resource('cabang', BranchController::class, [
            'names' => [
                'index' => 'branch.index',
                'show' => 'branch.show',
                'create' => 'branch.create',
                'store' => 'branch.store',
                'edit' => 'branch.edit',
                'update' => 'branch.update',
                'destroy' => 'branch.destroy',
            ],
        ]);

        Route::group(['prefix' => 'holidaycalendar', 'as' => 'holidaycalendar.'], function () {
            Route::get('/datatables', [HolidayCalendarController::class, 'dataForDatatables'])->name('datatables');
            Route::get('/export', [HolidayCalendarController::class, 'export'])->name('export');
            Route::post('delete-multiple', [HolidayCalendarController::class, 'deleteMultiple'])->name('deleteMultiple');
        });
        Route::resource('holidaycalendar', HolidayCalendarController::class);

        Route::name('developer.')->prefix('developer')->group(function () {
            Route::get('datatables', [DeveloperController::class, 'dataForDatatables'])->name('datatables');
            Route::get('export', [DeveloperController::class, 'export'])->name('export');
            Route::post('delete-multiple', [DeveloperController::class, 'deleteMultiple'])->name('deleteMultiple');
        });

        Route::resource('developer', DeveloperController::class, [
            'names' => [
                'index' => 'developer.index',
                'show' => 'developer.show',
                'create' => 'developer.create',
                'store' => 'developer.store',
                'edit' => 'developer.edit',
                'update' => 'developer.update',
                'destroy' => 'developer.destroy',
            ],
        ]);

        Route::name('notaris.')->prefix('notaris')->group(function () {
            Route::get('datatables', [NotarisController::class, 'dataForDatatables'])->name('datatables');
            Route::get('export', [NotarisController::class, 'export'])->name('export');
            Route::post('delete-multiple', [NotarisController::class, 'deleteMultiple'])->name('deleteMultiple');
        });

        Route::resource('notaris', NotarisController::class, [
            'names' => [
                'index' => 'notaris.index',
                'show' => 'notaris.show',
                'create' => 'notaris.create',
                'store' => 'notaris.store',
                'edit' => 'notaris.edit',
                'update' => 'notaris.update',
                'destroy' => 'notaris.destroy',
            ],
            'parameters' => [
                'notaris' => 'notaris',
            ],
        ]);

        Route::name('master-nama-dokumen.')->prefix('master-nama-dokumen')->group(function () {
            Route::get('datatables', [MasterNamaDokumenController::class, 'dataForDatatables'])->name('datatables');
            Route::get('export', [MasterNamaDokumenController::class, 'export'])->name('export');
            Route::post('delete-multiple', [MasterNamaDokumenController::class, 'deleteMultiple'])->name('deleteMultiple');
        });

        Route::resource('master-nama-dokumen', MasterNamaDokumenController::class, [
            'names' => [
                'index' => 'master-nama-dokumen.index',
                'show' => 'master-nama-dokumen.show',
                'create' => 'master-nama-dokumen.create',
                'store' => 'master-nama-dokumen.store',
                'edit' => 'master-nama-dokumen.edit',
                'update' => 'master-nama-dokumen.update',
                'destroy' => 'master-nama-dokumen.destroy',
            ],
            'parameters' => [
                'master-nama-dokumen' => 'masterNamaDokumen',
            ],
        ]);
    });
});
