/* =========================================================
   gut salzig — main.js
   ========================================================= */

(() => {
  'use strict';

  /* ---------- Sticky Navigation ---------- */
  const nav = document.getElementById('nav');
  const onScroll = () => {
    nav?.classList.toggle('nav--scrolled', window.scrollY > 60);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---------- Fullscreen Overlay Menu ---------- */
  const burger    = document.getElementById('navBurger');
  const menu      = document.getElementById('menu');
  const menuClose = document.getElementById('menuClose');

  const openMenu  = () => {
    menu?.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  };
  const closeMenu = () => {
    menu?.classList.remove('is-open');
    document.body.style.overflow = '';
  };

  burger?.addEventListener('click', openMenu);
  menuClose?.addEventListener('click', closeMenu);
  menu?.querySelectorAll('a').forEach(a =>
    a.addEventListener('click', () => setTimeout(closeMenu, 300))
  );
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeMenu();
  });

  /* ---------- Hero-Slider ---------- */
  const slides = document.querySelectorAll('.hero__slide');
  const dotsWrap = document.getElementById('heroDots');
  let current = 0;
  let timer;

  if (slides.length && dotsWrap) {
    slides.forEach((_, i) => {
      const b = document.createElement('button');
      b.setAttribute('aria-label', `Slide ${i + 1}`);
      if (i === 0) b.classList.add('is-active');
      b.addEventListener('click', () => go(i, true));
      dotsWrap.appendChild(b);
    });
    const dots = dotsWrap.querySelectorAll('button');

    const go = (next, manual = false) => {
      const prevSlide = slides[current];
      const prevDot = dots[current];
      current = (next + slides.length) % slides.length;
      // Vorherigen Slide nach links rausgleiten lassen
      prevSlide.classList.remove('is-active');
      prevSlide.classList.add('is-leaving');
      prevDot.classList.remove('is-active');
      // Nach Animation Klasse entfernen, damit Slide für nächste Runde wieder rechts startet
      setTimeout(() => prevSlide.classList.remove('is-leaving'), 1400);
      // Neuen Slide einblenden
      slides[current].classList.add('is-active');
      dots[current].classList.add('is-active');
      if (manual) reset();
    };

    const reset = () => {
      clearInterval(timer);
      timer = setInterval(() => go(current + 1), 6500);
    };
    reset();
  }

  /* ---------- Parallax ---------- */
  const parallaxBgs = document.querySelectorAll('[data-parallax-bg]');
  if (parallaxBgs.length && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const updateParallax = () => {
      parallaxBgs.forEach(el => {
        const rect = el.parentElement.getBoundingClientRect();
        const vh = window.innerHeight;
        if (rect.bottom < 0 || rect.top > vh) return;
        const progress = (rect.top + rect.height / 2 - vh / 2) / vh;
        el.style.transform = `translateY(${progress * -60}px)`;
      });
    };
    window.addEventListener('scroll', updateParallax, { passive: true });
    updateParallax();
  }

  /* ---------- Scroll-Reveal ---------- */
  const revealTargets = document.querySelectorAll('.reveal, .reveal-stagger');
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -80px 0px' });
    revealTargets.forEach(el => io.observe(el));
  } else {
    revealTargets.forEach(el => el.classList.add('is-visible'));
  }

  /* ---------- Live Clock (Departure Board) ---------- */
  const clockEl = document.getElementById('gsClock');
  if (clockEl) {
    const tick = () => {
      const d = new Date();
      const hh = String(d.getHours()).padStart(2, '0');
      const mm = String(d.getMinutes()).padStart(2, '0');
      clockEl.textContent = `${hh} : ${mm} CET`;
    };
    tick();
    setInterval(tick, 30000);
  }

  /* ---------- Smooth Scroll ---------- */
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', (e) => {
      const id = a.getAttribute('href');
      if (id.length < 2) return;
      const target = document.querySelector(id);
      if (!target) return;
      e.preventDefault();
      const top = target.getBoundingClientRect().top + window.scrollY - 70;
      window.scrollTo({ top, behavior: 'smooth' });
    });
  });

  /* ---------- Cockpit Weather Widget ---------- */
  const cockpit = document.getElementById('cockpit');
  const cockpitClose = document.getElementById('cockpitClose');
  if (cockpit) {
    // Demo weather rotation (echte API-Anbindung später)
    const weatherStates = [
      { temp: '19°', meta: 'Sonne · Wind 12 kn' },
      { temp: '17°', meta: 'Leicht bewölkt · 8 kn' },
      { temp: '21°', meta: 'Klar · Förde 16°' },
      { temp: '15°', meta: 'Brise · 14 kn NO' }
    ];
    let wIdx = Math.floor(Math.random() * weatherStates.length);
    const tempEl = document.getElementById('cockpitTemp');
    const metaEl = document.getElementById('cockpitMeta');
    const updateWeather = () => {
      const w = weatherStates[wIdx];
      if (tempEl) tempEl.textContent = w.temp;
      if (metaEl) metaEl.textContent = w.meta;
      wIdx = (wIdx + 1) % weatherStates.length;
    };
    updateWeather();
    setInterval(updateWeather, 12000);

    // Show widget immediately (mit kleiner Verzögerung für Fade-In)
    requestAnimationFrame(() => {
      setTimeout(() => cockpit.classList.add('is-visible'), 600);
    });
    cockpitClose?.addEventListener('click', () => cockpit.classList.remove('is-visible'));
  }

  /* ---------- Boarding Sound (Web Audio API) ---------- */
  const soundToggle = document.getElementById('soundToggle');
  if (soundToggle) {
    requestAnimationFrame(() => {
      setTimeout(() => soundToggle.classList.add('is-visible'), 900);
    });
    let audioCtx = null;
    const playBoardingChime = () => {
      try {
        audioCtx = audioCtx || new (window.AudioContext || window.webkitAudioContext)();
        if (audioCtx.state === 'suspended') audioCtx.resume();
        const now = audioCtx.currentTime;
        // Zwei Töne: E5 (659.25 Hz) → C5 (523.25 Hz) wie ein Flughafen-Gong
        const tones = [
          { freq: 659.25, start: 0,    dur: 0.5 },
          { freq: 523.25, start: 0.42, dur: 0.7 }
        ];
        tones.forEach(({ freq, start, dur }) => {
          const osc = audioCtx.createOscillator();
          const gain = audioCtx.createGain();
          osc.type = 'sine';
          osc.frequency.value = freq;
          gain.gain.setValueAtTime(0, now + start);
          gain.gain.linearRampToValueAtTime(0.18, now + start + 0.03);
          gain.gain.exponentialRampToValueAtTime(0.0001, now + start + dur);
          osc.connect(gain).connect(audioCtx.destination);
          osc.start(now + start);
          osc.stop(now + start + dur);
        });
        soundToggle.classList.add('is-playing');
        setTimeout(() => soundToggle.classList.remove('is-playing'), 1400);
      } catch (e) { /* no-op */ }
    };
    soundToggle.addEventListener('click', playBoardingChime);
  }

  /* ---------- Passport Stamps Scroll-Animation ---------- */
  const stamps = document.querySelectorAll('.passport-stamp, .travel-label, .luggage-tag, .postcard__visa');
  if ('IntersectionObserver' in window) {
    const stampIO = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-stamped');
          stampIO.unobserve(entry.target);
        }
      });
    }, { threshold: 0.4 });
    stamps.forEach(el => stampIO.observe(el));
  }
})();
