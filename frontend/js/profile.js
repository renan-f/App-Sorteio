if (!localStorage.getItem("id")) {
    window.location.href = "/login.html";
} else {
    window.addEventListener('load', start);
}

let btnSalvar;
let btnExcluir;
let btnSair;
let inputProfileNome;
let inputProfileEmail;
let inputProfilePassword;

function start() {
    btnSair = document.querySelector('#btn-sair');
    btnSair.addEventListener('click', () => {
        localStorage.clear();
        window.location.href = "login.html"
    })
    btnSalvar = document.getElementsByName('btn-salvar')[0];
    btnExcluir = document.getElementsByName('btn-excluir')[0];
    inputProfileNome = document.querySelector('#name-profile');
    inputProfileEmail = document.querySelector('#email-profile');
    inputProfilePassword = document.querySelector('#password-profile');

    btnExcluir.addEventListener('click', clickBtnExcluir);
    btnSalvar.addEventListener('click', clickBtnSalvar);

    loadForm();
}


function clickBtnSalvar(event) {
    event.preventDefault();
    let dados = {
        'name': inputProfileNome.value,
        'email': inputProfileEmail.value,
        'password': inputProfilePassword.value
    }
    salvarUsuario(dados);
}

function clickBtnExcluir(event) {
    event.preventDefault();
    deletarUsuario();
}

function loadForm() {
    inputProfileNome.value = localStorage.getItem("name");
    inputProfileEmail.value = localStorage.getItem("email");
    inputProfilePassword.value = localStorage.getItem("password");
}

function deletarUsuario() {
    const api = new XMLHttpRequest();
    const url = `http://localhost:8000/api/user/${localStorage.getItem("id")}`;
    api.open("DELETE", url, true);
    api.setRequestHeader("Content-type", "application/json");

    api.send();

    api.onreadystatechange = function () {
        if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
            var data = JSON.parse(api.responseText);
            if (data.result) {
                localStorage.clear();
                window.location.href = "/login.html";
            } else { console.log("Erro!") };
            ;
        } else {
            console.log(api.responseText);
        }
    }
}

function salvarUsuario(dados) {
    const api = new XMLHttpRequest();
    const url = `http://localhost:8000/api/user/edit/${localStorage.getItem("id")}`;
    api.open("POST", url, true);
    api.setRequestHeader("Content-type", "application/json");

    api.send(JSON.stringify(dados));

    api.onreadystatechange = function () {
        if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
            var data = JSON.parse(api.responseText);
            if (data.result) {
                localStorage.removeItem('name');
                localStorage.setItem("name", dados.name);
                localStorage.removeItem('email');
                localStorage.setItem("email", dados.email);
                localStorage.removeItem('password');
                localStorage.setItem("password", dados.password);
                window.location.href = "/index.html"
            }
        } else {
            console.log(api.responseText);
        }
    }
}
