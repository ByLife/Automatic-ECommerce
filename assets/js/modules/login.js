document.addEventListener("DOMContentLoaded", async () => {

    if(getCookie("verified") == 1) {
        document.querySelector(".alert-container").innerHTML =`
        <div class="alert alert-success" role="alert">
        <strong>Success!</strong> Your account has been verified, you can now login.
        </div>
        `;

        setCookie("verified", 0, 1);
    }

    await document.querySelector(".btn-login").addEventListener("click", () => {

        fetch("./api/client/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                user_email: document.querySelector(".user-email").value,
                user_password: document.querySelector(".user-password").value,
            })
        }).then(async (response) => {
            var response = await response.json()
            console.log(response);
            if (response.status == "success") {
                document.querySelector(".alert-container").innerHTML =`
                <div class="alert alert-success" role="alert">
                <strong>Success!</strong> You have been logged in, redirecting...
                </div>
                `;

                setCookie("token", response.user.token, 1);
                setTimeout(() => {
                    window.location.href = "./client/dashboard";
                }, 2000);
            } else {
                document.querySelector(".alert-container").innerHTML =`
                <div class="alert alert-danger" role="alert">
                <strong>Error!</strong> ${response.message}
                </div>
                `;
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
    })
})