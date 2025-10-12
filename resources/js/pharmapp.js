document.addEventListener('DOMContentLoaded', function () {

      const searchInput = document.getElementById('medicine');
      const resultsContainer = document.getElementById('medicine-results');
      const store = document.getElementById('home')
      const itemCart = window.itemCart;
      const show = document.getElementsByClassName('show')[0]
      const side = document.getElementsByClassName('left-side')[0]
      const itemInCart = document.querySelector('.item-cart')
      const formCart = document.getElementById('form-cart')
    //   const medicineList= @json($allMedicines);
      const medicineList = window.allMedicines || [];
      const input = document.getElementById('medicine');
      const resultDiv = document.getElementById('search-result');
      const payBtn =  itemCart.querySelector('.pay');
      const printBtn = document.querySelector('#prt-btn')
      const cancelBtn = document.querySelector('#cancel-btn')
      const clear = document.querySelector('#clear-cart')
      const showLeft = window.showLeft;
    
        loadCartFromLocalStorage()

        const flash = document.getElementById('flash');
        if (flash) {
            setTimeout(() => {
                flash.classList.add('opacity-0'); // requires Tailwind transition
                setTimeout(() => flash.remove(), 200); // after fade-out
            }, 1000);
        }

         clear.addEventListener('click', clearCart )

    function clearCart(){
     
        while(itemInCart.hasChildNodes()){
            itemInCart.removeChild(itemInCart.firstChild);
        }

        updateTotal();
        showBtn();
        localStorage.removeItem('cart');
        itemCart.classList.add('active');
        showLeft.classList.add('actives');
        saveCartToLocalStorage(); // ✅ Save cleared state
    }
    
    function saveCartToLocalStorage() {
        const cartItems = [];
        document.querySelectorAll('.item-cart li').forEach(li => {
            const title = li.querySelector('.title')?.innerText;
            const price = li.querySelector('.price')?.innerText;
            const quantity = li.querySelector('.inp')?.value;
            cartItems.push({ title, price, quantity });
        });
        localStorage.setItem('cart', JSON.stringify(cartItems));
    }

    function loadCartFromLocalStorage() {
        const saved = localStorage.getItem('cart');
        if (!saved) return;

        const cartItems = JSON.parse(saved);
        cartItems.forEach(item => {
            addItemToCart(item.title, item.price, item.quantity);
        });
        showBtn();
    }
    
     function updateTotal(){
           let total = 0
           const allCartItems = itemInCart.querySelectorAll('li')
           const emptyMessage = itemCart.querySelector('#empty');

           if (allCartItems.length === 0) {
              emptyMessage.innerText = 'cart is empty';
            } else {
                emptyMessage.innerText = '';
            }
            
            allCartItems.forEach((row) => {
            const priceElement = row.querySelector('.price');        
            const quantityInput = row.querySelector('input');   

            const price = parseFloat(priceElement.innerText.replace(/[^\d.]/g, '')) || 0;
            const quantity = parseInt(quantityInput.value) || 1;
            total = total + (price * quantity)
            });
            document.getElementById('total').innerText = total.toFixed(2);
        }
    function showBtn(){
        const payBtn =  itemCart.querySelector('.pay')     
        const allCartItems = itemInCart.querySelectorAll('li')
        const clear = document.querySelector('#clear-cart')
        const total = document.querySelectorAll('.tot')

        
        if(allCartItems.length === 0){
            payBtn.style.display = 'none';
            clear.style.display = 'none'
            for(let i=0; i < total.length; i++){
            total[i].style.display = 'none'
            }
       }else{
            payBtn.style.display = 'block';
            clear.style.display = 'block'
            for(let i=0; i < total.length; i++){
            total[i].style.display = 'block'
            }
        }
    }
    showBtn()
let cartInCart = []
window.printAndSave = function() {
    if (cartInCart.length === 0) {
        alert("Cart is empty!");
        return;
    }

    for (const cartItem of cartInCart) {
    const match = medicineList.find(med => med.medicine.toLowerCase() === cartItem.name.toLowerCase());

    if (match) {
        match.quantity = Math.max(0, match.quantity - cartItem.quantity); // prevent negative
        }
    }

    // Step 2: Reduce stock in DB
    fetch('/reduce-stock', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ cart: cartInCart })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Stock reduced:', data);

        // Step 3: Now save the sale in sales table
        return fetch('/save-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ cart: cartInCart })
        });
    })
    .then(response => response.json())
    .then(data => {
        console.log('Sale saved:', data);

        // Step 4: Print receipt
        window.print();
        fetchMed()
        clearCart()
        printBtn.style.display = 'none'
        cancelBtn.style.width  = '100%'

    })
    .catch(error => {
        console.error('Failed:', error);
    });
}

