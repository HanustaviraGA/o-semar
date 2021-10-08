<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    {{-- JS --}}
    <script src="{{ asset('/js/app.js') }}"></script>
    {{-- Font Awesome --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js" integrity="sha512-YSdqvJoZr83hj76AIVdOcvLWYMWzy6sJyIMic2aQz5kh2bPTd9dzY3NtdeEAzPp/PhgZqr4aJObB3ym/vsItMg==" crossorigin="anonymous"></script>
</head>

<body class="flex">
    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="logo">
            <h1 class="text-2xl">O-Semar</h1>
        </div>
        <nav class="sidebar-menu">
            <a href="" class="sidebar-link sidebar-active">
                <p>Dashboard</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="" class="sidebar-link">
                <p>Somewhere</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="" class="sidebar-link">
                <p>Somewhere</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="" class="sidebar-link">
                <p>Somewhere</p>
                <i class="fas fa-chevron-right"></i>
            </a>
        </nav>
    </aside>
    {{-- End of Sidebar --}}
    {{-- Dashboard Content --}}
    <main class="dashboard-content">
        {{-- Panel Navbar --}}
        <header class="panel-navbar">
            <div class="toogle-sidebar">
                <i class="fas fa-bars"></i>
            </div>
            <div class="panel-nav flex">
                <div class="menus mx-2 flex justify-center items-center">
                    <div class="search">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="bell">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="mail">
                        <i class="far fa-envelope"></i>
                    </div>
                    <div class="tasks">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
                <div class="divider-vertical mx-2 border-r"></div>
                <div class="profile">
                    <div class="avatar">
                        <i class="fas fa-user-alt"></i>
                    </div>
                </div>
            </div>
        </header>
        {{-- End of Panel Navbar --}}
        {{-- Dashboard Panel --}}
        <main class="dashboard-panel">
            <section class="info-counting">
                <div class="info">
                    <div class="count bg-blue-400">
                        <p>48</p>
                    </div>
                    <p>Daftar Pengajuan</p>
                </div>
                <div class="info">
                    <div class="count bg-orange-400">
                        <p>14</p>
                    </div>
                    <p>Daftar Pelaporan</p>
                </div>
                <div class="info">
                    <div class="count bg-teal-400">
                        <p>99+</p>
                    </div>
                    <p>Daftar Warga</p>
                </div>
            </section>
        </main>
        {{-- End of Dashboard Panel --}}
    </main>
    {{-- End of Dashboard Content --}}
</body>

</html>
