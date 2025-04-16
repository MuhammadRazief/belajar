<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IndoApril</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            max-width: 650px;
            margin: 0 auto;
        }
        h3, p {
            margin: 20px;
        }
        .header {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .right {
            text-align: right;
        }
        .summary-table {
            margin-bottom: 10px;
        }
        .summary-table td {
            border: none;
        }
        .summary-table .label {
            width: 70%;
        }
        .total-row td {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            color: #626060;
            font-size: 110%;
        }
        .center {
            text-align: center;
            color: #626060;
            font-weight: bold;
            font-size: 90%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>{{ $sale->customer ? $sale->customer->name : 'Non-Member' }}</h3>
        <p>
            Member Status: {{ $isMember ? 'Member' : 'Non-Member' }}<br>
            No. HP: {{ $sale->customer ? $sale->customer->no_hp : '-' }}<br>
            Bergabung Sejak: {{ $sale->customer ? $sale->customer->created_at->format('d F Y') : '-' }}<br>
            Poin Member: {{ $sale->customer ? $sale->customer->poin : 0 }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detail_sale as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp. {{ number_format($detail->product->price, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary-table">
        <tr>
            <td class="label">Poin Digunakan</td>
            <td class="right">{{ number_format($sale->used_point, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Total Harga</td>
            <td class="right">Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Harga Setelah Poin</td>
            <td class="right">Rp. {{ number_format($sale->total_price - $sale->used_point, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td class="label">Total Kembalian</td>
            <td class="right">Rp. {{ number_format($sale->total_return, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p class="footer">
        {{ date('Y-m-d H:i:s', strtotime($sale->sale_date)) }} | {{ $sale->user->name }}
    </p>
    <p class="center">Terima kasih atas pembelian Anda!</p>
</body>
</html>
