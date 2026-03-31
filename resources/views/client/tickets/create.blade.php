@extends('client.layouts.master')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Tạo Phiếu Hỗ Trợ Mới</h4>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('ticket.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="VD: Lỗi đăng nhập..."
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung chi tiết</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Mức độ ưu tiên</label>
                            <select name="priority" id="priority" class="form-select">
                                <option value="low">Thấp</option>
                                <option value="medium" selected>Trung bình</option>
                                <option value="high">Cao</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="assign_id" class="form-label">Giao cho nhân viên</label>
                            <select name="assign_id" id="assign_id" class="form-select">
                                <option value="">-- Chọn người xử lý --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <input type="hidden" name="status" value="open">

                    <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                    <a href="{{ route('ticket.home') }}" class="btn btn-outline-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>

@endsection