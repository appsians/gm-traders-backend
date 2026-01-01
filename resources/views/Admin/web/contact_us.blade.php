<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About BGM Traders</title>
  <style>
    /* Global styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Inter", sans-serif;
  background: #f8f9fa;
  color: #222;
  line-height: 1.6;
  overflow-x: hidden;
}

/* 🔙 Back Button */
.back-btn {
  position: absolute;
  top: 20px;
  left: 20px;
  background: #f8f9fa;
  color: #000;
  border: none;
  padding: 10px 16px;
  border-radius: 8px;
  font-size: 16px;
  cursor: pointer;
  transition: background 0.3s ease;
  z-index: 10;
}

.back-btn:hover {
  background: #46d07d;
}

/* 🔹 About Section */
.about-section {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 80px 20px 40px;
}

.about-container {
  background: #fff;
  padding: 40px 30px;
  max-width: 850px;
  border-radius: 15px;
  box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
}

.about-container h1 {
  text-align: center;
  margin-bottom: 20px;
  font-size: 2rem;
  color: #46d07d;
}

.about-container h2 {
  margin-top: 25px;
  margin-bottom: 10px;
  font-size: 1.3rem;
  color: #46d07d;
}

.about-container p {
  font-size: 1rem;
  margin-bottom: 15px;
  text-align: justify;
}

.about-container ul {
  margin-left: 20px;
  margin-bottom: 15px;
}

.about-container li {
  margin-bottom: 8px;
  font-size: 1rem;
}
.footer-bottom {
      border-top: 1px solid #333;
      text-align: center;
      color: #777;
      font-size: 14px;
    }

/* 🌐 Responsive Design */
@media (max-width: 768px) {
  .about-container {
    padding: 30px 20px;
  }

  .about-container h1 {
    font-size: 1.6rem;
  }

  .about-container p,
  .about-container li {
    font-size: 0.95rem;
  }

  .back-btn {
    padding: 8px 12px;
    font-size: 14px;
  }
}

@media (max-width: 375px) {
  .about-container {
    padding: 20px 15px;
  }

  .about-container h1 {
    font-size: 1.4rem;
  }

  .back-btn {
    top: 15px;
    left: 15px;
  }
}

  </style>

</head>
<body>
  <!-- 🔙 Back Button -->
  <button class="back-btn" onclick="goBack()">
    &#8592; Back
  </button>

  <!-- 🔹 About Section -->
  <section class="about-section">
    <div class="about-container">
      <h1>Contact Us</h1>
<p>
  If you have any questions about this Privacy Policy or our refund terms, please reach out to us:
</p>
<p>
  BGM Traders Private Limited<br>
  Main market Zainapora Shopian<br>
  District Shopian, Jammu & Kashmir – 192303
</p>
<p>
  📧 bismillahgmtraders@gmail.com<br>
  📞 ‪+91 9682617311‬ / ‪+91 7006846090‬
</p>

  </section>
   <div class="footer-bottom ">
        © 2025 YourCompany. All rights reserved.
   </div>

  <script>
    function goBack() {
      window.history.back();
    }
  </script>
</body>
</html>
