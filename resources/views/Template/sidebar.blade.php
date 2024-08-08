
    <div class="navigation">
        <ul>
            <li>
                <a href="{{ route('landingPage') }}">
                    <img src="{{asset('components/assets/L.png')}}" alt="" class="icon">
                    <span class="title">Lovify</span>
                </a>
            </li>
<hr style="margin-right: 10px; margin-bottom:10px;" color="white">
            <li>
                <a href="{{ route('client.home') }}">
                    <span class="icon"><i class="fa-solid fa-house"></i></span>
                    <span class="title">Dashboard</span>
                </a>
            </li>

        <li>
            <a href="{{ route('client.profile') }}">
                <span class="icon"><i class="fa-solid fa-user"></i></span>
                <span class="title">Profile</span>
            </a>
        </li>

            <li>
                <a href="{{ route('client.weddings') }}">
                    <span class="icon"><i class="fa-duotone fa-solid fa-rings-wedding"></i></span>
                    <span class="title">Weddings</span>
                </a>
            </li>

            <li>
                <a href="{{ route('client.transactions') }}">
                    <span class="icon"><i class="fa-solid fa-money-from-bracket"></i></span>
                    <span class="title">Transaction</span>
                </a>
            </li>

            <li>
                <a href="{{ route('client.history') }}">
                    <span class="icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                    <span class="title">History</span>
                </a>
            </li>

        <li>
            <a href="#">
                <span class="icon"><i class="fa-solid fa-circle-info"></i></span>
                <span class="title">Help</span>
            </a>
        </li>
    </ul>
    <div class="toggle"></div>
</div>
