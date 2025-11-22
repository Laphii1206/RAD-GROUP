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
        // Remove any existing event listeners before adding a new one
        button.removeEventListener('click', handleAddToCart);
        button.addEventListener('click', handleAddToCart);
    });

    // Function to handle Add to Cart
    function handleAddToCart(event) {
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
                    alert('Item added to cart successfully!');
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
                } else {
                    alert('Failed to add item to cart.');
                }
            })
            .catch(error => console.error('Error:', error));
    }
});

