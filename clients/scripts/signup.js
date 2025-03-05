const email = document.getElementById("email");
const phone = document.getElementById("phoneNumber");
const password = document.getElementById("password");
const signupBtn = document.getElementById("signupBtn");

signupBtn.addEventListener("click", async () => {
    signupBtn.disabled = true;

    const form = new FormData();
    form.append("email", email.value);
    form.append("phone", phone.value);
    form.append("password", password.value);

    try {
        const response = await axios.post(
            "http://localhost/DigitalWalletPlatform/server/user/v1/signup.php",
            form,
            {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }
        );

        if (response.data.status === "success") {
            localStorage.setItem("token", response.data.token);
            window.location.href = "../pages/home.html";
        } else {
            alert("Registration failed: " + (response.data.message));
        }
    } catch (error) {
        console.error("Error during registration:", error);
        alert("Network error. Please try again.");
    } finally {

        signupBtn.disabled = false;
    }
});