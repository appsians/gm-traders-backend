<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<button id="rzp-button">Pay Now</button>

<script>
    document.getElementById("rzp-button").onclick = function(e){
        e.preventDefault();
        
        const options = {
            key: "rzp_test_RWxDQPLznUuqF9",
            amount: 500 * 100,
            currency: "INR",
            name: "Rabiya Jamil",
            description: "Payment For Testing Purpose",
            image: "",
            handler: function(response){
                alert("Payment Succesfull" + + response.razorpay_payment_id)
            },
            prefill: {
                name: "Rabiya Jamil",
                email: "rabiyajamil@gmail.com",
                contact: "9999999999",
            },
            theme: {
                color: "#3399cc",
            }
        };
        
        const rzp1 = new Razorpay(options);
        // rzp1.open();
       rzp1.on('payment.failed', function (response) {
    alert("Payment Failed!\nReason: " + response.error.description);
});
    };
</script>