document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.movie-card').forEach(function (card, index) {
        card.style.animationDelay = (index * 60) + 'ms';
        card.classList.add('fade-in-card');
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const frame = document.getElementById('episodeFrame');
    const buttons = document.querySelectorAll('.episode-btn');

    if (!frame || buttons.length === 0) return;

    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            const video = button.getAttribute('data-video');
            if (video) {
                frame.setAttribute('src', video);
            }
            buttons.forEach(function (item) {
                item.classList.remove('active');
            });
            button.classList.add('active');
        });
    });
});
