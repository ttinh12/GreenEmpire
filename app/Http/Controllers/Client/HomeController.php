<?php

namespace App\Http\Controllers\Client;

use App\Models\Ticket;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// danh sách ticket

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $rel = DB::table('tickets')->where('status', 0)->get();

         //$rel1 = Ticket::all();

        // $rel2 = DB::table('tickets')->where('status', 1)->orderBy('status')->get();

        return view('client.tickets.index');

      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'assign_id' => $request->assign_id,
            'user_id' => $request->user_id,
            'status' => $request->status,
        ]);
        return redirect()->route('ticket.home');
                    
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
