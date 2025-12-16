<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FTI UKSW - Virtual Tour</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;900&family=Exo+2:wght@300;400;500;600;700&family=Audiowide&display=swap" rel="stylesheet">
    <link href="{{ asset('css/tooplate-neural-style.css') }}" rel="stylesheet">   


</head>
<body>
    <canvas id="neural-bg"></canvas>

    <nav id="navbar">
        <div class="nav-container">
            <a href="#home" class="logo-container">
                <svg class="logo-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <!-- Neural Network Logo -->
                    <circle cx="50" cy="20" r="8" fill="none" stroke="#00ffff" stroke-width="2"/>
                    <circle cx="25" cy="50" r="8" fill="none" stroke="#ff00ff" stroke-width="2"/>
                    <circle cx="75" cy="50" r="8" fill="none" stroke="#ff00ff" stroke-width="2"/>
                    <circle cx="50" cy="80" r="8" fill="none" stroke="#ffff00" stroke-width="2"/>
                    
                    <!-- Connections -->
                    <line x1="50" y1="28" x2="25" y2="42" stroke="#00ffff" stroke-width="1" opacity="0.6"/>
                    <line x1="50" y1="28" x2="75" y2="42" stroke="#00ffff" stroke-width="1" opacity="0.6"/>
                    <line x1="25" y1="58" x2="50" y2="72" stroke="#ff00ff" stroke-width="1" opacity="0.6"/>
                    <line x1="75" y1="58" x2="50" y2="72" stroke="#ff00ff" stroke-width="1" opacity="0.6"/>
                    
                    <!-- Center node -->
                    <circle cx="50" cy="50" r="5" fill="#00ffff"/>
                    <line x1="50" y1="28" x2="50" y2="45" stroke="#00ffff" stroke-width="1" opacity="0.6"/>
                    <line x1="50" y1="55" x2="50" y2="72" stroke="#ffff00" stroke-width="1" opacity="0.6"/>
                    <line x1="33" y1="50" x2="45" y2="50" stroke="#ff00ff" stroke-width="1" opacity="0.6"/>
                    <line x1="55" y1="50" x2="67" y2="50" stroke="#ff00ff" stroke-width="1" opacity="0.6"/>
                </svg>
                <span class="logo-text">UNNAMED TECH</span>
            </a>
            
            <div class="mobile-menu-toggle" id="mobile-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            <div class="nav-menu" id="nav-menu">
                <ul>
                    <li><a href="{{ route('virtualtour.start') }}"">VIRTUAL TOUR</a></li>
                    <li><a href="#about">ABOUT</a></li>
                    <li><a href="#contact">CONTACT</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="home" class="hero">
        <div class="hero-content">
            <h1 class="glitch" data-text="F T I">F T I</h1>
            <p class="subtitle">UNIVERSITAS KRISTEN SATYA WACANA</p>
        </div>
        <a href="{{ route('virtualtour.start') }}"" class="scroll-btn">
            <div class="scroll-btn-inner">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </div>
        </a>
    </section>
</body>
</html>