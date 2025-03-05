const email = document.getElementById("email");
const phone = document.getElementById("phoneNumber");
const password = document.getElementById("password");
const signupBtn = document.getElementById("signupBtn");

signupBtn.addEventListener("click", async () => {
    const form = new FormData();

    form.append("email", email.value);
    form.append("phone", phone.value);
    form.append("password", password.value);

    const response = await axios.post(
        "http://localhost/DigitalWallletPlatform/server/user/v1/signup.php",
        form
    );

    if (response.data.status === "success") {
        localStorage.setItem("token", response.data.token);
        window.location.href = "../pages/home.html";
    } else {
        alert("Registration failed");
    }
});
