<?php

use Illuminate\Support\Facades\Route;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\plant_meterialsController;
use App\Http\Controllers\Api\PlantreservationController;
use App\Http\Controllers\Api\PaymentController;
use App\Events\MessageSent;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\kanal_pickerController;
use App\Http\Controllers\Api\ConsultancyController;
use App\Http\Controllers\Api\Trills_MaterialController;
use App\Http\Controllers\WebviewController;
use Razorpay\Api\Api;
use Carbon\Carbon;




Route::get('/payment', function(){
    return view('payment');
});
route::get('/welcome', function () {
    return view('Admin.chat.index');
});

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');






Route::get('/test-qr', function () {
    $plant_id = 'plant-LZL1BT6A55';
    $url = url('/api/plant/scan/' . $plant_id); // 👈 include plant_id in URL

    $qrCode = (new Generator)->size(300)->generate($url);

    return response($qrCode)->header('Content-Type', 'image/svg+xml');
});


Route::get('/send-message', function () {
    event(new MessageSent('Hello world'));
    return 'Message sent!';
});


    // Route::prefix('fruit')->group(function () {
    //  Route::get('/', [ProductController::class, 'fruit']);
    // Route::get('/{id}', [ProductController::class, 'show']);
    // Route::post('/', [ProductController::class, 'fruitstore'])->name('create_fruit');
    // Route::post('/{id}', [ProductController::class, 'update']);
    // Route::delete('/{id}', [ProductController::class, 'destroy']);


//});

//admin fruits


      Route::prefix('fruits')->group(function () {
      Route::get('/add', [AdminController::class, 'fruits'])->name('add_fruits');
       Route::get('/all', [AdminController::class, 'all'])->name('all_fruits');
      Route::post('/create', [ProductController::class, 'fruitstore'])->name('create_fruit');
      Route::get('/edit/{id}', [ProductController::class, 'showfruits'])->name('edit_fruit');
      Route::post('/update', [ProductController::class, 'updatefruit'])->name('fruits.update');
     Route::delete('delete/{id}', [ProductController::class, 'destroyfruit']);

});

// Route::get('add/banners', [BannerController::class, 'banner'])->name('add_banner');
// Route::get('all/banners', [BannerController::class, 'all_banner'])->name('all_banner');

      Route::prefix('banner')->group(function () {
      Route::get('/add', [BannerController::class, 'banner'])->name('add_banner');
       Route::get('/all', [BannerController::class, 'all_banner'])->name('all_banner');
      Route::post('/create', [BannerController::class, 'store'])->name('create_banner');
      Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('edit_banner');
      Route::post('/update', [BannerController::class, 'update'])->name('update');
     Route::delete('delete/{id}', [BannerController::class, 'destroy']);

});


      Route::prefix('plant')->group(function () {
      Route::get('/add', [AdminController::class, 'plant'])->name('add_plant');
       Route::get('/all', [ProductController::class, 'index'])->name('all_plant');
      Route::post('/create', [ProductController::class, 'store'])->name('create_plant');
      Route::get('/edit/{id}', [ProductController::class, 'show'])->name('edit_plant');
      Route::post('/update', [ProductController::class, 'update'])->name('plant.update');
     Route::delete('delete/{id}', [ProductController::class, 'destroy']);

});


 Route::get('/chatsystem', [ChatController::class, 'index']);

 Route::post('/chat/send', [ChatController::class, 'sendMessage']);


  Route::get('/admin/chat/messages/{userId}', [ChatController::class, 'receive']);
   Route::post('/admin/chat/send', [ChatController::class, 'chatUsers'])->name('admin.chat.send');


// grading
Route::get('plant/reservation', [PlantreservationController::class, 'create'])->name('admin.reservation');;
Route::post('plant/reservation/store', [PlantreservationController::class, 'store']);

Route::get('/reservation/all', [PlantreservationController::class, 'getAllFeathers'])->name('plant.reservation.all');
Route::delete('/feather/delete/{id}', [PlantreservationController::class, 'destroy'])->name('reservation.delete');


//kanal picker


Route::post('plant/kanal/store', [kanal_pickerController::class, 'store']);


// 

// smart orchar



// Route::get('/payment', function () {
//     return view('payment');
// });

// Route::get('/create-order', [PaymentController::class, 'createOrder']);
// Route::post('/verify-payment', [PaymentController::class, 'verifyPayment']);




