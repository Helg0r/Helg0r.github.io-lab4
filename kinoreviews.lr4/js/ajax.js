var posts = document.querySelector('.reviews');
var ajax_loader = document.getElementById('ajax_loader_button');


function loadPostsListener(event) {

    var page = parseInt(ajax_loader.getAttribute('data-page'));
    page++;

    let max_page = parseInt(ajax_loader.getAttribute('data-page-max'));
    let url = 'more_posts.php?page=' + page;
    fetch(url)
        .then(response => response.text())
        .then((result) => {
            posts.insertAdjacentHTML('beforeend', result);
            ajax_loader.setAttribute('data-page', page.toString());
        })
        .catch(error => console.log(error));
    if (page == max_page) {
        ajax_loader.remove();
    }

}

ajax_loader.onclick = function () {
    loadPostsListener();
}
