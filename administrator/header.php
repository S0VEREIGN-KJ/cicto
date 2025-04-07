<header>
  <div class="header-content">
    <img src="../images/cicto_logo.png" alt="logo" class="logo">
    <div class="header-text">
      <h2>Administrator</h2> <!--TOP-->
      <p>City Information and Communication Technology Office</p>
      <p>City Hall , Dagupan Centro, Tabuk City, Kalinga</p>
    </div>
  </div>

  <<div class="picture">
  <img src="../images/tabuk.jpg" alt="Tabuk Image">
</div>

  <div id="time-date"> <!--DATE AND TIME-->
    <div id="clock"></div>
    <div id="calendar"></div>
  </div> <!--DATE AND TIME-->
</header>

<style>
  header {
    background-color: #2c3e50;
    color: white;
    padding: 20px;
    height: 160px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start; /* Aligns items at the top of the header */
    font-family: Arial, sans-serif;
    flex-wrap: wrap;
    z-index: 999999;
  }

  .header-content {
    display: flex;
    align-items: flex-start; /* Aligns logo and text to the top */
  }

  .picture {
  position: absolute;
  top: 0; /* Align with the top of the header */
  right: 20%; /* Slightly right-aligned */
  height: 200px; /* Make the height match the header */
  width: 30%; /* Adjust width for side design */
  background: linear-gradient(to right, rgba(0,0,0,0.5), rgba(0,0,0,0.3)); /* Design on the sides */
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 10px; /* Optional: Add some rounding for style */
}

.picture img {
  height: 100%; /* Ensures the image height matches the header */
  width: 100%;
  object-fit: cover; /* Ensures the image covers the area without stretching */
  border-radius: 10px; /* Optional: Add rounding for the image */
}

  .logo {
    width: 140px;
    height: 140px;
    margin-right: 20px;
  }

  .header-text {
    font-size: 18px;
  }

  .header-text h2 {
    font-size: 24px;
    font-weight: bold;
  }

  .header-text p {
    margin: 0; /* Remove any default margin */
    line-height: 1.5;
  }

  #time-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 14px;
  }

  #clock, #calendar {
    margin-right: 100px;
  }
</style>
