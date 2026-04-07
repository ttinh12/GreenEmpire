@extends('client.layouts.master')

@section('title') 
Danh mục Dịch vụ Nông nghiệp
@endsection 

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh mục dịch vụ & Vật tư nông nghiệp</h2>

    <table class="table table-bordered">
        <thead class="table-success">
            <tr>
                <th>Tên dịch vụ</th>
                <th>Mô tả</th>
                <th>Giá cơ bản</th>
                <th>Đơn vị</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service) {{-- Dùng forelse để check nếu trống --}}
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->description }}</td>
                    <td>{{ number_format($service->base_price) }} VNĐ</td>
                    <td>{{ $service->unit }}</td>
                    <td>
                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-success">Đăng ký ngay</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Hiện chưa có dịch vụ nào trong hệ thống.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{$services->links() }}
    </div>
</div>
@endsection