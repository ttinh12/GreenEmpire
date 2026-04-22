<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hợp đồng {{ $contract->code }}</title>
    <style>
        @page {
            margin: 28mm 18mm 24mm 18mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #111827;
            margin: 0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .document-code {
            font-size: 13px;
            margin-bottom: 8px;
        }

        .national-title {
            font-weight: 700;
            font-size: 15px;
            text-transform: uppercase;
            margin: 0;
        }

        .national-subtitle {
            font-weight: 700;
            font-size: 14px;
            margin: 6px 0 10px;
        }

        .divider {
            width: 180px;
            height: 1px;
            background: #111827;
            margin: 0 auto 24px;
        }

        .contract-title {
            text-align: center;
            font-size: 21px;
            font-weight: 700;
            text-transform: uppercase;
            margin: 24px 0 10px;
        }

        .contract-subtitle {
            text-align: center;
            font-size: 14px;
            margin: 0 0 24px;
            font-style: italic;
        }

        .paragraph {
            margin: 0 0 10px;
            text-align: justify;
        }

        .party-block {
            margin: 16px 0;
        }

        .party-title {
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .info-table,
        .item-table,
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .info-label {
            width: 160px;
            font-weight: 700;
        }

        .section-title {
            margin: 22px 0 10px;
            text-align: center;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .item-table th,
        .item-table td,
        .summary-table td {
            border: 1px solid #374151;
            padding: 8px;
            vertical-align: top;
        }

        .item-table th {
            background: #f3f4f6;
            text-align: center;
            font-weight: 700;
        }

        .summary-table {
            margin-top: 10px;
        }

        .summary-label {
            width: 65%;
            font-weight: 700;
            background: #f9fafb;
        }

        .signature-table {
            width: 100%;
            margin-top: 32px;
            border-collapse: collapse;
        }

        .signature-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
        }

        .signature-title {
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .signature-note {
            font-style: italic;
            font-size: 11px;
        }

        .signature-space {
            height: 80px;
        }

        .muted {
            color: #4b5563;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="text-right document-code">Mẫu số: HĐ/{{ $contract->code }}</div>

    <div class="text-center">
        <p class="national-title">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</p>
        <p class="national-subtitle">Độc lập - Tự do - Hạnh phúc</p>
        <div class="divider"></div>
    </div>

    <div class="contract-title">HỢP ĐỒNG {{ mb_strtoupper($contract->title ?? 'CUNG CẤP DỊCH VỤ', 'UTF-8') }}</div>
    <div class="contract-subtitle">Số hợp đồng: {{ $contract->code }}</div>

    <p class="paragraph">
        Hôm nay, ngày {{ optional($contract->signed_date)->format('d') ?? '....' }} tháng
        {{ optional($contract->signed_date)->format('m') ?? '....' }} năm
        {{ optional($contract->signed_date)->format('Y') ?? '........' }}, các bên gồm có:
    </p>

    <div class="party-block">
        <div class="party-title">BÊN A: GREEN EMPIRE</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Đại diện:</td>
                <td>{{ $contract->creator->name ?? 'Đại diện công ty' }}</td>
            </tr>
            <tr>
                <td class="info-label">Phòng ban phụ trách:</td>
                <td>{{ $contract->department->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="info-label">Vai trò:</td>
                <td>Đơn vị cung cấp / triển khai hợp đồng</td>
            </tr>
        </table>
    </div>

    <div class="party-block">
        <div class="party-title">BÊN B: {{ mb_strtoupper($contract->customer->name ?? 'KHÁCH HÀNG', 'UTF-8') }}</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Tên khách hàng:</td>
                <td>{{ $contract->customer->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="info-label">Mã khách hàng:</td>
                <td>{{ $contract->customer->code ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="info-label">Địa chỉ:</td>
                <td>{{ $contract->customer->address ?? 'Chưa cập nhật' }}</td>
            </tr>
            <tr>
                <td class="info-label">Điện thoại:</td>
                <td>{{ $contract->customer->phone ?? 'Chưa cập nhật' }}</td>
            </tr>
            <tr>
                <td class="info-label">Email:</td>
                <td>{{ $contract->customer->email ?? 'Chưa cập nhật' }}</td>
            </tr>
            <tr>
                <td class="info-label">Mã số thuế:</td>
                <td>{{ $contract->customer->tax_code ?? 'Chưa cập nhật' }}</td>
            </tr>
        </table>
    </div>

    <p class="paragraph">
        Sau khi bàn bạc trên tinh thần thiện chí và hợp tác, hai bên thống nhất ký kết hợp đồng với các điều khoản sau:
    </p>

    <div class="section-title">ĐIỀU 1. NỘI DUNG HỢP ĐỒNG</div>
    <p class="paragraph">
        Bên A đồng ý cung cấp cho Bên B nội dung công việc theo hợp đồng
        <strong>{{ $contract->title }}</strong>.
        {{ $contract->description ? 'Chi tiết nội dung: ' . $contract->description : 'Chi tiết công việc sẽ được thực hiện theo phạm vi đã thỏa thuận giữa hai bên.' }}
    </p>

    @if ($contract->items->isNotEmpty())
        <table class="item-table">
            <thead>
                <tr>
                    <th style="width: 6%;">STT</th>
                    <th style="width: 38%;">Nội dung hạng mục</th>
                    <th style="width: 12%;">Đơn vị</th>
                    <th style="width: 12%;">Số lượng</th>
                    <th style="width: 16%;">Đơn giá</th>
                    <th style="width: 16%;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contract->items as $index => $item)
                    <tr>
                        <td class="text-center">{{ $item->item_order ?: $index + 1 }}</td>
                        <td>
                            {{ $item->description }}
                            @if ($item->notes)
                                <div class="muted">{{ $item->notes }}</div>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->unit ?? '-' }}</td>
                        <td class="text-center">{{ rtrim(rtrim(number_format((float) ($item->quantity ?? 0), 2, '.', ','), '0'), '.') }}</td>
                        <td class="text-right">{{ number_format((float) ($item->unit_price ?? 0), 2, ',', '.') }}</td>
                        <td class="text-right">{{ number_format((float) (($item->quantity ?? 0) * ($item->unit_price ?? 0)), 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="paragraph">
            Hợp đồng hiện chưa có danh sách hạng mục chi tiết. Giá trị thực hiện được áp dụng theo các thông tin tổng hợp bên dưới.
        </p>
    @endif

    <div class="section-title">ĐIỀU 2. GIÁ TRỊ HỢP ĐỒNG VÀ THANH TOÁN</div>
    <table class="summary-table">
        <tr>
            <td class="summary-label">Giá trị trước thuế</td>
            <td class="text-right">{{ number_format((float) $contract->value, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="summary-label">Thuế VAT ({{ number_format((float) $contract->vat_rate, 0, ',', '.') }}%)</td>
            <td class="text-right">{{ number_format((float) $contract->vat_amount, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="summary-label">Tổng giá trị thanh toán</td>
            <td class="text-right"><strong>{{ number_format((float) $contract->total_value, 2, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td class="summary-label">Điều khoản thanh toán</td>
            <td>{{ $contract->payment_terms ?? 'Thanh toán theo thỏa thuận của hai bên.' }}</td>
        </tr>
    </table>

    <div class="section-title">ĐIỀU 3. THỜI HẠN THỰC HIỆN</div>
    <table class="info-table">
        <tr>
            <td class="info-label">Ngày bắt đầu:</td>
            <td>{{ optional($contract->start_date)->format('d/m/Y') ?? 'Chưa cập nhật' }}</td>
        </tr>
        <tr>
            <td class="info-label">Ngày kết thúc:</td>
            <td>{{ optional($contract->end_date)->format('d/m/Y') ?? 'Chưa cập nhật' }}</td>
        </tr>
        <tr>
            <td class="info-label">Ngày ký:</td>
            <td>{{ optional($contract->signed_date)->format('d/m/Y') ?? 'Chưa cập nhật' }}</td>
        </tr>
        <tr>
            <td class="info-label">Bảo hành:</td>
            <td>{{ $contract->warranty_months ?? 0 }} tháng</td>
        </tr>
        <tr>
            <td class="info-label">Trạng thái:</td>
            <td>{{ $contract->status_label }}</td>
        </tr>
    </table>

    <div class="section-title">ĐIỀU 4. THÔNG TIN QUẢN LÝ HỢP ĐỒNG</div>
    <table class="info-table">
        <tr>
            <td class="info-label">Mã hợp đồng:</td>
            <td>{{ $contract->code }}</td>
        </tr>
        <tr>
            <td class="info-label">Khách hàng:</td>
            <td>{{ $contract->customer->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="info-label">Phòng ban:</td>
            <td>{{ $contract->department->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="info-label">Người tạo:</td>
            <td>{{ $contract->creator->name ?? ($contract->created_by ?? 'N/A') }}</td>
        </tr>
        <tr>
            <td class="info-label">Ngày tạo:</td>
            <td>{{ optional($contract->created_at)->format('d/m/Y H:i:s') ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="info-label">Ngày cập nhật:</td>
            <td>{{ optional($contract->updated_at)->format('d/m/Y H:i:s') ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="info-label">Tệp đính kèm:</td>
            <td>{{ $contract->file_url ?: 'Không có' }}</td>
        </tr>
    </table>

    <p class="paragraph" style="margin-top: 20px;">
        Hợp đồng này có hiệu lực kể từ ngày ký. Hai bên cam kết thực hiện đúng các điều khoản đã nêu.
        Mọi sửa đổi, bổ sung chỉ có giá trị khi được lập thành văn bản và có xác nhận của cả hai bên.
    </p>

    <table class="signature-table">
        <tr>
            <td>
                <div class="signature-title">ĐẠI DIỆN BÊN A</div>
                <div class="signature-note">(Ký, ghi rõ họ tên)</div>
                <div class="signature-space"></div>
                <strong>{{ $contract->creator->name ?? 'GREEN EMPIRE' }}</strong>
            </td>
            <td>
                <div class="signature-title">ĐẠI DIỆN BÊN B</div>
                <div class="signature-note">(Ký, ghi rõ họ tên)</div>
                <div class="signature-space"></div>
                <strong>{{ $contract->customer->name ?? 'KHÁCH HÀNG' }}</strong>
            </td>
        </tr>
    </table>
</body>
</html>
