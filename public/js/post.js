const createCommentButton = document.getElementById('create-comment');
const newCommentContainer = document.getElementById('new-comment');
const newCommentContent = document.getElementById('new-comment-content');
const closeNewCommentButton = document.getElementById('close-new-comment');
const publishCommentButton = document.getElementById('publish-comment');
const commentsContainer = document.getElementById('comments-container');

createCommentButton.addEventListener('click', () => {
    newCommentContainer.classList.add('visible');
});

publishCommentButton.addEventListener('click', () => {
    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState === XMLHttpRequest.DONE && ajax.status === 200) {
            const newCommentData = JSON.parse(ajax.responseText);

            const newPostElement = document.createElement('div');
            newPostElement.innerHTML = `
                <div class="comment">
                    <p>${newCommentData.name} at ${newCommentData.created_at}</p>
                    <br>
                    <p>${newCommentData.content}</p>
                </div>
            `;

            commentsContainer.prepend(newPostElement);
            closeNewCommentButton.dispatchEvent(new Event('click'));
        }
    }

    ajax.open('POST', '../../includes/forms/create-comment.php');
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const content = encodeURIComponent(newCommentContent.value);
    ajax.send(`content=${content}&post_uuid=${uuid}`);
})

closeNewCommentButton.addEventListener('click', () => {
    newCommentContainer.classList.remove('visible');
    newCommentContent.value = '';
});

function likeComment(element) {
    const id = element.id;
    const commentId = id.split('-')[1];

    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState === XMLHttpRequest.DONE && ajax.status === 200) {
            const likesCounter = document.getElementById(`number_likes-${commentId}`);

            console.log('Response', ajax.responseText)

            switch (ajax.responseText) {
                case 'removed-like':
                    console.log('Removed liked')
                    likesCounter.innerHTML = parseInt(likesCounter.innerHTML) - 1;
                    break;
                case 'removed-dislike':
                    console.log('Removed disliked')
                    const dislikesCounter = document.getElementById(`number_dislikes-${commentId}`);

                    likesCounter.innerHTML = parseInt(likesCounter.innerHTML) + 1;
                    dislikesCounter.innerHTML = parseInt(dislikesCounter.innerHTML) - 1;
                    break;
                default:
                    console.log('Added liked')
                    likesCounter.innerHTML = parseInt(likesCounter.innerHTML) + 1;
                    break;
            }
        }
    }

    ajax.open('POST', '../../includes/forms/like-comment.php');
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send(`comment_id=${commentId}`);
}

function dislikeComment(element) {
    const id = element.id;
    const commentId = id.split('-')[1];

    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState === XMLHttpRequest.DONE && ajax.status === 200) {
            const dislikesCounter = document.getElementById(`number_dislikes-${commentId}`);

            switch (ajax.responseText) {
                case 'removed-dislike':
                    dislikesCounter.innerHTML = parseInt(dislikesCounter.innerHTML) - 1;
                    break;
                case 'removed-like':
                    const likesCounter = document.getElementById(`number_likes-${commentId}`);

                    dislikesCounter.innerHTML = parseInt(dislikesCounter.innerHTML) + 1;
                    likesCounter.innerHTML = parseInt(likesCounter.innerHTML) - 1;
                    break;
                default:
                    dislikesCounter.innerHTML = parseInt(dislikesCounter.innerHTML) + 1;
                    break;
            }
        }
    }

    ajax.open('POST', '../../includes/forms/dislike-comment.php');
    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ajax.send(`comment_id=${commentId}`);

}