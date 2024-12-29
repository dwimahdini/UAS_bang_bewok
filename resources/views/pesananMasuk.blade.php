@extends('layouts.sidebar')
@section('title', 'Pesanan Masuk')
@vite('resources/css/app.css')

@section('content')
<div class="p-1 md:p-1 font-inter">
    <h1 class="text-2xl font-bold mb-4">Pesanan Masuk</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg border border-gray-300">
            <thead style="background-color: #C3AB12;">
                <tr>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Pilih</th>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">No</th>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Nama Produk</th>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Jumlah</th>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Total Harga</th>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Tanggal</th>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjang as $item)
                    <tr class="hover:bg-gray-100 transition duration-300 ease-in-out">
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">
                            <input type="checkbox" name="order_ids[]" value="{{ $item->id }}">
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $item->produk->nama_produk }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $item->jumlah }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">Rp {{ number_format($item->produk->harga * $item->jumlah, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $item->updated_at->format('d F Y') }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">
                            <span class="{{ $item->status->id === 1 ? 'bg-blue-200 text-blue-800' : ($item->status->id === 2 ? 'bg-red-200 text-red-800' : 'bg-gray-200 text-gray-800') }} px-2 py-1 rounded">
                                    {{ $item->status->nama_status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Buttons below the table -->
    <div class="mt-4 flex justify-between space-x-4 w-full">
        <button class="bg-green-500 text-white px-4 py-2 rounded w-1/3" onclick="handleOrder('terima')">Terima Pesanan</button>
        <button class="bg-red-500 text-white px-4 py-2 rounded w-1/3" onclick="handleOrder('tolak')">Tolak Pesanan</button>
    </div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    async function handleOrder(action) {
        const orderIds = [...document.querySelectorAll('input[name="order_ids[]"]:checked')].map(input => input.value);

        if (orderIds.length === 0) {
            Swal.fire('Peringatan!', 'Silakan pilih setidaknya satu pesanan.', 'warning');
            return;
        }

        const actionMessages = {
            terima: { title: 'Terima Pesanan', confirmText: 'Ya, terima!' },
            tolak: { title: 'Tolak Pesanan', confirmText: 'Ya, tolak!' },
        };

        const { title, confirmText } = actionMessages[action];

        Swal.fire({
            title,
            text: `Apakah Anda yakin ingin ${title.toLowerCase()} yang dipilih?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: action === 'tolak' ? '#d33' : '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmText,
            cancelButtonText: 'Tidak, batalkan'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/pesananMasuk/${action === 'terima' ? 'terimaPesanan' : 'tolakPesanan'}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ order_ids: orderIds })
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('Error response:', errorText);
                        throw new Error('Server error');
                    }

                    const data = await response.json();
                    Swal.fire(title, data.message || 'Operasi berhasil.', 'success').then(() => {
                        location.reload();
                    });
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire('Gagal!', error.message || 'Terjadi kesalahan pada server.', 'error');
                }
            }
        });
    }
</script>
@endsection
