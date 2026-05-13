document.addEventListener('DOMContentLoaded', () => {
    const alerts = Array.from(document.querySelectorAll('.alert'));

    alerts.forEach((alertElement) => {
        window.setTimeout(() => {
            alertElement.classList.add('fade');
            alertElement.classList.add('show');
        }, 10);
    });
});
