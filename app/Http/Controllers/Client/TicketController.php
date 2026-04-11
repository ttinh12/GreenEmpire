<?php

namespace App\Http\Controllers\Client;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $tickets = Ticket::with(['creator', 'assignee'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Phân trang 10 mục mỗi trang cho giao diện gọn

        return view('client.tickets.index', compact('tickets'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Không cần $users = User::all() nữa
        return view('client.tickets.create');
    }    /** 
         * Store a newly created resource in storage.
         */
    public function store(Request $request)
    {
        // 1. Validate dữ liệu tối thiểu cần thiết
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'priority' => 'nullable|integer|in:1,2,3', // Đảm bảo priority nằm trong khoảng cho phép
        ]);

        // 2. Tạo Ticket với các giá trị được chỉ định sẵn
        Ticket::create([
            'title' => $request->title,
            'content' => $request->input('content'),
            'priority' => $request->priority ?? 2, // Mặc định là Trung bình (2) nếu không chọn

            // GIÁ TRỊ ÉP CỨNG:
            'status' => 1,      // Luôn là 1 (Hoạt động/Mới tạo)
            'assign_id' => null,   // Luôn là null (Để Admin vào giao sau)

            // THÔNG TIN NGƯỜI TẠO:
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
        ]);

        return redirect()->route('dashboard')->with('success', 'Yêu cầu của bạn đã được gửi thành công!');
    }   
    public function show(string $id)
    {
        return view('client.tickets.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Ticket::updated([
            'title' => 'php3',
            'description' => 'php3',
            'assign_id' => 1,
            'user_id' => 1,
            'status' => 0,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