function fetchMed(query = ''){

    fetch(`/?medicine=${encodeURIComponent(query)}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'  // 👈 This tells Laravel it's an AJAX request
        }
        })
        .then(response => response.text())
        .then(html => {
            resultsContainer.innerHTML = html;
        })
        .catch(error => {
            console.error('Search error:', error);
        });
    }

    function addItemToCart(title, price, quantity){
        const cartRow = document.createElement('li'); 
        cartRow.style.listStyle = 'none'
        const existingTitles = itemInCart.querySelectorAll('.title');
        for (let i = 0; i < existingTitles.length; i++) {
            if (existingTitles[i].innerText === title) {
                alert('Item already in cart');
                return;
            } 
        }
     
        const cartContent = `
                <div class='flex items-center justify-around border-b-1 bg-white'>
                    <a class="btn-primary btn-cart">X</a>
                    <h1 class='text-xl font-semibold tracking-wide title w-50'>${title}</h1>
                    <input type='number' value='${quantity}' class='inp' />
                    <p class="tracking-wide font-light price">${price}</p>
                </div>
                `
        
        cartRow.innerHTML = cartContent;
        itemInCart.appendChild(cartRow);

        const newBtn = cartRow.querySelector('.btn-cart');
        newBtn.addEventListener('click', (e) => {
            e.target.closest('li').remove();
             showBtn()
             updateTotal()
             saveCartToLocalStorage();
        });
        const newInput = cartRow.querySelector('.inp');     
        newInput.addEventListener('change', () => {
            if(isNaN(newInput.value) || newInput.value <= 0){
                newInput.value = 1
            }
              updateTotal()
              saveCartToLocalStorage();
        });
             updateTotal()
            saveCartToLocalStorage();
     }


       if(show){
         show.addEventListener('click', ()=>{
            const si = side.classList.toggle('active')
                
            if (si) {
                side.classList.add('active')
                show.classList.toggle('active');
            }else{
                side.classList.remove('active')
                show.classList.toggle('active');
            }
        })
       }
    
    if(resultsContainer){
       resultsContainer.addEventListener('click', addToCartClicked) 
    }
    
    if(resultDiv){
       resultDiv.addEventListener('click', matchList);
    }
    if(input){
        input.addEventListener('input', inputMatch );
    }
    
    if(payBtn){
        payBtn.addEventListener('click', payBtnClick);
    }
    
   
    
    function payBtnClick() {
        const modal = document.querySelector('.modal');
        const modalBody = modal.querySelector('.modal-body');
        const allCartItems = itemInCart.querySelectorAll('li');

        
        for (const cartItem of cartInCart) {
        const match = medicineList.find(med => med.medicine.toLowerCase() === cartItem.name.toLowerCase());
            if (cartItem.quantity > match.quantity) {
                alert('Not enough in store for: ' + cartItem.name);
                return; // Exit the entire printAndSave function
            }

        }


        // Clear the modal body
        modalBody.innerHTML = '';
        cartInCart = []

        if (allCartItems.length > 0) {
            // Create a table
            const table = document.createElement('table');
            table.className = 'w-full border-collapse'; 

            // Create the table header
            const thead = document.createElement('thead');
            thead.innerHTML = `
                <tr>
                    <th class="text-center px-6">Drugs</th>
                    <th class="text-center px-6">Qtys</th>
                    <th class="text-center px-6">Price</th>
                </tr>
            `;
            table.appendChild(thead);

            // Create the table body
            const tbody = document.createElement('tbody');

            allCartItems.forEach(item => {
                const med = item.querySelector('.title')?.innerText || '';
                const price = item.querySelector('.price')?.innerText || '';
                const quantityEL = item.querySelector('.inp');
                const quantity = quantityEL?.value || 1;

                cartInCart.push({
                name: med,
                price: parseInt(price),
                quantity: parseInt(quantity)
                 });

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="text-center px-6">${med}</td>
                    <td class="text-center px-6">${quantity}</td>
                    <td class="text-center px-6">${price}</td>
                `;
                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            modalBody.appendChild(table);
            itemCart.classList.add('active')
            showLeft.classList.add('actives')
        }

        // Show modal and total
        modal.classList.add('activex');
        document.body.classList.add('flow')
        const totalPrice = itemCart.querySelector('#total')?.innerText || '0';
        const checkPrice = document.getElementById('tota');
        checkPrice.innerText = totalPrice;

        // Close modal
        document.querySelector('.close-btn').addEventListener('click', () => {
            modal.classList.remove('activex');
            document.body.classList.remove('flow')
        });
    }

      function addToCartClicked(event) {
        const item = event.target.closest('.cart-items'); // Always get the outer container     
        if (!item) return; // If no .medicine-item found, exit early

        if (item.querySelector('.highlights')) {
            alert('This item is out of stock.');
            return;
         }

        const title = item.querySelector('.title')?.innerText;
        const price = item.querySelector('.price')?.innerText;
        const quantityInput = document.getElementById('quantity');
        const quantity = quantityInput.value || 1
         
        addItemToCart(title, price, quantity)
        itemCart.classList.remove('active')
        showLeft.classList.remove('actives')
        showBtn()
     }

    function inputMatch(){
        const query = input.value.trim().toLowerCase();
        resultDiv.innerHTML = ''; // Clear previous results

        if (!query) return;

        const matched = medicineList.filter(med => 
            med.medicine.toLowerCase().includes(query)
        );
 
        if (matched.length > 0) {
            resultDiv.innerHTML = `
                <ul style="border: 1px solid #ccc; padding: 5px; cursor: pointer">
                    ${matched.map(med => `<li class="${med.quantity < 50 ? 'highlights' : ''}">${med.medicine}</li>`).join('')}
                </ul>
            `;
        } else {
            resultDiv.innerHTML = '<p>No match found</p>';
        }
    }

  function matchList(e) {
    const item = e.target.closest('li');
    const high = item.classList.contains('highlights')

    
    if (!item) return;

    if (high) {
        alert('Item is out of stock');
        input.value = ''
        resultDiv.innerHTML = '';
        return;
    }

    if (e.target.tagName === 'LI' && !high) {
        input.value = e.target.innerText;
        resultDiv.innerHTML = '';
    }
}

