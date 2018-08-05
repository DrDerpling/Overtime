<nav class="nav nav-with-sidebar">
    <div class="nav-wrapper">
        <a href="#" class="brand-logo center"><strong>Over</strong>time</a>
        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <form action="{{ route('logout') }}" method="post">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <li><button class="btn-flat" type="submit">Logout</button></li>
            </form>
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
    @if($user->isManager())
        <li><a href="{{ route('home') }}">Dashboard</a></li>
        <li><a href="{{ route('user.create') }}">Register employee</a></li>
        <li><a href="{{ route('user.index') }}">Employee overview</a></li>
    @endif


</ul>