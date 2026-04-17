<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Invoice</title>
</head>

<body style="background:#f4f6f9;padding:30px;font-family:Arial">

<div style="max-width:700px;margin:auto;background:white;border-radius:8px;overflow:hidden">

<!-- Header -->
<div style="background:#4f46e5;color:white;padding:20px">
<h2 style="margin:0">CRM System</h2>
<p style="margin:0">Invoice Notification</p>
</div>

<!-- Content -->
<div style="padding:25px">

<h3>Xin chào {{ $invoice->customer->name ?? 'Khách hàng' }} 👋</h3>

<p>Invoice của bạn đã được tạo với thông tin sau:</p>

<table style="width:100%;border-collapse:collapse">

<tr>
<td style="padding:10px;border-bottom:1px solid #eee">
<strong>Mã Invoice</strong>
</td>
<td style="border-bottom:1px solid #eee">
{{ $invoice->code }}
</td>
</tr>

<tr>
<td style="padding:10px;border-bottom:1px solid #eee">
<strong>Ngày phát hành</strong>
</td>
<td style="border-bottom:1px solid #eee">
{{ $invoice->issue_date->format('d/m/Y') }}
</td>
</tr>

<tr>
<td style="padding:10px;border-bottom:1px solid #eee">
<strong>Hạn thanh toán</strong>
</td>
<td style="border-bottom:1px solid #eee">
{{ $invoice->due_date->format('d/m/Y') }}
</td>
</tr>

<tr>
<td style="padding:10px;border-bottom:1px solid #eee">
<strong>Tổng tiền</strong>
</td>
<td style="border-bottom:1px solid #eee;color:#e11d48;font-weight:bold">
{{ number_format($invoice->total_amount,0,',','.') }} VNĐ
</td>
</tr>

<tr>
<td style="padding:10px;border-bottom:1px solid #eee">
<strong>Đã thanh toán</strong>
</td>
<td style="border-bottom:1px solid #eee">
{{ number_format($invoice->paid_amount,0,',','.') }} VNĐ
</td>
</tr>

<tr>
<td style="padding:10px">
<strong>Còn lại</strong>
</td>
<td style="color:#f59e0b;font-weight:bold">
{{ number_format($invoice->remaining,0,',','.') }} VNĐ
</td>
</tr>

</table>

@if($invoice->bank_info)
<br>
<div style="background:#f9fafb;padding:15px;border-radius:6px">
<strong>Thông tin thanh toán</strong>
<p>{{ $invoice->bank_info }}</p>
</div>
@endif

<br>

<a href="#" 
style="
background:#4f46e5;
color:white;
padding:12px 20px;
text-decoration:none;
border-radius:6px;
display:inline-block;
margin-top:10px
">
Xem Invoice
</a>

</div>

<!-- Footer -->
<div style="background:#f9fafb;padding:20px;text-align:center;font-size:12px;color:#666">
CRM System © {{ date('Y') }} <br>
Email này được gửi tự động
</div>

</div>

</body>
</html>
