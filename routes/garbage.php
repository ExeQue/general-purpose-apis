<?php

use App\Apps\Garbage\Controllers\ApiController;
use App\Apps\Garbage\Controllers\CountyController;
use App\Apps\Garbage\Controllers\HelpController;

Route::prefix('county')->group(function () {
    Route::get('list', [CountyController::class, 'list'])->name('garbage.county.list');
    Route::get('locate/{address}', [CountyController::class, 'locate'])->name('garbage.county.locate');
});

Route::get('information/{address}/{segment?}', [ApiController::class, 'fetchInformation'])->name('garbage.info');

Route::any('/', [HelpController::class, 'help'])->name('garbage.help');
Route::get('download/{address}/{type}', [HelpController::class, 'download'])->name('garbage.download');
