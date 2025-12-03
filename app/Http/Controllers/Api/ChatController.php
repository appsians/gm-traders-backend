<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use App\Models\Order;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{


        public function userMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
        $admin = User::where('role', 'admin')->first();

          $message = Chat::create([
           'sender_id' => Auth::user()->id,
         // 'sender_id' => '58',
            'receiver_id' => $admin->id,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully',
            'data' => $message,
        ]);

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function sendMessage(Request $request)
{
    $request->validate([
        'message' => 'required|string',
        'receiver_id' => 'nullable|integer', // optional, admin will auto-assign
    ]);

    $senderId = Auth::id(); // whoever is logged in (admin or user)
    $sender = Auth::user();

    // Determine receiver
    if ($sender->role === 'admin') {
        // admin is sending a message
        $receiverId = $request->receiver_id; // must be passed from frontend
    } else {
        // user is sending message to admin
        $receiverId = User::where('role', 'admin')->value('id');
    }

    // Save message
    $message = Chat::create([
        'sender_id' => $senderId,
        'receiver_id' => $receiverId,
        'message' => $request->message,
    ]);

    // Broadcast event (if using Pusher or Laravel Echo)
    broadcast(new MessageSent($message))->toOthers();

    return response()->json([
        'status' => true,
        'message' => 'Message sent successfully',
        'data' => $message,
    ]);
}


 public function receive($userId, Request $request)
{
    $lastMessageId = $request->get('last_message_id');
    
    $query = chat::where(function ($query) use ($userId) {
        $query->where('sender_id', Auth::id())
              ->where('receiver_id', $userId);
    })->orWhere(function ($query) use ($userId) {
        $query->where('sender_id', $userId)
              ->where('receiver_id', Auth::id());
    });
    
    // If last_message_id is provided, only get messages after that
    if ($lastMessageId) {
        $query->where('id', '>', $lastMessageId);
    }
    
    $messages = $query->orderBy('created_at', 'asc')
      ->get()
      ->map(function ($msg) {
          return [
              'id' => $msg->id,
              'sender_id' => $msg->sender_id,
              'message' => $msg->message,
              'time' => $msg->created_at->diffForHumans(),
              'created_at' => $msg->created_at->toDateTimeString(),
          ];
      });

    return response()->json(['data' => $messages]);
}



    public function chatUsers()
{
   
    $adminId = Auth::user()->id;

    // Get distinct user IDs who have sent or received messages with admin
    $users = Chat::where('receiver_id', $adminId)
                ->orWhere('sender_id', $adminId)
                ->pluck('sender_id')
                ->merge(
                    Chat::where('receiver_id', $adminId)->pluck('receiver_id')
                )
                ->unique()
                ->filter(fn($id) => $id != $adminId)
                ->values();


    $chatUsers = User::whereIn('id', $users)->get();

    return view('Admin.chat.index', compact('chatUsers'));
}



public function chat()
{
    $adminId = User::where('role', 'admin')->value('id');
    $authId = Auth::id();

    $messages = Chat::where(function ($query) use ($adminId, $authId) {
        $query->where('sender_id', $authId)
              ->where('receiver_id', $adminId);
    })
    ->orWhere(function ($query) use ($adminId, $authId) {
        $query->where('sender_id', $adminId)
              ->where('receiver_id', $authId);
    })
    ->orderBy('created_at', 'asc')
    ->get();
    
    
    if ($messages->isEmpty()) {
        return response()->json([
            'status'  => false,
            'message' => 'No messages found.',
        ], 200);
    }

    return response()->json([
        'status' => true,
        'data' => $messages,
        'message' => 'chat added successfully',
    ],200);
    
    
}

public function index()
{
    $adminId = Auth::id();

    // All users who have chatted with admin
    $userIds = Chat::where('receiver_id', $adminId)
        ->orWhere('sender_id', $adminId)
        ->pluck('sender_id')
        ->merge(Chat::where('receiver_id', $adminId)->pluck('receiver_id'))
        ->unique()
        ->filter(fn($id) => $id != $adminId)
        ->values();


    // Fetch users + message count + last message
    $chatUsers = User::whereIn('id', $userIds)->get()->map(function ($user) use ($adminId) {
        // Get last message between admin and this user
        $lastMessage = Chat::where(function ($q) use ($user, $adminId) {
                $q->where('sender_id', $user->id)
                  ->where('receiver_id', $adminId);
            })
            ->orWhere(function ($q) use ($user, $adminId) {
                $q->where('sender_id', $adminId)
                  ->where('receiver_id', $user->id);
            })
            ->latest()
            ->first();

        // Get message count
        $messageCount = Chat::where(function ($q) use ($user, $adminId) {
                $q->where('sender_id', $user->id)
                  ->where('receiver_id', $adminId);
            })
            ->orWhere(function ($q) use ($user, $adminId) {
                $q->where('sender_id', $adminId)
                  ->where('receiver_id', $user->id);
            })
            ->count();

        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'profile_image' => $user->profile_image
    ? rtrim(config('app.url'), '/') . '/' . ltrim($user->profile_image, '/')
    : 'https://via.placeholder.com/37x37',

            'last_message' => $lastMessage?->message ?? 'No messages yet',
            'last_message_time' => $lastMessage?->created_at?->diffForHumans() ?? '-',
            'message_count' => $messageCount,
        ];
    });

    return view('Admin.chat.index', compact('chatUsers'));
}

