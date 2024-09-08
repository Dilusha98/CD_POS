<div class="container-fluid">
    <!-- POS Header -->
    <div class="row mb-3">
        <div class="col-md-8">
            <h3>Point of Sale</h3>
        </div>
        <div class="col-md-4 text-right">
            <button class="btn btn-primary" id="new-sale">New Sale</button>
        </div>
    </div>

    <!-- Customer and Search Bar -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="form-group">
                <label for="customer">Select Customer</label>
                <select class="form-control" id="customer">
                    <option value="1">Walk-in Customer</option>
                    <option value="2">John Doe</option>
                    <!-- Add more customers here -->
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" id="product-search" placeholder="Search by product name or barcode">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Product List -->
    <div class="row">
        <div class="col-md-8">
            <h5>Products</h5>
            <div class="row" id="product-list">
                <!-- Sample product cards (can be dynamically loaded) -->
                <div class="col-md-4">
                    <div class="card product-card" data-id="1" data-price="20">
                        <div class="card-body">
                            <h6 class="card-title">Product 1</h6>
                            <p class="card-text">$20.00</p>
                            <button class="btn btn-primary btn-add-to-cart">Add to Cart</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card product-card" data-id="2" data-price="15">
                        <div class="card-body">
                            <h6 class="card-title">Product 2</h6>
                            <p class="card-text">$15.00</p>
                            <button class="btn btn-primary btn-add-to-cart">Add to Cart</button>
                        </div>
                    </div>
                </div>
                <!-- More products... -->
            </div>
        </div>

        <!-- Cart -->
        <div class="col-md-4">
            <h5>Cart</h5>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            <!-- Cart items will be added here -->
                        </tbody>
                    </table>

                    <!-- Total and Checkout -->
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <h6>Total:</h6>
                        </div>
                        <div class="col-6 text-right">
                            <h6 id="cart-total">$0.00</h6>
                        </div>
                    </div>

                    <button class="btn btn-success btn-block mt-3" id="checkout-btn">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Example of adding products to the cart
    $(document).ready(function() {
        $('.btn-add-to-cart').on('click', function() {
            var productId = $(this).closest('.product-card').data('id');
            var productName = $(this).closest('.product-card').find('.card-title').text();
            var productPrice = $(this).closest('.product-card').data('price');

            var cartRow = `
                <tr>
                    <td>${productName}</td>
                    <td>1</td>
                    <td>$${productPrice.toFixed(2)}</td>
                    <td>$${productPrice.toFixed(2)}</td>
                    <td><button class="btn btn-danger btn-sm btn-remove">Remove</button></td>
                </tr>
            `;

            $('#cart-items').append(cartRow);
            updateCartTotal();
        });

        // Update total price of the cart
        function updateCartTotal() {
            var total = 0;
            $('#cart-items tr').each(function() {
                var price = parseFloat($(this).find('td:nth-child(4)').text().replace('$', ''));
                total += price;
            });
            $('#cart-total').text(`$${total.toFixed(2)}`);
        }

        // Remove item from cart
        $(document).on('click', '.btn-remove', function() {
            $(this).closest('tr').remove();
            updateCartTotal();
        });

        // Checkout button
        $('#checkout-btn').on('click', function() {
            alert('Checkout functionality can be implemented here.');
        });
    });
</script>
