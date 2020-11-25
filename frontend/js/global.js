window.addEventListener('load', () => {
    var elemsNav = document.querySelectorAll('.sidenav');
    var instancesNav = M.Sidenav.init(elemsNav, {});
})

function clearFields(fields) {
    let allFields = Array.from(fields);
    allFields.forEach((field) => {
        if (field.type == 'text') {
            field.value = '';
        }
        if (field.type == 'checkbox') {
            field.checked = false;
        }
    })
}