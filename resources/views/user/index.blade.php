@extends('layout.master')

@section('title', 'PRISM FLUX - Where Ideas Refract Into Reality')

@section('content')
</head>
<body>
    <!-- Loading Screen -->
    <div class="loader" id="loader">
        <div class="loader-content">
            <div class="loader-prism">
                <div class="prism-face"></div>
                <div class="prism-face"></div>
                <div class="prism-face"></div>
            </div>
            <div class="loader-text">Refracting Reality...</div>
        </div>
    </div>

    <!-- Hero Section with Enhanced 3D Carousel -->
    <section class="hero" id="home">
        <div class="hero-background">
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
                <div class="shape shape-4"></div>
            </div>
        </div>
        
        <div class="carousel-container">
            <div class="carousel" id="carousel">
                @forelse($activities as $activity)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-index="{{ $loop->index }}">
                        <div class="card">
                            <div class="card-shine"></div>
                            <div class="card-glow"></div>
                            <div class="card-number">{{ str_pad($activity->id, 2, '0', STR_PAD_LEFT) }}</div>
                            
                            <div class="card-image">
                                <div class="image-overlay"></div>
                                <div class="image-corner"></div>
                                <img src="{{ $activity->primaryImage ? asset('storage/' . $activity->primaryImage->image_url) : asset('images/default-activity.jpg') }}" 
                                     alt="{{ $activity->title }}">
                            </div>
                            
                            <div class="card-content">
                                <h3 class="card-title">{{ $activity->title }}</h3>
                                <p class="card-description">{{ Str::limit($activity->description, 100) }}</p>
                                
                                <div class="activity-meta">
                                    <div class="meta-item price-tag">
                                        <span class="meta-icon">💰</span>
                                        <span class="meta-text">{{ number_format($activity->price, 2) }} JOD</span>
                                    </div>
                                    <div class="meta-item host-tag">
                                        <span class="meta-icon">👤</span>
                                        <span class="meta-text">{{ $activity->host->name ?? 'Unknown Host' }}</span>
                                    </div>
                                    <div class="meta-item category-tag">
                                        <span class="meta-icon">🎯</span>
                                        <span class="meta-text">{{ $activity->category->name ?? 'Uncategorized' }}</span>
                                    </div>
                                </div>
                                
                                <button class="card-cta" onclick="window.location.href='{{ route('user.activity_details', $activity->id) }}'">
                                    <span class="btn-text">Explore Now</span>
                                    <span class="btn-arrow">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M7 15L13 10L7 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="carousel-item active" data-index="0">
                        <div class="card">
                            <div class="card-shine"></div>
                            <div class="card-glow"></div>
                            <div class="card-number">00</div>
                            
                            <div class="card-image">
                                <div class="image-overlay"></div>
                                <img src="{{ asset('images/default-activity.jpg') }}" alt="No Activities">
                            </div>
                            
                            <div class="card-content">
                                <h3 class="card-title">No Activities Available</h3>
                                <p class="card-description">Check back later for exciting activities!</p>
                                
                                <button class="card-cta" onclick="scrollToSection('about')">
                                    <span class="btn-text">Discover More</span>
                                    <span class="btn-arrow">→</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <div class="carousel-controls">
                <button class="carousel-btn prev-btn" id="prevBtn" aria-label="Previous">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="carousel-btn next-btn" id="nextBtn" aria-label="Next">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <div class="carousel-indicators" id="indicators">
                @foreach($activities as $index => $activity)
                    <span class="indicator {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                        <span class="indicator-fill"></span>
                    </span>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Philosophy Section -->
    <section class="philosophy-section" id="about">
        <div class="philosophy-container">
            <div class="section-decoration">
                <div class="deco-line"></div>
                <div class="deco-circle"></div>
            </div>
            
            <h2 class="philosophy-headline">
                <span class="headline-top">Refracting Ideas</span>
                <span class="headline-bottom">Into Reality</span>
            </h2>
            
            <p class="philosophy-subheading">
                At PRISM FLUX, we turn your passions into experiences. Whether you're climbing mountains, painting canvases, 
                or dancing under the stars — we help you find, create, and share unforgettable moments with others who feel the same.
            </p>
            
            <div class="philosophy-pillars">
                <div class="pillar pillar-discover">
                    <div class="pillar-badge">01</div>
                    <div class="pillar-icon-wrapper">
                        <div class="pillar-icon">💎</div>
                    </div>
                    <h3 class="pillar-title">Discover</h3>
                    <p class="pillar-description">
                        Find activities that match your vibe — from sunrise yoga to desert hikes, art jams to urban adventures. 
                        No matter what sparks joy in you, there's a community waiting to join you.
                    </p>
                    <div class="pillar-corner"></div>
                </div>
                
                <div class="pillar pillar-create">
                    <div class="pillar-badge">02</div>
                    <div class="pillar-icon-wrapper">
                        <div class="pillar-icon">🔬</div>
                    </div>
                    <h3 class="pillar-title">Create</h3>
                    <p class="pillar-description">
                        Got an idea? Turn it into a real event. Host your own workshop, tour, or hangout — and let others discover 
                        the magic you've created. Your passion is the spark. We'll help you build the fire.
                    </p>
                    <div class="pillar-corner"></div>
                </div>
                
                <div class="pillar pillar-connect">
                    <div class="pillar-badge">03</div>
                    <div class="pillar-icon-wrapper">
                        <div class="pillar-icon">∞</div>
                    </div>
                    <h3 class="pillar-title">Connect</h3>
                    <p class="pillar-description">
                        Meet people who speak your language — not just words, but energy, rhythm, and curiosity. 
                        Build friendships through shared experiences, not just likes or DMs. Real moments. Real connections.
                    </p>
                    <div class="pillar-corner"></div>
                </div>
            </div>
            
            <div class="philosophy-particles" id="particles"></div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section" id="stats">
        <div class="section-header">
            <div class="header-decoration">
                <span class="deco-dot"></span>
                <span class="deco-line-horizontal"></span>
                <span class="deco-dot"></span>
            </div>
            <h2 class="section-title">Live Metrics — Where Communities Grow</h2>
            <p class="section-subtitle">
                Real-time impact and community energy, powered by shared experiences and unforgettable moments
            </p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card stat-card-1">
                <div class="stat-decoration"></div>
                <div class="stat-icon">🚀</div>
                <div class="stat-number" data-target="150">0</div>
                <div class="stat-label">Activities Hosted</div>
                <p class="stat-description">
                    From yoga at sunrise to desert campfires — we've helped creators launch over 150 unique experiences 
                    across the region. Every one is a story waiting to happen.
                </p>
            </div>
            
            <div class="stat-card stat-card-2">
                <div class="stat-decoration"></div>
                <div class="stat-icon">⚡</div>
                <div class="stat-number" data-target="99">0</div>
                <div class="stat-label">Satisfaction Rate</div>
                <p class="stat-description">
                    We don't just measure attendance — we measure joy. 99% of participants say they'd come back 
                    or bring a friend. That's what real connection looks like.
                </p>
            </div>
            
            <div class="stat-card stat-card-3">
                <div class="stat-decoration"></div>
                <div class="stat-icon">🏆</div>
                <div class="stat-number" data-target="25">0</div>
                <div class="stat-label">Community Leaders</div>
                <p class="stat-description">
                    Not just hosts — community builders. Over 25 passionate creators are turning their hobbies 
                    into shared adventures, inspiring others to join in.
                </p>
            </div>
            
            <div class="stat-card stat-card-4">
                <div class="stat-decoration"></div>
                <div class="stat-icon">💎</div>
                <div class="stat-number" data-target="500">0</div>
                <div class="stat-label">Daily Active Members</div>
                <p class="stat-description">
                    Every day, 500+ young people log in, discover new activities, book spots, and connect with others 
                    who share their vibe. The energy never sleeps.
                </p>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="skills-section" id="skills">
        <div class="skills-container">
            <div class="section-header">
                <div class="header-decoration">
                    <span class="deco-square"></span>
                </div>
                <h2 class="section-title">Your Activity Toolkit</h2>
                <p class="section-subtitle">
                    Everything you need to create, manage, and grow your activity — from booking tools to promotion kits. 
                    We handle the tech, you bring the energy.
                </p>
            </div>
            
            <div class="skill-categories">
                <div class="category-tab active" data-category="all">All Tools</div>
                <div class="category-tab" data-category="frontend">Experience Design</div>
                <div class="category-tab" data-category="backend">Growth & Promotion</div>
                <div class="category-tab" data-category="cloud">Booking & Payments</div>
                <div class="category-tab" data-category="emerging">Hosting Tools</div>
            </div>

            <div class="skills-hexagon-grid" id="skillsGrid">
                <!-- Skills will be generated by JavaScript -->
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="section-header">
            <h2 class="section-title">Initialize Connection</h2>
            <p class="section-subtitle">Ready to transform your vision into reality? Let's connect.</p>
        </div>
        
        <div class="contact-container">
            <div class="contact-info">
                <a href="https://maps.google.com/?q=Amman+Jordan" target="_blank" class="info-item">
                    <div class="info-icon">📍</div>
                    <div class="info-text">
                        <h4>Location</h4>
                        <p>Amman, Jordan</p>
                    </div>
                    <div class="info-arrow">→</div>
                </a>
                
                <a href="mailto:hello@prismflux.io" class="info-item">
                    <div class="info-icon">📧</div>
                    <div class="info-text">
                        <h4>Email</h4>
                        <p>hello@prismflux.io</p>
                    </div>
                    <div class="info-arrow">→</div>
                </a>
                
                <a href="tel:+962798628264" class="info-item">
                    <div class="info-icon">📱</div>
                    <div class="info-text">
                        <h4>Phone</h4>
                        <p>+962 798 628 264</p>
                    </div>
                    <div class="info-arrow">→</div>
                </a>
            </div>
            
            <form class="contact-form" id="contactForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                        <span class="input-border"></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                        <span class="input-border"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                    <span class="input-border"></span>
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required></textarea>
                    <span class="input-border"></span>
                </div>
                
                <button type="submit" class="submit-btn">
                    <span class="btn-bg"></span>
                    <span class="btn-text">Transmit Message</span>
                    <span class="btn-icon">✉</span>
                </button>
            </form>
        </div>
    </section>

