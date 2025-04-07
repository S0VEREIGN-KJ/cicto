// Get the clock and calendar elements
const clockDiv = document.getElementById('clock');
const calendarDiv = document.getElementById('calendar');

// Function to update the time and date
function updateTimeDate() {
    const now = new Date();
    const time = now.toLocaleTimeString();
    const date = now.toLocaleDateString();
    clockDiv.innerText = time;
    calendarDiv.innerText = date;
}

// Update the time and date every second
setInterval(updateTimeDate, 1000);