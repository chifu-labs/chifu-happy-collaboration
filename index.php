<?php
require_once 'database.php';

// Increment view count
$pdo->exec("UPDATE views SET view_count = view_count + 1 WHERE id = 1");

// Get view count
$viewCount = $pdo->query("SELECT view_count FROM views WHERE id = 1")->fetchColumn();

// Get likes/dislikes
$reactions = $pdo->query("SELECT likes, dislikes FROM reactions WHERE id = 1")->fetch(PDO::FETCH_ASSOC);
$likes = $reactions['likes'] ?? 0;
$dislikes = $reactions['dislikes'] ?? 0;

// Get comments
$comments = $pdo->query("SELECT * FROM comments ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>🎉 Happy Birthday Joseph Mphimba!</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=DM+Sans:wght@300;400;500&family=Abril+Fatface&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

<!-- Confetti Canvas -->
<canvas id="confetti-canvas"></canvas>

<!-- Floating Music Button -->
<div class="music-btn" id="musicBtn" title="Toggle Music">
  <i class="fas fa-music" id="musicIcon"></i>
  <span class="music-ripple"></span>
</div>
<audio id="bgMusic" loop autoplay>
  <source src="music/Joseph.mp3" type="audio/mpeg">
</audio>

<!-- ========== HERO SECTION ========== -->
<section class="hero">
  <div class="balloons-container" id="balloonsContainer"></div>
  <div class="hero-content">
    <div class="hero-badge">🎂 March 17, 2026</div>
    <h1 class="hero-title">
      <span class="line1">Happy Birthday</span>
      <span class="line2">Joseph</span>
      <span class="line3">Mphimba</span>
    </h1>
    <p class="hero-subtitle">🎉 Today is your special day — may it be as incredible as you are! 🎈</p>
    <div class="hero-icons">
      <span class="hero-icon" style="--d:0s">🎂</span>
      <span class="hero-icon" style="--d:0.2s">🎉</span>
      <span class="hero-icon" style="--d:0.4s">🎈</span>
      <span class="hero-icon" style="--d:0.6s">🍹</span>
      <span class="hero-icon" style="--d:0.8s">✨</span>
    </div>
  </div>
  <div class="hero-scroll-hint">
    <span>Scroll down</span>
    <i class="fas fa-chevron-down"></i>
  </div>
</section>

<!-- ========== PHOTO SLIDESHOW ========== -->
<section class="section slideshow-section">
  <div class="section-header">
    <h2 class="section-title">📸 Moments in Time</h2>
    <p class="section-sub">A glimpse into Joseph's wonderful life</p>
  </div>
  <div class="slideshow-wrapper">
    <div class="slideshow" id="slideshow">
      <div class="slide active">
        <img src="images/Joseph1.jpeg" alt="Joseph 1" loading="lazy"/>
        <div class="slide-caption">Joseph — A Remarkable Soul ✨</div>
      </div>
      <div class="slide">
        <img src="images/Joseph2.jpeg" alt="Joseph 2" loading="lazy"/>
        <div class="slide-caption">Memories to Cherish Forever 🌟</div>
      </div>
      <div class="slide">
        <img src="images/Joseph3.jpeg" alt="Joseph 3" loading="lazy"/>
        <div class="slide-caption">A Life Full of Joy 🎊</div>
      </div>
      <div class="slide">
        <img src="images/Joseph4.jpeg" alt="Joseph 4" loading="lazy"/>
        <div class="slide-caption">Happy Birthday, Joseph! 🎂</div>
      </div>
    </div>
    <button class="slide-arrow prev" id="prevSlide"><i class="fas fa-chevron-left"></i></button>
    <button class="slide-arrow next" id="nextSlide"><i class="fas fa-chevron-right"></i></button>
    <div class="slide-dots" id="slideDots"></div>
  </div>
</section>

<!-- ========== CELEBRATION DECORATIONS ========== -->
<section class="section deco-section">
  <div class="section-header">
    <h2 class="section-title">🎊 Let's Celebrate!</h2>
    <p class="section-sub">Today is a day of pure joy and celebration</p>
  </div>
  <div class="deco-grid">
    <div class="deco-card">
      <div class="deco-icon">🎂</div>
      <h3>Birthday Cake</h3>
      <p>A magnificent cake for a magnificent person</p>
    </div>
    <div class="deco-card">
      <div class="deco-icon">🍹</div>
      <h3>Cheers!</h3>
      <p>Raise a glass to many more wonderful years</p>
    </div>
    <div class="deco-card">
      <div class="deco-icon">🎈</div>
      <h3>Balloons</h3>
      <p>Floating high, just like your spirits today</p>
    </div>
    <div class="deco-card">
      <div class="deco-icon">🎁</div>
      <h3>Gifts & Wishes</h3>
      <p>Wrapped with love from everyone who cares</p>
    </div>
    <div class="deco-card">
      <div class="deco-icon">🌟</div>
      <h3>You're a Star</h3>
      <p>Shining bright in everything you do</p>
    </div>
    <div class="deco-card">
      <div class="deco-icon">🎵</div>
      <h3>Music & Dance</h3>
      <p>Let the rhythm of joy fill your heart</p>
    </div>
  </div>
</section>

<!-- ========== VIEWER COUNTER ========== -->
<section class="section counter-section">
  <div class="counter-glass">
    <div class="counter-emoji">👀</div>
    <div class="counter-text">
      <span class="counter-number" id="viewCount"><?= number_format($viewCount) ?></span>
      <span class="counter-label">people have viewed this birthday page</span>
    </div>
  </div>
</section>

<!-- ========== LIKE / DISLIKE ========== -->
<section class="section reaction-section">
  <div class="section-header">
    <h2 class="section-title">❤️ Show Your Love</h2>
    <p class="section-sub">Let Joseph know how you feel today</p>
  </div>
  <div class="reaction-card">
    <button class="reaction-btn like-btn" id="likeBtn">
      <span class="reaction-emoji">👍</span>
      <span class="reaction-count" id="likeCount"><?= $likes ?></span>
      <span class="reaction-label">Like</span>
    </button>
    <div class="reaction-divider"></div>
    <button class="reaction-btn dislike-btn" id="dislikeBtn">
      <span class="reaction-emoji">👎</span>
      <span class="reaction-count" id="dislikeCount"><?= $dislikes ?></span>
      <span class="reaction-label">Dislike</span>
    </button>
  </div>
</section>

<!-- ========== BIRTHDAY MESSAGE BOARD ========== -->
<section class="section messages-section">
  <div class="section-header">
    <h2 class="section-title">💌 Birthday Wishes</h2>
    <p class="section-sub">Leave a heartfelt message for Joseph</p>
  </div>

  <div class="message-form-wrapper">
    <div class="message-form-card">
      <h3>✍️ Write Your Wish</h3>
      <div class="form-group">
        <label for="guestName">Your Name</label>
        <input type="text" id="guestName" placeholder="Enter your name..." maxlength="100"/>
      </div>
      <div class="form-group">
        <label for="guestComment">Your Birthday Message</label>
        <textarea id="guestComment" rows="4" placeholder="Write a heartfelt birthday wish..." maxlength="500"></textarea>
      </div>
      <button class="submit-btn" id="submitComment">
        <i class="fas fa-paper-plane"></i> Send Wish
      </button>
      <div id="formMsg" class="form-message"></div>
    </div>
  </div>

  <div class="comments-grid" id="commentsGrid">
    <?php foreach($comments as $c): ?>
    <div class="comment-card">
      <div class="comment-avatar"><?= strtoupper(substr(htmlspecialchars($c['name']), 0, 1)) ?></div>
      <div class="comment-body">
        <div class="comment-header">
          <span class="comment-name"><?= htmlspecialchars($c['name']) ?></span>
          <span class="comment-time"><?= date('M d, Y', strtotime($c['created_at'])) ?></span>
        </div>
        <p class="comment-text"><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ========== SHARE BUTTONS ========== -->
<section class="section share-section">
  <div class="section-header">
    <h2 class="section-title">📣 Spread the Joy</h2>
    <p class="section-sub">Share this celebration with the world</p>
  </div>
  <div class="share-btns">
    <a href="https://wa.me/?text=🎉%20Happy%20Birthday%20Joseph%20Mphimba!%20Check%20out%20this%20special%20birthday%20page:%20<?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>"
       target="_blank" class="share-btn whatsapp">
      <i class="fab fa-whatsapp"></i> WhatsApp
    </a>
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>"
       target="_blank" class="share-btn facebook">
      <i class="fab fa-facebook-f"></i> Facebook
    </a>
    <a href="https://twitter.com/intent/tweet?text=🎉+Happy+Birthday+Joseph+Mphimba!&url=<?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>"
       target="_blank" class="share-btn twitter">
      <i class="fab fa-x-twitter"></i> Twitter/X
    </a>
  </div>
</section>

<!-- ========== ABOUT THE AUTHORS ========== -->
<section class="section author-section">
  <div class="section-header">
    <h2 class="section-title">👨‍💻 About the Creators</h2>
    <p class="section-sub">The talented duo behind this birthday celebration</p>
  </div>
  <div class="authors-grid">

    <!-- Author 1: Happy Mnyimbiri -->
    <div class="author-card">
      <div class="author-avatar">HM</div>
      <div class="author-info">
        <h3 class="author-name">Happy Mnyimbiri</h3>
        <p class="author-title">BICT — Level 1 · Mzuzu University</p>
        <address>
          <div class="author-contact"><i class="fas fa-phone"></i> <a href="tel:0990681741">0990681741</a></div>
          <div class="author-contact"><i class="fas fa-envelope"></i> <a href="mailto:happymw.247@yahoo.com">happymw.247@yahoo.com</a></div>
        </address>
        <p class="author-note">Created with ❤️ to celebrate the amazing Joseph Mphimba.</p>
      </div>
    </div>

    <!-- Author 2: Chifuniro Chatangwa -->
    <div class="author-card">
      <div class="author-avatar" style="background: linear-gradient(135deg, #06B6D4, #3B82F6);">CC</div>
      <div class="author-info">
        <h3 class="author-name">Chifuniro Chatangwa</h3>
        <p class="author-title">Data Science — Level 1 · Mzuzu University</p>
        <address>
          <div class="author-contact"><i class="fas fa-phone"></i> <a href="tel:+265893856271">+265 893856271</a></div>
          <div class="author-contact"><i class="fas fa-envelope"></i> <a href="mailto:chifunirochatangwa@gmail.com">chifunirochatangwa@gmail.com</a></div>
        </address>
        <p class="author-note">Proud to help build something special for a special person.</p>
      </div>
    </div>

  </div>
</section>

<!-- ========== PROMO CONTACT SECTION ========== -->
<section class="section promo-section">
  <div class="promo-card">
    <div class="promo-glow"></div>
    <div class="promo-icon">🎂</div>
    <h2 class="promo-title">Want a Birthday Website Like This?</h2>
    <p class="promo-text">
      Contact the creators and get your own personalised birthday website for just
    </p>
    <div class="promo-price">K10,000</div>
    <p class="promo-sub">Custom photos · Music · Wishes board · Animations · Fully hosted</p>
    <div class="promo-contacts">
      <a href="tel:0990681741" class="promo-btn">
        <i class="fas fa-phone"></i>
        <div>
          <span class="promo-btn-name">Happy Mnyimbiri</span>
          <span class="promo-btn-num">0990681741</span>
        </div>
      </a>
      <a href="tel:+265893856271" class="promo-btn promo-btn-alt">
        <i class="fas fa-phone"></i>
        <div>
          <span class="promo-btn-name">Chifuniro Chatangwa</span>
          <span class="promo-btn-num">+265 893856271</span>
        </div>
      </a>
    </div>
    <div class="promo-email-row">
      <a href="mailto:happymw.247@yahoo.com" class="promo-email"><i class="fas fa-envelope"></i> happymw.247@yahoo.com</a>
      <a href="mailto:chifunirochatangwa@gmail.com" class="promo-email"><i class="fas fa-envelope"></i> chifunirochatangwa@gmail.com</a>
    </div>
    <p class="promo-tag">✨ Mzuzu University · BICT &amp; Data Science · Level 1 ✨</p>
  </div>
</section>

<!-- ========== FOOTER ========== -->
<footer class="footer">
  <p>🎂 Made with love for <strong>Joseph Mphimba</strong> • March 17, 2026 🎉</p>
  <p class="footer-small">Created by Happy Mnyimbiri &amp; Chifuniro Chatangwa | Mzuzu University</p>
</footer>

<script src="script.js"></script>
</body>
</html>
