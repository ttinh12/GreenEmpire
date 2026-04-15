<?php
use App\Enums\TicketStatus;
?>

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
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                            value="{{ old('title') }}" placeholder="VD: Cần hỗ trợ thuê máy cày...">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung chi tiết</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content"
                            rows="3">{{ old('content') }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="priority" class="form-label">Mức độ ưu tiên</label>
                            <select name="priority" id="priority" class="form-select">
                                <option value="1">Thấp</option>
                                <option value="2" selected>Trung bình</option>
                                <option value="3">Cao</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Gửi yêu cầu hỗ trợ</button> <a
                        href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
@endsection