document.addEventListener("DOMContentLoaded", async () => {
    function getValueAtIndex(index){
        return window.location.href.split("/")[index];
    }
    var userModal = {
        user_id: 0,
        user_token: "",
    }

    userModal.user_id = getValueAtIndex(5);
    userModal.user_token = getValueAtIndex(6);


    await document.querySelector(".btn-reset").addEventListener("click", () => {
        if (document.querySelector(".user-password").value == document.querySelector(".user-password-confirm").value) {

            $userReset = {
                type: "reset_pass",
                user_id: userModal.user_id,
                token: userModal.user_token,
                user_password: document.querySelector(".user-password").value,
            }
            fetch("./api/client/reset", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify($userReset),
            }).then(async (response) => {
                console.log(response);
                var response = await response.json()
                if (response.status == "success") {
                    document.querySelector(".alert-container").innerHTML =`
                    <div class="alert alert-success" role="alert">
                    <strong>Success!</strong> Your password has been reset, you can now login.
                    </div>
                    `;
                    setTimeout(() => {
                        window.location.href = "./login";
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
        } else {
            document.querySelector(".alert-container").innerHTML =`
            <div class="alert alert-danger" role="alert">
            <strong>Error!</strong> Passwords do not match.
            </div>
            `;
        }
    })

    
});