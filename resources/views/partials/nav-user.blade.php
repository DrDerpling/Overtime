<nav class="nav nav-with-sidebar">
    <div class="nav-wrapper">
        <a href="#" class="brand-logo"><strong>Over</strong>time</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="sass.html">Hour overview</a></li>
            <li><a href="badges.html">Use overtime</a></li>
            <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </ul>
    </div>
</nav>

<ul id="slide-out" class="sidenav sidenav-fixed">
    <li>
        <div class="user-view">
            <div class="background">
                <img src="{{ asset('storage/images/lava-boy-1.png') }}">
            </div>
            <a><img class="circle" src="{{ asset('storage/images/logo.png') }}"></a>
            <a><span class="white-text company">{{ $user->company->name }}</span></a>
            <a><span class="white-text name">{{ $user->fullName }}</span></a>
            <a><span class="white-text email">{{ $user->email }}</span></a>
        </div>
    </li>
    <li><a href="{{ route('user.create') }}">Registration employee</a></li>
</ul>