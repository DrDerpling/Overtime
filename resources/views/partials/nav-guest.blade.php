<nav class="nav">
    <div class="nav-wrapper">
        <a href="#" class="brand-logo center"><strong>Over</strong>time</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <form  action="{{ route('logout') }}" method="post">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <li><button class="btn-flat" type="submit">Logout</button></li>
            </form>
        </ul>
    </div>
</nav>
