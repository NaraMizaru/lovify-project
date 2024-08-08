<link rel="stylesheet" href="{{asset('components/css/admin/sidebar.css')}}">

<nav class="sidebar">
    <div class="logo-menu">
        <h2 class="logo">Lovify</h2>
        <i class="fa-solid fa-bars toggle-btn"></i>
    </div>

    <ul class="list">
        <li class="list-item active">
            <a href="{{route('admin.home')}}" class="a-sidebar">
                <i class="fa-regular fa-grid-horizontal"></i>
                <span class="link-name" style="--i:1;">Dashboard</span>
            </a>
        </li>
        <li class="list-item">
            <a href="{{route('vendors.admin')}}" class="a-sidebar">
                <i class="fa-solid fa-list-check"></i>
                <span class="link-name" style="--i:2;">Kelola Vendor</span>
            </a>
        </li>
        <li class="list-item">
            <a href="{{route('weddings.admin')}}" class="a-sidebar">
                <i class="fa-solid fa-list-check"></i>
                <span class="link-name" style="--i:3;">Kelola Wedding</span>
            </a>
        </li>
        <li class="list-item">
            {{-- <a href="#" class="a-sidebar">
                <i class="fa-solid fa-list-check"></i>
                <span class="link-name" style="--i:4;">Kelola Paket</span>
            </a> --}}
        </li>
        <li class="list-item">
            {{-- <a href="#" class="a-sidebar">
                <i class="fa-solid fa-list-check"></i>
                <span class="link-name" style="--i:4;">Kelola Transaksi</span>
            </a> --}}
        </li>
    </ul>
</nav>
@push('js')
<script src="{{asset('components/js/admin/sidebar.js')}}"></script>
@endpush
