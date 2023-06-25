function addQuestion() {
    let questions = document.getElementById("questions");
    questions.innerText = "";

    var numQuestions = document.getElementById("num-questions").value;
    var questionsDiv = document.getElementById("questions");

    for (var i = 1; i <= numQuestions; i++) {
        var questionDiv = document.createElement("div");
        questionDiv.innerHTML = "<h2>Pergunta " + i + ":</h2>" +
            "<label>Pergunta:</label>" +
            "<input type='text' name='pergunta" + i + "' required>" +
            "<br>" +
            "<label>Resposta correta:</label>" +
            "<input type='text' name='resposta-correta" + i + "' required>" +
            "<br>" +
            "<label>Resposta errada 1:</label>" +
            "<input type='text' name='resposta-errada1-" + i + "' required>" +
            "<br>" +
            "<label>Resposta errada 2:</label>" +
            "<input type='text' name='resposta-errada2-" + i + "' required>" +
            "<br>";

        questionsDiv.appendChild(questionDiv);
    }
}

function saveQuiz() {
var form = document.getElementById("quizForm");
var formData = new FormData(form);

var numQuestions = parseInt(formData.get("num-questions"));

var quizQuestions = []; // Crie um array vazio para armazenar as perguntas

for (var i = 1; i <= numQuestions; i++) {
var question = {
    pergunta: formData.get("pergunta" + i),
    A: formData.get("resposta-correta" + i),
    B: formData.get("resposta-errada1-" + i),
    C: formData.get("resposta-errada2-" + i)
};

quizQuestions.push(question);
}

// Crie elementos HTML dinamicamente para exibir as perguntas e opções
var outputDiv = document.getElementById("quizOutput");

for (var i = 0; i < quizQuestions.length; i++) {
var question = quizQuestions[i];

// Crie um elemento de parágrafo para exibir a pergunta
var questionPara = document.createElement("p");
questionPara.textContent = "Pergunta " + (i + 1) + ": " + question.pergunta;
outputDiv.appendChild(questionPara);

// Crie radio buttons para as opções A, B e C
var optionA = createRadioButton(question.A, "pergunta" + i, "A");
var optionB = createRadioButton(question.B, "pergunta" + i, "B");
var optionC = createRadioButton(question.C, "pergunta" + i, "C");

// Adicione os radio buttons ao elemento de saída
outputDiv.appendChild(optionA);
outputDiv.appendChild(optionB);
outputDiv.appendChild(optionC);
form.reset();
}
localStorage.setItem("quizQuestions", JSON.stringify(quizQuestions));
window.location.href = "perguntas.html";
}

// Função auxiliar para criar um radio button com rótulo
function createRadioButton(label, name, value) {
var radioButton = document.createElement("input");
radioButton.type = "radio";
radioButton.name = name;
radioButton.value = value;

var labelElement = document.createElement("label");
labelElement.textContent = label;
labelElement.appendChild(radioButton);

return labelElement;
}