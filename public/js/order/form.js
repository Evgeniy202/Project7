const showOrderBtn = document.getElementById('show_order');
const hideOrderBtn = document.getElementById('hide_order');
const orderForm = document.getElementById('order_form');

showOrderBtn.addEventListener('click', () => {
    orderForm.hidden = false;
});

hideOrderBtn.addEventListener('click', () => {
   orderForm.hidden = true;
});
