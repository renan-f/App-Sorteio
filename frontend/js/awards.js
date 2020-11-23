if (!localStorage.getItem("id")) {
    window.location.href = "/login.html";
} else {
    window.addEventListener('load', start);
}

let btnSair;
let btnSalvar;
let btnCancelar;
let btnEditAlterar;
let btnEditDeletar;
let btnEditCancelar;
var instance;
let inputNameAward;
let inputImageAward;
let divAwards;
let editInputNameAward;
let editInputImageAward;
let editInputIdAward;

function start() {
    btnSair = document.querySelector('#btn-sair');
    btnSair.addEventListener('click', () => {
        localStorage.clear();
        window.location.href = "login.html"
    });
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, {});

    btnSalvar = document.querySelector('#btn-salvar');
    btnSalvar.addEventListener('click', clickBtnSalvar);
    btnCancelar = document.querySelector('#btn-cancelar');
    btnCancelar.addEventListener('click', clickBtnCancelar);
    divAwards = document.querySelector('#div-awards');

    inputNameAward = document.querySelector('#award-name');
    inputImageAward = document.querySelector('#award-image');

    editInputNameAward = document.querySelector('#award-edit-name');
    editInputImageAward = document.querySelector('#award-edit-image');
    editInputIdAward = document.querySelector('#award-edit-id');

    btnEditAlterar = document.querySelector('#btn-edit-alterar');
    btnEditAlterar.addEventListener('click', clickBtnAlterar);
    btnEditCancelar = document.querySelector('#btn-edit-cancelar');
    btnEditCancelar.addEventListener('click', clickBtnCancelar);
    btnEditDeletar = document.querySelector('#btn-edit-deletar');
    btnEditDeletar.addEventListener('click', clickBtnDeletar);

    awardsForUser();
}

function clickBtnSalvar(event) {
    event.preventDefault();
    let dados = {
        "user_id": localStorage.getItem('id'),
        "name": inputNameAward.value,
        "image": inputImageAward.value
    }
    salvar(dados);
}

function clickBtnAlterar(event) {
    event.preventDefault();
    let dados = {
        "id": editInputIdAward.value,
        "name": editInputNameAward.value,
        "image": editInputImageAward.value
    };

    alterar(dados);
}

function clickBtnDeletar(event) {
    event.preventDefault();
    let dados = {
        "id": editInputIdAward.value,
    };

    deletar(dados);
}

function clickBtnCancelar(event) {
    event.preventDefault();
}

function renderizaAwards(dados) {

    const awards = Array.from(dados);
    divAwards.innerText = '';

    awards.forEach((award) => {
        let divPai = document.createElement('div');
        divPai.setAttribute('class', 'col s12 m8 offset-m2 l6 offset-l3');

        let divCard = document.createElement('div');
        divCard.setAttribute('class', 'card-panel grey lighten-5 z-depth-1');

        let divCardContent = document.createElement('div');
        divCardContent.setAttribute('class', 'row valign-wrapper');

        let divCardContentImage = document.createElement('div');
        divCardContentImage.setAttribute('class', 'col s2');

        let imgCard = document.createElement('img');
        imgCard.setAttribute('class', 'circle responsive-img');
        imgCard.setAttribute('src', award.image);

        let divCardContentText = document.createElement('div');
        divCardContentText.setAttribute('class', 'col s10');

        let spanTextCard = document.createElement('div');
        spanTextCard.setAttribute('class', 'black-text');
        spanTextCard.textContent = award.name;

        let divActions = document.createElement('div');
        divActions.setAttribute('class', 'col s12');

        let inputId = document.createElement('input');
        inputId.setAttribute('type', 'hidden');
        inputId.setAttribute('name', 'award.id');
        inputId.value = award.id;

        let iconOptionsAward = document.createElement('i');
        iconOptionsAward.setAttribute('class', 'material-icons');
        iconOptionsAward.textContent = 'edit';

        let linkOptionsAward = document.createElement('a');
        linkOptionsAward.setAttribute('href', "#modal2");
        linkOptionsAward.setAttribute('class', 'btn-floating  waves-effect waves-light green modal-trigger');
        linkOptionsAward.addEventListener('click', setValuesOnEditModal);

        linkOptionsAward.appendChild(iconOptionsAward);
        divCardContentImage.appendChild(imgCard);
        divCardContentText.appendChild(spanTextCard);
        divCardContent.appendChild(divCardContentImage);
        divCardContent.appendChild(divCardContentText);
        divCardContent.appendChild(inputId);
        divCardContent.appendChild(linkOptionsAward);
        divCard.appendChild(divCardContent);
        divPai.appendChild(divCard);
        divAwards.appendChild(divPai);
    });
}

function setValuesOnEditModal(event) {
    let dadosAward = {
        "id": event.target.parentNode.parentNode.children[2].value,
        "name": event.target.parentNode.parentNode.children[1].children[0].innerText,
        "image": event.target.parentNode.parentNode.children[0].children[0].getAttribute('src')
    }

    editInputIdAward.value = dadosAward.id;
    editInputImageAward.value = dadosAward.image;
    editInputNameAward.value = dadosAward.name;
}

function salvar(dados) {
    const api = new XMLHttpRequest();
    const url = "http://localhost:8000/api/award";
    api.open("POST", url, true);
    api.setRequestHeader("Content-type", "application/json");

    api.send(JSON.stringify(dados));

    api.onreadystatechange = function () {
        if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
            var data = JSON.parse(api.responseText);
            if (data.id) {
                awardsForUser();
            }
        } else {
            console.log(api.responseText);
        }
    }
}

function alterar(dados) {
    const api = new XMLHttpRequest();
    const url = "http://localhost:8000/api/award/";
    const award = dados.id;

    const editDados = {
        "user_id": localStorage.getItem('id'),
        "name": dados.name,
        "image": dados.image
    }
    api.open("POST", `${url}${award}`, true);
    api.setRequestHeader("Content-type", "application/json");

    api.send(JSON.stringify(editDados));

    api.onreadystatechange = function () {
        if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
            var data = JSON.parse(api.responseText);
            if (data.result) {
                awardsForUser();
            }
        } else {
            console.log(api.responseText);
        }
    }
}

function deletar(dados) {
    const api = new XMLHttpRequest();
    const url = "http://localhost:8000/api/award/";
    const award = dados.id;

    api.open("DELETE", `${url}${award}`, true);

    api.setRequestHeader("Content-type", "application/json");

    api.send();

    api.onreadystatechange = function () {
        if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
            var data = JSON.parse(api.responseText);
            if (data.result) {
                awardsForUser();
            }
        } else {
            console.log(api.responseText);
        }
    }
}

function awardsForUser() {
    const api = new XMLHttpRequest();
    const url = `http://localhost:8000/api/awards/user/${localStorage.getItem('id')}`;
    api.open("GET", url, true);
    api.setRequestHeader("Content-type", "application/json");
    api.send();

    api.onreadystatechange = function () {
        if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
            var data = JSON.parse(api.responseText);
            if (data.length > 0) {
                renderizaAwards(data);
            }
        }
    }
}