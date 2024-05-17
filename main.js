document.addEventListener('DOMContentLoaded', function() {
    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const message = document.getElementById("message");

    emailjs.init("7sry94AwFT6Vm6s92");

    function submitMessage() {
        let templateParams = {
            to_name: "Simple Coding Tutorials",
            from_name: name.value,
            from_email: email.value,
            message: message.value
        };

        emailjs.send("service_ry8ebat", "template_xgaz6pn", templateParams)
            .then(function(response) {
                showAlert("Message sent successfully!");
                name.value = "";
                email.value = "";
                message.value = "";
            }, function(error) {
                showAlert("Failed to send message!");
            });
    }

    function showAlert(message) {
        const alert = document.getElementById("alert");
        alert.innerHTML = message;
        alert.style.display = "flex";
        setTimeout(function() {
            alert.style.display = "none";
        }, 3000);
    }

    document.getElementById("submit").addEventListener("click", submitMessage);
});


