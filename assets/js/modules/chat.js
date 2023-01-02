var URL_FETCH = "./api/client/ticket";

request = (method, data) => {
    return fetch(URL_FETCH, {
        method: "POST",
        body: JSON.stringify(data)
    })
}





Main = async () => {
    window.onload = async () => {
        var ticket_id = document.querySelector(".ticket_id").innerHTML;
        var click_button = document.querySelector(".form-input-cursa");
        var close_ticket_button = document.querySelector(".cursa-close-ticket-input");
        var save_button = click_button;
        var spinner = 
                `<div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>`
        
        getOwner(ticket_id).then(ticket_owner => {
            try {
                if(JSON.parse(ticket_owner.owner).status == 0) {
                document.querySelector(".cursa-support-title").innerHTML = JSON.parse(ticket_owner.owner).message
                getMessages(ticket_id, ticket_owner);
                setInterval(async() => await getMessages(ticket_id, ticket_owner), 5000)
                } else {
                    document.querySelector(".cursa-support-title").innerHTML = JSON.parse(ticket_owner.owner).message + " - Closed Ticket";
                }
            } catch (error) {
                document.querySelector(".cursa-support-title").innerHTML = "Closed Ticket"
            }
        })


        close_ticket_button.addEventListener("click", async () => {
            close_ticket_button.disabled = true;
            close_ticket_button.innerHTML = spinner;
            request("POST", {
                action: "close_ticket",
                token: getCookie("token"),
                ticket_id: ticket_id
            }).then(response => {
                response.json().then(data => {
                    if (data.status == "success") {
                        document.querySelector(".cursa-support-title").innerHTML = "Ticket closed";
                    } else {
                        document.querySelector(".cursa-support-title").innerHTML = "Error: " + data.message;
                    }
                })
            }).catch(error => {
                console.log(error);
            })
            close_ticket_button.removeAttribute("disabled");
            close_ticket_button.innerHTML = "";
        })

        
        click_button.addEventListener("click", async () => {
            try {
                click_button.disabled = true;
                click_button.innerHTML = spinner;
                
                let input = document.querySelector(".form-textarea-cursa");
                let value = input.value.replace("\n", "RETURN_DOWN");
                input.value = "";
                var response = await request("POST", {
                    action: "send_message",
                    token: getCookie("token"),
                    message: value,
                    ticket_id: ticket_id
                })
                var data = await response.json();
                if(data.status == "success"){
                    input.value = "";
                    document.querySelector(".form-textarea-cursa").value = "";
                    document.querySelector(".form-textarea-cursa").focus();
                    document.querySelector(".form-textarea-cursa").placeholder = "Message sent";
                    
                } else {
                    document.querySelector(".form-textarea-cursa").placeholder =  "Error: " + data.message;
                }
            } catch (error) {
                console.log(error);
            }
            document.querySelector(".form-input-cursa").removeAttribute("disabled");
            document.querySelector(".form-input-cursa").innerHTML = "Reply";
        })
    }
}

getOwner = async (ticket_id) => {
    var ticket_owner = await request("POST", {
        action: "get_owner",
        ticket_id: ticket_id,
        token: getCookie("token")
        })
    var ticket_owner = await ticket_owner.json();
    return ticket_owner;
}

getMessages = async (ticket_id, ticket_owner) => {
    try {
        var msgs = await request("POST", {
            action: "get_messages",
            ticket_id: ticket_id,
            token: getCookie("token")
            
        })
        var data = await msgs.json();
        if(data.status == "success"){
            if(Old_msgs != data.messages){
            
            document.querySelectorAll(".nk-reply-item").forEach(item => { item.remove() });
            JSON.parse(data.messages).forEach(message => {
                console.log(JSON.parse(ticket_owner.owner).user_mail)
                console.log(document.querySelector(".user-cursa-mail").innerHTML)
                console.log(document.querySelector(".user-cursa-mail").innerHTML == JSON.parse(ticket_owner.owner).user_mail)
                if(JSON.parse(ticket_owner.owner).user_mail == document.querySelector(".user-cursa-mail").innerHTML){ 
                    var reply = `
                    <div class="nk-reply-item">
                        <div class="nk-reply-header">
                            <div class="user-card">
                                <div class="user-avatar sm bg-blue">
                                    <span>${message.id}</span>
                                </div>
                                <div class="user-name">${message.user_name} <span>(You)</span></div>
                            </div>
                            <div class="date-time">${message.created_at}</div>
                        </div>
                        <div class="nk-reply-body">
                            <div class="nk-reply-entry entry">
                                ${message.message}
                            </div>
                            
                        </div>
                    </div>
                    `
                    document.querySelector(".cursa-chatbox").insertAdjacentHTML("beforebegin", reply);
                } else {
                    var reply = `
                    <div class="nk-reply-item">
                        <div class="nk-reply-header">
                            <div class="user-card">
                                <div class="user-avatar sm bg-pink">
                                    <span>${message.id}</span>
                                </div>
                                <div class="user-name">${message.user_name}</div>
                            </div>
                            <div class="date-time">${message.created_at}</div>
                        </div>
                        <div class="nk-reply-body">
                            <div class="nk-reply-entry entry">
                                ${message.message}
                            </div>
                            
                        </div>
                    </div>
                    `
                    document.querySelector(".cursa-chatbox").insertAdjacentHTML("beforebegin", reply);
                }
            })
        }
            var msgs = {}
            var Old_msgs = msgs
        }
    } catch (error) {
        console.log(error);
    }
}

Main()