public function getUserOrders($userId)
{
    $orders = Order::with(['orderitems', 'billing'])
        ->where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($order) {
            $rawOrder = $order->getAttributes();
            return [
                'id' => $order->id,
                'order_id' => $rawOrder['order_id'] ?? '-',
                'name' => $rawOrder['name'] ?? '-',
                'location' => $rawOrder['location'] ?? '-',
                'status' => $rawOrder['status'] ?? 'pending',
                'amount_paid' => $rawOrder['amount_paid'] ?? 0,
                'amount_remaining' => $rawOrder['amount_remaining'] ?? 0,
                'subtotal' => $rawOrder['subtotal'] ?? 0,
                'delivery_fee' => $rawOrder['delivery_fee'] ?? 0,
                'total_amount' => $rawOrder['total_amount'] ?? 0,
                'placed_date' => $rawOrder['placed_date'] ? \Carbon\Carbon::parse($rawOrder['placed_date'])->format('M j, Y') : '-',
                'placed_date_raw' => $rawOrder['placed_date'] ? \Carbon\Carbon::parse($rawOrder['placed_date'])->format('Y-m-d') : null,
                'deliver_date' => $rawOrder['deliver_date'] ? \Carbon\Carbon::parse($rawOrder['deliver_date'])->format('M j, Y') : null,
                'deliver_date_raw' => $rawOrder['deliver_date'] ? \Carbon\Carbon::parse($rawOrder['deliver_date'])->format('Y-m-d') : null,
                'delivered_date' => $rawOrder['delivered_date'] ? \Carbon\Carbon::parse($rawOrder['delivered_date'])->format('M j, Y') : null,
                'items' => $order->orderitems->map(function($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product_id ?? 'N/A',
                        'variety' => $item->variety ?? 'N/A',
                        'quality' => $item->quality ?? 'N/A',
                        'price' => $item->price ?? 0,
                        'quantity' => $item->quantity ?? 0,
                        'total_price' => $item->total_price ?? 0,
                    ];
                }),
                'billing' => $order->billing ? [
                    'full_name' => $order->billing->full_name ?? '',
                    'phone' => $order->billing->phone ?? '',
                    'address' => $order->billing->address ?? '',
                    'city' => $order->billing->city ?? '',
                    'state' => $order->billing->state ?? '',
                ] : null
            ];
        });

    return response()->json([
        'status' => true,
        'data' => $orders
    ]);
}

public function getUserConsultancy($userId)
{
    $consultancies = \App\Models\UserConsult::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($consult) {
            return [
                'id' => $consult->id,
                'consultancy' => $consult->consultancy ?? '-',
                'sub_consultancy' => $consult->sub_consultancy ?? '-',
                'created_at' => $consult->created_at ? $consult->created_at->format('M j, Y') : '-',
            ];
        });

    return response()->json([
        'status' => true,
        'data' => $consultancies
    ]);
}

 public function chatSystem(Request $request)
    {
    


        $adminId = Auth::id();

        // ⚡ CASE 1: Handle AJAX "send message"
        if ($request->ajax() && $request->action === 'send') {
            $request->validate(['message' => 'required|string']);

            $message = Chat::create([
                'sender_id' => $adminId,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
            ]);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'message' => $message->message,
                    'time' => $message->created_at->format('h:i A')
                ],
            ]);
        }

        // ⚡ CASE 2: Handle AJAX "fetch messages"
        if ($request->ajax() && $request->action === 'fetch') {
            $userId = $request->receiver_id;

            $messages = Chat::where(function ($q) use ($userId, $adminId) {
                    $q->where('sender_id', $adminId)
                      ->where('receiver_id', $userId);
                })
                ->orWhere(function ($q) use ($userId, $adminId) {
                    $q->where('sender_id', $userId)
                      ->where('receiver_id', $adminId);
                })
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($msg) {
                    return [
                        'id' => $msg->id,
                        'sender_id' => $msg->sender_id,
                        'message' => $msg->message,
                        'time' => $msg->created_at->diffForHumans(),
                        'created_at' => $msg->created_at->toDateTimeString(),
                    ];
                });

            return response()->json(['data' => $messages]);
        }

        // ⚡ CASE 3: Default page load
        $userIds = Chat::where('receiver_id', $adminId)
            ->orWhere('sender_id', $adminId)
            ->pluck('sender_id')
            ->merge(Chat::where('receiver_id', $adminId)->pluck('receiver_id'))
            ->unique()
            ->filter(fn($id) => $id != $adminId)
            ->values();

        $chatUsers = User::whereIn('id', $userIds)->get()->map(function ($user) use ($adminId) {
            $lastMessage = Chat::where(function ($q) use ($user, $adminId) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $adminId);
                })
                ->orWhere(function ($q) use ($user, $adminId) {
                    $q->where('sender_id', $adminId)
                      ->where('receiver_id', $user->id);
                })
                ->latest()
                ->first();

            return [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'profile_image' => $user->profile_image
                    ? rtrim(config('app.url'), '/') . '/' . ltrim($user->profile_image, '/')
                    : 'https://via.placeholder.com/37x37',
                'last_message' => $lastMessage?->message ?? 'No messages yet',
                'last_message_time' => $lastMessage?->created_at?->diffForHumans() ?? '-',
            ];
        });

        return view('Admin.chat.index', compact('chatUsers'));
    }


    




}
