document.addEventListener('DOMContentLoaded', function () {
    const cartDropdownContainer = document.getElementById('cartDropdownContainer');
    const dropdownMenu = cartDropdownContainer.querySelector('.dropdown-menu');

    // Function to show the dropdown on hover
    function showDropdown() {
        dropdownMenu.classList.add('show');
        dropdownMenu.setAttribute('aria-expanded', 'true');
    }

    // Function to hide the dropdown on mouse leave
    function hideDropdown() {
        dropdownMenu.classList.remove('show');
        dropdownMenu.setAttribute('aria-expanded', 'false');
    }

    // Attach hover event listeners
    cartDropdownContainer.addEventListener('mouseenter', showDropdown);
    cartDropdownContainer.addEventListener('mouseleave', hideDropdown);

    // Function to update the cart dropdown content
    function updateCartDropdown(cartItems) {
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

    // Handle quantity increase and decrease buttons
    document.querySelectorAll('.quantity-decrease').forEach(button => {
        button.addEventListener('click', function () {
            const input = this.nextElementSibling; // Get the input field next to the "-" button
            const currentValue = parseInt(input.value, 10);
            if (currentValue > 1) {
                input.value = currentValue - 1; // Decrease the value
            }
        });
    });

    document.querySelectorAll('.quantity-increase').forEach(button => {
        button.addEventListener('click', function () {
            const input = this.previousElementSibling; // Get the input field before the "+" button
            const currentValue = parseInt(input.value, 10);
            input.value = currentValue + 1; // Increase the value
        });
    });

    // Handle Add to Cart button
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.add-to-cart-form');
            const formData = new FormData(form);

            // Ensure the quantity is included in the form data
            const quantityInput = form.querySelector('.quantity-input');
            if (quantityInput) {
                formData.set('quantity', quantityInput.value); // Add or update the quantity in the form data
            }

            // Send the form data to the server
            fetch('../cart/add_to_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Server Response:', data); // Debugging: Log the server response
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
});

