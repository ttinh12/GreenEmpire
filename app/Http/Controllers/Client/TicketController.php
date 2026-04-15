<?php

namespace App\Http\Controllers\Client;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreTicketRequest;

use function Symfony\Component\String\u;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $tickets = Ticket::with(['user', 'assignee'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Phân trang 10 mục mỗi trang cho giao diện gọn

        return view('client.tickets.index', compact('tickets'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Không cần lấy danh sách User nữa vì khách không được chọn
        return view('client.tickets.create');
    }

    public function store(StoreTicketRequest $request)
    {
        // Khi code chạy đến đây, dữ liệu chắc chắn đã hợp lệ
        $validated = $request->validated();

        Ticket::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'priority' => $validated['priority'],

            // Các giá trị mặc định hệ thống tự áp đặt
            'status' => 1,    // Chờ xử lý
            'assign_id' => null, // Chưa giao cho ai
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
        ]);

        return redirect()->route('dashboard')->with('success', 'Gửi phiếu hỗ trợ thành công!');
    }
    public function show(string $id)
    {
        $ticket = Ticket::with(['user', 'assignee'])->findOrFail($id);
        return view('client.tickets.show', compact('ticket'));
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
