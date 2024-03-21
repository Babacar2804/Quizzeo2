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
    var passwordLength = 12; 
    var passwordChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";

    for (var i = 0; i < passwordLength; i++) {
        var randomIndex = Math.floor(Math.random() * passwordChars.length);
        password += passwordChars.charAt(randomIndex);
    }

    document.getElementById("password").value = password;
}