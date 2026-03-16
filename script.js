/* =============================================
   BIRTHDAY WEBSITE — JOSEPH MPHIMBA
   JavaScript: Confetti, Slideshow, Music, AJAX
   ============================================= */

// ── CONFETTI ──────────────────────────────────
(function() {
  const canvas = document.getElementById('confetti-canvas');
  const ctx = canvas.getContext('2d');
  let particles = [];
  const COLORS = ['#FFD700','#FF6B9D','#8B5CF6','#06B6D4','#FFA500','#FF4488','#00E5FF'];

  function resize() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  function createParticles(count) {
    for (let i = 0; i < count; i++) {
      particles.push({
        x: Math.random() * canvas.width,
        y: -20 - Math.random() * 200,
        w: 8 + Math.random() * 8,
        h: 4 + Math.random() * 6,
        color: COLORS[Math.floor(Math.random() * COLORS.length)],
        vx: (Math.random() - 0.5) * 2,
        vy: 1.5 + Math.random() * 2.5,
        angle: Math.random() * Math.PI * 2,
        spin: (Math.random() - 0.5) * 0.15,
        opacity: 1,
        life: 1,
        decay: 0.004 + Math.random() * 0.003
      });
    }
  }

  function loop() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach((p, i) => {
      p.x += p.vx;
      p.y += p.vy;
      p.angle += p.spin;
      p.life -= p.decay;
      p.opacity = Math.max(0, p.life);
      ctx.save();
      ctx.globalAlpha = p.opacity;
      ctx.translate(p.x, p.y);
      ctx.rotate(p.angle);
      ctx.fillStyle = p.color;
      ctx.fillRect(-p.w/2, -p.h/2, p.w, p.h);
      ctx.restore();
      if (p.life <= 0 || p.y > canvas.height + 30) particles.splice(i, 1);
    });
    requestAnimationFrame(loop);
  }
  loop();

  // Initial burst
  createParticles(200);
  // Periodic drizzle
  setInterval(() => createParticles(15), 1200);
})();

// ── BALLOONS ──────────────────────────────────
(function() {
  const container = document.getElementById('balloonsContainer');
  const emojis = ['🎈','🎉','✨','🎊','⭐','💛','🌟'];
  function spawnBalloon() {
    const el = document.createElement('span');
    el.className = 'balloon';
    el.textContent = emojis[Math.floor(Math.random() * emojis.length)];
    el.style.left = (Math.random() * 100) + '%';
    const dur = 6 + Math.random() * 8;
    el.style.animationDuration = dur + 's';
    el.style.animationDelay = (Math.random() * 3) + 's';
    el.style.fontSize = (1.5 + Math.random() * 2) + 'rem';
    container.appendChild(el);
    setTimeout(() => el.remove(), (dur + 4) * 1000);
  }
  for (let i = 0; i < 12; i++) setTimeout(spawnBalloon, i * 400);
  setInterval(spawnBalloon, 1500);
})();

// ── SCROLL REVEAL ─────────────────────────────
(function() {
  const sections = document.querySelectorAll('.section, .counter-section');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('reveal','visible'); }
    });
  }, { threshold: 0.1 });
  sections.forEach(s => { s.classList.add('reveal'); io.observe(s); });
})();

// ── MUSIC PLAYER ──────────────────────────────
const audio = document.getElementById('bgMusic');
const musicBtn = document.getElementById('musicBtn');
const musicIcon = document.getElementById('musicIcon');
let playing = false;

function attemptAutoplay() {
  const promise = audio.play();
  if (promise !== undefined) {
    promise.then(() => {
      playing = true;
      musicIcon.className = 'fas fa-pause';
    }).catch(() => {
      playing = false;
      musicIcon.className = 'fas fa-music';
    });
  }
}
window.addEventListener('click', () => { if (!playing) attemptAutoplay(); }, { once: true });
document.addEventListener('DOMContentLoaded', attemptAutoplay);

