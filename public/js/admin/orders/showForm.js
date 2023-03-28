const showFormBtn = document.getElementById('show_form');
const hideFormBtn = document.getElementById('hide_form');
const add_form = document.getElementById('add_form');

showFormBtn.addEventListener('click', () => {
    add_form.hidden = false;
});

hideFormBtn.addEventListener('click', () => {
    add_form.hidden = true;
});
