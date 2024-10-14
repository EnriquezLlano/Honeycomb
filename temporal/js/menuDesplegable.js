function toggleDropdown() {
    var dropdown = document.getElementById('dropdown');
    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
}

// Cerrar el menú si se hace clic fuera de él
window.onclick = function(event) {
    if (!event.target.closest('.button_login')) {
        document.getElementById('dropdown').style.display = 'none';
    }
}
