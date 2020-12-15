<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PagesController::class, 'emails'])->name('emails');

Route::get('/send-email', [PagesController::class, 'sendEmail'])->name('sendEmail');

Route::get('/{id}/view', [PagesController::class, 'viewEmail'])->name('viewEmail');

Route::get('/{recipient}/emails', [PagesController::class, 'viewRecipientEmails'])->name('viewRecipientEmails');

Route::get('/{id}/attachments', [PagesController::class, 'viewAttachments'])->name('viewAttachments');

Route::get('/{id}/downloadAttachment', [PagesController::class, 'downloadAttachment'])->name('downloadAttachment');
