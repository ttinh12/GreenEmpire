<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn {{ $invoice->code }}</title>
    <style>
        @page { margin: 25mm 18mm 22mm 18mm; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #111827;
            margin: 0;
        }

        .text-center  { text-align: center; }
        .text-right   { text-align: right; }
        .text-left    { text-align: left; }
        .fw-bold      { font-weight: 700; }
        .muted        { color: #6b7280; }

        /* ── Tiêu đề quốc gia ── */
        .national-title    { font-weight: 700; font-size: 14px; text-transform: uppercase; margin: 0; }
        .national-subtitle { font-weight: 700; font-size: 13px; margin: 4px 0 8px; }
        .divider           { width: 160px; height: 1px; background: #111827; margin: 0 auto 20px; }

        /* ── Tiêu đề hóa đơn ── */
        .doc-title    { font-size: 20px; font-weight: 700; text-transform: uppercase; margin: 16px 0 4px; }
        .doc-code     { font-size: 13px; margin: 0 0 4px; }
        .doc-date     { font-size: 12px; margin: 0 0 20px; font-style: italic; }

        /* ── Bảng thông tin hai bên ── */
        .party-block   { margin: 12px 0; }
        .party-title   { font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px; }
        .info-table    { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 3px 0; vertical-align: top; }
        .info-label    { width: 155px; font-weight: 700; }

        /* ── Bảng hàng hóa ── */
        .item-table               { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .item-table th,
        .item-table td            { border: 1px solid #374151; padding: 7px; vertical-align: top; }
        .item-table th            { background: #f3f4f6; text-align: center; font-weight: 700; }

        /* ── Bảng tổng kết ── */
        .summary-table            { width: 50%; border-collapse: collapse; margin-left: auto; margin-top: 8px; }
        .summary-table td         { border: 1px solid #374151; padding: 7px 10px; }
        .summary-label            { background: #f9fafb; font-weight: 700; }
        .summary-total td         { background: #f0effe; font-weight: 700; font-size: 13px; }

        /* ── Thanh toán ── */
        .payment-table            { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .payment-table th,
        .payment-table td         { border: 1px solid #d1d5db; padding: 6px 8px; }
        .payment-table th         { background: #f3f4f6; font-weight: 700; text-align: center; }

        /* ── Trạng thái badge ── */
        .badge-paid    { background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 4px; }
        .badge-pending { background: #fef9c3; color: #854d0e; padding: 2px 8px; border-radius: 4px; }
        .badge-unpaid  { background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 4px; }

        /* ── Chữ ký ── */
        .signature-table    { width: 100%; margin-top: 36px; border-collapse: collapse; }
        .signature-table td { width: 50%; vertical-align: top; text-align: center; }
        .signature-title    { font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
        .signature-note     { font-style: italic; font-size: 11px; color: #6b7280; }
        .signature-space    { height: 70px; }

        .section-title { margin: 18px 0 8px; font-size: 13px; font-weight: 700; text-transform: uppercase; }
        .paragraph     { margin: 0 0 8px; text-align: justify; }
        .doc-right     { text-align: right; font-size: 11px; color: #6b7280; margin-bottom: 6px; }
    </style>
</head>
<body>

    <div class="doc-right">Số: {{ $invoice->code }}</div>

    {{-- Tiêu đề quốc gia --}}
    <div class="text-center">
        <p class="national-title">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</p>
        <p class="national-subtitle">Độc lập - Tự do - Hạnh phúc</p>
        <div class="divider"></div>
    </div>

    {{-- Tiêu đề --}}
    <div class="text-center">
        <p class="doc-title">HÓA ĐƠN DỊCH VỤ</p>
        <p class="doc-code">Mã hóa đơn: <strong>{{ $invoice->code }}</strong></p>
        <p class="doc-date">
            Ngày lập: {{ $invoice->issue_date->format('d/m/Y') }} &nbsp;|&nbsp;
            Hạn thanh toán: {{ $invoice->due_date->format('d/m/Y') }}
        </p>
    </div>

    {{-- Bên cung cấp --}}
    <div class="party-block">
        <div class="party-title">ĐƠN VỊ CUNG CẤP DỊCH VỤ (Bên A)</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Tên đơn vị:</td>
                <td><strong>XƯỞNG CNTT – FPT POLYTECHNIC</strong></td>
            </tr>
            <tr>
                <td class="info-label">Phòng ban:</td>
                <td>{{ $invoice->department?->name ?? 'Không phân phòng' }}</td>
            </tr>
            <tr>
                <td class="info-label">Người lập:</td>
                <td>{{ $invoice->creator?->name ?? 'Hệ thống' }}</td>
            </tr>
            <tr>
                <td class="info-label">Hợp đồng liên quan:</td>
                <td>{{ $invoice->contract?->code ?? '—' }} – {{ $invoice->contract?->title ?? '' }}</td>
            </tr>
        </table>
    </div>

    {{-- Khách hàng --}}
    <div class="party-block">
        <div class="party-title">KHÁCH HÀNG (Bên B)</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Tên khách hàng:</td>
                <td><strong>{{ $invoice->customer?->name ?? '—' }}</strong></td>
            </tr>
            <tr>
                <td class="info-label">Mã khách hàng:</td>
                <td>{{ $invoice->customer?->code ?? '—' }}</td>
            </tr>
            <tr>
                <td class="info-label">Địa chỉ:</td>
                <td>{{ $invoice->customer?->address ?? 'Chưa cập nhật' }}</td>
            </tr>
            <tr>
                <td class="info-label">Điện thoại:</td>
                <td>{{ $invoice->customer?->phone ?? 'Chưa cập nhật' }}</td>
            </tr>
            <tr>
                <td class="info-label">Email:</td>
                <td>{{ $invoice->customer?->email ?? 'Chưa cập nhật' }}</td>
            </tr>
            @if($invoice->customer?->tax_code)
            <tr>
                <td class="info-label">Mã số thuế:</td>
                <td>{{ $invoice->customer->tax_code }}</td>
            </tr>
            @endif
        </table>
    </div>

    {{-- Bảng hàng hóa/dịch vụ --}}
    <div class="section-title">CHI TIẾT DỊCH VỤ</div>

    @if($invoice->invoiceItems->count() > 0)
    <table class="item-table">
        <thead>
            <tr>
                <th style="width:5%">STT</th>
                <th style="width:35%">Tên dịch vụ / Mô tả</th>
                <th style="width:10%">Đơn vị</th>
                <th style="width:10%">SL</th>
                <th style="width:15%">Đơn giá (₫)</th>
                <th style="width:10%">VAT</th>
                <th style="width:15%">Thành tiền (₫)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->invoiceItems as $i => $item)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>
                    @if($item->service)
                        <strong>{{ $item->service->name }}</strong><br>
                        <span class="muted" style="font-size:11px;">{{ $item->description }}</span>
                    @else
                        {{ $item->description }}
                    @endif
                </td>
                <td class="text-center">{{ $item->unit ?? '—' }}</td>
                <td class="text-center">{{ number_format($item->quantity, 2, '.', ',') }}</td>
                <td class="text-right">{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                <td class="text-center">{{ $item->vat_rate }}%</td>
                <td class="text-right">{{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="paragraph muted">Hóa đơn không có chi tiết dịch vụ cụ thể. Giá trị được tính theo hợp đồng.</p>
    @endif

    {{-- Tổng kết --}}
    <table class="summary-table">
        <tr>
            <td class="summary-label">Tạm tính</td>
            <td class="text-right">{{ number_format($invoice->subtotal, 0, ',', '.') }} ₫</td>
        </tr>
        <tr>
            <td class="summary-label">VAT ({{ $invoice->vat_rate }}%)</td>
            <td class="text-right">{{ number_format($invoice->vat_amount, 0, ',', '.') }} ₫</td>
        </tr>
        <tr class="summary-total">
            <td class="summary-label">TỔNG TIỀN</td>
            <td class="text-right">{{ number_format($invoice->total_amount, 0, ',', '.') }} ₫</td>
        </tr>
        <tr>
            <td class="summary-label">Đã thanh toán</td>
            <td class="text-right" style="color:#166534;">{{ number_format($invoice->paid_amount, 0, ',', '.') }} ₫</td>
        </tr>
        <tr>
            <td class="summary-label">Còn lại</td>
            <td class="text-right" style="color:#991b1b; font-weight:700;">
                {{ number_format($invoice->total_amount - $invoice->paid_amount, 0, ',', '.') }} ₫
            </td>
        </tr>
        <tr>
            <td class="summary-label">Trạng thái</td>
            <td class="text-center">
                @php
                    $sv = $invoice->status instanceof \App\Enums\InvoiceStatus
                        ? $invoice->status->value : $invoice->status;
                @endphp
                @if($sv == 1)
                    <span class="badge-paid">Đã thanh toán</span>
                @elseif($sv == 2)
                    <span class="badge-pending">Chờ thanh toán</span>
                @else
                    <span class="badge-unpaid">Chưa thanh toán</span>
                @endif
            </td>
        </tr>
    </table>

    {{-- Thông tin thanh toán --}}
    @if($invoice->bank_info)
    <div class="section-title">THÔNG TIN THANH TOÁN</div>
    <p class="paragraph">{{ $invoice->bank_info }}</p>
    @endif

    {{-- Lịch sử thanh toán --}}
    @if($invoice->payments->count() > 0)
    <div class="section-title">LỊCH SỬ THANH TOÁN</div>
    <table class="payment-table">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Số tiền (₫)</th>
                <th>Phương thức</th>
                <th>Số tham chiếu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->payments as $p)
            @php
                $methods = [1=>'Chuyển khoản', 2=>'Tiền mặt', 3=>'Séc', 4=>'Khác'];
            @endphp
            <tr>
                <td class="text-center">{{ $p->payment_date->format('d/m/Y') }}</td>
                <td class="text-right">{{ number_format($p->amount, 0, ',', '.') }}</td>
                <td class="text-center">{{ $methods[$p->method] ?? 'Khác' }}</td>
                <td class="text-center">{{ $p->reference ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- Ghi chú --}}
    @if($invoice->notes)
    <div class="section-title">GHI CHÚ</div>
    <p class="paragraph">{{ $invoice->notes }}</p>
    @endif

    <p class="paragraph" style="margin-top:16px;">
        Hóa đơn này là chứng từ hợp lệ cho giao dịch giữa hai bên.
        Mọi thắc mắc vui lòng liên hệ đội ngũ xưởng CNTT qua hệ thống Ticket hoặc email.
    </p>

    {{-- Chữ ký --}}
    <table class="signature-table">
        <tr>
            <td>
                <div class="signature-title">ĐẠI DIỆN BÊN A</div>
                <div class="signature-note">(Ký, ghi rõ họ tên)</div>
                <div class="signature-space"></div>
                <strong>{{ $invoice->creator?->name ?? 'XƯỞNG CNTT' }}</strong>
            </td>
            <td>
                <div class="signature-title">ĐẠI DIỆN BÊN B</div>
                <div class="signature-note">(Ký, ghi rõ họ tên)</div>
                <div class="signature-space"></div>
                <strong>{{ $invoice->customer?->name ?? 'KHÁCH HÀNG' }}</strong>
            </td>
        </tr>
    </table>

</body>
</html>