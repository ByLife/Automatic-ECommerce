document.addEventListener("DOMContentLoaded", async () => {
    await document.querySelector(".btn-register").addEventListener("click", () => {
        console.log("Registering...")
        fetch("./api/client/register", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                user_email: document.querySelector(".user-mail").value,
                user_password: document.querySelector(".user-password").value,
                user_password_verify: document.querySelector(".user-password-repeat").value,
            })
        }).then(async (response) => {
            var response = await response.json()
            console.log(response);
            if (response.status == "success") {
                document.querySelector(".alert-container").innerHTML =`
                <div class="alert alert-success" role="alert">
                <strong>Success!</strong> Your account has been created, verify your email !
                </div>
                `;
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
});