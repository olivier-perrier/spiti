<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InvitationController;
use App\Models\Beneficiary;
use App\Models\BeneficiaryOQTF;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pdf/oqtf', function () {
    return view('pdf.oqtf', [
        'user' => auth()->user(),
        'beneficiary' => Beneficiary::first(),
        'oqtf' => BeneficiaryOQTF::first(),
        'date' => Carbon::now()->locale('fr')->toFormattedDateString(),
    ]);
});

Route::get('/pricing', function () {
    return view('stripe.pricing-table');
})->name('pricing');

Route::get('/subscription-checkout', function (Request $request) {

    return $request->user()
        ->newSubscription('subscription', ['price_1PmzhaHPSse5Na6ss27NsyeW'])
        // ->create($request->paymentMethodId)
        // ->trialDays(5)
        // ->allowPromotionCodes()
        ->checkout([
            'success_url' => url('/admin'),
            'cancel_url' => url('/admin'),
        ]);
});

// Invitations
Route::get('/invitations', [InvitationController::class, 'show'])->name('invitations.show');

// Register
Route::post('/register', RegisterController::class)->name('register');
