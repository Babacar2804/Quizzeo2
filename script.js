function showForm() {
    var form = document.getElementById("creationForm");
    if (form.style.display === "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}
function showPopup(message) {
    alert(message);
}

function generatePassword() {
    var generatedPasswordField = document.getElementById("generatedPassword");
    var password = generateRandomPassword();
    generatedPasswordField.innerText = password;
}

function generateRandomPassword(length = 8) {
    var characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var password = '';
    for (var i = 0; i < length; i++) {
        password += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return password;
}

function showForm() {
    var form = document.getElementById("creationForm");
    form.style.display = "block";
}