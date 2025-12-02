<?php

namespace App\Http\Controllers\Api;
use App\Models\Consultancy;
use App\Models\UserConsult;
use App\Mail\ConsultationMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class ConsultancyController extends Controller
{
       public function store(Request $request)
    {
        $request->validate([
            'consultancy' => 'required|string|max:255',
            'sub_consultancy' => 'required|string|max:255',
        ]);

        $consultation = UserConsult::create([
            'user_id' => auth()->id(),
         
            'consultancy' => $request->consultancy,
            'sub_consultancy' => $request->sub_consultancy,
        ]);

        // Send email to user
         Mail::to(auth()->user()->email)->send(new ConsultationMail($consultation));
     //   Mail::to('rabiarajpoot4040@gmail.com')->send(new ConsultationMail($consultation));

        return response()->json([
            'status' => true,
            'message' => 'Consultation request submitted successfully.',
            'data' => $consultation,
        ],200);
    

      if(!$consultation) {
            return response()->json([
                'status' => false,
                'message' => 'something wrong',
            ], 404);
        }
    }


    public function index()
    {

        $consultancies = Consultancy::select('consultancy', 'sub_consultancy')->get();

        //  if(!$consultancies) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'something wrong',
        //     ], 404);
        // }
     

        $consultancyList = $consultancies->pluck('consultancy')->unique()->values();
        $subConsultancyList = $consultancies->pluck('sub_consultancy')->unique()->values(); 
        return response()->json([
            'status' => true,
            'message' => 'Consultancy data fetched successfully.',
            'consultancy_topic' => $consultancyList,
            'sub_consultancy_topic' => $subConsultancyList,
        ],200);
        }
        
        
        
  public function consultrecord()
    {
        
        $consultancies = UserConsult::with('user')->latest()->get();
    
       
     
        return view('Admin.user_consult.user_consultancy', compact('consultancies'));
    }
    
    
    
       public function destroy($id)
    {
        $material = UserConsult::find($id);

        if (!$material) {
            return response()->json([
                'status' => false,
                'message' => 'data not found.',
            ], 404);
        }

        $material->delete();

        return response()->json([
            'status' => true,
            'message' => ' Consultancy deleted successfully.',
        ], 200);
    }


    
    
public function consult()
{
    // Get the authenticated user's ID
    $userId = Auth::id(); // or auth()->id();

    // Fetch all consultancy records of this user, latest first
    $consultancies = UserConsult::where('user_id', $userId)
                                ->latest()
                                ->get();

    // Return as JSON
    return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => $consultancies
    ]);
}
  
  
  
  
public function consultdata()
{
   $userId = auth()->id();
   // $userId= 19;
    

    $consultancies = UserConsult::where('user_id', $userId)->latest()->get();

    return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => $consultancies
    ]);
}

 }

