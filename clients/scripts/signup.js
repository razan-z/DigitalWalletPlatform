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
                    "Content-Type": "multipart/form-data", // Ensure correct content type
                },
            }
        );

        // Handle the response
        if (response.data.status === "success") {
            localStorage.setItem("token", response.data.token);
            window.location.href = "../pages/home.html";
        } else {
            alert("Registration failed: " + (response.data.message || "Unknown error"));
        }
    } catch (error) {
        console.error("Error during registration:", error);
        alert("Network error. Please try again.");
    } finally {
        // Re-enable the button after the request completes
        signupBtn.disabled = false;
    }
});