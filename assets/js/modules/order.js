document.addEventListener("DOMContentLoaded", async () => {
    function checkCardNumber(cardNumber) {
        var regex = new RegExp("^[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}$");
        if (!regex.test(cardNumber)) {
            return false;
        }
        return true;
    }

    function checkCardExpiryDate(cardExpiryDate) {
        var regex = new RegExp("^[0-9]{2}/[0-9]{2}$");
        if (!regex.test(cardExpiryDate)) {
            return false;
        }
        return true;
    }

    function checkCardCVV(cardCVV) {
        var regex = new RegExp("^[0-9]{3}$");
        if (!regex.test(cardCVV)) {
            return false;
        }
        return true;
    }

    function checkCardHolderName(cardHolderName) {
        var regex = new RegExp("^[A-Za-z ]+$");
        if (!regex.test(cardHolderName)) {
            return false;
        }
        return true;
    }

    document.querySelectorAll('.btn-order').forEach((button) => {
        button.addEventListener('click', async (e) => {
            e.preventDefault()
            try {
                
                const cardNumber = document.querySelector(`.src-card-num-${e.target.value}`).value
                const cardExpiryDate = document.querySelector(`.src-card-exp-${e.target.value}`).value
                const cardCVV = document.querySelector(`.srv-cvv-${e.target.value}`).value
                const cardHolderName = document.querySelector(`.srv-fullname-${e.target.value}`).value
                if (!checkCardNumber(cardNumber)) {
                    document.querySelector('.alert-container').innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Card number is not valid
                        </div>
                    `
                    return
                }
                if (!checkCardExpiryDate(cardExpiryDate)) {
                    document.querySelector('.alert-container').innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Card expiry date is not valid
                        </div>
                    `
                    return
                }
                if (!checkCardCVV(cardCVV)) {
                    document.querySelector('.alert-container').innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Card CVV is not valid
                        </div>
                    `
                    return
                }
                if (!checkCardHolderName(cardHolderName)) {
                    document.querySelector('.alert-container').innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Card holder name is not valid
                        </div>
                    `
                    return
                }
                const response = await fetch("./api/client/order", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        token: getCookie('token'),
                        card_number: cardNumber,
                        card_expiry_date: cardExpiryDate,
                        card_cvv: cardCVV,
                        card_holder_name: cardHolderName,
                        product_id: e.target.value,
                        type: 'place',
                    }),
                })
                const data = await response.json()
                if (data.status == 'success') {
                    document.querySelector('.alert-container').innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Order placed, redirecting to dashboard...
                        </div>
                    `
                    setTimeout(() => {
                        window.location.href = './client/dashboard'
                    }, 2000)
                } else {
                    alert(data.message)
                }
            } catch (e) {
                console.log(e)
            }
        })
    })
})