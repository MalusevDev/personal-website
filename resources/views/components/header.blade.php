<header class="header">
    <nav class="nav">
        <div class="home">
            <a rel="me" href="{{ route('index') }}">dusanmalusev.dev</a>
        </div>
        <label id="menu-button" for="menu-controller">
            <input type="checkbox" id="menu-controller" class="hidden">
            <x-nav-sm-hamburger-menu-icon/>
            <div id="menu-wrapper">
                <ul>
                    <x-nav-sm-close/>
                    <x-nav-search-button/>
                    @foreach($links as $name => $route)
                        <x-nav-item :link="$route" :title="$name"/>
                    @endforeach
                </ul>
            </div>
        </label>

        <ul>
            @foreach($links as $name => $route)
                <x-nav-item :link="$route" :title="$name"/>
            @endforeach
            <x-nav-search-button/>
        </ul>
    </nav>
</header>
