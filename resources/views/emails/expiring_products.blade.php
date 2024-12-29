<!DOCTYPE html>
<html>
<head>
    <title>Produk Mendekati Kedaluarsa</title>
</head>
<body>
    <h1>Produk yang Mendekati Kedaluarsa</h1>
    <p>Berikut adalah daftar produk yang mendekati tanggal kedaluarsa:</p>
    <ul>
        @foreach ($products as $product)
            <li>{{ $product->nama_produk }} - Kedaluarsa pada: {{ $product->tanggal_kadaluarsa->format('d F Y') }}</li>
        @endforeach
    </ul>
</body>
</html>