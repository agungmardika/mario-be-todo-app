document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const toggleSidebar = document.getElementById("toggleSidebar");
    const mainContent = document.querySelector(".main-content");

    // Fungsi untuk menggeser Sidebar
    toggleSidebar?.addEventListener("click", function () {
        sidebar?.classList.toggle("closed");
        mainContent?.classList.toggle("expanded");
    });

    // Tombol Logout
    const logoutButton = document.getElementById("logoutButton");
    const logoutForm = document.getElementById("logout-form");

    logoutButton?.addEventListener("click", function () {
        if (confirm("Apakah Anda yakin ingin keluar?")) {
            logoutForm.submit();
        }
    });

    // Validasi Form Login
    const loginForm = document.getElementById("loginForm");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");

    loginForm?.addEventListener("submit", function (event) {
        const email = emailInput?.value.trim();
        const password = passwordInput?.value.trim();
        let isValid = true;

        if (!email || !validateEmail(email)) {
            showError(emailInput, "Email tidak valid");
            isValid = false;
        } else {
            clearError(emailInput);
        }

        if (!password || password.length < 6) {
            showError(passwordInput, "Password harus minimal 6 karakter");
            isValid = false;
        } else {
            clearError(passwordInput);
        }

        if (!isValid) {
            event.preventDefault(); // Mencegah pengiriman form jika tidak valid
        }
    });

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function showError(input, message) {
        const parent = input?.parentElement;
        if (parent) {
            let error = parent.querySelector(".error-message");
            if (!error) {
                error = document.createElement("div");
                error.className = "error-message";
                parent.appendChild(error);
            }
            error.textContent = message;
        }
    }

    function clearError(input) {
        const parent = input?.parentElement;
        const error = parent?.querySelector(".error-message");
        if (error) {
            error.remove();
        }
    }
});
