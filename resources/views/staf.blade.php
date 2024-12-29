@extends('layouts.sidebar')
@section('title', 'Staf')
@vite('resources/css/app.css')

@section('content')
<div class="p-1 md:p-1">
    <!-- Frame untuk Staf -->
    <div id="frameStaf" class="bg-white p-4 rounded-lg shadow-sm">
        <h1 class="text-2xl font-bold mb-4">Daftar Staf</h1>

        <div class="flex flex-col md:flex-row md:items-center gap-2 mb-4">
            <select id="sortCriteria" class="border border-gray-300 px-5 py-2 text-sm rounded-lg focus:outline-none transition duration-300" onchange="sortTable()">
                <option value="" disabled selected>Urutkan</option>
                <option value="nama">Nama</option>
                <option value="posisi">Posisi</option>
            </select>

            <input
                type="text"
                id="searchInput"
                onkeyup="searchTable()"
                placeholder="Cari Staf"
                class="flex-grow border border-gray-300 px-5 py-2 text-sm rounded-lg focus:outline-none transition duration-300">

            <button onclick="openAddStaffModal()" class="border border-gray-300 px-4 py-2 text-sm rounded-lg focus:outline-none transition duration-300" style="background-color: #5D5108; color: white;" onmouseover="this.style.backgroundColor='#C3AB12'" onmouseout="this.style.backgroundColor='#5D5108'">
                Tambah Staf
            </button>
        </div>

        <!-- Tabel Staf -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg border border-gray-300 table-auto w-full">
                <thead style="background-color: #C3AB12;">
                    <tr>
                        <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">No</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Nama</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Nomor Telepon</th>
                        <th class="px-6 py-4 text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Email</th>
                        <th class="px-6 py-4 text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Posisi</th>
                        <th class="px-6 py-4 text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Cabang</th>
                        <th class="px-6 py-4 text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="staffTable" class="bg-white divide-y divide-gray-200">
                    @foreach($staffs as $staff)
                    <tr class="hover:bg-gray-100 transition duration-300 ease-in-out">
                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-900 text-center border-r border-gray-300">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-900 border-r border-gray-300">{{ $staff->nama }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-900 text-center border-r border-gray-300">{{ $staff->notel }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-900 border-r border-gray-300">{{ $staff->email }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-900 text-center border-r border-gray-300">{{ $staff->posisi }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-900 text-center border-r border-gray-300">{{ $staff->cabang }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-900 text-center">
                            <button class="edit-button bg-yellow-400 text-white px-2 py-1 rounded-lg hover:bg-yellow-500 transition duration-300"
                                    onclick="openEditModal(this)"
                                    data-id="{{ $staff->id }}"
                                    data-nama="{{ $staff->nama }}"
                                    data-notel="{{ $staff->notel }}"
                                    data-email="{{ $staff->email }}"
                                    data-posisi="{{ $staff->posisi }}"
                                    data-cabang="{{ $staff->cabang }}">
                                Edit
                            </button>
                            <button type="button"
                                    class="bg-red-500 text-white px-2 py-1 rounded-lg hover:bg-red-600 transition duration-300"
                                    onclick="confirmDelete({{ $staff->id }})">
                                Hapus
                            </button>
                            <form id="deleteForm-{{ $staff->id }}" action="{{ route('staff.destroy', $staff->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Staff Modal -->
<div id="addStaffModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-lg font-semibold mb-4">Tambah Staf Baru</h2>
        <form action="{{ route('staff.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium mb-2">Nama</label>
                <input type="text" id="nama" name="nama" autocomplete="off" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none transition duration-300" required>
            </div>
            <div class="mb-4">
                <label for="notel" class="block text-sm font-medium mb-2">Nomor Telepon</label>
                <input type="text" id="notel" name="notel" autocomplete="off" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none transition duration-300" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-2">Email</label>
                <input type="email" id="email" name="email" autocomplete="off" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none transition duration-300" required>
            </div>
            <div class="mb-4">
                <label for="posisi" class="block text-sm font-medium mb-2">Posisi</label>
                <select id="posisi" name="posisi" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none transition duration-300" required>
                    <option value="staf">Staf</option>
                    <option value="kepala cabang">Kepala Cabang</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="cabang" class="block text-sm font-medium mb-2">Cabang</label>
                <select id="cabang" name="cabang" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none transition duration-300" required>
                    <option value="" disabled selected>Pilihan Cabang</option>
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeAddStaffModal()" class="bg-gray-500 text-white px-3 py-2 rounded-lg hover:bg-gray-600 transition duration-300 mr-2">Batal</button>
                <button type="submit" class="border border-gray-300 px-3 py-2 text-sm rounded-lg focus:outline-none transition duration-300" style="background-color: #5D5108; color: white;" onmouseover="this.style.backgroundColor='#C3AB12'" onmouseout="this.style.backgroundColor='#5D5108'">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Staff Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-xl font-semibold mb-4">Edit Staf</h2>
        <form id="editForm" action="#" method="POST" onsubmit="return handleEditSubmit(event)">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="editNama" class="block text-sm font-medium mb-2">Nama</label>
                <input type="text" id="editNama" name="nama" autocomplete="off" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none transition duration-300" required>
            </div>
            <div class="mb-4">
                <label for="editNotel" class="block text-sm font-medium mb-2">Nomor Telepon</label>
                <input type="text" id="editNotel" name="notel" autocomplete="off" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none transition duration-300" required>
            </div>
            <div class="mb-4">
                <label for="editEmail" class="block text-sm font-medium mb-2">Email</label>
                <input type="email" id="editEmail" name="email" autocomplete="off" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none transition duration-300" required>
            </div>
            <div class="mb-4">
                <label for="editPosisi" class="block text-sm font-medium mb-2">Posisi</label>
                <select id="editPosisi" name="posisi" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none transition duration-300" required>
                    <option value="staf">Staf</option>
                    <option value="kepala cabang">Kepala Cabang</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="editCabang" class="block text-sm font-medium mb-2">Cabang</label>
                <select id="editCabang" name="cabang" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none transition duration-300" required>
                    <option value="" disabled selected>Pilihan Cabang</option>
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeEditModal()" class="bg-red-500 text-white px-4 py-2 rounded-lg">Batal</button>
                <button type="submit" class="border border-gray-300 px-4 py-2 text-xs bg-blue-500 text-white rounded-lg focus:outline-none transition duration-300">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pastikan elemen yang ingin diakses ada
        const toggleSidebarButton = document.getElementById('toggleSidebarButton'); // Ganti dengan ID yang sesuai
        const sidebar = document.getElementById('sidebar'); // Ganti dengan ID yang sesuai
        const mainContent = document.getElementById('mainContent'); // Ganti dengan ID yang sesuai
        const logoText = document.getElementById('logoText'); // Ganti dengan ID yang sesuai
        const menuTexts = document.querySelectorAll('.menu-text'); // Ganti dengan selector yang sesuai

        if (toggleSidebarButton && sidebar && mainContent && logoText) {
            // Event listener untuk toggle sidebar
            toggleSidebarButton.addEventListener('click', () => {
                if (sidebar.classList.contains('w-64')) {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-20');
                    logoText.classList.add('hidden'); // Sembunyikan teks logo
                    menuTexts.forEach(text => text.classList.add('hidden')); // Sembunyikan teks menu
                    mainContent.classList.remove('ml-64');
                    mainContent.classList.add('ml-20'); // Sesuaikan margin untuk konten utama
                } else {
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');
                    logoText.classList.remove('hidden'); // Tampilkan teks logo
                    menuTexts.forEach(text => text.classList.remove('hidden')); // Tampilkan teks menu
                    mainContent.classList.remove('ml-20');
                    mainContent.classList.add('ml-64'); // Sesuaikan margin untuk konten utama
                }
            });
        } else {
            console.error("Element not found: toggleSidebarButton, sidebar, mainContent, or logoText");
        }

        // Pastikan elemen notifikasi ada
        const notification = document.getElementById('notification-content');
        const notificationButton = document.getElementById('notification-button');
        const closeButton = document.getElementById('close-notification');

        if (notification) {
            // Menampilkan notifikasi otomatis setelah halaman dimuat jika ada produk mendekati kadaluarsa
            notification.classList.remove('hidden'); // Menampilkan notifikasi
            // Menutup notifikasi setelah 5 detik
            setTimeout(function() {
                notification.classList.add('hidden'); // Menyembunyikan notifikasi setelah 5 detik
            }, 2000);
        }

        // Fungsi untuk menampilkan atau menyembunyikan notifikasi saat tombol bel diklik
        if (notificationButton) {
            notificationButton.addEventListener('click', function() {
                notification.classList.toggle('hidden'); // Menyembunyikan atau menampilkan notifikasi saat tombol bel diklik
            });
        }

        // Function to open the add staff modal
        window.openAddStaffModal = function() {
            document.getElementById("addStaffModal").classList.remove("hidden");
        };

        // Function to open the edit modal
        window.openEditModal = function(button) {
            const id = button.getAttribute('data-id');
            const form = document.getElementById('editForm');
            form.action = `/staff/${id}`;

            document.getElementById('editNama').value = button.getAttribute('data-nama');
            document.getElementById('editNotel').value = button.getAttribute('data-notel');
            document.getElementById('editEmail').value = button.getAttribute('data-email');
            document.getElementById('editPosisi').value = button.getAttribute('data-posisi');
            document.getElementById('editCabang').value = button.getAttribute('data-cabang');

            document.getElementById("editModal").classList.remove("hidden");
        };

        // Function to close the add staff modal
        window.closeAddStaffModal = function() {
            document.getElementById("addStaffModal").classList.add("hidden");
        };

        // Function to close the edit modal
        window.closeEditModal = function() {
            document.getElementById("editModal").classList.add("hidden");
        };

        // Function to confirm deletion
        window.confirmDelete = function(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus staf ini?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deleteForm-${id}`).submit();
                }
            });
        };

        // Sorting and searching functions
        function sortTable() {
            const table = document.getElementById("staffTable");
            const rows = Array.from(table.rows);
            const criteria = document.getElementById("sortCriteria").value;

            if (!criteria) return;

            rows.sort((a, b) => {
                let valueA, valueB;

                switch (criteria) {
                    case 'nama':
                        valueA = a.cells[1].innerText.toLowerCase();
                        valueB = b.cells[1].innerText.toLowerCase();
                        return valueA.localeCompare(valueB);
                    case 'posisi':
                        valueA = a.cells[4].innerText.toLowerCase();
                        valueB = b.cells[4].innerText.toLowerCase();
                        const positionOrder = ['kepala cabang', 'staf'];
                        return positionOrder.indexOf(valueA) - positionOrder.indexOf(valueB);
                    default:
                        return 0;
                }
            });

            // Re-append sorted rows and update numbering
            rows.forEach((row, index) => {
                table.appendChild(row);
                row.cells[0].innerText = index + 1; // Update the numbering
            });
        }

        function searchTable() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = document.querySelectorAll("#staffTable tr");
            rows.forEach(row => {
                const name = row.cells[1]?.innerText.toLowerCase() || '';
                row.style.display = name.includes(input) ? '' : 'none';
            });
        }

        // Function to handle the edit form submission
        window.handleEditSubmit = function(event) {
            event.preventDefault(); // Prevent default form submission
            const form = event.target; // Get the form that triggered the event
            console.log("Form submitted for editing staff with ID:", form.action.split('/').pop()); // Log ID

            // Debugging: Log form data
            const formData = new FormData(form);
            for (const [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            form.submit(); // Submit the form normally
        };

        @if (session('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
        @endif
    });
</script>
@endsection