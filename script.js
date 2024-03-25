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

function showQCM() {
    document.getElementById('QuizzInput').value = 'qcm';
    const questionDiv = createQuestionDiv('qcm');
    document.getElementById('questionsContainer').appendChild(questionDiv);
}

function showSondage() {
    document.getElementById('QuizzInput').value = 'sondage';
    const questionDiv = createQuestionDiv('sondage');
    document.getElementById('questionsContainer').appendChild(questionDiv);
}
let questionIndex=0;
function createQuestionDiv(type) {
    questionIndex++;

    const questionDiv = document.createElement('div');
    questionDiv.id = 'questionDiv_' + questionIndex;

    const questionLabel = document.createElement('label');
    questionLabel.textContent = 'Question ' + questionIndex + ' :';
    const questionInput = document.createElement('input');
    questionInput.type = 'text';
    questionInput.name = 'questions[]';
    questionInput.required = true;

    questionDiv.appendChild(questionLabel);
    questionDiv.appendChild(questionInput);
    questionDiv.appendChild(document.createElement('br'));

    let reponsesLabels = [];

    if (type === 'qcm') {
        reponsesLabels = ['Bonne réponse:', 'Réponse 2:', 'Réponse 3:'];
    } else if (type === 'sondage') {
        reponsesLabels = ['Réponse 1:', 'Réponse 2:', 'Réponse 3:'];
    }

    for(let i = 0; i < 3; i++) {
        
        
        const reponseInput = document.createElement('input');
        reponseInput.type = 'text';
        reponseInput.name = 'reponses_' + questionIndex + '[]';
        reponseInput.required = true;
        reponseInput.placeholder = reponsesLabels[i];

        questionDiv.appendChild(reponseInput);
        questionDiv.appendChild(document.createElement('br'));
    }

    return questionDiv;
}
