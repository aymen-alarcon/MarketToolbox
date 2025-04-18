<?php
   session_start();
   include 'db.php';
   
   $isLoggedIn = isset($_SESSION['UserID']);
   $initial = '';

   if ($isLoggedIn) {
      $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
      $initial = strtoupper(substr($username, 0, 1));
   }

   $query = "SELECT type FROM users WHERE UserID = :UserID";
   $stmt = $pdo->prepare($query);
   $stmt->bindParam(':UserID', $_SESSION['UserID']);
   $stmt->execute();
   $type = $stmt->fetch();

   $sql_rooms = "SELECT room_id, room_name_en, room_name_fr, room_name_ar FROM rooms";
   $stmt_rooms = $pdo->prepare($sql_rooms);
   $stmt_rooms->execute();
   $rooms = $stmt_rooms->fetchAll(PDO::FETCH_ASSOC);

   $preferred_language = 'en';

?>
<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
   <title>MarkeToolbox</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="shortcut icon" type="image/x-icon" href="assets/img/MarketToolbox.jpeg">
   <link rel="stylesheet" href="assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
   <link rel="stylesheet" href="assets/css/fontawesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <script src="https://unpkg.com/akar-icons-fonts"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</head>
<style>
   .dropdown-content {
    display: none;
    position: absolute;
    background-color: hsl(230, 100%, 98%);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    min-width: 160px;
    z-index: 1;
    padding: 10px 0;
    border-radius: 5px;
}

.dropdown-content a {
    color: #333;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: hsl(230, 75%, 56%);
    color: hsl(230, 100%, 98%);
}

.nav__item:hover .dropdown-content {
    display: block;
}

