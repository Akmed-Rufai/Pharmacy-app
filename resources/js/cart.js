

// cart.js
const itemCart = document.querySelector('.items')
const showLeft = document.getElementsByClassName('show-left')[0];

if (itemCart && showLeft) {
    showLeft.addEventListener('click', () => {
        itemCart.classList.toggle('active');
        showLeft.classList.toggle('actives');
    });

    // ✅ Make them global immediately
    window.itemCart = itemCart;
    window.showLeft = showLeft;
}
