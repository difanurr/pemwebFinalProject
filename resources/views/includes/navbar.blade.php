<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">

</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <a class="navbar-brand" href="#">DATA TOKO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/barang">Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/customer">Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/transaksi">Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/detail">Detail Transaksi</a>
                </li>
            </ul>
            <ul class="navbar-nav justify-content-end ms-auto">
                <li class="nav-item">
                    <button id="logoutButton" class="btn btn-outline-danger btn-sm" type="button">Logout</button>
                </li>
            </ul>
        </div>
    </nav>

    <script>
        // Ambil URL saat ini
        var currentURL = window.location.href;

        // Ambil semua elemen navbar yang memiliki kelas "nav-link"
        var navLinks = document.querySelectorAll('.nav-link');

        // Loop melalui setiap elemen navbar
        for (var i = 0; i < navLinks.length; i++) {
            // Periksa jika URL elemen navbar saat ini sama dengan URL saat ini
            if (navLinks[i].href === currentURL) {
                // Tambahkan kelas "active" pada elemen navbar yang sesuai
                navLinks[i].classList.add('active');
            }
        }

        // Tambahkan event listener untuk tombol logout
        document.getElementById("logoutButton").addEventListener("click", function() {
            window.location.href = "{{ route('logout') }}";
        });
    </script>
</body>
</html>
