/**
 * Classic Anglican — theme.js
 * Handles: hero slider, mobile menu toggle, back-to-top button.
 * Loaded in footer via functions.php (wp_enqueue_script).
 */

document.addEventListener('DOMContentLoaded', function () {

  // ─── HERO SLIDER ──────────────────────────────────────────────────────────
  const slides     = document.querySelectorAll('.slide');
  const dots       = document.querySelectorAll('.slide-dot');
  let   current    = 0;
  let   sliderTimer;

  function goToSlide(n) {
    if (!slides.length) return;

    // Remove active state from current slide & dot
    slides[current].classList.remove('active');
    if (dots[current]) {
      dots[current].classList.remove('bg-gold');
      dots[current].classList.add('bg-white/40', 'bg-white\\/40');
      dots[current].style.background = 'rgba(255,255,255,0.4)';
    }

    // Advance
    current = (n + slides.length) % slides.length;

    // Activate new slide & dot
    slides[current].classList.add('active');
    if (dots[current]) {
      dots[current].style.background = '#b8975a'; // gold
    }

    // Reset auto-play timer
    clearInterval(sliderTimer);
    sliderTimer = setInterval(function () { goToSlide(current + 1); }, 6000);
  }

  function nextSlide() { goToSlide(current + 1); }
  function prevSlide() { goToSlide(current - 1); }

  // Expose to inline onclick attributes in front-page.php
  window.goToSlide = goToSlide;
  window.nextSlide = nextSlide;
  window.prevSlide = prevSlide;

  // Start auto-play
  if (slides.length > 1) {
    sliderTimer = setInterval(function () { goToSlide(current + 1); }, 6000);
  }

  // Pause on hover
  const heroSection = document.querySelector('.slide')?.closest('section');
  if (heroSection) {
    heroSection.addEventListener('mouseenter', function () { clearInterval(sliderTimer); });
    heroSection.addEventListener('mouseleave', function () {
      sliderTimer = setInterval(function () { goToSlide(current + 1); }, 6000);
    });
  }

  // Touch / swipe support on mobile
  let touchStartX = 0;
  document.addEventListener('touchstart', function (e) {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });
  document.addEventListener('touchend', function (e) {
    const dx = e.changedTouches[0].screenX - touchStartX;
    if (Math.abs(dx) > 50) {
      dx < 0 ? nextSlide() : prevSlide();
    }
  }, { passive: true });


  // ─── MOBILE MENU TOGGLE ───────────────────────────────────────────────────
  const mobileBtn  = document.getElementById('mobileMenuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  const ham1 = document.getElementById('ham1');
  const ham2 = document.getElementById('ham2');
  const ham3 = document.getElementById('ham3');

  if (mobileBtn && mobileMenu) {
    mobileBtn.addEventListener('click', function () {
      const isOpen = !mobileMenu.classList.contains('hidden');

      mobileMenu.classList.toggle('hidden');
      mobileBtn.setAttribute('aria-expanded', !isOpen);

      // Animate hamburger to X
      if (!isOpen) {
        if (ham1) { ham1.style.transform = 'translateY(6px) rotate(45deg)'; }
        if (ham2) { ham2.style.opacity   = '0'; }
        if (ham3) { ham3.style.transform = 'translateY(-6px) rotate(-45deg)'; }
      } else {
        if (ham1) { ham1.style.transform = ''; }
        if (ham2) { ham2.style.opacity   = ''; }
        if (ham3) { ham3.style.transform = ''; }
      }
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
      if (!mobileBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
        mobileMenu.classList.add('hidden');
        mobileBtn.setAttribute('aria-expanded', 'false');
        if (ham1) ham1.style.transform = '';
        if (ham2) ham2.style.opacity   = '';
        if (ham3) ham3.style.transform = '';
      }
    });
  }


  // ─── BACK TO TOP ──────────────────────────────────────────────────────────
  const backTop = document.getElementById('backTop');

  if (backTop) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 400) {
        backTop.style.opacity       = '1';
        backTop.style.pointerEvents = 'auto';
      } else {
        backTop.style.opacity       = '0';
        backTop.style.pointerEvents = 'none';
      }
    });

    backTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }


  // ─── SMOOTH ANCHOR LINKS ──────────────────────────────────────────────────
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

});
