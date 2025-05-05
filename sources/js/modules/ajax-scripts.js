/* eslint-env browser */
/* global fetch, FormData, mytheme_ajax_object */

/**
 * Handles AJAX-based pagination for blog listing.
 * Fetches filtered posts based on category and page number.
 * @param {number} paged - The page number to fetch (default is 1).
 */
function mytheme_ajaxPagination(paged = 1) {
    const postcategoryElement = document.getElementById('postcategory');
    const postcategory = postcategoryElement ? postcategoryElement.value : '';

    const data = new FormData();
    data.append('action', 'mytheme_ajaxsearch_filter');
    data.append('postcategory', postcategory);
    data.append('paged', paged);
    data.append('nonce', mytheme_ajax_object.nonce);

    const loadingIndicator = document.querySelector('.loading');
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }

    fetch(mytheme_ajax_object.ajax_url, {
        method: 'POST',
        body: data,
    })
        .then((response) => response.text())
        .then((html) => {
            const blogListing = document.querySelector('.blog-listing');
            if (blogListing) {
                blogListing.innerHTML = html;
            }
        })
        .finally(() => {
            if (loadingIndicator) {
                loadingIndicator.style.display = 'none';
            }
        });
}

/** Trigger AJAX pagination when the category dropdown changes */
document.addEventListener('change', function(e) {
    if (e.target && e.target.id === 'postcategory') {
        mytheme_ajaxPagination();
    }
});

/** Handle pagination clicks */
document.addEventListener('click', function(e) {
    const target = e.target;
    const pageLink = target.closest('.pagination .page-numbers');
    if (pageLink) {
        e.preventDefault();
        const pageValue = pageLink.textContent.trim();
        const page = parseInt(pageValue, 10);
        if (!isNaN(page)) {
            mytheme_ajaxPagination(page);
        }
    }
});
