    
      <?php
// Get the current URL
$currentUrl = $_SERVER['REQUEST_URI'];

// Function to check if a URL matches the current URL
function isCurrentUrl($url, $currentUrl) {
    return rtrim($url, '/') === rtrim($currentUrl, '/');
}

?>
       
       <div class="d-flex flex-column align-items-center align-items-sm-start px-4 pt-2 text-white min-vh-100 shaadow">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none my-5 text-center border-bottom">
                    <h2 class="d-none d-sm-inline ">GEGE Admin</h2>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start mt-3" id="menu">
                    <li class="nav-item mb-3">
                        <a href="/gegeproject/admin/dashboard" class="nav-link align-middle px-4 py-2 text-white d-block  <?= isCurrentUrl('/gegeproject/admin/dashboard', $currentUrl) ? 'active' : '' ?>">
                        <i class="fa-solid fa-house"></i> <span class="ms-1 fs-5 fw-normal d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="/gegeproject/admin/user" class="nav-link px-4 py-2 align-middle text-white <?= isCurrentUrl('/gegeproject/admin/user', $currentUrl) ? 'active' : '' ?>">
                        <i class="fa-regular fa-user"></i><span class="ms-2 fs-5 fw-normal d-none d-sm-inline">Users</span> </a>
                    </li>

                    
                    <li class="nav-item mb-3">
                        <a href="/gegeproject/admin/media" class="nav-link px-4 py-2 align-middle text-white <?= isCurrentUrl('/gegeproject/admin/media', $currentUrl) ? 'active' : '' ?>">
                        <i class="fa-regular fa-image"></i> <span class="ms-1 fs-5 d-none d-sm-inline">Media</span> </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="./../../assets/img/profile.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1"><?=$_SESSION['user']['username']?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">

                        <li><a class="dropdown-item" href="../dashboard/logout.php">Sign out</a></li>
                    </ul>
                </div>
            </div>
      
            