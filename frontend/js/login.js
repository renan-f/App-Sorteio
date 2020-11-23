if (localStorage.getItem("id")) {
    window.location.href = "/index.html";
}


let btnLogin;
let btnCriarConta;
let btnCadastrar;
let btnVoltar;
let divLogin;
let divCadastro;
let inputLoginEmail;
let inputLoginPassword;
let inputCadastroNome;
let inputCadastroEmail;
let inputCadastroPassword;


window.addEventListener('load', () => {
    btnLogin = document.getElementsByName('btn-login')[0];
    btnCriarConta = document.getElementsByName('btn-criar-conta')[0];

    btnCadastrar = document.getElementsByName('btn-cadastrar')[0];
    btnVoltar = document.getElementsByName('btn-voltar')[0];

    divLogin = document.querySelector('#card-login');
    btnLogin.addEventListener('click', clickBtnLogin);
    divCadastro = document.querySelector('#card-cadastro');
    btnCriarConta.addEventListener('click', clickBtnCriarConta);

    btnCadastrar.addEventListener('click', clickBtnCadastrar);
    btnVoltar.addEventListener('click', clickBtnVoltar);

    inputLoginEmail = document.querySelector('#email-login');
    inputLoginPassword = document.querySelector('#password-login');

    inputCadastroNome = document.querySelector('#name-cadastro');
    inputCadastroEmail = document.querySelector('#email-cadastro');
    inputCadastroPassword = document.querySelector('#password-cadastro');
});

function clickBtnLogin(event) {
    event.preventDefault();
    let dados = {
        "email": inputLoginEmail.value,
        "password": inputLoginPassword.value
    }
    login(dados);
}

function clickBtnCadastrar(event) {
    event.preventDefault();
    let dados = {
        "name": inputCadastroNome.value,
        "email": inputCadastroEmail.value,
        "password": inputCadastroPassword.value
    }
    cadastrar(dados);
}

function controleDiv() {
    divCadastro.classList.toggle('none');
    divLogin.classList.toggle('none');
}

function clickBtnCriarConta(event) {
    event.preventDefault();
    controleDiv();
}

function clickBtnVoltar(event) {
    event.preventDefault();
    controleDiv();
}

function cadastrar(dados) {
    const api = new XMLHttpRequest();
    const url = "http://localhost:8000/api/user"
    api.open("POST", url, true);
    api.setRequestHeader("Content-type", "application/json");

    api.send(JSON.stringify(dados));

    api.onreadystatechange = function () {
        if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
            var data = JSON.parse(api.responseText);
            if (data.id) {
                localStorage.setItem("id", data.id);
                localStorage.setItem("name", data.name);
                localStorage.setItem("email", data.email);
                localStorage.setItem("password", data.password);
                window.location.href = "/index.html"
            } else { console.log("Erro!") };
            ;
        } else {
            console.log(api.responseText);
        }
    }
}

function login(dados) {
    const api = new XMLHttpRequest();
    const url = "http://localhost:8000/api/user/login"
    api.open("POST", url, true);
    api.setRequestHeader("Content-type", "application/json");

    api.send(JSON.stringify(dados));

    api.onreadystatechange = function () {
        if (api.readyState == 4 && api.status == 200) {
            var data = JSON.parse(api.responseText);
            if (data.id) {
                localStorage.setItem("id", data.id);
                localStorage.setItem("name", data.name);
                localStorage.setItem("email", data.email);
                window.location.href = "/index.html";
            } else {
                controleDiv();
                console.log(data)
            }
        } else {
            console.log("Erro!");
        }
    }
}

