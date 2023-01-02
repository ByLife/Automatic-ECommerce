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



})