@extends('views.main')
@section('title', '| penjualan')
@section('breadcrumb1', 'penjualan')
@section('breadcrumb2', 'penjualan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('sales.updateSale',$sale->id)}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="table table-bordered">
                                <table>
                                    <tbody>
                                        <tr class="tabletitle">
                                            <td class="item">
                                                Nama Produk
                                            </td>
                                            <td class="item">
                                                QTy
                                            </td>
                                            <td class="item">
                                                Harga
                                            </td>
                                            <td class="item">
                                                Sub Total
                                            </td>
                                        </tr>
                                        @foreach ($detail_sale as $detail)
                                            <tr class="service">
                                                <td class="tableitem">
                                                    <p class="itemtext">{{ $detail->product->name }}</p>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">{{ $detail->quantity }}</p>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">{{ $detail->product->price }}</p>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">{{ $detail->sub_total }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="tabletitle">
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <h4>Total Harga</h4>
                                            </td>
                                            <td>
                                                <h4>{{ $sale->total_price}}</h4>
                                            </td>
                                        </tr>
                                        <tr class="tabletitle">
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <h4>Total Bayar</h4>
                                            </td>
                                            <td>
                                                <h4>{{ $sale->total_pay}}</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="row">
                                <input type="hidden" name="sale_id" value="{{$sale->id}}">
                                <input type="hidden" name="customer_id" value="{{$sale->customer->id}}">
                                <div class="form-group">
                                    <label for="name" class="form-label">Nama Member (identitas)</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        required="" value="{{ $sale->customer ? $sale->customer->name : ''}}">
                                </div>
                                <div class="form-group">
                                    <label for="poin" class="form-label">Poin</label>
                                    <input type="text" name="poin" id="poin" value="{{ $sale->customer ? $sale->customer->poin : ''}}" disabled=""
                                        class="form-control">
                                </div>
                                <div class="form-check ms-4">
                                    <input class="form-check-input" type="checkbox" value="Ya" id="check2"
                                        {{ $isFirst ? 'disabled' : ''}} name="check_poin">
                                    <label class="form-check-label" for="check2">
                                        Gunakan poin
                                    </label>
                                    @if ($isFirst)
                                        <small class="text-danger">Poin tidak dapat digunakan pada pembelanjaan
                                            pertama.</small>
                                    @endif
                                </div>
                            </div>
                            <div class="row text-end">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit">Selanjutnya</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection