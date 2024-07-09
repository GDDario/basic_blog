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