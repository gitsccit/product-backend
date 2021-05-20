function find_base_url() {
    let url = window.location.href;
    let index = url.indexOf('/hardware');

    return url.substr(0, index) + '/hardware/compare';
}

function product_compare(currentProduct, check = true) {
    let url = find_base_url();

    const currentCheckbox = document.getElementsByName(currentProduct)[0];
    currentCheckbox.checked = check;
    if (check) {
        url += `/${currentCheckbox.name}`;
    }

    const checkboxes = document.getElementsByClassName('product-compare');
    for (const checkbox of checkboxes) {
        if (checkbox.checked && checkbox.name != currentProduct) {
            url += `/${checkbox.name}`;
        }
    }

    let request = new XMLHttpRequest();
    const compareModal = document.querySelector('#compare-modal-content');
    request.onloadstart = function () {
        compareModal.innerHTML = `
            <div class="spinner-border text-primary align-self-center" role="status">
                <span class="sr-only">Loading...</span>
            </div>`;
    };
    request.onreadystatechange = function () {
        compareModal.innerHTML = request.response;
    };

    request.open('GET', url);
    request.setRequestHeader('X-Requested-With','XMLHttpRequest');
    request.send();

    return false;
}
