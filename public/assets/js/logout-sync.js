window.addEventListener('storage', function(event) {
    if (event.key === 'logout') {
        // When logout event is detected in another tab, redirect to login page
        window.location.href = '/login';
    }
});

function logout() {
    // Set logout event in localStorage to notify other tabs
    localStorage.setItem('logout', Date.now());
    // Redirect to logout URL
    window.location.href = '/logout';
}
