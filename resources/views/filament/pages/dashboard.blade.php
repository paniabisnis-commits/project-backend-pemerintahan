<x-filament::page>
    <div class="admin-dashboard">

        <!-- SAPAAN -->
        <h1 class="admin-title">
            Selamat Datang, {{ auth()->user()->name }} 👋
        </h1>

        <!-- JAM REALTIME -->
        <div class="admin-clock-wrapper">
            <div id="realtime-day" class="admin-day">-</div>
            <div id="realtime-clock" class="admin-clock">--:--:--</div>
            <div id="realtime-date" class="admin-date">-</div>
        </div>

        <!-- DESKRIPSI -->
        <p class="admin-desc">
            Halaman dashboard ini merupakan pusat pengelolaan sistem informasi
            website desa. Administrator dapat mengatur konten berita, event,
            layanan publik, serta memantau aktivitas data yang masuk melalui
            sistem backend.
        </p> br

        <!-- CATATAN -->
        <div class="admin-note">
            <strong>Catatan Admin</strong>
            <ul>
                <li>Gunakan menu sidebar untuk mengelola data</li>
                <li>Pastikan data yang dipublikasikan sudah valid</li>
                <li>Periksa pengaduan masyarakat secara berkala</li>
            </ul>
        </div>

    </div>

    <!-- SCRIPT JAM -->
    <script>
        function updateClock() {
            const now = new Date();

            const time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            const day = now.toLocaleDateString('id-ID', {
                weekday: 'long'
            });

            const date = now.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            document.getElementById('realtime-clock').innerText = time;
            document.getElementById('realtime-day').innerText = day;
            document.getElementById('realtime-date').innerText = date;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
</x-filament::page>