Route::get('/test-razorpay', function () {
    try {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'amount'   => 10000, // 100 INR
            'currency' => 'INR',
            'receipt'  => 'test_rcpt_' . time(),
        ]);

        return response()->json($order);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});


Route::get('/ssl-test', function () {
    $ch = curl_init('https://api.razorpay.com/v1/orders');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'cURL error: ' . curl_error($ch);
    }
    curl_close($ch);
    return 'OK — SSL works!';
});

Route::get('/create-order', [PaymentController::class, 'createOrder'])->name('create.order');
Route::post('/verify-payment', [PaymentController::class, 'verifyPayment'])->name('verify.payment');

// Route::get('/env-test', function () {
//     return [
//         'DB_CONNECTION' => env('DB_CONNECTION'),
//         'DB_HOST' => env('DB_HOST'),
//         'DB_DATABASE' => env('DB_DATABASE'),
//         'DB_USERNAME' => env('DB_USERNAME'),
//         'DB_PASSWORD' => env('DB_PASSWORD') ? '*****' : null,
//     ];
// });


Route::get('/check-keys', function () {
    return [
        'RAZORPAY_KEY' => env('RAZORPAY_KEY'),
        'RAZORPAY_SECRET' => env('RAZORPAY_SECRET'),
    ];
});



Route::post('/orders/set-delivered-date/{id}', [OrderController::class, 'setDeliveredDate'])->name('setDeliveredDate');


      Route::prefix('Order')->group(function () {
       Route::get('/all', [OrderController::class, 'allorders'])->name('all_Order');
      Route::post('/confirm/{orderId}', [OrderController::class, 'confirmorder'])->name('confirm_order');
      Route::get('/pending', [OrderController::class, 'pendingorders'])->name('pendingorder');
      Route::get('/complete', [OrderController::class, 'completeorders'])->name('complete_order');
       Route::delete('delete/{id}', [OrderController::class, 'destroy']);

});


 Route::get('/admin/consultancy', [ConsultancyController::class, 'consultrecord']);
 
    Route::prefix('trills')->group(function () {
      Route::get('/add', [AdminController::class, 'trills'])->name('index');
     Route::post('/store', [Trills_MaterialController::class, 'store']);
     Route::get('/all', [Trills_MaterialController::class, 'index']);
  Route::get('/edit/{id}', [Trills_MaterialController::class, 'show']);
   Route::post('update', [Trills_MaterialController::class, 'update']);
   Route::delete('delete/{id}', [Trills_MaterialController::class, 'destroy']);
});

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return '✅ Cache cleared successfully!';
});


Route::get('/delete-unverified-orders', function () {
    $deleted = DB::table('orders')
        ->where('is verify', 0)
        ->where('created_at', '<', Carbon::now()->subMinutes(10))
        ->delete();

    return "Deleted {$deleted} unverified orders older than 5 minutes.";
});


Route::get('/run-delete-orders', function () {
    Artisan::call('orders:delete-unverified');
    return 'Unverified orders deleted successfully!';
});

 Route::get('/billing', [AdminController::class, 'billing'])->name('billing.show');
 
 
 //qrcode on admin side 
 Route::post('/plant/generate-qr', [ProductController::class, 'generateQr'])->name('plant.generateQr');
  Route::post('/fruit/generate-qr', [ProductController::class, 'generateFruitQr'])->name('fruit.generateQr');
});
  
  Route::get('/', [WebviewController::class, 'home'])->name('web.home');
     Route::prefix('web')->group(function () {
      Route::get('/home', [WebviewController::class, 'home'])->name('web.home');
     Route::get('/privacy', [WebviewController::class, 'privacy'])->name('web.privacy');
     Route::get('/about', [WebviewController::class, 'about'])->name('web.about');
  Route::get('/contact', [WebviewController::class, 'contact_us'])->name('web.contact_us');
   Route::get('refund', [WebviewController::class, 'refund'])->name('web.refund');
     });
     
     
       Route::delete('consult/delete/{id}', [ConsultancyController::class, 'destroy']);

 Route::get('/fruits/search', [AdminController::class, 'searchfruit'])->name('fruit_search');
 Route::post('/contact/send', [AdminController::class, 'send']);
 
  Route::delete('billing/delete/{id}', [AdminController::class, 'destroy']);
  
 
  Route::get('/order/detail/{id}', [OrderController::class, 'show'])->name('order.detail');

    

 
//  Route::get('get/variety', [kanal_pickerController::class, 'getvariety']);

 
//  include __DIR__.'/auth.php';

