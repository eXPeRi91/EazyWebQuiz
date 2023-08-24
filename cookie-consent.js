// Get cookie consent banner and button
const cookieConsent = document.getElementById('cookieConsent');
const cookieConsentBtn = document.getElementById('cookieConsentBtn');

// Check if the user has given consent
if (!localStorage.getItem('cookieConsent')) {
    cookieConsent.style.display = 'block';
}

// Set cookie consent on button click
cookieConsentBtn.addEventListener('click', () => {
    localStorage.setItem('cookieConsent', 'true');
    cookieConsent.style.display = 'none';
});
