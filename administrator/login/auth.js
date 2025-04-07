// auth.js - shared authentication logic

// Function to verify token
function verifyToken(token) {
    // Verify token (replace with actual API call)
    const verifyTokenRequest = new Promise((resolve, reject) => {
      setTimeout(() => {
        if (token === 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaGFuIjoiMjMwfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c') {
          resolve(true);
        } else {
          reject('Invalid token');
        }
      }, 1000);
    });
  
    return verifyTokenRequest;
  }
  
  // Function to check if user is authenticated
  function isAuthenticated() {
    // Check if the session variable is set
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'check_admin.php', true);
    xhr.onload = function() {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.authenticated) {
          return true;
        }
      }
      return false;
    };
    xhr.send();
  }
  
  // Export functions
  export { verifyToken, isAuthenticated };