</style>
<body>
   <div id="content">
      <?php
         $message = isset($_GET['message']) ? $_GET['message'] : '';
         $success = isset($_GET['success']) ? $_GET['success'] : '';
         $error = isset($_GET['error']) ? $_GET['error'] : '';

         if ($message) {
            $alertType = $success ? 'alert-success' : 'alert-danger';
            $alertMessage = urldecode($message);
            echo '<div class="floating-alert alert ' . $alertType . ' alert-dismissible fade show mt-5" role="alert" id="floating-alert">
                     ' . $alertMessage . '
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
         }
      ?>
      <header class="header" id="header">
         <nav class="nav d-flex align-items-center">
            <div class="burger-menu me-4 mb-4">
               <label class="container">
                  <input type="checkbox" id="menu-toggle">
                  <div class="checkmark" onclick="openNav()">
                     <span></span>
                     <span></span>
                     <span></span>
                  </div>
               </label>
            </div>
            <div id="sidenav" class="sidenav">
               <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
               <div class="input">
               <button class="value">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024" stroke-width="0" fill="currentColor" stroke="currentColor" class="icon"><path d="M946.5 505L560.1 118.8l-25.9-25.9a31.5 31.5 0 0 0-44.4 0L77.5 505a63.9 63.9 0 0 0-18.8 46c.4 35.2 29.7 63.3 64.9 63.3h42.5V940h691.8V614.3h43.4c17.1 0 33.2-6.7 45.3-18.8a63.6 63.6 0 0 0 18.7-45.3c0-17-6.7-33.1-18.8-45.2zM568 868H456V664h112v204zm217.9-325.7V868H632V640c0-22.1-17.9-40-40-40H432c-22.1 0-40 17.9-40 40v228H238.1V542.3h-96l370-369.7 23.1 23.1L882 542.3h-96.1z"></path></svg>
                  <a href="index.php">Home</a>
               </button>
                  <?php
                     if(isset($_SESSION['UserID'])) {
                        echo '
                           <button class="value">
                              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="0" fill="currentColor" stroke="currentColor" class="icon"><path d="M12 2.5a5.5 5.5 0 0 1 3.096 10.047 9.005 9.005 0 0 1 5.9 8.181.75.75 0 1 1-1.499.044 7.5 7.5 0 0 0-14.993 0 .75.75 0 0 1-1.5-.045 9.005 9.005 0 0 1 5.9-8.18A5.5 5.5 0 0 1 12 2.5ZM8 8a4 4 0 1 0 8 0 4 4 0 0 0-8 0Z"></path></svg>
                              <a href="profile_user.php">Profile</a>
                           </button>
                        ';
                     } else {
                        echo '';
                     }
                  ?>
                  <?php
                     if(isset($_SESSION['UserID'])) {                  
                        if ($type['type'] == '2') {
                           echo '
                                 <button class="value">
                                    <svg id="Line" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill="#7D8590" id="XMLID_1646_" d="m17.074 30h-2.148c-1.038 0-1.914-.811-1.994-1.846l-.125-1.635c-.687-.208-1.351-.484-1.985-.824l-1.246 1.067c-.788.677-1.98.631-2.715-.104l-1.52-1.52c-.734-.734-.78-1.927-.104-2.715l1.067-1.246c-.34-.635-.616-1.299-.824-1.985l-1.634-.125c-1.035-.079-1.846-.955-1.846-1.993v-2.148c0-1.038.811-1.914 1.846-1.994l1.635-.125c.208-.687.484-1.351.824-1.985l-1.068-1.247c-.676-.788-.631-1.98.104-2.715l1.52-1.52c.734-.734 1.927-.779 2.715-.104l1.246 1.067c.635-.34 1.299-.616 1.985-.824l.125-1.634c.08-1.034.956-1.845 1.994-1.845h2.148c1.038 0 1.914.811 1.994 1.846l.125 1.635c.687.208 1.351.484 1.985.824l1.246-1.067c.787-.676 1.98-.631 2.715.104l1.52 1.52c.734.734.78 1.927.104 2.715l-1.067 1.246c.34.635.616 1.299.824 1.985l1.634.125c1.035.079 1.846.955 1.846 1.993v2.148c0 1.038-.811 1.914-1.846 1.994l-1.635.125c-.208.687-.484 1.351-.824 1.985l1.067 1.246c.677.788.631 1.98-.104 2.715l-1.52 1.52c-.734.734-1.928.78-2.715.104l-1.246-1.067c-.635.34-1.299.616-1.985.824l-.125 1.634c-.079 1.035-.955 1.846-1.993 1.846zm-5.835-6.373c.848.53 1.768.912 2.734 1.135.426.099.739.462.772.898l.18 2.341 2.149-.001.18-2.34c.033-.437.347-.8.772-.898.967-.223 1.887-.604 2.734-1.135.371-.232.849-.197 1.181.089l1.784 1.529 1.52-1.52-1.529-1.784c-.285-.332-.321-.811-.089-1.181.53-.848.912-1.768 1.135-2.734.099-.426.462-.739.898-.772l2.341-.18h-.001v-2.148l-2.34-.18c-.437-.033-.8-.347-.898-.772-.223-.967-.604-1.887-1.135-2.734-.232-.37-.196-.849.089-1.181l1.529-1.784-1.52-1.52-1.784 1.529c-.332.286-.81.321-1.181.089-.848-.53-1.768-.912-2.734-1.135-.426-.099-.739-.462-.772-.898l-.18-2.341-2.148.001-.18 2.34c-.033.437-.347.8-.772.898-.967.223-1.887.604-2.734 1.135-.37.232-.849.197-1.181-.089l-1.785-1.529-1.52 1.52 1.529 1.784c.285.332.321.811.089 1.181-.53.848-.912 1.768-1.135 2.734-.099.426-.462.739-.898.772l-2.341.18.002 2.148 2.34.18c.437.033.8.347.898.772.223.967.604 1.887 1.135 2.734.232.37.196.849-.089 1.181l-1.529 1.784 1.52 1.52 1.784-1.529c.332-.287.813-.32 1.18-.089z"></path><path id="XMLID_1645_" fill="#7D8590" d="m16 23c-3.859 0-7-3.141-7-7s3.141-7 7-7 7 3.141 7 7-3.141 7-7 7zm0-12c-2.757 0-5 2.243-5 5s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z"></path></svg>
                                    <a href="settings.php">Settings</a>
                                 </button>
                              ';
                        } else {
                           echo '';
                        }
                     }
                  ?>
                  <?php
                     if(isset($_SESSION['UserID'])) {                  
                        if ($type['type'] == '2') {
                           echo '
                              <button class="value">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path d="M12 20v-6m0 0v-4m0 4h4m-4 0H8"></path></svg>
                                 <a href="add_product.php">Add a New Product</a>
                              </button>
                           ';
                        } else {
                           echo '';
                        }
                     }
                  ?>
                  <button class="value">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M5 6h18l-2 11H7L5 6z"></path>
                        <path d="M7 6L6 2H2"></path>
                     </svg>
                     <a href="#">Products</a>
                  </button>
                  <button class="value">
                     <svg viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg"><path fill="#7D8590" d="m109.9 20.63a6.232 6.232 0 0 0 -8.588-.22l-57.463 51.843c-.012.011-.02.024-.031.035s-.023.017-.034.027l-4.721 4.722a1.749 1.749 0 0 0 0 2.475l.341.342-3.16 3.16a8 8 0 0 0 -1.424 1.967 11.382 11.382 0 0 0 -12.055 10.609c-.006.036-.011.074-.015.111a5.763 5.763 0 0 1 -4.928 5.41 1.75 1.75 0 0 0 -.844 3.14c4.844 3.619 9.4 4.915 13.338 4.915a17.14 17.14 0 0 0 11.738-4.545l.182-.167a11.354 11.354 0 0 0 3.348-8.081c0-.225-.02-.445-.032-.667a8.041 8.041 0 0 0 1.962-1.421l3.16-3.161.342.342a1.749 1.749 0 0 0 2.475 0l4.722-4.722c.011-.011.018-.025.029-.036s.023-.018.033-.029l51.844-57.46a6.236 6.236 0 0 0 -.219-8.589zm-70.1 81.311-.122.111c-.808.787-7.667 6.974-17.826 1.221a9.166 9.166 0 0 0 4.36-7.036 1.758 1.758 0 0 0 .036-.273 7.892 7.892 0 0 1 9.122-7.414c.017.005.031.014.048.019a1.717 1.717 0 0 0 .379.055 7.918 7.918 0 0 1 4 13.317zm5.239-10.131c-.093.093-.194.176-.293.26a11.459 11.459 0 0 0 -6.289-6.286c.084-.1.167-.2.261-.3l3.161-3.161 6.321 6.326zm7.214-4.057-9.479-9.479 2.247-2.247 9.479 9.479zm55.267-60.879-50.61 56.092-9.348-9.348 56.092-50.61a2.737 2.737 0 0 1 3.866 3.866z"></path></svg>
                     <a href="#">About us</a>
                  </button>
                  <button class="value">
                     <svg fill="none" viewBox="0 0 24 25" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="m11.9572 4.31201c-3.35401 0-6.00906 2.59741-6.00906 5.67742v3.29037c0 .1986-.05916.3927-.16992.5576l-1.62529 2.4193-.01077.0157c-.18701.2673-.16653.5113-.07001.6868.10031.1825.31959.3528.67282.3528h14.52603c.2546 0 .5013-.1515.6391-.3968.1315-.2343.1117-.4475-.0118-.6093-.0065-.0085-.0129-.0171-.0191-.0258l-1.7269-2.4194c-.121-.1695-.186-.3726-.186-.5809v-3.29037c0-1.54561-.6851-3.023-1.7072-4.00431-1.1617-1.01594-2.6545-1.67311-4.3019-1.67311zm-8.00906 5.67742c0-4.27483 3.64294-7.67742 8.00906-7.67742 2.2055 0 4.1606.88547 5.6378 2.18455.01.00877.0198.01774.0294.02691 1.408 1.34136 2.3419 3.34131 2.3419 5.46596v2.97007l1.5325 2.1471c.6775.8999.6054 1.9859.1552 2.7877-.4464.795-1.3171 1.4177-2.383 1.4177h-14.52603c-2.16218 0-3.55087-2.302-2.24739-4.1777l1.45056-2.1593zm4.05187 11.32257c0-.5523.44772-1 1-1h5.99999c.5523 0 1 .4477 1 1s-.4477 1-1 1h-5.99999c-.55228 0-1-.4477-1-1z" fill="#7D8590" fill-rule="evenodd"></path></svg>
                     <a href="index.php#footer">Contact Us</a>
                  </button>
               </div>
               <button class="value">
                  <i class="bi bi-translate"></i>
                  <a href="#">Language</a>
               </button>

               <?php
                  if(isset($_SESSION['UserID'])) {
                     echo '
                        <div class="bottom">
                           <div class="logout">
                              <i class="bi bi-box-arrow-left" style="width: 20px;"></i>                     
                              <a href="logout.php" style="color: #000;">Logout</a>
                           </div>
                        </div>
                     ';
                  } else {
                     echo '
                        <div class="bottom">
                           <div class="logout">
                              <i class="bi bi-box-arrow-left" style="width: 20px;"></i>                     
                              <a href="sign-up.php" style="color: #000;">Sign Up</a>
                           </div>
                        </div>
                     ';
                  }
               ?>
            </div>
            <div class="nav__logo">
               <a href="index.php"><img src="assets/img/MarkerToolbox.png" alt=""></a>
            </div>
            <div class="nav__menu" id="nav-menu">
               <ul class="nav__list">
                  <li class="nav__item">
                     <a href="#" class="nav__link">Rooms</a>
                     <div class="dropdown-content">
                        <?php if (!empty($rooms)): ?>
                              <?php foreach ($rooms as $room): ?>
                                 <a href="#"><?= htmlspecialchars($room['room_name_en']) ?></a>
                              <?php endforeach; ?>
                        <?php else: ?>
                              <p>No rooms available</p>
                        <?php endif; ?>
                     </div>
                  </li>
                  <li class="nav__item">
                     <a href="#" class="nav__link">About Us</a>
                  </li>
                  <li class="nav__item">
                     <a href="index.php#footer" class="nav__link">Contact US</a>
                  </li>
               </ul>
               <div class="nav__close" id="nav-close">
                  <i class="ri-close-line"></i>
               </div>
            </div>
            <div class="nav__actions mx-3 mb-3">
            <i class="ri-search-line nav__search" id="search-btn"></i>
               <?php if ($isLoggedIn): ?>
                  <div class="nav__user">
                     <div class="nav__avatar" id="user-avatar"><?php echo $initial; ?></div>
                     <ul class="nav__dropdown" id="user-dropdown">
                        <li class="nav__dropdown-item">
                           <i class="bi bi-gear"></i>
                           <a href="settings.php">Settings</a>
                        </li>
                        <li class="nav__dropdown-item">
                           <i class="bi bi-box-arrow-left" style='width: 20px;'></i>
                           <a href="logout.php">Logout</a>
                        </li>
                     </ul>
                  </div>
               <?php else: ?>
                  <i class="ri-user-line nav__login" id="login-btn"></i>
               <?php endif; ?>
               <div class="nav__toggle" id="nav-toggle">
                  <i class="ri-menu-line"></i>
               </div>
            </div>
         </nav>
      </header>
      <div class="search" id="search">
         <form action="" class="search__form">
            <i class="ri-search-line search__icon"></i>
            <input type="search" placeholder="What are you looking for?" class="search__input">
         </form>
         <i class="ri-close-line search__close" id="search-close"></i>
      </div>
      <?php if (!$isLoggedIn): ?>
         <div class="login" id="login">
            <form action="login-process.php" class="login__form" method="POST">
               <h2 class="login__title">Log In</h2>
               <div class="login__group">
                  <div>
                     <label for="email" class="login__label">Email</label>
                     <input type="email" placeholder="Write your email" id="email" name="email" class="login__input">
                  </div>
                  <div>
                     <label for="password" class="login__label">Password</label>
                     <input type="password" placeholder="Enter your password" id="password" name="password" class="login__input">
                  </div>
               </div>
               <div>
                  <p class="login__signup">
                     You do not have an account? <a href="sign-up.php">Sign up</a>
                  </p>
                  <a href="#" class="login__forgot">
                     You forgot your password
                  </a>
                  <button type="submit" class="login__button">Log In</button>
               </div>
            </form>
            <i class="ri-close-line login__close" id="login-close"></i>
         </div>
      <?php endif; ?>
   </div>
   <script>
      document.addEventListener('DOMContentLoaded', function () {
         var userAvatar = document.getElementById('user-avatar');
         var userDropdown = document.getElementById('user-dropdown');

         userAvatar.addEventListener('click', function () {
            var isVisible = userDropdown.style.display === 'block';
            userDropdown.style.display = isVisible ? 'none' : 'block';
         });

         document.addEventListener('click', function (event) {
               if (!userAvatar.contains(event.target) && !userDropdown.contains(event.target)) {
                  userDropdown.style.display = 'none';
               }
            });
      });

      setTimeout(function() {
         var alert = document.getElementById("floating-alert");
         if (alert) {
            alert.classList.remove('show');
         }
      }, 5000);
   </script>