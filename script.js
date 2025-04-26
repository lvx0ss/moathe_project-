// script.js
document.getElementById('nightModeToggle').addEventListener('click', function() {
    document.body.classList.toggle('night-mode');
    
    // تغيير الصورة بناءً على الوضع
    if (document.body.classList.contains('night-mode')) {
        this.src = 'day.png';
        
    } else {
        this.src = 'night.png';
    }
});