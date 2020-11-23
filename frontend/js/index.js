if (!localStorage.getItem("id")) {
    window.location.href = "/login.html";
} else {
    window.addEventListener('load', start);
}

let btnSair;
let divSorteios;


function start() {
    divSorteios = document.querySelector('#div-sorteios');
    btnSair = document.querySelector('#btn-sair');
    btnSair.addEventListener('click', () => {
        localStorage.clear();
        window.location.href = "login.html"
    })
    getSorteios();
}

function handleSorteios(data, dadosSorteio) {
    const sorteios = Array.from(dadosSorteio);
    const awards = Array.from(data);

    sorteios.forEach((element) => {
        let divpai = document.createElement('div');
        divpai.setAttribute('class', 'col s12');

        let h2 = document.createElement('h2');
        h2.setAttribute('class', 'header center-align');
        h2.textContent = element.description;

        let divProduto = document.createElement('div');
        divpai.setAttribute('class', 'card hoverable');

        awards.forEach((award) => {
            renderizaPremiosNoSorteio(award, divProduto, element.id);
        });

        let inputHiden = document.createElement('input');
        inputHiden.type = 'hidden';
        inputHiden.setAttribute('id', `sweepstake-${element.id}`);
        inputHiden.value = element.id;

        divpai.appendChild(h2);
        divpai.appendChild(inputHiden);
        divpai.appendChild(divProduto);
        divSorteios.appendChild(divpai);

        var elems = document.querySelectorAll('.collapsible');
        var instances = M.Collapsible.init(elems, {});

        getSweepstakeResult(element.id);
    });


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

function renderizaGanhadorNoSorteio(dados) {
    const results = Array.from(dados);
    dados.forEach((result) => {
        const li = document.getElementById(`${result.award_id}-${result.sweepstakes_id}`);

        let spanResultName = document.createElement('span');
        spanResultName.innerText = result.name;

        let spanResultEmail = document.createElement('span');
        spanResultEmail.innerText = result.email;

        li.children[1].appendChild(spanResultName)
        li.children[1].innerHTML += '<br>';
        li.children[1].appendChild(spanResultEmail)
        li.children[1].innerHTML += '<hr>';
    })

}

function renderizaBotaoSortear(pai) {
    divProduto = pai;

    let divPai = document.createElement('div');

    let btnSortear = document.createElement('button');
    btnSortear.setAttribute('class', 'btn waves-effect waves-light');
    btnSortear.textContent = "Sortear";

    divProduto.appendChild(divPai);
    divPai.appendChild(btnSortear);
    divPai.innerHTML += '<hr> <h5>Ganhadores</h5>';
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
            getAwardsForUserInSweepstake(data)
        }
    }
}

function getAwardsForUserInSweepstake(dadosSorteio) {
    const api = new XMLHttpRequest();
    const url = "http://localhost:8000/api/awards/sweepstake/user/"
    const param = localStorage.getItem("id");
    api.open("GET", `${url}${param}`, true);
    api.setRequestHeader("Content-type", "application/json");

    api.send();

    api.onreadystatechange = function () {
        if (api.readyState == 4 && api.status == 200) {
            var data = JSON.parse(api.responseText);
            handleSorteios(data, dadosSorteio);
        }
    }
}

function getSweepstakeResult($idSweepstake) {
    const api = new XMLHttpRequest();
    const url = "http://localhost:8000/api/sweepstake-result/sweepstake/"
    const param = $idSweepstake;
    api.open("GET", `${url}${param}`, true);
    api.setRequestHeader("Content-type", "application/json");

    api.send();

    api.onreadystatechange = function () {
        if (api.readyState == 4 && api.status == 200) {
            var data = JSON.parse(api.responseText);
            renderizaGanhadorNoSorteio(data);
        }
    }
}