<table>
    <thead>
        <tr>
            <th>Nama Pelanggan</th>
            <th>No HP Pelanggan</th>
            <th>Poin Pelanggan</th>
            <th>Produk</th>
            <th>Total Harga</th>
            <th>Total Bayar</th>
            <th>Total Diskon</th>
            <th>Total Kembalian</th>
            <th>Tanggal Pembelian</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
            @if ($sale->customer)
                <tr>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ $sale->customer->no_hp }}</td>
                    <td>{{ $sale->customer->poin }}</td>
                    <td>
                        @foreach ($detail_sale as $detail)
                            @if ($sale->id == $detail->sale_id)
                                {{ $detail->product->name . ' ' . $detail->quantity . ' : Rp ' . number_format($detail->sub_total, 0, ',', '.') . ', ' }}
                            @endif
                        @endforeach
                    </td>
                    <td>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->total_pay, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->used_point, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->total_return, 0, ',', '.') }}</td>
                    <td>{{ $sale->sale_date }}</td>
                </tr>
            @else
                <tr>
                    <td>Bukan Member</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        @foreach ($detail_sale as $detail)
                            @if ($sale->id == $detail->sale_id)
                                {{ $detail->product->name . ' ' . $detail->quantity . ' : Rp ' . number_format($detail->sub_total, 0, ',', '.') . ', ' }}
                            @endif
                        @endforeach
                    </td>
                    <td>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->total_pay, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->used_point, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->total_return, 0, ',', '.') }}</td>
                    <td>{{ $sale->sale_date }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
