function toggleMenuAsignaturas() {
    const summary = document.getElementById('boton-desplegable-header');

    if (!summary) return;

    const details = summary.closest('details');

    if (details) {
        details.open = !details.open;
    }
}