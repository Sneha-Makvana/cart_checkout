<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-4">
            <input type="text" id="search-box" class="form-control" placeholder="Search products...">
        </div>
        <div class="col-md-4">
            <select id="category-filter" class="form-control">
                <option value="">All Categories</option>
                <option value="Women">Women</option>
                <option value="Men">Men</option>
                <option value="Children">Children</option>
            </select>
        </div>
    </div>

    <div id="product-container" class="row"></div>

    <div class="row">
        <div class="col-12 text-center">
            <nav>
                <ul id="pagination" class="pagination justify-content-center mt-4"></ul>
            </nav>
        </div>
    </div>
</div>

<script>
    const fetchProducts = (page = 1) => {
        const search = $('#search-box').val();
        const category = $('#category-filter').val();

        $.ajax({
            url: '<?= base_url('product/fetchProducts') ?>',
            method: 'POST',
            data: {
                search,
                category,
                page
            },
            dataType: 'json',
            success: (response) => {
                const {
                    products,
                    total_count,
                    current_page,
                    per_page
                } = response;
                renderProducts(products);
                renderPagination(total_count, current_page, per_page);
            },
            error: () => {
                alert('Failed to fetch products. Please try again.');
            },
        });
    };

    const renderProducts = (products) => {
        const container = $('#product-container');
        container.empty();

        if (products.length === 0) {
            container.html('<div class="col-12"><p>No products found.</p></div>');
            return;
        }

        products.forEach((product) => {
            const productHTML = `
                <div class="col-lg-4 col-md-6 item-entry mb-4">
                    <a href="<?= base_url('product/display/') ?>${product.id}" class="product-item md-height bg-gray d-block">
                        <img src="<?= base_url('public/uploads/') ?>${product.image}" alt="${product.product_name}" class="img-fluid">
                    </a>
                    <div class="d-flex">
                        <h2 class="item-title">
                            <a href="<?= base_url('product/display/') ?>${product.id}" class="text-dark">${product.product_name}</a>
                        </h2>
                        <strong class="item-price">$${product.price}</strong>
                    </div>
                </div>
            `;
            container.append(productHTML);
        });
    };

    const renderPagination = (totalCount, currentPage, perPage) => {
        const pagination = $('#pagination');
        pagination.empty();

        const totalPages = Math.ceil(totalCount / perPage);

        for (let i = 1; i <= totalPages; i++) {
            const activeClass = i === currentPage ? 'active' : '';
            const pageItem = `
                <li class="page-item ${activeClass}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
            pagination.append(pageItem);
        }
    };

    $(document).ready(() => {
        fetchProducts();

        $('#search-box').on('input', () => fetchProducts());
        $('#category-filter').on('change', () => fetchProducts());
        $(document).on('click', '#pagination .page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            fetchProducts(page);
        });
    });
</script>

<?= $this->endSection(); ?>