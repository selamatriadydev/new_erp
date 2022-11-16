
<html>

<head>
	<title>Print</title>

</head>
<style>
	* {
		font-size: 12px;
		font-family: 'Merchant Copy Doublesize';
	}


	tr.border {
		border-top: 1px solid black;
		border-collapse: collapse;
	}

	td.description,
	th.description {
		text-align: center;
		width: 30px;
		max-width: 75px;
	}

	td.quantity,
	th.quantity {
		width: 74px;
		max-width: 74px;
		word-break: break-all;
	}

	td.price,
	th.price {
		width: 80px;
		max-width: 80px;
		word-break: break-all;
	}

	.centered {
		text-align: center;
		align-content: center;
	}

	.ticket {
		width: 200px;
		max-width: 200px;
	}

	img {
		max-width: inherit;
		width: inherit;
	}

	@media print {

		.hidden-print,
		.hidden-print * {
			display: none !important;
		}
	}
</style>

<body>

	<div class="ticket">

		<p class="centered">
			@foreach($namacabang as $n)
		<h1>{{$n->nama_cabang}}</h1>
		<h3>{{$n->no_hp}}</h3>
		@endforeach
		@foreach($nota as $not)

		<p>Invoice :{{$no_nota}}</p>
		<p>Tanggal : {{ \Carbon\Carbon::parse($not->tanggal_transaksi)->isoFormat('dddd, D MMMM Y')}}</p>
		<p>Kasir : {{Auth::user()->name}}</p>
		@endforeach
		=============================
		<table>
			<thead>
				<tr>
					<th class="quantity">Barang</th>
					<th class="description">Qty</th>
					<th class="description">Disc</th>
					<th class="price">Sub Total</th>
				</tr>
			</thead>
		</table>
		=============================
		<table>
			<tbody>
				@foreach($detail as $det)
				<tr class="border">
					<td class="quantity">{{$det->nama_item}}</td>
					<td class="description">{{$det->jumlah}}</td>
					@if($det->disc > "0")
					<td class="description">{{$det->disc}}%</td>
					@elseif($det->cut_sale > "0")
					<td class="description">{{$det->cut_sale}}</td>
					@else
					<td class="description"></td>
					@endif
					<td class="price">@currency($det->subtotal_up)</td>
				</tr>
				@endforeach
		</table>
		=============================
		<table>
			<tr>
				<td class="quantity">Big Total</td>
				<td class="description"></td>
				<td class="price">@currency($sumbig)</td>
			</tr>
			@foreach($nota as $notas)
			<tr>
				<td class="quantity">Bayar</td>
				<td class="description"></td>
				<td class="price">@currency($notas->bayar)</td>
			</tr>
			<tr>
				<td class="quantity">Kembalian</td>
				<td class="description"></td>
				<td class="price">@currency($notas->kembali)</td>
			</tr>
			@endforeach
			</tbody>
		</table>
		<p style="text-align:center; margin-top: 50px;"><strong>Terimakasih Telah Berbelanja!</strong> Barang yang sudah dibeli tidak dapat dikembalikan.</p>
		<p style="text-align:center;">Jangan lupa berkunjung kembali</p>
	</div>




	<script>
		window.print();
	</script>

</body>

</html>