document.addEventListener('DOMContentLoaded', function () {
      const cartDropdownContainer = document.getElementById('cartDropdownContainer');
      const dropdownMenu = cartDropdownContainer.querySelector('.dropdown-menu');

      // Show dropdown on hover
      cartDropdownContainer.addEventListener('mouseenter', function () {
        dropdownMenu.classList.add('show');
        dropdownMenu.setAttribute('aria-expanded', 'true');
      });

      // Hide dropdown when mouse leaves
      cartDropdownContainer.addEventListener('mouseleave', function () {
        dropdownMenu.classList.remove('show');
        dropdownMenu.setAttribute('aria-expanded', 'false');
      });

    // Select all Add to Cart buttons
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.add-to-cart-form');
            const formData = new FormData(form);

            // Send the form data to the server using AJAX
            fetch('../cart/add_to_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the cart badge
                    const cartBadge = document.querySelector('#cartDropdownContainer .badge');
                    if (cartBadge) {
                        cartBadge.textContent = data.total_cart_items;
                    } else {
                        const cartDropdown = document.querySelector('#cartDropdown');
                        const badge = document.createElement('span');
                        badge.className = 'position-absolute translate-middle badge rounded-pill bg-danger';
                        badge.style.transform = 'translate(-50%, -50%)';
                        badge.textContent = data.total_cart_items;
                        cartDropdown.appendChild(badge);
                    }

                    // Update the dropdown content dynamically
                    updateCartDropdown(data.cart_items);

                    // Show success message
                    alert('Item added to cart successfully!');
                } else {
                    alert(data.message || 'Failed to add item to cart.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Function to update the cart dropdown content
    function updateCartDropdown(cartItems) {
        const dropdownMenu = document.querySelector('#cartDropdownContainer .dropdown-menu');
        dropdownMenu.innerHTML = ''; // Clear the current dropdown content

        if (cartItems.length > 0) {
            cartItems.forEach(item => {
                const listItem = document.createElement('li');
                listItem.className = 'dropdown-item';
                listItem.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <span>${item.product_name}</span>
                        <span>RM ${item.product_price}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small>Quantity: ${item.quantity}</small>
                        <small>Total: RM ${item.total_price}</small>
                    </div>
                `;
                dropdownMenu.appendChild(listItem);
            });

            // Add a divider and "View Cart" button
            const divider = document.createElement('li');
            divider.innerHTML = '<hr class="dropdown-divider">';
            dropdownMenu.appendChild(divider);

            const viewCartButton = document.createElement('li');
            viewCartButton.className = 'text-center';
            viewCartButton.innerHTML = '<a href="../cart/cart.php" class="btn btn-primary btn-sm">View Cart</a>';
            dropdownMenu.appendChild(viewCartButton);
        } else {
            const emptyMessage = document.createElement('li');
            emptyMessage.className = 'dropdown-item text-center';
            emptyMessage.textContent = 'Your cart is empty.';
            dropdownMenu.appendChild(emptyMessage);
        }
    }
});

