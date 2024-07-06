const modal = document.getElementById('delete-modal');
const uuidInput = document.getElementById('uuid');

function openModal(uuid) {
    modal.classList.toggle('visible');

    uuidInput.value = uuid;
}

document.addEventListener('click', (e) => {
    if (e.target.classList.contains('close-modal')) {
        modal.classList.toggle('visible');
    }
})