if(formCart){
formCart.addEventListener('submit', function(e) {
    e.preventDefault(); // Stop page reload

    const medicineInput = formCart.querySelector('#medicine');
    const quantityInput = formCart.querySelector('#quantity');  
    const medicine = medicineInput.value.trim();
    const quantity = parseInt(quantityInput.value.trim()) || 1;
    const medInStore = medicineList.find((med)=> med.medicine == medicine)

    if(medicine == ''){
        alert('pls type a medicine')
        return
    }

    if(!medInStore){
        alert('not a medicine in store')
        return
    }

    quantityInput.addEventListener('change', (e)=>{
        if(isNaN(quantityInput.value) || quantityInput.value <= 0){
            quantityInput.value = 1
        }
    })

    const cartItem = document.createElement('li');
    cartItem.style.listStyle = 'none'
    const matchedMedicine = medicineList.find(med => 
    med.medicine.trim().toLowerCase() === medicine.trim().toLowerCase()) 
    const price = matchedMedicine ? matchedMedicine.price: 0;
    cartItem.innerHTML = `
                    <div class='flex items-center justify-around border-b-1 bg-white'>
                        <a class="btn-primary btn-cart-form">X</a>
                        <h1 class='text-xl font-semibold tracking-wide title w-50'>${medicine}</h1>
                        <input type='number' value='${quantity}' class='inp' />
                        <p class="tracking-wide font-light price">${price}</p>
                    </div>
                    `;
    const formMedicine = itemInCart.querySelectorAll('.title ')
    const cartQuant = cartItem.querySelector('.inp');
    
    cartQuant.addEventListener('change', (e)=>{
    if(isNaN(cartQuant.value) || cartQuant.value <= 0){
        cartQuant.value = 1
    }
    updateTotal()
    })

    for(let i=0; i < formMedicine.length; i++){
        if (formMedicine[i].innerText.trim().toLowerCase() === medicine.toLowerCase()) {
        alert('Item already in cart');
        return;
         }
    }
    
    itemInCart.appendChild(cartItem);
    const formBtn = cartItem.querySelector('.btn-cart-form');
           formBtn.addEventListener('click', (e) => {
            e.target.closest('li').remove();
            showBtn()
            updateTotal()
    
        });

    // Optional: Clear inputs
    medicineInput.value = '';
    quantityInput.value = '';
    showBtn()
    itemCart.classList.remove('active')
    showLeft.classList.remove('actives')
    fetchMed()
    updateTotal()
})
}
    if(searchInput){
         searchInput.addEventListener('input', function () {
        fetchMed(this.value);
    });
    }
   

    window.addEventListener('beforeunload', () => {
    saveCartToLocalStorage();
});

});

