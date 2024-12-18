function toggleAccordion(header) {
    var content = header.nextElementSibling;
    if (content.style.maxHeight) {
        content.style.maxHeight = null;
    } else {
        var active = document.querySelector('.accordion-content.active');
        if (active) {
            active.style.maxHeight = null;
            active.classList.remove('active');
        }
        content.style.maxHeight = content.scrollHeight + 'px';
        content.classList.add('active');
    }
}