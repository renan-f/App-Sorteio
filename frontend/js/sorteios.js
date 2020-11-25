window.addEventListener('load', start);
let variaveis = {};
let titleSorteio;
let divForm;
let divAgradecimento;
let btnParticipar;
let btnNovaInscrição;
let nome;
let sobrenome;
let email;
function start() {
    handleSorteio();
    titleSorteio = document.querySelector('#title-sweepstake');
    divForm = document.querySelector('#divForm');
    divAgradecimento = document.querySelector('#divAgradecimento');
    nome = document.querySelector('#first_name');
    sobrenome = document.querySelector('#last_name');
    email = document.querySelector('#email');
    btnParticipar = document.querySelector('#btnParticipar');
    btnParticipar.addEventListener('click', participar);
    btnNovaInscrição = document.querySelector('#btnNovaInscrição');
    btnNovaInscrição.addEventListener('click', handleNovaInscricao);
}

function participar(event) {
    event.preventDefault();
    const participante = {
        "sweepstakes_id": variaveis.id,
        "name": `${nome.value} ${sobrenome.value}`,
        "email": email.value
    }

    enviarParticipante(participante);

}

function handleSorteio() {
    getUrlVars();
    buscarSorteio();
}

function getUrlVars() {
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        variaveis[key] = decodeURIComponent(value);
    });
}

function renderizaSorteio(data) {
    const { description } = data;
    titleSorteio.innerText = description;
    controleDiv(divForm, true);
}

function controleDiv(div, ativo) {
    console.log(div)
    ativo ? div.classList.remove('none') : div.classList.add('none');
}

function buscarSorteio() {
    const api = new XMLHttpRequest();
    const url = `http://localhost:8000/api/sweepstake/${variaveis.id}`;
    console.log(url)
    api.open("GET", url, true);
    api.setRequestHeader("Content-type", "application/json");

    api.send();

    api.onreadystatechange = function () {
        if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
            var data = JSON.parse(api.responseText);
            if (data[0].id) {
                renderizaSorteio(data[0]);
            }
        }
    }
}

function enviarParticipante(participante) {
    const api = new XMLHttpRequest();
    const url = `http://localhost:8000/api/participant`;
    api.open("POST", url, true);
    api.setRequestHeader("Content-type", "application/json");

    console.log(JSON.stringify(participante));
    api.send(JSON.stringify(participante));

    api.onreadystatechange = function () {
        if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
            var data = JSON.parse(api.responseText);
            if (data.id) {
                telaAgradecimento();
            }
        }
    }
}

function telaAgradecimento() {
    clearForm();
    controleDiv(divForm, false);
    controleDiv(divAgradecimento, true);
}

function handleNovaInscricao() {
    controleDiv(divForm, true);
    controleDiv(divAgradecimento, false);
}

function clearForm() {
    Array.from(document.getElementsByTagName('input')).forEach((field) => {
        field.value = '';
        field.classList.remove('valid');
    })
}