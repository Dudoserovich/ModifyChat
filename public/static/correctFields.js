const fields = document.querySelectorAll('.fields');

fields.forEach(e => {
    e.oninput = (el) => {
        el.target.value = el.target.value.trim().replace(/(\s|#)/g, '');
    }
})