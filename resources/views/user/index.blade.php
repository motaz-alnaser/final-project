@extends('layout.master')

@section('title', 'home')


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
            <div style="color: var(--accent-purple); font-size: 18px; text-transform: uppercase; letter-spacing: 3px;">Refracting Reality...</div>
        </div>
    </div>

    
   <section class="hero" id="home">
    <div class="carousel-container">
        <div class="carousel" id="carousel">
            @forelse($activities as $activity)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-index="{{ $loop->index }}">
                    <div class="card">
                        <div class="card-number">0{{ $activity->id }}</div>
                        <div class="card-image">
                            <img src="{{ $activity->primaryImage ? asset('storage/' . $activity->primaryImage->image_url) : asset('images/default-activity.jpg') }}" alt="{{ $activity->title }}">
                        </div>
                        <h3 class="card-title">{{ $activity->title }}</h3>
                        <p class="card-description">{{ Str::limit($activity->description, 100) }}</p>
                        <div class="activity-meta">
                            <span class="activity-price">{{ number_format($activity->price, 2) }} JOD</span>
                            <span class="activity-host">By {{ $activity->host->name ?? 'Unknown' }}</span>
                            <span class="activity-category">{{ $activity->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <button class="card-cta" onclick="window.location.href='{{ route('user.activity_details', $activity->id) }}'">Explore</button>
                    </div>
                </div>
            @empty
                <div class="carousel-item active" data-index="0">
                    <div class="card">
                        <div class="card-number">00</div>
                        <div class="card-image">
<!-- في الكاروسيل -->
<img src="{{ $activity->primaryImage ? asset('storage/' . $activity->primaryImage->image_url) : asset('images/default-activity.jpg') }}" alt="{{ $activity->title }}">                       </div>
                        <h3 class="card-title">No Activities Available</h3>
                        <p class="card-description">Check back later for exciting activities!</p>
                        <button class="card-cta" onclick="scrollToSection('about')">Discover More</button>
                    </div>
                </div>
            @endforelse
        </div>
        
        <div class="carousel-controls">
            <button class="carousel-btn" id="prevBtn">‹</button>
            <button class="carousel-btn" id="nextBtn">›</button>
        </div>
        
        <div class="carousel-indicators" id="indicators">
            @foreach($activities as $index => $activity)
                <span class="indicator {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></span>
            @endforeach
        </div>
    </div>
</section>
    <!-- NEW: Prism Philosophy Section (About) -->
    <section class="philosophy-section" id="about">
        <div class="philosophy-container">
            <div class="prism-line"></div>
            
            <h2 class="philosophy-headline">
                Refracting Ideas<br>Into Reality
            </h2>
            
            <p class="philosophy-subheading">
                At PRISM FLUX, we turn your passions into experiences. Whether you’re climbing mountains, painting canvases, or dancing under the stars — we help you find, create, and share unforgettable moments with others who feel the same
            </p>
            
            <div class="philosophy-pillars">
                <div class="pillar">
                    <div class="pillar-icon">💎</div>
                    <h3 class="pillar-title">DISCOVER</h3>
                    <p class="pillar-description">
Find activities that match your vibe — from sunrise yoga to desert hikes, art jams to urban adventures. No matter what sparks joy in you, there’s a community waiting to join you.

                    </p>
                </div>
                
                <div class="pillar">
                    <div class="pillar-icon">🔬</div>
                    <h3 class="pillar-title">CREATE</h3>
                    <p class="pillar-description">
Got an idea? Turn it into a real event. Host your own workshop, tour, or hangout — and let others discover the magic you’ve created. Your passion is the spark. We’ll help you build the fire.

                    </p>
                </div>
                
                <div class="pillar">
                    <div class="pillar-icon">∞</div>
                    <h3 class="pillar-title">CONNECT</h3>
                    <p class="pillar-description">
Meet people who speak your language — not just words, but energy, rhythm, and curiosity. Build friendships through shared experiences, not just likes or DMs. Real moments. Real connections.

                    </p>
                </div>
               
            </div>
            
            <div class="philosophy-particles" id="particles">
                <!-- Particles will be generated by JavaScript -->
            </div>
        </div>
    </section>

    <!-- Stats Section with Content -->
    <section class="stats-section" id="stats">
        <div class="section-header">
            <h2 class="section-title">LIVE METRICS — WHERE COMMUNITIES GROW</h2>
            <p class="section-subtitle">Real-time impact and community energy, powered by shared experiences and unforgettable moments</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🚀</div>
                <div class="stat-number" data-target="150">0</div>
                <div class="stat-label">ACTIVITIES HOSTED</div>
                <p class="stat-description">From yoga at sunrise to desert campfires — we’ve helped creators launch over 150 unique experiences across the region. Every one is a story waiting to happen</p>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">⚡</div>
                <div class="stat-number" data-target="99">0</div>
                <div class="stat-label">PARTICIPANT SATISFACTION</div>
                <p class="stat-description">We don’t just measure attendance — we measure joy. 99% of participants say they’d come back or bring a friend. That’s what real connection looks like</p>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">🏆</div>
                <div class="stat-number" data-target="25">0</div>
                <div class="stat-label">COMMUNITY LEADERS</div>
                <p class="stat-description">Not just hosts — community builders. Over 25 passionate creators are turning their hobbies into shared adventures, inspiring others to join in.

</p>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">💎</div>
                <div class="stat-number" data-target="500">0</div>
                <div class="stat-label">MEMBERS ENGAGED DAILY</div>
                <p class="stat-description">Every day, 500+ young people log in, discover new activities, book spots, and connect with others who share their vibe. The energy never sleepsContinuous integration and deployment with automated testing ensuring maximum code quality.</p>
            </div>
        </div>
    </section>

    <!-- Enhanced Skills Section - Technical Arsenal -->
    <section class="skills-section" id="skills">
        <div class="skills-container">
            <div class="section-header">
                <h2 class="section-title">YOUR ACTIVITY TOOLKIT</h2>
                <p class="section-subtitle">Everything you need to create, manage, and grow your activity — from booking tools to promotion kits. We handle the tech, you bring the energy</p>
            </div>
            
            <div class="skill-categories">
                <div class="category-tab active" data-category="all">ALL TOOLS</div>
                <div class="category-tab" data-category="frontend">EXPERIENCE DESIGN</div>
                <div class="category-tab" data-category="backend">PROMOTION & GROWTH</div>
                <div class="category-tab" data-category="cloud">BOOKING & PAYMENTS</div>
                <div class="category-tab" data-category="emerging">HOSTING TOOLS</div>
            </div>

            <div class="skills-hexagon-grid" id="skillsGrid">
                <!-- Hexagonal skill items will be generated by JavaScript -->
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
                <a href="https://maps.google.com/?q=Silicon+Valley+CA+94025" target="_blank" class="info-item">
                    <div class="info-icon">📍</div>
                    <div class="info-text">
                        <h4>Location</h4>
                        <p>Jordan, amman</p>
                    </div>
                </a>
                
                <a href="mailto:hello@prismflux.io" class="info-item">
                    <div class="info-icon">📧</div>
                    <div class="info-text">
                        <h4>Email</h4>
                        <p>hello@prismflux.io</p>
                    </div>
                </a>
                
                <a href="tel:+15551234567" class="info-item">
                    <div class="info-icon">📱</div>
                    <div class="info-text">
                        <h4>Phone</h4>
                        <p>962 798628264</p>
                    </div>
                </a>
              
            </div>
            
            <form class="contact-form" id="contactForm">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Transmit Message</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    
<script src="templatemo-prism-scripts.js"></script>
<script>
        // Keep loader functionality
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

        // Initialize counters
        document.addEventListener('DOMContentLoaded', function() {
            const statNumbers = document.querySelectorAll('.stat-number[data-target]');
            statNumbers.forEach(number => {
                animateCounter(number);
            });
        });

        // Function to scroll to section
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

// Initialize carousel
let currentIndex = 0;
const carousel = document.getElementById('carousel');
const indicatorsContainer = document.getElementById('indicators');
const items = document.querySelectorAll('.carousel-item');
const indicators = document.querySelectorAll('.indicator');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

function updateCarousel() {
    const totalItems = items.length;
    const isMobile = window.innerWidth <= 768;
    const isTablet = window.innerWidth <= 1024;

    items.forEach((item, index) => {
        // Calculate relative position
        let offset = index - currentIndex;

        // Wrap around for continuous rotation
        if (offset > totalItems / 2) {
            offset -= totalItems;
        } else if (offset < -totalItems / 2) {
            offset += totalItems;
        }

        const absOffset = Math.abs(offset);
        const sign = offset < 0 ? -1 : 1;

        // Reset transform
        item.style.transform = '';
        item.style.opacity = '';
        item.style.zIndex = '';
        item.style.transition = 'all 0.8s cubic-bezier(0.4, 0.0, 0.2, 1)';

        // Adjust spacing based on screen size
        let spacing1 = 400;
        let spacing2 = 600;
        let spacing3 = 750;

        if (isMobile) {
            spacing1 = 280;  // Closer spacing for mobile
            spacing2 = 420;
            spacing3 = 550;
        } else if (isTablet) {
            spacing1 = 340;
            spacing2 = 520;
            spacing3 = 650;
        }

        if (absOffset === 0) {
            // Center item
            item.style.transform = 'translate(-50%, -50%) translateZ(0) scale(1)';
            item.style.opacity = '1';
            item.style.zIndex = '10';
        } else if (absOffset === 1) {
            // Side items
            const translateX = sign * spacing1;
            const rotation = isMobile ? 25 : 30;
            const scale = isMobile ? 0.88 : 0.85;
            item.style.transform = `translate(-50%, -50%) translateX(${translateX}px) translateZ(-200px) rotateY(${-sign * rotation}deg) scale(${scale})`;
            item.style.opacity = '0.8';
            item.style.zIndex = '5';
        } else if (absOffset === 2) {
            // Further side items
            const translateX = sign * spacing2;
            const rotation = isMobile ? 35 : 40;
            const scale = isMobile ? 0.75 : 0.7;
            item.style.transform = `translate(-50%, -50%) translateX(${translateX}px) translateZ(-350px) rotateY(${-sign * rotation}deg) scale(${scale})`;
            item.style.opacity = '0.5';
            item.style.zIndex = '3';
        } else if (absOffset === 3) {
            // Even further items
            const translateX = sign * spacing3;
            const rotation = isMobile ? 40 : 45;
            const scale = isMobile ? 0.65 : 0.6;
            item.style.transform = `translate(-50%, -50%) translateX(${translateX}px) translateZ(-450px) rotateY(${-sign * rotation}deg) scale(${scale})`;
            item.style.opacity = '0.3';
            item.style.zIndex = '2';
        } else {
            // Hidden items (behind)
            item.style.transform = 'translate(-50%, -50%) translateZ(-500px) scale(0.5)';
            item.style.opacity = '0';
            item.style.zIndex = '1';
        }
    });

    // Update indicators
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

// Event listeners
prevBtn?.addEventListener('click', prevSlide);
nextBtn?.addEventListener('click', nextSlide);

// Indicator clicks
indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => goToSlide(index));
});

// Auto-rotate carousel
setInterval(nextSlide, 5000);

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') prevSlide();
    if (e.key === 'ArrowRight') nextSlide();
});

// Update carousel on window resize
let resizeTimeout;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
        updateCarousel();
    }, 250);
});

// Initialize carousel
updateCarousel();
    </script>

@endsection