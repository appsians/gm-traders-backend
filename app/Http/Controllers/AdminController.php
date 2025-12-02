<?php

namespace App\Http\Controllers;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Models\Fruit;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Trills_Material;
use App\Models\Billing;

use App\Mail\ContactMail;


use App\Models\plant_reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



class AdminController extends Controller
{
    public function index()
    {
         $orders = Order::latest()->get();

    // Counts
        $user =  Trills_Material::count();
         $plants = Product::count();
          $fruit = Fruit::count();
    $totalOrders = Order::count();
    $pendingOrders = Order::where('status', 'pending')->count();
    $completedOrders = Order::where('status', 'completed')->count();

    return view('dashboard', compact('orders', 'totalOrders', 'pendingOrders', 'completedOrders','user','plants','fruit'));

    }

    // fruits

     public function fruits()
    {
        return view('Admin.fruit.add');
    }

     public function all()

    {

       //   $fruits = Fruit::all();
          $fruits = Fruit::all();
        return view('Admin.fruit.datatable' ,compact('fruits'));
    }
    
    //search 
    
    
    
    
 public function plant()
    {
        return view('Admin.plant.add');
    }


       public function getallreservation()

    {
$fruits = plant_reservation::all(10);

        return view('Admin.grading.datatable' ,compact('fruits'));
    }

   public function trills()
    {
        return view('Admin.trills_materials.add');
    }


public function users()
{
    $user = User::count();

    return view('dashboard',compact('user'));
}

public function billing()
{
    $user = Billing::with('order')->get();



    return view('Admin.billing.datatable',compact('user'));
}




  public function destroy($id)
    {
        $material = Billing::find($id);

        if (!$material) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found.',
            ], 404);
        }

        $material->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data deleted successfully.',
        ], 200);
    }




  public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // send email
        Mail::to('rabiarajpoot4040@gmail.com')->send(new ContactMail($request->all()));

        return response()->json([
            'status' => 'success',
            'message' => 'Your message has been sent!'
        ]);
    }





}


