if (!localStorage.getItem("id")) {
    window.location.href = "/login.html";
} else {
    window.addEventListener('load', start);
}

let loading;
let btnSair;
let btnSalvar;
let btnCancelar;
let divSorteios;
let btnNovo;
let divModal;
let divSelectProdutos;

function start() {
    divSorteios = document.querySelector('#div-sorteios');
    btnSair = document.querySelector('#btn-sair');
    btnSair.addEventListener('click', () => {
        localStorage.clear();
        window.location.href = "login.html"
    });

    loading = document.querySelectorAll('.progress')[0];

    btnCancelar = document.querySelector('#btn-cancelar');
    btnCancelar.addEventListener('click', btnClickCancelar)
    btnSalvar = document.querySelector('#btn-salvar');
    btnSalvar.addEventListener('click', btnClickSalvar);
    btnNovo = document.querySelectorAll('.modal-trigger')[0];

    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, {});

    divModal = document.querySelector("#modal1");
    divSelectProdutos = document.querySelector(".div-select-produtos");

    getSorteios();
    awardsForUser();
}

function controleLoading(state) {
    state ? loading.classList.remove('none') : loading.classList.add('none');
}

function btnClickCancelar(event) {
    event.preventDefault();
}

function btnClickSalvar(event) {
    event.preventDefault();
    controleLoading(true);
    const sweepstake = {
        "user_id": localStorage.getItem("id"),
        "description": event.target.form[0].value
    }

    const fields = Array.from(event.target.form);
    const awardsChecked = [];
    fields.forEach((field) => {
        if (field.type == "checkbox" && field.checked) {
            awardsChecked.push(field.id);
        }
    });
    salvarSweepstake(sweepstake, awardsChecked);
    clearFields(fields);
}

function clickBtnSortear(event) {
    const idcomposto = event.target.parentNode.parentNode.parentNode.getAttribute('id');
    const splitId = idcomposto.split('-');
    const award_id = splitId[0];
    const sweepstake_id = splitId[1];
    salvarResultAwardSweepstake(sweepstake_id, award_id);
}

function handleSorteios(dadosSorteio) {
    controleLoading(true);
    const sorteios = Array.from(dadosSorteio);

    divSorteios.innerHTML = '';
    sorteios.forEach((sorteio) => {
        let divpai = document.createElement('div');
        divpai.setAttribute('class', 'col s12 center-align');

        let h3 = document.createElement('h3');
        h3.setAttribute('class', 'header center-align');
        h3.setAttribute('style', 'padding : 5px;');
        h3.textContent = sorteio.description;

        let divProduto = document.createElement('div');
        divpai.setAttribute('class', 'card hoverable');

        let inputHiden = document.createElement('input');
        inputHiden.type = 'hidden';
        inputHiden.setAttribute('id', `sweepstake-${sorteio.id}`);
        inputHiden.value = sorteio.id;

        renderizaBotaoLinkSorteio(sorteio.id, divpai);

        divpai.appendChild(h3);
        divpai.appendChild(inputHiden);
        divpai.appendChild(divProduto);
        divSorteios.appendChild(divpai);

        const { awards } = sorteio;
        awards.forEach((award) => {
            renderizaPremiosNoSorteio(award, divProduto);
            const { results } = award;
            renderizaGanhadorNoSorteio(results);
        });

        var elems = document.querySelectorAll('.collapsible');
        var instances = M.Collapsible.init(elems, {});
    });
}

function renderizaBotaoLinkSorteio(id, div) {
    let pai = div;

    let divrow = document.createElement('div');
    divrow.setAttribute('class', 'row');

    let divinput = document.createElement('div');
    divinput.setAttribute('class', 'input-field col s12');

    let icon = document.createElement('i');
    icon.setAttribute('class', 'material-icons prefix');
    icon.innerText = 'content_copy';
    icon.setAttribute('style', 'cursor: grab')
    icon.addEventListener('click', copyClipboard);

    let inputLink = document.createElement('input');
    inputLink.setAttribute('type', 'text');
    inputLink.setAttribute('readonly', true);
    inputLink.setAttribute('class', 'center-align materialize-textarea');
    inputLink.value = `http://127.0.0.1:5500/sorteios.html?id=${id}`;

    divinput.appendChild(icon);
    divinput.appendChild(inputLink);


    divrow.appendChild(divinput);



    pai.appendChild(divrow);
}

function copyClipboard(event) {
    event.target.parentNode.children[1].select();
    document.execCommand('copy');
}

