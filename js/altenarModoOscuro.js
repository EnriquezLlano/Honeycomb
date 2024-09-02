const toggleButton = document.getElementById('toggleMode');
const body = document.body;

function applyTheme(theme) {
    if (theme === 'dark') {
        body.classList.add('dark-mode');
        toggleButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sun-high" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M14.828 14.828a4 4 0 1 0 -5.656 -5.656a4 4 0 0 0 5.656 5.656z" />
          <path d="M6.343 17.657l-1.414 1.414" />
          <path d="M6.343 6.343l-1.414 -1.414" />
          <path d="M17.657 6.343l1.414 -1.414" />
          <path d="M17.657 17.657l1.414 1.414" />
          <path d="M4 12h-2" />
          <path d="M12 4v-2" />
          <path d="M20 12h2" />
          <path d="M12 20v2" />
        </svg>`;
    } else {
        body.classList.remove('dark-mode');
        toggleButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-moon-stars" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3c1e61" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
          <path d="M17 4a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2" />
          <path d="M19 11h2m-1 -1v2" />
        </svg>`;
    }
}

// Verifica la preferencia almacenada o la del sistema al cargar la página
function initializeTheme() {
    const storedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (storedTheme) {
        applyTheme(storedTheme);
    } else if (systemPrefersDark) {
        applyTheme('dark');
    } else {
        applyTheme('light');
    }
}

// Añade un evento click al botón para alternar el modo oscuro
toggleButton.addEventListener('click', () => {
    const isDarkMode = body.classList.contains('dark-mode');
    const newTheme = isDarkMode ? 'light' : 'dark';
    
    // Aplica el tema seleccionado y guarda la preferencia
    applyTheme(newTheme);
    localStorage.setItem('theme', newTheme);
});

// Inicializa el tema al cargar la página
initializeTheme();
