// Dunkel- und Hellmodus Implementation

document.addEventListener('DOMContentLoaded', () => {
    const theme = localStorage.getItem('theme') || 'light';
    setTheme(theme);

    document.getElementById('toggleTheme').addEventListener('click', () => {
        const newTheme = document.getElementById('theme').getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        setTheme(newTheme);
    });
});

function setTheme(theme) {
    document.getElementById('theme').setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    if (theme === 'dark') {
        document.getElementsByClassName('themeIcon').src = '../assets/light.svg';
        document.getElementsByClassName('themeName').textContent = 'Hell';

    } else {
        document.getElementById('themeIcon').src = '../assets/dark.svg';
        document.getElementById('themeName').textContent = 'Dunkel';
    }
}

// Account Button Toggle

document.addEventListener('DOMContentLoaded', function() {
    const accountToggle = document.getElementById('account-toggle');
    const accountMenu = document.getElementById('account-menu');

    // Initially hide the menu
    accountMenu.style.display = 'none';

    accountToggle.addEventListener('click', function(event) {
        event.preventDefault();
        if (accountMenu.style.display === 'none') {
            accountMenu.style.display = 'flex';
        } else {
            accountMenu.style.display = 'none';
        }
    });
});

// Filter toggle menu

document.addEventListener('DOMContentLoaded', function() {
    const filterToggle = document.getElementById('filter-icon');
    const filterMenu = document.getElementById('filter-ui');

    filterMenu.style.display = "none";

    filterToggle.addEventListener('click', (event) => {
        event.preventDefault();
        if (filterMenu.style.display === 'none') {
            filterMenu.style.display = 'flex';
        } else {
            filterMenu.style.display = 'none';
        }
    });
});



