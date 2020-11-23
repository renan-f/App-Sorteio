let btnSair;

window.addEventListener('load', start);

function start() {
    btnSair = document.querySelector('#btn-sair');
    btnSair.addEventListener('click', () => {
        localStorage.clear();
        window.location.href = "login.html"
    })
}