<!DOCTYPE html>
<html>
<head>
    <title>Laporan Riwayat Pesanan</title>
    <style>
        /* Add your styles here */
        body {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Laporan Riwayat Pesanan</h1>
    <h3>Susu Coklat dan Roti Kukus Bang Bewok</h3>
    <h4>Tanggal dibuatnya laporan: {{ now()->translatedFormat('d F Y') }}</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
            
        <tbody>
            <br>
            @foreach($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->produk ? $item->produk->nama_produk : 'Produk tidak ditemukan' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->created_at->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->status->nama_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Total Produk: {{ $totalProduk }}</h3>
    <h3>Total Harga: Rp. {{ number_format($totalHarga, 0, '', '.') }}</h3>
</body>
</html>
