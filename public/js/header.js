const subMenu = document.getElementById('user-sub-menu');
const userMenu = document.getElementById('user-menu');
const adminButton = document.getElementById('admin-button');

userMenu.addEventListener('click', (e) => {
    e.stopPropagation();
    subMenu.classList.toggle('visible');
});

document.addEventListener('click', (e) => {
    if (!userMenu.contains(e.target) && !subMenu.contains(e.target)) {
        subMenu.classList.remove('visible');
    }
});
