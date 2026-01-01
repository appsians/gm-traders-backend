<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\OpenAiController;
use App\Http\Controllers\Api\ConsultancyController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ReferralController;
use App\Http\Controllers\Api\Trills_MaterialController;
use App\Http\Controllers\Api\PlantController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\plant_meterialsController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PlantreservationController;
use App\Http\Controllers\Api\kanal_pickerController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Log;



 //Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {

// });
//      Route::get('/profile', function (Request $request) {
//         return $request->user();

//     });
//
Route::middleware('auth:sanctum')->group(function () {
      Route::post('/create-order', [PaymentController::class, 'createOrder']);
       Route::post('/verify-payment', [PaymentController::class, 'verifyPayment']);
     
    
    
 Route::post('/chat/send', [ChatController::class, 'userMessage']);
  Route::get('/chat/received', [ChatController::class, 'chat']);

     Route::get('/plant/scan/{plant_id}', [ProductController::class, 'scanProduct']);
    Route::get('fruit/scan/{fruit_id}', [ProductController::class, 'scanfruit']);
    //banners
   


    Route::post('/profile/update', [ProfileController::class, 'update']);
     Route::post('/profile_image/update', [ProfileController::class, 'updateProfileImage']);
       Route::get('/user/consultancy', [ConsultancyController::class, 'consultdata']);



     Route::get('/user/post', [CommunityController::class, 'index']);
    Route::post('add/post', [CommunityController::class, 'store']);
     Route::get('edit/post/{id}', [CommunityController::class, 'show']);
    Route::post('update/post/{id}', [CommunityController::class, 'update']);
    Route::delete('delete/post/{id}', [CommunityController::class, 'destroy']);
    Route::get('all/post', [CommunityController::class, 'allpostget']);


     Route::prefix('products')->group(function () {
     Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store']);
    Route::post('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

Route::get('/referralSummary',[ReferralController::class, 'referralSummary']);


   Route::post('submit/consult', [ConsultancyController::class, 'store']);
Route::get('consult/topic', [ConsultancyController::class, 'index']);

 Route::get('all/orders  ', [OrderController::class, 'getOrders']);

});
 Route::get('/store/getProducts  ', [plant_meterialsController::class, 'getAllPlantsAndMaterials']);


 Route::post('order/store  ', [OrderController::class, 'store']);
 // Route::get('all/orders  ', [OrderController::class, 'getOrders']);



  //  Route::get('/user/post', [CommunityController::class, 'index']);
    // Route::post('add/post', [CommunityController::class, 'store']);
    //  Route::get('edit/post/{id}', [CommunityController::class, 'show']);
    // Route::post('update/post/{id}', [CommunityController::class, 'update']);
    // Route::delete('delete/post/{id}', [CommunityController::class, 'destroy']);
    // Route::get('all/post', [CommunityController::class, 'allpostget']);


    Route::post('/analyze-image', [OpenAiController::class, 'analyzeImage']);
    // Route::get('/plants/scan', [ProductController::class, 'scanProduct']);
   // Route::get('fruit/scan', [ProductController::class, 'scanfruit']);

    //  Route::post('/chat/send', [ChatController::class, 'sendMessage']);

   // Route::post('/profile/update', [ProfileController::class, 'update']);
   //  Route::post('/profile_image/update', [ProfileController::class, 'updateProfileImage']);

    //  Route::prefix('products')->group(function () {
    //  Route::get('/', [ProductController::class, 'index']);
    // Route::get('/{id}', [ProductController::class, 'show']);
    // Route::post('/', [ProductController::class, 'store']);
    // Route::post('/{id}', [ProductController::class, 'update']);
    // Route::delete('/{id}', [ProductController::class, 'destroy']);

   // fruits api


    //referal_Coin
    //  Route::get('/referralSummary',[ReferralController::class, 'referralSummary']);
    // // plantbooking
    //   Route::get('/plant',[PlantController::class, 'getPlantBookings']);









    // Route::prefix('fruit')->group(function () {
    //  Route::get('/', [ProductController::class, 'fruit']);
    // Route::get('/{id}', [ProductController::class, 'show']);
    // Route::post('/', [ProductController::class, 'fruitstore']);
    // Route::post('/{id}', [ProductController::class, 'update']);
    // Route::delete('/{id}', [ProductController::class, 'destroy']);




  //  Route::post('/analyze-image', [OpenAiController::class, 'analyzeImage']);

//});



//Route::get('/scan', [ProductController::class, 'scanProduct']);
// Route::get('fruits/scan', [ProductController::class, 'scanfruit']);

// Route::get('/test-qr', function () {
//     $tree_id = 'tr2300'; // replace with an existing tree_id in your DB
//     $url = "https://8d02eea25632.ngrok-free.app/api/scan/" . $tree_id;

//     return QrCode::size(300)->generate($url);
// });

// });
// Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
//     return response()->json([
//         'status' => 'success',
//         'message' => 'Profile fetched successfully',
//         'data' => $request->user(),
//     ]);
// });








//    Route::get('/community', [CommunityController::class, 'index']);
//     Route::post('/community', [CommunityController::class, 'store']);
//     Route::post('/community/{id}', [CommunityController::class, 'update']);
//     Route::delete('/community/{id}', [CommunityController::class, 'destroy']);
    //    Route::post('/community/all', [CommunityController::class, 'allpost']);




    //open ai
   // Route::post('/analyze-image', [OpenAiController::class, 'analyzeImage']);


    //chat system
    //     Route::post('/chat/send', [ChatController::class, 'userMessage']);
    // Route::get('/chat/received', [ChatController::class, 'receive']);


    // consult system

    //    Route::post('submit/consult', [ConsultancyController::class, 'store']);
    //     Route::get('consult/topic', [ConsultancyController::class, 'index']);





       //treills materials

        Route::get('/trellis', [Trills_MaterialController::class, 'index']);
    Route::post('add/trellis', [Trills_MaterialController::class, 'store']);
     Route::get('edit/trellis/{id}', [Trills_MaterialController::class, 'show']);
    Route::post('update/trellis/{id}', [Trills_MaterialController::class, 'update']);
    Route::delete('delete/trellis/{id}', [Trills_MaterialController::class, 'destroy']);
// //booking



//referal_Coin
   //  Route::get('/referralSummary',[ReferralController::class, 'referralSummary']);
    // plantbooking
  //    Route::get('/plant',[PlantController::class, 'getPlantBookings']);


    //  banner screen
//    Route::get('/home/banners', [BannerController::class, 'index'])->name('banners');




Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/verify_otp', [loginController::class, 'verifyOtp']);
Route::post('/resend_otp', [loginController::class, 'resendOtp']);



Route::get('/varieties', [PlantreservationController::class, 'getAllVarieties']);
Route::post('variety/store', [PlantreservationController::class, 'store']);
Route::post('feathers', [PlantreservationController::class, 'getFeathersByVariety']);


// Route::get('plant/reservation', [PlantreservationController::class, 'create'])->name('admin.reservation');;
// Route::post('plant/reservation/store', [PlantreservationController::class, 'store']);
// Route::get('/plant/reservation/all', [AdminController::class, 'getallreservation'])->name('plant.reservation.all');
// //kanal picker


Route::post('plant/kanal/store', [kanal_pickerController::class, 'store']);
Route::get('kanal/picker/variety', [kanal_pickerController::class, 'getAllVarieties']);
Route::post('kanal/picker/feather', [kanal_pickerController::class, 'getFeathersByVariety']);


Route::post('/smart-orchard', [OpenAiController::class, 'calculate']);

Route::post('plant/reservation/store', [PlantreservationController::class, 'store']);

  // Route::get('/user/consultancy', [ConsultancyController::class, 'consultdata']);

  Route::get('/home/banners', [BannerController::class, 'index'])->name('banners');


Route::get('/test-live-otp', function () {
    // Replace with the mobile number you want to test
    $mobile = '919682617311'; // numeric + country code

    // Your DLT-approved template ID
    $templateId = env('MSG91_DLT_TEMPLATE_ID'); 

    try {
        // Send OTP request to Msg91
        $response = Http::withHeaders([
            'authkey' => env('MSG91_AUTH_KEY'),
            'Content-Type' => 'application/json'
        ])->post('https://api.msg91.com/api/v5/otp', [
            'template_id' => $templateId,
            'mobile' => $mobile
           
        ]);

        $data = $response->json();

        // Log request and response for debugging
        Log::info('Msg91 OTP Request', [
            'mobile' => $mobile,
            'template_id' => $templateId,
            'response' => $data
        ]);

        // Return response to browser for testing
        return response()->json($data);

    } catch (\Exception $e) {
        Log::error('Msg91 OTP Error', ['message' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
Route::get('/reasons', [AdminController::class, 'fetch']);


Route::post('/reasons', [AdminController::class, 'savereplace']);
Route::put('/reasons/{id}', [AdminController::class, 'updateReplace']);
Route::delete('/reasons/{id}', [AdminController::class, 'deleteReplace']);

Route::post('/replace/order', [OrderController::class, 'Replaceorder']);





