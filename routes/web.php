<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/login', '/admin/login')->name('login');

Route::get('/contracts/report', [\App\Http\Controllers\ContractReportController::class, 'viewReport'])->name('contracts.report');
Route::get('/contracts/report/download', [\App\Http\Controllers\ContractReportController::class, 'downloadPdf'])->name('contracts.report.download');

Route::get('/admin/contracts/report', [\App\Http\Controllers\ContractReportController::class, 'viewReport']);
Route::get('/admin/contracts/report/download', [\App\Http\Controllers\ContractReportController::class, 'downloadPdf']);
