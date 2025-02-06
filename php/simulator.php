<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR QR Code Scanner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        footer{
            background-color: rgba(40, 167, 69, .9);
        }
    </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg sticky-top px-5 bg-success text-white">
      <div class="container-fluid">
          <a class="navbar-brand mx-5 text-white" href="../index.php">
                <img src="../images/clearteenalogo.png" class="teenanimlogo" alt="home logo" style="width: 50px; height: 50px;">
                <strong class="fs-5 ms-3">TEEN-ANIM</strong>
          </a>
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                      <a class="nav-link fw-semibold text-white" href="Forum/community.php">Farming Community</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link fw-semibold text-white mx-5" href="simulator.php">Simulation</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link fw-semibold text-white me-5" href="plantinder.php">Plantinder</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link fw-semibold text-white me-5" href="modulepage.php">Module</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link fw-semibold text-white me-5" href="userpage.php">Profile</a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>
    <main class="container text-center mt-5">
        <h1 class="mb-3">Experience Augmented Reality in Farming</h1>
        <p class="lead">Scan the QR code below to access our AR feature and explore interactive farming experiences. 
        This feature brings farming knowledge to life and provides a hands-on way to learn about sustainable agriculture.</p>
        <div class="row gap-3 p-5">
            <div class="card mx-auto p-3 col" style="width: 19em;">
                <img src="../images/qr2.png" class="card-img-top" alt="QR Code for AR">
                <div class="card-body">
                    <p class="card-text">Point your smartphone camera at this QR code or use a QR code scanner app to access the AR experience.</p>
                </div>
            </div>
            <div class="card mx-auto p-3 col" style="width: 19em;">
                <img src="../images/clearteenalogo.png" class="card-img-top" alt="Image for for AR">
                <div class="card-body">
                    <p class="card-text">After Dowloading the App. Point your camera here.</p>
                </div>
            </div>
        </div>
    </main>
    <footer class=" text-white text-center py-3">
        &copy; 2024 Farming AR. All rights reserved.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
