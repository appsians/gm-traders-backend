<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Pay with Razorpay</title>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body style="text-align:center; padding-top:50px;">

  <h2>Pay ₹{{ $data['amount'] / 100 }}</h2>
  <button id="rzp-button1" style="padding:10px 25px; background:#3399cc; color:#fff; border:none; border-radius:5px;">Pay Now</button>

  <script>
    document.getElementById('rzp-button1').onclick = function(e) {
        e.preventDefault();

        var options = {
            key: "{{ $data['key'] }}",
            amount: "{{ $data['amount'] }}",
            currency: "{{ $data['currency'] }}",
            name: "BGM Traders",
            description: "Test Transaction",
            order_id: "{{ $data['order_id'] }}",

            handler: function (response) {
                fetch("/verify-payment", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
                    },
                    body: JSON.stringify({
                        razorpay_payment_id: response.razorpay_payment_id,
                        order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    console.log(data);
                })
                .catch(err => console.error(err));
            },
            theme: { color: "#3399cc" }
        };


        var rzp1 = new Razorpay(options);
        rzp1.open();
    }
  </script>

</body>
</html>
