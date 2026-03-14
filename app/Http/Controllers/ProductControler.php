<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        echo "Đây là trang sản phẩm";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        echo "Đây là trang tạo sản phẩm";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        echo "Đây là trang chi tiết sản phẩm có id: " . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function list()
    {
        echo "Đây là trang danh sách sản phẩm";
    }

    public function detail()
    {
        echo "Đây là trang chi tiết sản phẩm";
    }
    public function search()
    {
        echo "Đây là trang tìm kiếm sản phẩm";
    }
}
