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
        return view('Admin.user_consult.user_consultancy');
    }

    public function consultanciesData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = isset($columnIndex_arr[0]['column']) ? $columnIndex_arr[0]['column'] : 0;
        $columnName = isset($columnName_arr[$columnIndex]['data']) ? $columnName_arr[$columnIndex]['data'] : 'id';
        $columnSortOrder = isset($order_arr[0]['dir']) ? $order_arr[0]['dir'] : 'desc';
        $searchValue = isset($search_arr['value']) ? $search_arr['value'] : '';

        $columnMap = [
            'id' => 'id',
            'consultancy' => 'consultancy',
            'sub_consultancy' => 'sub_consultancy',
        ];

        $dbColumnName = $columnMap[$columnName] ?? 'id';

        $query = UserConsult::with('user');

        if ($searchValue != '') {
            $query->where(function($q) use ($searchValue) {
                $q->where('consultancy', 'like', '%' . $searchValue . '%')
                  ->orWhere('sub_consultancy', 'like', '%' . $searchValue . '%')
                  ->orWhereHas('user', function($userQuery) use ($searchValue) {
                      $userQuery->where('name', 'like', '%' . $searchValue . '%')
                                ->orWhere('email', 'like', '%' . $searchValue . '%');
                  });
            });
        }

        $totalRecords = UserConsult::count();
        $totalRecordswithFilter = $query->count();

        $query->orderBy($dbColumnName, $columnSortOrder);
        $consultancies = $query->skip($start)->take($rowperpage)->get();

        $data_arr = [];
        foreach ($consultancies as $consult) {
            $data_arr[] = [
                'id' => $consult->id,
                'user_name' => $consult->user->name ?? '-',
                'user_email' => $consult->user->email ?? '-',
                'consultancy' => $consult->consultancy ?? '-',
                'sub_consultancy' => $consult->sub_consultancy ?? '-',
                'created_at' => $consult->created_at ? \Carbon\Carbon::parse($consult->created_at)->format('m/d/Y') : '-',
            ];
        }

        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ];

        return response()->json($response);
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

