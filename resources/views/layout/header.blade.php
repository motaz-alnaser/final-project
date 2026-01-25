<!-- Navigation Header -->
<header class="header" id="header">
    <nav class="nav-container">
        <a href="#home" class="logo">
            <div class="logo-icon">
                <div class="logo-prism">
                    <div class="prism-shape"></div>
                </div>
            </div>
            <span class="logo-text">
                <span class="prism">PRISM</span>
                <span class="flux">FLUX</span>
            </span>
        </a>
        
        <ul class="nav-menu" id="navMenu">
            <li><a href="#home" class="nav-link active">Home</a></li>
            <li><a href="#about" class="nav-link">About</a></li>
            <li><a href="#stats" class="nav-link">Metrics</a></li>
            <li><a href="#skills" class="nav-link">Arsenal</a></li>
            <li><a href="#contact" class="nav-link">Contact</a></li>
            <li><a href="activities" style="color: var(--accent-cyan); text-decoration: none;">Activities</a></li>
            
           
            <li>
                <div class="header-user">
                    @if(Auth::check())
                      
                       
                        <a href="{{ route('user.profile') }}" class="btn-profile">{{ Auth::user()->name }}</a>

                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-logout">Log Out</button>
                        </form>
                    @else
                        
                        <a href="{{ route('login') }}" class="btn-login">Log In</a>
                    @endif
                </div>
            </li>
        </ul>
        
        <div class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
</header>