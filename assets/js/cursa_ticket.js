var URL_FETCH = "./modules/user_ticket.php";

request = (data) => {
    return fetch(URL_FETCH, {
        method: "POST",
        body: JSON.stringify(data)
    })
}





Main = async () => {
    window.onload = async () => {
        var button_send = document.querySelector(".cursa-input-create-ticket");
        

        var Spinner =
                `<div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>`

        button_send.addEventListener("click", async () => {
            var ticket_subject = document.querySelector(".textarea-cursa-ticket-subject").value;
            button_send.disabled = true;
            document.querySelector(".cursa-input-create-ticket").innerHTML = Spinner;
            document.querySelector(".textarea-cursa-ticket-subject").value = "";
            request({
                action: "create_ticket",
                subject: ticket_subject,
            }).then(response => {
                response.json().then(data => {
                    if (data.status == "success") {
                        document.querySelector(".textarea-cursa-ticket-subject").placeholder = "Ticket created";
                    } else {
                        document.querySelector(".textarea-cursa-ticket-subject").placeholder = "Error: " + data.message;
                    }
                })
            }).catch(error => {
                console.log(error);
            })
            button_send.removeAttribute("disabled");
            button_send.innerHTML = "";
        })
    }
}

Main()