<script src="{{ asset('js/templatemo-prism-scripts.js') }}"></script>
<script>
    // Loader functionality
    window.addEventListener('load', () => {
        setTimeout(() => {
            const loader = document.getElementById('loader');
            loader.classList.add('hidden');
        }, 1000);
    });

    // Animated counter for stats
    function animateCounter(element) {
        const target = parseInt(element.dataset.target);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const counter = setInterval(() => {
            current += step;
            if (current >= target) {
                element.textContent = target.toLocaleString();
                clearInterval(counter);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, 16);
    }

    // Initialize counters when visible
    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumbers = entry.target.querySelectorAll('.stat-number[data-target]');
                statNumbers.forEach(number => {
                    if (!number.classList.contains('counted')) {
                        number.classList.add('counted');
                        animateCounter(number);
                    }
                });
            }
        });
    }, observerOptions);

    document.addEventListener('DOMContentLoaded', function() {
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            observer.observe(statsSection);
        }
    });

    // Scroll to section function
    function scrollToSection(sectionId) {
        const section = document.getElementById(sectionId);
        const header = document.getElementById('header');
        if (section) {
            const headerHeight = header?.offsetHeight || 0;
            const targetPosition = section.offsetTop - headerHeight;
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    }

    // Carousel functionality
    let currentIndex = 0;
    const carousel = document.getElementById('carousel');
    const items = document.querySelectorAll('.carousel-item');
    const indicators = document.querySelectorAll('.indicator');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    function updateCarousel() {
        const totalItems = items.length;
        const isMobile = window.innerWidth <= 768;
        const isTablet = window.innerWidth <= 1024;

        items.forEach((item, index) => {
            let offset = index - currentIndex;

            if (offset > totalItems / 2) {
                offset -= totalItems;
            } else if (offset < -totalItems / 2) {
                offset += totalItems;
            }

            const absOffset = Math.abs(offset);
            const sign = offset < 0 ? -1 : 1;

            item.style.transform = '';
            item.style.opacity = '';
            item.style.zIndex = '';
            item.style.transition = 'all 0.8s cubic-bezier(0.4, 0.0, 0.2, 1)';

            let spacing1 = 400;
            let spacing2 = 600;
            let spacing3 = 750;

            if (isMobile) {
                spacing1 = 280;
                spacing2 = 420;
                spacing3 = 550;
            } else if (isTablet) {
                spacing1 = 340;
                spacing2 = 520;
                spacing3 = 650;
            }

            if (absOffset === 0) {
                item.style.transform = 'translate(-50%, -50%) translateZ(0) scale(1)';
                item.style.opacity = '1';
                item.style.zIndex = '10';
            } else if (absOffset === 1) {
                const translateX = sign * spacing1;
                const rotation = isMobile ? 25 : 30;
                const scale = isMobile ? 0.88 : 0.85;
                item.style.transform = `translate(-50%, -50%) translateX(${translateX}px) translateZ(-200px) rotateY(${-sign * rotation}deg) scale(${scale})`;
                item.style.opacity = '0.8';
                item.style.zIndex = '5';
            } else if (absOffset === 2) {
                const translateX = sign * spacing2;
                const rotation = isMobile ? 35 : 40;
                const scale = isMobile ? 0.75 : 0.7;
                item.style.transform = `translate(-50%, -50%) translateX(${translateX}px) translateZ(-350px) rotateY(${-sign * rotation}deg) scale(${scale})`;
                item.style.opacity = '0.5';
                item.style.zIndex = '3';
            } else if (absOffset === 3) {
                const translateX = sign * spacing3;
                const rotation = isMobile ? 40 : 45;
                const scale = isMobile ? 0.65 : 0.6;
                item.style.transform = `translate(-50%, -50%) translateX(${translateX}px) translateZ(-450px) rotateY(${-sign * rotation}deg) scale(${scale})`;
                item.style.opacity = '0.3';
                item.style.zIndex = '2';
            } else {
                item.style.transform = 'translate(-50%, -50%) translateZ(-500px) scale(0.5)';
                item.style.opacity = '0';
                item.style.zIndex = '1';
            }
        });

        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentIndex);
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % items.length;
        updateCarousel();
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        updateCarousel();
    }

    function goToSlide(index) {
        currentIndex = index;
        updateCarousel();
    }

    prevBtn?.addEventListener('click', prevSlide);
    nextBtn?.addEventListener('click', nextSlide);

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => goToSlide(index));
    });

    setInterval(nextSlide, 5000);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') prevSlide();
        if (e.key === 'ArrowRight') nextSlide();
    });

    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            updateCarousel();
        }, 250);
    });

    updateCarousel();
</script>

@endsection