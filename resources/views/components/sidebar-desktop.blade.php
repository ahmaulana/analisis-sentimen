<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
    <div class="p-6">
        <a href="{{ route('performa') }}" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Analisis Sentimen</a>
    </div>
    <nav class="text-white text-base font-semibold pt-3">
        <a href="{{ route('performa') }}" class="flex items-center {{ (request()->routeIs('performa')) ? 'active-nav-link' : '' }} text-white py-4 pl-6 nav-item">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>

        <a href="{{ route('tweet') }}" class="{{ (request()->routeIs('tweet')) ? 'active-nav-link' : '' }} flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class="fab fa-twitter mr-3"></i>
            Tweet
        </a>

        <a href="{{ route('klasifikasi') }}" class="{{ (request()->routeIs('klasifikasi')) ? 'active-nav-link' : '' }} flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class="fas fa-cogs mr-3"></i>
            Klasifikasi
        </a>

    </nav>
</aside>