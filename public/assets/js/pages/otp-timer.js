/* ====================================
   OTP VERIFICATION COUNTDOWN TIMER
   ==================================== */

(function() {
    let timeLeft = 600; // 10 minutes in seconds
    const countdown = document.getElementById('countdown');

    if (!countdown) return;

    const timer = setInterval(function() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        countdown.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

        if (timeLeft <= 0) {
            clearInterval(timer);
            countdown.textContent = 'Expired';
            countdown.classList.remove('text-danger');
            countdown.classList.add('text-secondary');
        }
        timeLeft--;
    }, 1000);
})();
