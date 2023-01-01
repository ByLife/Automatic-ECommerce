document.addEventListener("DOMContentLoaded", async () => {
    function getValueAtIndex(index){
        return window.location.href.split("/")[index];
    }

    await document.querySelector(".btn-reset").addEventListener("click", () => {
            fetch("./api/client/reset", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    type: "reset",
                    user_email: document.querySelector(".user-email").value,
                })
            }).then(async (response) => {
                var response = await response.json()
                console.log(response);
                if (response.status == "success") {
                    document.querySelector(".alert-container").innerHTML =`
                    <div class="alert alert-success" role="alert">
                    <strong>Success!</strong> An email has been sent !
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