musicBtn.addEventListener('click', () => {
  if (playing) { audio.pause(); musicIcon.className = 'fas fa-music'; playing = false; }
  else { audio.play(); musicIcon.className = 'fas fa-pause'; playing = true; }
});

// ── SLIDESHOW ─────────────────────────────────
(function() {
  const slides = document.querySelectorAll('.slide');
  const dotsContainer = document.getElementById('slideDots');
  let current = 0;
  let timer;

  slides.forEach((_, i) => {
    const dot = document.createElement('div');
    dot.className = 'dot' + (i === 0 ? ' active' : '');
    dot.addEventListener('click', () => goto(i));
    dotsContainer.appendChild(dot);
  });

  function goto(n) {
    slides[current].classList.remove('active');
    dotsContainer.children[current].classList.remove('active');
    current = (n + slides.length) % slides.length;
    slides[current].classList.add('active');
    dotsContainer.children[current].classList.add('active');
    resetTimer();
  }

  function resetTimer() {
    clearInterval(timer);
    timer = setInterval(() => goto(current + 1), 4000);
  }

  document.getElementById('prevSlide').addEventListener('click', () => goto(current - 1));
  document.getElementById('nextSlide').addEventListener('click', () => goto(current + 1));
  resetTimer();
})();

// ── LIKE / DISLIKE ────────────────────────────
document.getElementById('likeBtn').addEventListener('click', function() {
  sendReaction('like', this);
});
document.getElementById('dislikeBtn').addEventListener('click', function() {
  sendReaction('dislike', this);
});

function sendReaction(type, btn) {
  btn.classList.add('pop');
  btn.addEventListener('animationend', () => btn.classList.remove('pop'), { once: true });
  fetch('like.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'type=' + type
  })
  .then(r => r.json())
  .then(data => {
    document.getElementById('likeCount').textContent = data.likes;
    document.getElementById('dislikeCount').textContent = data.dislikes;
  })
  .catch(() => {});
}

// ── COMMENTS ─────────────────────────────────
document.getElementById('submitComment').addEventListener('click', submitComment);

function submitComment() {
  const name = document.getElementById('guestName').value.trim();
  const comment = document.getElementById('guestComment').value.trim();
  const msgEl = document.getElementById('formMsg');
  const btn = document.getElementById('submitComment');

  if (!name || !comment) {
    msgEl.textContent = '⚠️ Please fill in both fields.';
    msgEl.className = 'form-message error';
    return;
  }

  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

  fetch('comment.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'name=' + encodeURIComponent(name) + '&comment=' + encodeURIComponent(comment)
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      msgEl.textContent = '🎉 Your wish has been sent!';
      msgEl.className = 'form-message success';
      document.getElementById('guestName').value = '';
      document.getElementById('guestComment').value = '';
      prependComment(data.name, data.comment, data.date);
    } else {
      msgEl.textContent = '❌ ' + (data.error || 'Something went wrong.');
      msgEl.className = 'form-message error';
    }
  })
  .catch(() => {
    msgEl.textContent = '❌ Connection error. Please try again.';
    msgEl.className = 'form-message error';
  })
  .finally(() => {
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Wish';
    setTimeout(() => { msgEl.textContent = ''; }, 4000);
  });
}

function prependComment(name, comment, date) {
  const grid = document.getElementById('commentsGrid');
  const initial = name.charAt(0).toUpperCase();
  const card = document.createElement('div');
  card.className = 'comment-card';
  card.innerHTML = `
    <div class="comment-avatar">${initial}</div>
    <div class="comment-body">
      <div class="comment-header">
        <span class="comment-name">${escapeHtml(name)}</span>
        <span class="comment-time">${date}</span>
      </div>
      <p class="comment-text">${escapeHtml(comment).replace(/\n/g,'<br>')}</p>
    </div>
  `;
  grid.insertBefore(card, grid.firstChild);
}

function escapeHtml(str) {
  return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