function renderizaPremiosNoSorteio(premio, pai) {
    let divProduto = pai;
    let divPai = document.createElement('div');
    divPai.setAttribute('class', 'card-stacked');

    let ulContent = document.createElement('ul');
    ulContent.setAttribute('class', 'collapsible');

    let li = document.createElement('li');
    li.setAttribute('id', `${premio.award_id}-${premio.sweepstakes_id}`);

    let divCollapsibleHeader = document.createElement('div');
    divCollapsibleHeader.setAttribute('class', 'collapsible-header')
    divCollapsibleHeader.innerHTML = `<i class="material-icons">keyboard_arrow_down</i>${premio.name}`;

    let divCollapsibleBody = document.createElement('div');
    divCollapsibleBody.setAttribute('class', 'collapsible-body');
    renderizaBotaoSortear(divCollapsibleBody);

    li.appendChild(divCollapsibleHeader);
    li.appendChild(divCollapsibleBody);
    ulContent.appendChild(li);
    divPai.appendChild(ulContent);
    divProduto.appendChild(divPai);
}

function renderizaGanhadorNoSorteio(sorteados) {
    const results = Array.from(sorteados);

    results.forEach((result) => {
        const li = document.getElementById(`${result.award_id}-${result.sweepstakes_id}`);

        let spanResultName = document.createElement('span');
        spanResultName.innerText = result.name;

        let spanResultEmail = document.createElement('span');
        spanResultEmail.innerText = result.email;

        li.children[1].appendChild(spanResultName)
        li.children[1].innerHTML += '<br>';
        li.children[1].appendChild(spanResultEmail)
        li.children[1].innerHTML += '<hr>';
    });

    controleLoading(false);
}

function renderizaBotaoSortear(pai) {
    divProduto = pai;
    let divPai = document.createElement('div');

    let btnSortear = document.createElement('button');
    btnSortear.setAttribute('class', 'btn waves-effect waves-light');
    btnSortear.textContent = "Sortear";
    btnSortear.setAttribute('onclick', 'clickBtnSortear(event)');

    divProduto.appendChild(divPai);
    divPai.appendChild(btnSortear);
    divPai.innerHTML += '<hr> <h5>Ganhadores</h5>';
}

function generateAwards(premios) {
    const allPremios = Array.from(premios);
    allPremios.forEach((premio) => {
        let p = document.createElement('p');
        let label = document.createElement('label');
        let input = document.createElement('input');
        input.setAttribute('type', 'checkbox');
        input.setAttribute('id', premio.id);
        let span = document.createElement('span');
        span.textContent = premio.name;

        label.appendChild(input);
        label.appendChild(span);
        p.appendChild(label);
        divSelectProdutos.appendChild(p);
    });
}

function getSorteios() {
    const api = new XMLHttpRequest();
    const url = "http://localhost:8000/api/sweepstakes/user/"
    const param = localStorage.getItem("id");
    api.open("GET", `${url}${param}`, true);
    api.setRequestHeader("Content-type", "application/json");

    api.send();

    api.onreadystatechange = function () {
        if (api.readyState == 4 && api.status == 200) {
            var data = JSON.parse(api.responseText);
            if (data.length > 0) {
                handleSorteios(data);
            } else {
                controleLoading(false);
            }
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
                generateAwards(data);
            }
        }
    }
}

function salvarSweepstake(sweepstake, awards) {
    const api = new XMLHttpRequest();
    const url = "http://localhost:8000/api/sweepstake";
    api.open("POST", url, true);
    api.setRequestHeader("Content-type", "application/json");
    api.send(JSON.stringify(sweepstake));

    api.onreadystatechange = function () {
        if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
            var data = JSON.parse(api.responseText);
            if (data.id) {
                sarvarAwardsSweepstake(data.id, awards);
            }
        }
    }
}

function sarvarAwardsSweepstake(idSweepstake, awards) {
    const awardsSweepstake = [];
    Array.from(awards).forEach((award) => {
        awardsSweepstake.push({
            'award_id': award,
            'sweepstakes_id': idSweepstake
        });
    });

    const url = "http://localhost:8000/api/awards_sweepstake";

    let retorno = false;
    for (let i = 0; i < awardsSweepstake.length; i++) {
        const api = new XMLHttpRequest();
        api.open("POST", url, true);
        api.setRequestHeader("Content-type", "application/json");
        api.send(JSON.stringify(awardsSweepstake[i]));
        api.onreadystatechange = function () {
            if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
                var data = JSON.parse(api.responseText);
                if (i == awardsSweepstake.length - 1) {
                    retorno = true;
                }
            }
        }
    }

    getSorteios()
}

function salvarResultAwardSweepstake(idSweepstake, idAward) {
    const sorteio = {
        'sweepstakes_id': idSweepstake,
        'award_id': idAward
    }

    const url = "http://localhost:8000/api/sortear";

    const api = new XMLHttpRequest();
    api.open("POST", url, true);
    api.setRequestHeader("Content-type", "application/json");
    console.log(sorteio)
    api.send(JSON.stringify(sorteio));
    api.onreadystatechange = function () {
        if (api.readyState == 4 && (api.status == 200 || api.status == 201)) {
            var data = JSON.parse(api.responseText);
            if (data.id) {
                getSorteios();
                awardsForUser();
            }
        }
    }
}