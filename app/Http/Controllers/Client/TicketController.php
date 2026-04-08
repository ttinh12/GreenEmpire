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
        $users = User::all();
        return view('client.tickets.create', compact('users'));
    }
    /** 
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    // Validate dữ liệu
    $request->validate([
        'title'   => 'required|max:255',
        'content' => 'required',
    ]);

    Ticket::create([
        'title'     => $request->title,
        'content'   => $request->input('content'),
        'priority'  => $request->priority ?? 1,
        'status'    => $request->status ?? 1,
        'assign_id' => $request->assign_id ?: null, // Tránh gửi chuỗi rỗng
        'user_id'   => auth()->id(),
        // LẤY TÊN USER ĐĂNG NHẬP ĐỂ ĐIỀN VÀO CỘT NAME
        'name'      => auth()->user()->name, 
    ]);

    return redirect()->route('dashboard')->with('success', 'Yêu cầu của bạn đã được gửi thành công!');
}     
    /**
     * Display the specified resource.
     */
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
