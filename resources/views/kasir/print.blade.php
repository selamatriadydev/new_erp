
<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice</title>
		<link rel="stylesheet" href="style.css">
		<link rel="license" href="https://www.opensource.org/licenses/mit-license/">
		<script src="script.js"></script>
        <style> /* reset */

            *
            {
                border: 0;
                box-sizing: content-box;
                color: inherit;
                font-family: inherit;
                font-size: 14px;
                font-style: inherit;
                font-weight: inherit;
                line-height: inherit;
                list-style: none;
                margin: 0;
                padding: 0;
                text-decoration: none;
                vertical-align: top;
            }
            
            /* content editable */
            
            *[contenteditable] { border-radius: 0.25em; min-width: 1em; max-width: 400px; outline: 0; }
            
            *[contenteditable] { cursor: pointer; }
            
            *[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable], td:focus *[contenteditable], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }
            
            span[contenteditable] { display: inline-block; }
            
            /* heading */
            
            h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }
            
            /* table */
            
            table { font-size: 75%; table-layout: fixed; width: 100%; }
            table { border-collapse: separate; border-spacing: 2px; }
            th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
            th, td { border-radius: 0.25em; border-style: solid; }
            th { background: #EEE; border-color: #BBB; }
            td { border-color: #DDD; }
            
            /* page */
            
            html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
            html { background: #999; cursor: default; }
            
            body { box-sizing: border-box; height: 6in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
            body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }
            
            /* header */
            
            header { margin: 0 0 3em; }
            header:after { clear: both; content: ""; display: table; }
            
            /*header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; margin-top: -20px; padding: 0.5em 0; }*/
            header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
            header address p { margin: 0 0 0.25em; }
            header span, header img { display: block; float: right; }
            header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
            header img { max-height: 100%; max-width: 100%; }
            header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }
            
            /* article */
            
            article, article address, table.meta, table.inventory { margin: 0 0 3em; }
            article:after { clear: both; content: ""; display: table; }
            article h1 { clip: rect(0 0 0 0); position: absolute; }
            
            article address { float: left; font-size: 125%; font-weight: bold; }
            
            /* table meta & balance */
            
            table.meta { float: right; width: 40%; margin-top: -180px}
            table.meta:after, table.balance:after { clear: both; content: ""; display: table; }
            table.balance { float: right; width: 40%; margin-top: -30px}
            
            /* table meta */
            
            table.meta th { width: 50%; }
            table.meta td { width: 50%; }
            
            /* table items */
            
            table.inventory { clear: both; width: 100%;  margin-left:  -20px; }
            table.inventory th { font-weight: bold; text-align: center;}
            
            table.inventory td:nth-child(1) { width: 26%; }
            table.inventory td:nth-child(2) { width: 38%; }
            table.inventory td:nth-child(3) { text-align: right; width: 12%; }
            table.inventory td:nth-child(4) { text-align: right; width: 12%; }
            table.inventory td:nth-child(5) { text-align: right; width: 12%; }
            
            /* table balance */
            
            table.balance th, table.balance td { width: 50%;  }
            table.balance td { text-align: right;  }
            
            /* aside */
            
            aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
            aside h1 { border-color: #999; border-bottom-style: solid; }
            
            /* javascript */
            
            .add, .cut
            {
                border-width: 1px;
                display: block;
                font-size: .10rem;
                padding: 0.25em 0.5em;	
                float: left;
                text-align: center;
                width: 0.6em;
            }
            
            .add, .cut
            {
                background: #9AF;
                box-shadow: 0 1px 2px rgba(0,0,0,0.2);
                background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
                background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
                border-radius: 0.5em;
                border-color: #0076A3;
                color: #FFF;
                cursor: pointer;
                font-weight: bold;
                text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
            }
            
            .add { margin: -2.5em 0 0; }
            
            .add:hover { background: #00ADEE; }
            
            .cut { opacity: 0; position: absolute; top: 0; left: -1.5em; }
            .cut { -webkit-transition: opacity 100ms ease-in; }
            
            tr:hover .cut { opacity: 1; }
            
            @media print {
                * { -webkit-print-color-adjust: exact; }
                html { background: none; padding: 0; }
                body { box-shadow: none; margin: 0; }
                span:empty { display: none; }
                .add, .cut { display: none; }
            }
            
            @page { margin: 0; }
            </style>
	</head>
	<body>
		<header>
			<h1>INVOICE</h1>
			<address contenteditable class="alamat">
            @foreach($nota as $not)
				<p>To :</p>
                <h3><b>{{$not->nama_cust}}</b> ({{$not->jenis_cust}}-{{$not->jenis_order}})</h3>
                <p><b> {{$not->no_telp}}</b></p>
				<p>{{$not->kel}},{{$not->kec}},{{$not->kota}}</p>
                <p>{{$not->jalan}}</p>
                <p>{{$not->patokan}}</p>
			</address>
			<!-- <span><img alt="" src="http://www.jonathantneal.com/examples/invoice/logo.png"><input type="file" accept="image/*"></span> -->
		</header>
			<!-- <address contenteditable>
			</address> -->
			<table class="meta">
				<tr>
					<th><span contenteditable>No Order #</span></th>
                   
					<td style="width: 150px"><span contenteditable>{{$not->no_invoice}}</span></td>
				</tr>
               
				<tr>
					<th><span contenteditable>Tanggal Kirim</span></th>
					<td style="width: 150px"><span contenteditable>{{ \Carbon\Carbon::parse($not->tanggal_kirim)->isoFormat('dddd, D MMMM Y')}}</span></td>
				</tr>
                <tr>
					<th><span contenteditable>Jam Kirim</span></th>
					<td style="width: 150px"><span contenteditable>{{ \Carbon\Carbon::parse($not->jam_kirim)->format('H:i')}}</span></td>
				</tr>
				<!--<tr>-->
				<!--	<th><span contenteditable>Big Total</span></th>-->
				<!--	<td><span id="prefix" contenteditable>@currency($not->bigtotal)</span></td>-->
				<!--</tr>-->
                <tr>
					<th><span contenteditable>Terbayar</span></th>
					<td style="width: 150px"><span data-prefix>@currency($not->bayar)</span></td>
				</tr>
			</table>
        <article >
			<table class="inventory" style="margin-right:  100px" >
				<thead>
					<tr>
						<th style="width: 300px"><span contenteditable>Item</span></th>
						<!-- <th><span contenteditable>Description</span></th>
						<th><span contenteditable>Status</span></th> -->
						<th style="width: 80px"><span contenteditable>Harga</span></th>
						<th style="width: 60px"><span contenteditable>Jumlah</span></th>
						<th style="width: 60px"><span contenteditable>Disc</span></th>
						<th style="width: 60px"><span contenteditable>Potongan</span></th>
						<th style="width: 100px"><span contenteditable>Total</span></th>
					</tr>
				</thead>
				<tbody>
                    @foreach($detail as $det)
					<tr>
						<td><span contenteditable>{{$det->nama_paket}}</span></td>
					
						<td><span contenteditable>@currency($det->harga)</span></td>
						<td><span contenteditable>{{$det->qty}} </span></td>
						<td><span contenteditable>{{$det->disc}}%</span></td>
						<td><span contenteditable>@currency($det->cutsale) </span></td>
						<td><span>@currency($det->subtotal)</span></td>
					</tr>
                    @endforeach
				</tbody>
			</table>
            <p style="max-width: 400px; margin-top: -20px; font-size: 12px;">
                *NOTE : Maksimal Konsumsi 3 Hari Setelah Pengiriman <br>
                {{ \Carbon\Carbon::parse($not->tanggal_kirim)->isoFormat('dddd, D MMMM Y')}}
                <br>
                  @foreach($namacabang as $cabang)
                 <p style="font-size: 12px; margin-top: 10px;"> {{$cabang->nama_cabang}} {{$cabang->no_hp}}</p>
                @endforeach
                 <br>
                <p style="font-size: 12px; margin-top: 10px;">support system by Hi-Code</p> 
            </p>
			<!-- <a class="add">+</a> -->
			<table class="balance" style="margin-top: -50px;">
			
                <tr>
					<th><span contenteditable>Big total</span></th>
					<td><span data-prefix>@currency($not->bigtotal)</span></td>
				</tr>
				
				<tr>
					<th><span contenteditable>Sisa</span></th>
					<td><span data-prefix>@currency($not->sisa)</span></td>
				</tr>
					<tr>
					<th><span contenteditable>Keterangan</span></th>
					<td><span data-prefix>{{$not->keterangan}}</span></td>
				</tr>
				@if($not->bayar == $not->bigtotal)
				<tr>
					<th><span contenteditable>Status</span></th>
					<td><span data-prefix>Lunas</span></td>
				</tr>
                @elseif($not->sisa == 0)
                <tr>
					<th><span contenteditable>Status</span></th>
					<td><span data-prefix>Belum Bayar</span></td>
				</tr>
				 @elseif($not->bayar <  $not->bigtotal)
                <tr>
					<th><span contenteditable>Status</span></th>
					<td><span data-prefix>Belum Lunas</span></td>
				</tr>
                @else
                <tr>
					<th><span contenteditable>Status</span></th>
					<td><span data-prefix>Lunas</span></td>
				</tr>
                @endif
			</table>
		</article>
		<aside>
			
            @endforeach
		</aside>
	</body>
</html>
<script>
    window.print();
</script>
