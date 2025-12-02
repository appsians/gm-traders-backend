<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BGM Traders – Refund Policy</title>
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

/* 🔹 Policy Section */
.policy-section {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 80px 20px 40px;
}

.policy-container {
  background: #fff;
  padding: 40px 30px;
  max-width: 850px;
  border-radius: 15px;
  box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
}

.policy-container h1 {
  text-align: center;
  margin-bottom: 20px;
  font-size: 2rem;
  color: #46d07d;
}

.policy-container h2 {
  margin-top: 25px;
  margin-bottom: 10px;
  font-size: 1.3rem;
  color: #46d07d;
}

.policy-container p,
.policy-container li {
  font-size: 1rem;
  margin-bottom: 15px;
  text-align: justify;
}

.policy-container ul {
  margin-left: 20px;
  margin-bottom: 15px;
}

.policy-container li {
  margin-bottom: 8px;
}

.footer-bottom {
  border-top: 1px solid #333;
  text-align: center;
  color: #777;
  font-size: 14px;
}

/* 🌐 Responsive Design */
@media (max-width: 768px) {
  .policy-container {
    padding: 30px 20px;
  }

  .policy-container h1 {
    font-size: 1.6rem;
  }

  .policy-container p,
  .policy-container li {
    font-size: 0.95rem;
  }

  .back-btn {
    padding: 8px 12px;
    font-size: 14px;
  }
}

@media (max-width: 375px) {
  .policy-container {
    padding: 20px 15px;
  }

  .policy-container h1 {
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

  <!-- 🔹 Policy Section -->
  <section class="policy-section">
    <div class="policy-container">
      <h1>BGM Traders – Refund & Non-Refundable Policy</h1>

      <h2>1. General Policy</h2>
      <p>
        BGM Traders Private Limited values our customers and strives to provide the best quality high-density apple plants and related services.
        This Refund Policy explains the conditions under which payments and bookings are considered refundable or non-refundable.
      </p>

      <h2>2. Booking and Payment</h2>
      <ul>
        <li>Once a booking or order is confirmed through the BGM Traders App, it is treated as a final sale.</li>
        <li>All payments made for bookings, plants, or related services are non-refundable unless stated otherwise.</li>
        <li>Customers are advised to review all details carefully before making any payment.</li>
      </ul>

      <h2>3. Non-Refundable Conditions</h2>
      <ul>
        <li>Cancellation by the customer after booking confirmation will result in no refund.</li>
        <li>If the customer fails to collect plants or services within the specified period, the booking amount will be forfeited.</li>
        <li>Refunds will not be issued for:
          <ul>
            <li>Change of mind</li>
            <li>Incorrect booking details entered by the user</li>
            <li>Delay caused by weather, transportation, or government restrictions</li>
          </ul>
        </li>
      </ul>

      <h2>4. Refund Exceptions</h2>
      <p>
        Refunds may be considered only under special circumstances, such as:
      </p>
      <ul>
        <li>Order cancellation initiated by BGM Traders due to unavailability or operational issues.</li>
        <li>Any duplicate payment made due to a technical error in the app.</li>
      </ul>
      <p>
        In such cases, the refund will be processed to the original payment method within 7–10 working days.
      </p>
    </div>
  </section>

  <div class="footer-bottom">
    © 2025 BGM Traders. All rights reserved.
  </div>

  <script>
    function goBack() {
      window.history.back();
    }
  </script>
</body>
</html>
