var comment_form = document.getElementById('add-comment-form');
var comments__title = document.getElementById('comments__title');

comment_form.addEventListener("submit", CommentDataSend);

async function CommentDataSend(e) {
    e.preventDefault();

    let comment_text = document.getElementById('add-comment-form__text');
    let post_id = parseInt(comment_form.getAttribute('data-post'));

    let commentFormData = new FormData(comment_form);
    commentFormData.append("post_id", post_id.toString());

    fetch('add_comment.php', {
        method: 'POST',
        body: commentFormData
    }
    )
        .then(response => response.text())
        .then((result) => {
            console.log(result);
            comments__title.insertAdjacentHTML('afterEnd', result);
            comment_text.textContent = "";
        })
        .catch(error => console.log(error));
}