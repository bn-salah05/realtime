<?php

use App\Models\Room;
use App\Models\User;
use App\Models\Order;
use App\Events\Example;
use App\Models\Message;
use App\Events\OrderDelivered;
use App\Events\Chat\ExampleTwo;
use App\Events\OrderDispatched;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/room/{room}', function (Room $room) {

    return view('room', [
        'room' => $room
    ]);
})->middleware(['auth', 'verified'])->name('room');

Route::get('/orders/{order}', function (Order $order) {
    return view('order', [
        'order' => $order
    ]);
});

Route::get('/broadcast', function () {

    sleep(3);
    
    broadcast(new OrderDispatched(Order::find(1)));

    sleep(5);

    broadcast(new OrderDelivered(Order::find(1)));

    //broadcast(new Example(User::find(1), Message::find(1)));
    
    //broadcast(new ExampleTwo());

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
