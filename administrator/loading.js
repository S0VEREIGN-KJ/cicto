// script.js
document.addEventListener("DOMContentLoaded", function() {
    const loadingOverlay = document.getElementById("loadingOverlay");

    // Function to show the loading overlay
    function showLoading() {
        loadingOverlay.style.display = "flex"; // Use flex to center the message
    }

    // Function to hide the loading overlay
    function hideLoading() {
        loadingOverlay.style.display = "none";
    }

    // Simulate loading process
    showLoading(); // Show overlay when loading starts

    // Simulate a loading delay (e.g., fetching data)
    setTimeout(() => {
        hideLoading(); // Hide overlay after loading is complete
    }, 1500); // Change this duration as needed
});