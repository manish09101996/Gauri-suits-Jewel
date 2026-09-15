<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }} - Gauri Suits & Jewel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.5;
            padding: 40px 20px;
        }
        .invoice-box {
            max-width: 850px;
            margin: auto;
            background: #ffffff;
            padding: 48px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 28px;
            border-bottom: 2px solid #58111A;
            margin-bottom: 32px;
        }
        .brand-title {
            font-family: 'Cinzel', serif;
            font-size: 26px;
            font-weight: 800;
            color: #58111A;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .brand-sub {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #C5A869;
            font-weight: 600;
            margin-top: 2px;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h1 {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 1px;
        }
        .invoice-title .meta {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-bottom: 32px;
        }
        .info-card h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #94a3b8;
            margin-bottom: 8px;
            font-weight: 700;
        }
        .info-card p {
            font-size: 14px;
            color: #334155;
            line-height: 1.6;
        }
        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
        }
        table.items-table th {
            background: #f8fafc;
            color: #475569;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            padding: 12px 16px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
        }
        table.items-table td {
            padding: 14px 16px;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
        }
        table.items-table td.qty, table.items-table th.qty { text-align: center; }
        table.items-table td.price, table.items-table th.price { text-align: right; }
        .summary-wrap {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 32px;
        }
        .summary-table {
            width: 320px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
            color: #475569;
            border-bottom: 1px solid #f1f5f9;
        }
        .summary-row.total {
            border-top: 2px solid #0f172a;
            border-bottom: 2px solid #0f172a;
            font-size: 18px;
            font-weight: 800;
            color: #58111A;
            padding: 12px 0;
            margin-top: 8px;
        }
        .footer-note {
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #64748b;
            text-align: center;
            line-height: 1.6;
        }
        .print-bar {
            max-width: 850px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-print {
            background: #58111A;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-print:hover { background: #400c13; }
        .btn-back {
            color: #475569;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }
        @media print {
            body { background: #fff; padding: 0; }
            .invoice-box { box-shadow: none; border: none; padding: 0; }
            .print-bar { display: none; }
        }
    </style>
</head>
<body>

    <div class="print-bar">
        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-back">← Back to Order</a>
        <button onclick="window.print()" class="btn-print">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Tax Invoice
        </button>
    </div>

    <div class="invoice-box">
        <div class="header">
            <div>
                <div class="brand-title">Gauri Suits & Jewel</div>
                <div class="brand-sub">Luxury Punjabi Couture & Fine Jewellery</div>
                <p style="font-size: 12px; color: #64748b; margin-top: 6px;">
                    Heritage Arcade, Mall Road, Ludhiana, Punjab - 141001<br>
                    GSTIN: 03AAAAA0000A1Z5 | contact@gaurisuits.com | +91 98765 43210
                </p>
            </div>
            <div class="invoice-title">
                <h1>TAX INVOICE</h1>
                <div class="meta"><strong>Invoice #:</strong> {{ $order->order_number }}</div>
                <div class="meta"><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</div>
                <div class="meta"><strong>Status:</strong> <span style="text-transform: uppercase; font-weight: 700; color: {{ $order->payment_status === 'paid' ? '#059669' : '#d97706' }};">{{ $order->payment_status }}</span></div>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h3>Billed & Shipped To:</h3>
                <p>
                    <strong>{{ $order->shipping_name }}</strong><br>
                    {{ $order->shipping_address_line1 }}<br>
                    @if($order->shipping_address_line2) {{ $order->shipping_address_line2 }}<br> @endif
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_postal_code }}<br>
                    {{ $order->shipping_country ?? 'India' }}<br>
                    Phone: {{ $order->shipping_phone }}<br>
                    Email: {{ $order->customer_email ?? ($order->user->email ?? 'N/A') }}
                </p>
            </div>
            <div class="info-card">
                <h3>Order & Payment Details:</h3>
                <p>
                    <strong>Order ID:</strong> #{{ $order->order_number }}<br>
                    <strong>Order Date:</strong> {{ $order->created_at->format('d M, Y h:i A') }}<br>
                    <strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}<br>
                    <strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}<br>
                    @if($order->payment && $order->payment->transaction_id)
                        <strong>Transaction ID:</strong> {{ $order->payment->transaction_id }}<br>
                    @endif
                    @if($order->shipment && $order->shipment->tracking_number)
                        <strong>Tracking Number:</strong> {{ $order->shipment->tracking_number }} ({{ $order->shipment->carrier }})<br>
                    @endif
                </p>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Product & Description</th>
                    <th>SKU</th>
                    <th class="qty">Qty</th>
                    <th class="price">Unit Price</th>
                    <th class="price">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $idx => $item)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>
                        <strong style="color: #0f172a;">{{ $item->product_name }}</strong>
                        @if($item->variant_title)
                            <div style="font-size: 12px; color: #64748b;">Variant: {{ $item->variant_title }}</div>
                        @endif
                    </td>
                    <td style="color: #64748b; font-size: 12px;">{{ $item->sku ?? 'N/A' }}</td>
                    <td class="qty">{{ $item->quantity }}</td>
                    <td class="price">₹{{ number_format($item->unit_price, 2) }}</td>
                    <td class="price"><strong>₹{{ number_format($item->total_price, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-wrap">
            <div class="summary-table">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="summary-row" style="color: #059669;">
                    <span>Discount ({{ $order->coupon_code ?? 'Coupon' }}):</span>
                    <span>-₹{{ number_format($order->discount_amount, 2) }}</span>
                </div>
                @endif
                <div class="summary-row">
                    <span>Shipping Charges:</span>
                    <span>{{ $order->shipping_amount > 0 ? '₹' . number_format($order->shipping_amount, 2) : 'FREE' }}</span>
                </div>
                @if($order->tax_amount > 0)
                <div class="summary-row">
                    <span>GST / Taxes:</span>
                    <span>₹{{ number_format($order->tax_amount, 2) }}</span>
                </div>
                @endif
                <div class="summary-row total">
                    <span>Grand Total:</span>
                    <span>₹{{ number_format($order->grand_total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="footer-note">
            <p>Thank you for shopping with <strong>Gauri Suits & Jewel</strong>. Celebrating timeless Punjabi craftsmanship & royal jewellery.</p>
            <p style="margin-top: 4px;">This is a computer-generated tax invoice and requires no physical signature. For queries, write to support@gaurisuits.com.</p>
        </div>
    </div>

</body>
</html>
