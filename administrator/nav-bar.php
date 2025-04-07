<div class="nav-bar">
</div>

<style>
  .nav-bar {
    position: static;
    left: 0;
    width: 100%;
    height: 15px; /* keep the height unchanged */
    background-color: #333;
    color: white;
    padding: 10px;
    text-align: center;
    position: relative;
    overflow: hidden;
    font-size: 14px; /* adjusting font size to fit the smaller height */
    font-weight: bold;
    letter-spacing: 1px;
    animation: backgroundPulse 3s infinite alternate; /* animation for background */
  }

  /* Animated glow effect on text */
  .nav-bar span {
    position: relative;
    z-index: 2;
    animation: textGlow 1.5s infinite alternate; /* text glow animation */
  }

  /* Background color pulse effect */
  @keyframes backgroundPulse {
    0% {
      background-color: #333;
    }
    50% {
      background-color: #555;
    }
    100% {
      background-color: #333;
    }
  }

  /* Text glow animation */
  @keyframes textGlow {
    0% {
      text-shadow: 0 0 5px rgba(255, 255, 255, 0.3), 0 0 10px rgba(255, 255, 255, 0.5);
    }
    50% {
      text-shadow: 0 0 10px rgba(255, 255, 255, 0.7), 0 0 15px rgba(255, 255, 255, 0.9);
    }
    100% {
      text-shadow: 0 0 5px rgba(255, 255, 255, 0.3), 0 0 10px rgba(255, 255, 255, 0.5);
    }
  }
</style>
