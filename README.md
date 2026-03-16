# 🎉 Birthday Website — Joseph Mphimba
**Created by Happy Mnyimbiri | BICT – Mzuzu University**

---

## 📁 Project Structure

```
birthday-website/
├── index.php          ← Main page
├── style.css          ← All styles (glassmorphism, animations)
├── script.js          ← Confetti, slideshow, AJAX, music
├── database.php       ← PDO database connection
├── comment.php        ← AJAX: save & return comments
├── like.php           ← AJAX: like/dislike reactions
├── view.php           ← View counter endpoint
├── setup.sql          ← Database setup script
├── README.md          ← This file
├── images/
│   ├── Joseph1.jpeg
│   ├── Joseph2.jpeg
│   ├── Joseph3.jpeg
│   └── Joseph4.jpeg
└── music/
    └── Joseph.mp3
```

---

## ⚙️ Setup Instructions (XAMPP)

### Step 1 — Install XAMPP
Download and install XAMPP from https://www.apachefriends.org/

### Step 2 — Copy Project Files
Copy the entire `birthday-website/` folder to:
```
C:\xampp\htdocs\birthday-website\
```

### Step 3 — Add Your Media Files
- Place your 4 photos into: `images/` (named Joseph1.jpeg through Joseph4.jpeg)
- Place the birthday song into: `music/` (named Joseph.mp3)

### Step 4 — Set Up the Database
1. Start XAMPP → click **Start** for **Apache** and **MySQL**
2. Open your browser and go to: http://localhost/phpmyadmin
3. Click **SQL** tab at the top
4. Open the file `setup.sql` from the project folder
5. Copy and paste all the SQL into the box
6. Click **Go** to run it
7. You should see: `Database setup complete!`

### Step 5 — Run the Website
Open your browser and go to:
```
http://localhost/birthday-website/
```

---

## 🔧 Configuration

If your MySQL password is not empty, update `database.php`:
```php
define('DB_PASS', 'your_mysql_password');
```

---

## ✨ Features

| Feature | Description |
|---|---|
| 🎉 Hero Banner | Animated gradient, floating balloons, confetti |
| 📸 Photo Slideshow | Auto-advancing carousel with 4 photos |
| 🎵 Background Music | Autoplay birthday song with pause/play |
| 👍 Like/Dislike | AJAX-powered reaction buttons with animation |
| 💌 Message Board | Submit & view birthday wishes in real time |
| 👀 View Counter | Live count of page visitors |
| 📣 Share Buttons | WhatsApp, Facebook, Twitter/X |
| 🎊 Confetti | Canvas-based falling confetti effect |
| 📱 Responsive | Works on all devices |

---

## 🛠 Technologies Used

- PHP 8+ (backend logic, AJAX endpoints)
- MySQL (data storage via PDO)
- HTML5 + CSS3 (glassmorphism, animations)
- JavaScript ES6 (confetti, slideshow, AJAX)
- Font Awesome 6 (icons)
- Google Fonts (Abril Fatface, Playfair Display, DM Sans)

---

## 📞 Author Contact

**Happy Mnyimbiri**  
BICT — Mzuzu University  
📱 0990681741  
📧 happymw.247@yahoo.com
