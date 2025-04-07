const logoutLink = document.getElementById('logout-link');
const confirmOverlay = document.getElementById('confirm-overlay');
const confirmYesBtn = document.getElementById('confirm-yes');
const confirmNoBtn = document.getElementById('confirm-no');

logoutLink.addEventListener('click', (e) => {
  e.preventDefault();
  confirmOverlay.style.display = 'block';
});

confirmYesBtn.addEventListener('click', () => {
  window.location.href = '../logout.php';
  confirmOverlay.style.display = 'none';
});

confirmNoBtn.addEventListener('click', () => {
  confirmOverlay.style.display = 'none';
});