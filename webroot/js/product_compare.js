function product_compare(baseUrl, currentProductID) {
    let url = baseUrl + '/hardware/compare';

    const currentCheckbox = document.getElementsByName(currentProductID)[0];
    currentCheckbox.checked = true;
    url += `/${currentCheckbox.name}`;

    const checkboxes = document.getElementsByClassName('product-compare');
    for (const checkbox of checkboxes) {
        if (checkbox.checked && checkbox.name != currentProductID) {
            url += `/${checkbox.name}`;
        }
    }

    let request = new XMLHttpRequest();
    const compareModal = document.querySelector('#compare-modal-content');
    request.onloadstart = function () {
        compareModal.innerHTML = `
            <div class="spinner-border text-primary align-self-center" role="status">
                <span class="sr-only"></span>
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
