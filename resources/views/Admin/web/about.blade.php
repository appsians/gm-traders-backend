@extend('web.app')
@section('contant')<!DOCTYPE html>
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
      <h1>About BGM Traders</h1>
      <p>
        <strong>BGM Traders Private Limited</strong>, headquartered in the heart of Kashmir, is a progressive agribusiness company
        dedicated to transforming the region’s horticulture sector through innovation, technology, and sustainable practices.
      </p>
      <p>
        We specialize in <strong>High-Density Apple Orchards, Trellis Systems, Drip Irrigation Solutions,</strong> and
        <strong>Smart Mandi Integration</strong>, empowering farmers with the tools and knowledge to maximize productivity and profitability.
      </p>

      <h2>Our Founders</h2>
      <ul>
        <li><strong>Mr. Sadam Hussain Bhat – Director:</strong> Visionary entrepreneur and agricultural innovator, leading the mission to modernize apple farming in Kashmir.</li>
        <li><strong>Mr. Shahid Ahmad Bhat – Shareholder:</strong> Contributing to the company’s growth with strategic insights and business development expertise.</li>
        <li><strong>Mr. Nisar Ahmad Bhat – Shareholder:</strong> Bringing years of experience in horticulture and local farming practices to ensure quality and reliability.</li>
      </ul>

      <h2>Our Core Offerings</h2>
      <ul>
        <li>🌳 <strong>High-Density Apple Plants:</strong> Premium, disease-free varieties ideal for Kashmir’s climate.</li>
        <li>💧 <strong>Drip & Micro Irrigation Systems:</strong> Efficient water-saving solutions for modern farms.</li>
        <li>🧱 <strong>Trellis Systems:</strong> Durable infrastructure to support high-density plantations.</li>
        <li>📱 <strong>Smart Mandi / e-Mandi:</strong> A digital marketplace connecting Kashmiri growers directly with buyers across India.</li>
        <li>🤖 <strong>AI Crop Doctor:</strong> Smart AI tool that identifies plant diseases and offers instant treatment suggestions.</li>
      </ul>

      <h2>Our Vision</h2>
      <p>
        To make Kashmir a leader in modern horticulture by combining traditional expertise with world-class agricultural innovation.
      </p>

      <h2>Our Mission</h2>
      <p>
        To empower farmers through modern farming techniques, sustainable practices, and digital market access — ensuring long-term prosperity for Kashmir’s horticulture community.
      </p>

      <h2>Why Choose Us</h2>
      <ul>
        <li>✅ Locally rooted, globally inspired</li>
        <li>✅ Expert orchard planning and technical support</li>
        <li>✅ Transparent and farmer-friendly approach</li>
        <li>✅ Committed to quality, growth, and sustainability</li>
      </ul>
    </div>

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
@endsection
