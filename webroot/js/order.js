function add_to_order(category, currentProduct) {
    let url = window.location.href;
    let index = url.indexOf(category);

    url = url.substr(0, index) + '/order';

    let request = new XMLHttpRequest();
    const compareModal = document.querySelector('#cart-modal-content');
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
    request.send();

    return false;
}
