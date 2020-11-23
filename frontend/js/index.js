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
        console.log(element);
        let divpai = document.createElement('div');
        divpai.setAttribute('class', 'col s12');

        let h2 = document.createElement('h2');
        h2.setAttribute('class', 'header center-align');
        h2.textContent = element.description;

        let divProduto = document.createElement('div');
        divpai.setAttribute('class', 'card hoverable');

        awards.forEach((award) => {
            renderizaPremiosNoSorteio(award, divProduto);
        })

        let inputHiden = document.createElement('input');
        inputHiden.type = 'hidden';
        inputHiden.value = element.id;

        divpai.appendChild(h2);
        divpai.appendChild(inputHiden);
        divpai.appendChild(divProduto);
        divSorteios.appendChild(divpai);
        renderizaBotaoSortear(divpai);
    });

}

function renderizaPremiosNoSorteio(premio, pai) {
    console.log(premio);
    divProduto = pai;

    let divPai = document.createElement('div');
    divPai.setAttribute('class', 'card-stacked');

    let divContent = document.createElement('div');
    divPai.setAttribute('class', 'card-content');

    let nameAward = document.createElement('p');
    nameAward.textContent = premio.name;

    divProduto.appendChild(divPai);
    divPai.appendChild(divContent);
    divContent.appendChild(nameAward);
}

function renderizaBotaoSortear(pai) {
    divProduto = pai;

    let divPai = document.createElement('div');
    divPai.setAttribute('class', 'card-action');

    let btnSortear = document.createElement('button');
    btnSortear.setAttribute('class', 'btn waves-effect waves-light');
    btnSortear.textContent = "Sortear";

    divProduto.appendChild(divPai);
    divPai.appendChild(btnSortear);
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