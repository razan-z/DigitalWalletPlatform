const email = document.getElementById("email");
const phone = document.getElementById("phoneNumber");
const password = document.getElementById("password");
const loginBtn = document.getElementById("loginBtn");

loginBtn.addEventListener("click", async () => {
    const form = new FormData();

    form.append("email", email.value);
    form.append("phone", phone.value);
    form.append("password", password.value);

    const response = await axios.post(
        "http://localhost/DigitalWalletPlatform/server/user/v1/login.php",
        form
    );

    if (response.data.message === "success") {
        localStorage.setItem("token", response.data.token);
        window.location.href = "../pages/home.html";
    } else {
        alert("Login failed");
    }
})