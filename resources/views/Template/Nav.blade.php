<nav>
    <div class="logo">
        <h2>Lovify</h2>
    </div>
    <div class="content">
        <a href="{{ route('landingPage') }}">Home</a>
        <hr color="white">
        <a href="{{ route('packets') }}">Packets</a>
        <hr color="white">
        <a href="{{ route('vendors') }}">Vendors</a>
    </div>
    @auth
        <div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    @else
        <div class="account">
            <a href="{{ route('login') }}">Login</a>
            <hr color="white">
            <a href="{{ route('register') }}">Register</a>
        </div>
    @endauth
</nav>
