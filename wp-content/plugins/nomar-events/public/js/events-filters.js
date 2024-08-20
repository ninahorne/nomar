document.addEventListener('DOMContentLoaded', function () {
  handleDropdowns();
});

function getUrlParameter(name) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(name) || ''; // Return an empty string if the parameter is not present
}

function handleDropdowns() {
  const catDropdown = document.getElementById('category');
  const locDropdown = document.getElementById('location');
  const category = getUrlParameter('c_cat');
  const location = getUrlParameter('loc');

  catDropdown.value = category;
  locDropdown.value = location;

  // Function to update the query parameters
  function updateQueryParam(param, value) {
    const url = new URL(window.location.href);
    const params = url.searchParams;

    if (value) {
      params.set(param, value); // Set or update the query parameter
    } else {
      params.delete(param); // Remove the query parameter if the value is blank
    }

    // Update the URL without reloading the page
    window.location.href = url.pathname + '?' + params.toString() + '#results';
  }

  // Handle the category dropdown change
  catDropdown.addEventListener('change', function () {
    const selectedCategory = this.value;
    if (selectedCategory != category) {
      updateQueryParam('c_cat', selectedCategory);
    }
  });

  // Handle the location dropdown change
  locDropdown.addEventListener('change', function () {
    const selectedLocation = this.value;
    if (selectedLocation != location) {
      updateQueryParam('loc', selectedLocation);
    }
  });
}
