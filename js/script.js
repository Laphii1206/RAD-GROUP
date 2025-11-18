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
    });