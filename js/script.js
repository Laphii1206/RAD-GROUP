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
                        // If the badge doesn't exist, create it
                        const cartDropdown = document.querySelector('#cartDropdown');
                        const badge = document.createElement('span');
                        badge.className = 'position-absolute translate-middle badge rounded-pill bg-danger';
                        badge.style.transform = 'translate(-50%, -50%)';
                        badge.textContent = data.total_cart_items;
                        cartDropdown.appendChild(badge);
                    }

                    // Update the cart dropdown
                    const cartDropdownMenu = document.querySelector('#cartDropdownContainer .dropdown-menu');
                    cartDropdownMenu.innerHTML = ''; // Clear the current dropdown content

                    // Add updated cart items to the dropdown
                    data.cart_items.forEach(item => {
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
                        cartDropdownMenu.appendChild(listItem);
                    });

                    // Add a divider and "View Cart" button
                    const divider = document.createElement('li');
                    divider.innerHTML = '<hr class="dropdown-divider">';
                    cartDropdownMenu.appendChild(divider);

                    const viewCartButton = document.createElement('li');
                    viewCartButton.className = 'text-center';
                    viewCartButton.innerHTML = '<a href="../cart/cart.php" class="btn btn-primary btn-sm">View Cart</a>';
                    cartDropdownMenu.appendChild(viewCartButton);

                    alert('Item added to cart successfully!');
                } else {
                    alert('Failed to add item to cart.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

