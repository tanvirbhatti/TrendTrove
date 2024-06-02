<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Website</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>


<?php include 'navbar.php'; ?>

<div class="maincontainer container mt-5">
    <h3 class="heading ">Style Showcase: Unveiling the Latest Trends</h3>

    <!-- Filter options -->
    <div class="row mt-5">
        <div class="col-md-3">
            <label for="genderFilter">Filter by Gender:</label>
            <select id="genderFilter" class="form-control">
                <option value="">All Genders</option>
                <option value="Men">Men</option>
                <option value="Women">Women</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="categoryFilter">Filter by Category:</label>
            <select id="categoryFilter" class="form-control">
                <option value="">All Categories</option>
                <option value="1">Shoes</option>
                <option value="2">Hoodies</option>
                <option value="3">Pants</option>
                <option value="5">Jackets</option>
                <option value="4">T-shirt</option>
            </select>
        </div>
    </div>


    <!-- Product display area -->
    <div id="products" class="row mt-3"></div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        function fetchProducts() {
            var genderFilter = $('#genderFilter').val();
            var categoryFilter = $('#categoryFilter').val();

            $.get("Api.php", { gender: genderFilter, category: categoryFilter }, function (data) {
                $("#products").empty();

                data.forEach(function (product) {
                    var productHtml = '<div class="col-md-4 mb-4">';
                    productHtml += '<div class="card">';
                    productHtml += '<img class="card-img" src="' + product.ImagePath + '" alt="' + product.Name + '">';
                    productHtml += '<div class="flex-row space-between w-full mb-sm">';
                    productHtml += '<p class="product-cat hide">' + product.Category + '</p>';
                    productHtml += '</div>';
                    productHtml += '<h1 class="product-name">' + product.Name + '</h1>';
                    productHtml += '<div class="flex-row">';
                    productHtml += '<p class="price">$<span>' + product.Price + '</span></p>';
                    productHtml += '</div>';
                    productHtml += '<div class="btn-col">';
                    productHtml += '<button class="icon-link  view-product" data-product-id="' + product.ProductID + '">View Product';
                    productHtml += '<svg fill="none" class="rubicons arrow-right-up" xmlns="http://www.w3.org/2000/svg" width="auto" height="auto" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">';
                    productHtml += '<path d="M17.9645 12.9645l.071-7h-7.071" stroke-linecap="round"></path>';
                    productHtml += '<path d="M5.9645 17.9645l12-12" stroke-linecap="round" stroke-linejoin="round"></path>';
                    productHtml += '</svg></button>';
                    productHtml += '</div></div></div>';
                    $("#products").append(productHtml);
                });
            });
        }

        fetchProducts();

        $('#genderFilter, #categoryFilter').on('change', function () {
            fetchProducts();
        });

        $('#products').on('click', '.view-product', function () {
            var productId = $(this).data('product-id');
            window.location.href = 'product_details.php?product_id=' + productId;
        });
    });
</script>

</body>

</html>