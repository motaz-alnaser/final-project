<!-- Navigation Header -->
<header class="header" id="header">
    <nav class="nav-container">
        <a href="#home" class="logo">
            <div class="logo-icon">
                <img src="{{ asset('images/downloadlogo-removebg-preview (1).png') }}" alt="PRISM FLUX Logo" class="logo-img">
            </div>
         
        </a>
        
        <ul class="nav-menu" id="navMenu">
            <li><a href="{{ route('home') }}" class="nav-link active">Home</a></li>           
            <li><a href="#about" class="nav-link">About</a></li>
            <li><a href="#stats" class="nav-link">Metrics</a></li>
            <li><a href="#contact" class="nav-link">Contact</a></li>
            <li><a href="{{ route('user.activities') }}" class="nav-link nav-link-special">Activities</a></li>
            
            <li>
                <div class="header-user">
                    @if(Auth::check())
                        <a href="{{ route('user.profile') }}" class="btn-profile">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <circle cx="9" cy="5" r="3" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M3 16C3 13.2386 5.68629 11 9 11C12.3137 11 15 13.2386 15 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-logout">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M7 16H4C3.44772 16 3 15.5523 3 15V3C3 2.44772 3.44772 2 4 2H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M11 13L15 9M15 9L11 5M15 9H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Log Out</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-login">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M11 2H14C14.5523 2 15 2.44772 15 3V15C15 15.5523 14.5523 16 14 16H11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M7 13L11 9M11 9L7 5M11 9H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Log In</span>
                        </a>
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

<script>
// Header scroll effect
window.addEventListener('scroll', () => {
    const header = document.getElementById('header');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Mobile menu toggle
const menuToggle = document.getElementById('menuToggle');
const navMenu = document.getElementById('navMenu');

menuToggle?.addEventListener('click', () => {
    menuToggle.classList.toggle('active');
    navMenu.classList.toggle('active');
});

// Close menu when clicking on a link
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        menuToggle.classList.remove('active');
        navMenu.classList.remove('active');
    });
});

// Active link on scroll
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-link');

window.addEventListener('scroll', () => {
    let current = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
});
</script>