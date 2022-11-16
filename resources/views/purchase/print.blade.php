<html>
<head>
<title>Faktur Pembayaran</title>
<style>
#tabel
{
font-size:15px;
border-collapse:collapse;
}
#tabel  td
{
padding-left:12px;
border: 1px solid black;
}
</style>
</head>
<body style='font-family:tahoma; font-size:12pt;'>
<center>
<table style='width:800px; font-size:12pt; font-family:calibri; border-collapse: collapse;' border = '0'>
@foreach($cabang as $cab)
<td width='70%' align='left' style='padding-right:80px; vertical-align:top'>
<span style='font-size:12pt'><b>{{$cab->nama_cabang}}</b></span></br>
{{$cab->alamat}}<br>
{{$cab->no_hp}}
</td>
@endforeach
<td style='vertical-align:top' width='30%' align='left'>
<b><span style='font-size:12pt'>FAKTUR PENJUALAN</span></b></br>
No Trans. : {{$no}}</br>
Tanggal :{{ \Carbon\Carbon::parse($tgl)->isoFormat('dddd, D MMMM Y')}}</br>
</td>
</table>
<table style='width:800px; font-size:12pt; font-family:calibri; border-collapse: collapse;' border = '0'>
<td width='70%' align='left' style='padding-right:80px; vertical-align:top'>
@foreach($user as $us)
Nama Customer : {{$us->nama}} {{$us->toko}}</br>
Alamat : {{$us->alamat}}
@endforeach
</td>
<td style='vertical-align:top' width='30%' align='left'>
No Telp : {{$us->no_hp}}
</td>
</table>
<table cellspacing='0' style='width:800px; font-size:12pt; font-family:calibri;  border-collapse: collapse;' border='1'>
 
<tr align='center'>
<td width='10%'>Kode Barang</td>
<td width='20%'>Nama Barang</td>
<td width='12%'>Harga</td>
<td width='6%'>Qty</td>
<td width='7%'>Discount</td>
<td width='12%'>Total Harga</td>
@foreach($tampil as $tam)
<tr>
<td>{{$tam->code_master}}</td>
<td>{{$tam->nama_barang}}</td>
<td>@currency($tam->jual)</td>
<td>{{$tam->jumlah}} {{$tam->nama_satuan}}</td>
<td>Rp0,00</td>
<td style='text-align:right'>@currency($tam->sub_jual)</td>

<tr>
    @endforeach
<td colspan = '5'><div style='text-align:right'>Total Yang Harus Di Bayar Adalah : </div></td>
<td style='text-align:right'>@currency($big_total)</td>
</tr>
<tr>
<td colspan = '6'><div style='text-align:right'>Jatuh Tempo : {{ \Carbon\Carbon::parse($tam->due_date)->isoFormat('dddd, D MMMM Y')}}</div></td>
</tr>
<tr>
<td colspan = '5'><div style='text-align:right'>Cash : </div></td>
<td style='text-align:right'>@currency($bayar)</td>
</tr>
<tr>
<td colspan = '5'><div style='text-align:right'>Kembalian : </div></td><td style='text-align:right'>@currency($bayar - $big_total)</td>
</tr>
<tr>
<td colspan = '5'><div style='text-align:right'>DP : </div></td>
<td style='text-align:right'>@currency($bayar)</td>
</tr>
<tr>
<td colspan = '5'><div style='text-align:right'>Sisa : </div></td>
<td style='text-align:right'>@currency($sisa)</td></tr>
</table>
 
<table style='width:900; font-size:12pt;' cellspacing='2'>
<tr>
<td align='center'>Diterima Oleh,</br></br><u>(............)</u></td>
<td style='border:1px solid black; padding:5px; text-align:left; width:30%'></td>
<td align='center'>TTD,</br></br><u>(...........)</u></td>
</tr>
</table>
</center>
</body>
</html>
<script>
    window.print();
</script>