<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ACR Mart - Products</title>
  <style>
    /* (your CSS unchanged — copied exactly from your file) */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { background: #fff; color: #333; min-height: 100vh; display: flex; flex-direction: column; }
    nav { position: fixed; top: 0; height: 10%; width: 100%; background: #4B2E0E; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 3px 10px rgba(0,0,0,0.3); z-index: 10; }
    .nav-left img { height: 120px; display: block; }
    .nav-right a { color: #f0d87c; text-decoration: none; margin-left: 2rem; font-weight: 600; transition: color 0.3s ease; position: relative; }
    .nav-right a:hover, .nav-right a:focus { color: #b69122; }
    .nav-right a::after { content: ''; position: absolute; width: 0; height: 2px; background: #f0d87c; left: 0; bottom: -4px; transition: width 0.3s ease; }
    .nav-right a:hover::after, .nav-right a:focus::after { width: 100%; }
    main { flex: 1; padding: 100px 2rem 2rem; max-width: 1200px; margin: auto; }
    main h2 { text-align: center; font-size: 2rem; font-weight: 900; margin-bottom: 1.5rem; color: #4B2E0E; }
    .filters { display: flex; justify-content: center; gap: 1.5rem; margin-bottom: 2rem; flex-wrap: wrap; }
    select { font-size: 1rem; padding: 0.4rem 0.8rem; border-radius: 6px; border: 1px solid #ccc; min-width: 180px; cursor: pointer; color: #4B2E0E; font-weight: 600; user-select: none; }
    .product-grid { display: flex; gap: 2rem; flex-wrap: wrap; justify-content: center; }
    .product-card { background: #fdfdfd; border-radius: 10px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 200px; text-align: center; padding: 1.5rem 1rem; transition: transform 0.3s ease; }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
    .product-card img { width: 100%; height: 140px; object-fit: contain; border-radius: 8px; margin-bottom: 1rem; }
    .product-card h3 { font-size: 1.2rem; margin-bottom: 0.5rem; font-weight: 700; color: #4B2E0E; }
    .product-card p { font-size: 1rem; font-weight: 600; color: #d1a83f; margin-bottom: 0.8rem; }
    .quantity-input { width: 60px; padding: 0.3rem; font-size: 1rem; border-radius: 5px; border: 1px solid #ccc; text-align: center; margin-bottom: 1rem; }
    .product-card button { padding: 0.5rem 1rem; background-color: #4B2E0E; color: #f0d87c; border: none; border-radius: 6px; cursor: pointer; font-weight: 700; transition: background-color 0.3s ease; width: 100%; }
    .product-card button:hover { background-color: #3a2207; }
    footer { background-color: #3a2207; color: #fff; padding: 40px 0; font-family: Arial, sans-serif; }
    .footer-container { display: flex; justify-content:end; flex-wrap: wrap; max-width: 1200px; margin: auto; }
    .footer-container div { flex: 1; margin: 15px; min-width: 220px; }
    .footer-container h3 { border-bottom: 2px solid #ffcc00; padding-bottom: 8px; margin-bottom: 15px; font-size: 18px; }
    .footer-container ul { list-style: none; }
    .footer-container ul li { margin: 8px 0; }
    .footer-container ul li a { color: #ddd; text-decoration: none; transition: 0.3s; }
    .footer-container ul li a:hover { color: #ffcc00; }
    .footer-contact p { margin: 6px 0; }
    .footer-social a img { width: 28px; margin-right: 10px; filter: brightness(0) invert(1); transition: 0.3s; }
    .footer-social a img:hover { filter: brightness(0) invert(0.8) sepia(1) hue-rotate(30deg) saturate(5); }
    .footer-bottom { text-align: center; padding: 15px 0; border-top: 1px solid #444; margin-top: 20px; font-size: 14px; color: #bbb; }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav>
    <div class="nav-left">
      <img src="piks/logo.png" alt="ACR Mart Logo" />
    </div>
    <div class="nav-right">
      <a href="home.html">Home</a>
      <a href="products.php">Products</a>
      <a href="about.html">About Us</a>
      <a href="cart.php">🛒 Cart</a>
      <a href="signin.php">Sign In</a>
    </div>
  </nav>

  <!-- Main Content -->
  <main>
    <h2>Products</h2>

    <!-- Filters -->
    <div class="filters">
      <select id="categorySelect" aria-label="Select product category">
        <option value="all">All Products</option>
        <option value="Stationery">Stationery</option>
        <option value="Beverages">Beverages</option>
      </select>

      <select id="sortSelect" aria-label="Sort products">
        <option value="name-asc">Sort by Name (A to Z)</option>
        <option value="name-desc">Sort by Name (Z to A)</option>
        <option value="price-asc">Sort by Price (Low to High)</option>
        <option value="price-desc">Sort by Price (High to Low)</option>
      </select>
    </div>

    <!-- Product Grid -->
    <div class="product-grid" id="productGrid"></div>
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-container">
      <div class="footer-about">
        <h3>About Us</h3>
        <p>We are your one-stop online store, offering high-quality products at affordable prices with fast delivery and excellent customer service.</p>
      </div>
      <div class="footer-links">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="products.html">Shop</a></li>
          <li><a href="about.html">About</a</li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>
      <div class="footer-contact">
        <h3>Contact Us</h3>
        <p>Email: support@acrmart.com</p>
        <p>Phone: +94 77 123 4567</p>
        <p>Address: Colombo, Sri Lanka</p>
      </div>
      <div class="footer-social">
        <h3>Follow Us</h3>
        <a href="#"><img src="piks/fb.png" alt="Facebook"></a>
        <a href="#"><img src="piks/inst.png" alt="Instagram"></a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2025 ACR Mart. All rights reserved.</p>
    </div>
  </footer>

  <!-- JS for Products & server-based Cart -->
  <script>
    const productGrid = document.getElementById("productGrid");
    const categorySelect = document.getElementById("categorySelect");
    const sortSelect = document.getElementById("sortSelect");

    let allProducts = [];

    function renderProducts(products) {
      productGrid.innerHTML = "";
      products.forEach(product => {
        const card = document.createElement("div");
        card.className = "product-card";
        // product.image_url is expected to be filename (e.g. "milo.png")
        card.innerHTML = `
          <img src="piks/${product.image_url}" alt="${product.name}">
          <h3>${product.name}</h3>
          <p>Rs. ${product.price}</p>
          <input type="number" min="1" value="1" class="quantity-input" aria-label="Quantity for ${product.name}">
          <button class="purchase-btn" 
            data-id="${product.product_id}" 
            data-name="${encodeHTMLAttr(product.name)}" 
            data-price="${product.price}" 
            data-image="${product.image_url}">
            Add to Cart
          </button>
        `;
        productGrid.appendChild(card);
      });

      // Attach click listeners (server-add)
      document.querySelectorAll(".purchase-btn").forEach(button => {
        button.addEventListener("click", async () => {
          const productId = button.getAttribute("data-id");
          const productName = button.getAttribute("data-name");
          const productPrice = button.getAttribute("data-price");
          const productImageFile = button.getAttribute("data-image"); // filename
          const quantityInput = button.previousElementSibling;
          const quantity = parseInt(quantityInput.value, 10) || 1;
          if (quantity < 1) return alert("Quantity must be at least 1");

          // Build form data
          const params = new URLSearchParams();
          params.append('id', productId);
          params.append('name', productName);
          params.append('price', productPrice);
          // send full image path expected by cart.php (adjust if your cart expects only filename)
          params.append('image', 'piks/' + productImageFile);
          params.append('quantity', quantity);

          // disable button while adding
          button.disabled = true;
          button.textContent = 'Adding...';

          try {
            const res = await fetch('add_to_cart.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: params.toString()
            });
            const data = await res.json();
            if (data.status === 'success') {
              alert('Added to cart');
              // Optional: update cart badge or redirect to cart.php
              // window.location.href = 'cart.php';
            } else {
              alert('Error: ' + (data.message || 'Unable to add to cart'));
            }
          } catch (err) {
            console.error(err);
            alert('Network error while adding to cart');
          } finally {
            button.disabled = false;
            button.textContent = 'Add to Cart';
          }
        });
      });
    }

    // small helper to encode attributes (avoid breaking HTML)
    function encodeHTMLAttr(str) {
      return String(str).replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function applyFiltersAndSort() {
      let filtered = [...allProducts];
      const selectedCategory = categorySelect.value;
      if (selectedCategory !== "all") {
        filtered = filtered.filter(p => p.category === selectedCategory);
      }

      const sortValue = sortSelect.value;
      if (sortValue === "name-asc") filtered.sort((a,b)=>a.name.localeCompare(b.name));
      else if (sortValue === "name-desc") filtered.sort((a,b)=>b.name.localeCompare(a.name));
      else if (sortValue === "price-asc") filtered.sort((a,b)=>a.price - b.price);
      else if (sortValue === "price-desc") filtered.sort((a,b)=>b.price - a.price);

      renderProducts(filtered);
    }

    categorySelect.addEventListener("change", applyFiltersAndSort);
    sortSelect.addEventListener("change", applyFiltersAndSort);

    // load products json (your get_products.php)
    fetch('get_products.php')
      .then(res => res.json())
      .then(data => {
        allProducts = data;
        applyFiltersAndSort();
      })
      .catch(err => {
        console.error('Failed to load products:', err);
        productGrid.innerHTML = '<p style="color:#a00">Failed to load products. Check get_products.php</p>';
      });
  </script>
</body>
</html>
