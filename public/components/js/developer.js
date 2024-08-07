document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('click', (e) => {
        e.preventDefault();
        setTimeout(() => radio.checked = !radio.checked, 0);
    });
});
