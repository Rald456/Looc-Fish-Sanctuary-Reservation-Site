<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['username'])) {
    include('database.php'); // Ensure this file establishes `$conn`
    $user_id = $_SESSION['user_id'];

    $query = "SELECT username FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $user_data['username'];
    } else {
        $_SESSION['username'] = "Guest";
    }
}

$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <title>Home - Looc Fish Sanctuary</title>
</head>
<body id="body">

<header>
    <div class="header-container d-flex justify-content-between align-items-center">
        <h1 class="fw-bolder text-capitalized">Looc Fish Sanctuary</h1>
        <div class="profile-container d-flex align-items-center">
            <!-- Display logged-in username -->
            <span class="username me-3 text-white"><?php echo htmlspecialchars($username); ?></span>
            
            <!-- Profile dropdown -->
            <div class="dropdown">
                <i class="fa-solid fa-user-circle fa-2x profile-icon" data-bs-toggle="dropdown"></i>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#myProfileModal">
                            <i class="fa-solid fa-user-pen me-2"></i> My Account
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                            <i class="fa-solid fa-bell me-2"></i> Notifications
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#checkActivitiesModal">
                            <i class="fa-solid fa-list-check me-2"></i> Check Activities
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="logout.php">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Log Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<!-- Carousel Section -->
<div id="carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <div class="carousel-inner">
        <div class="carousel-item active c-item">
            <img src="1.jpg" class="d-block w-100 c-img" alt="slide1">
            <div class="carousel-caption top-0 mt-5">
            <div class="about-container">
                    <p class="about text-uppercase">About The Sanctuary</p>
                    <p class="about-text">The 48-hectare Looc Bay Marine Refuge and Fish Sanctuary is home to multi-colored and wide variety of tropical reef fishes, sea grasses, and coral reef beds, giant clam garden; shy and elusive sea turtles and octopus, eels, pelagics, and white egrets that roost in the historical Looc Lighthouse during the night.</p> 
                        <div class="text-center">
                            <a href="about-us.php" class="btn btn-outline-light mt-3" style="font-size: 1.2rem;">Learn More About Our History</a>
                        </div>
                </div>
            </div>
        </div>
        <div class="carousel-item c-item">
            <img src="2.jpg" class="d-block w-100 c-img" alt="slide2">
            <div class="carousel-caption top-0 mt-5">
                
                <p class="mt-5 fs-3 text-uppercase">We offer</p>
            </div>
        </div>
        <div class="carousel-item c-item">
            <img src="3.jpg" class="d-block w-100 c-img" alt="slide3">
            <div class="carousel-caption top-0 mt-5">
              
                <p class="mt-5 fs-3 text-uppercase">About The Sanctuary</p>
            </div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Reservation Form Section -->
<div class="container my-5" style="background-color: rgba(0, 0, 0, 0.7); padding: 20px; border-radius: 10px;">
    <h1 class="text-center mb-4 text-white">Make Reservation</h1>
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <form class="form-group" action="reservation_process.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="first_name" id="firstname_field" placeholder="First name" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="last_name" id="lastname_field" placeholder="Last name" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-venus-mars" aria-hidden="true"></i></span>
                            <select class="form-select" name="gender" required>
                                <option value="">Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-list-ol" aria-hidden="true"></i></span>
                            <input type="number" class="form-control" name="age" placeholder="Age" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="contact_number" placeholder="Contact Number" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            <input type="date" class="form-control" name="arrival_date" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-house" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="municipality" list="municipalityOptions" id="municipalityField" placeholder="Enter Municipality" required>  
                            <datalist id="municipalityOptions">
                                <option value="Looc">
                                <option value="Alcantara">
                                <option value="Calatrava">
                                <option value="Ferrol">
                                <option value="Odiongan">
                                <option value="San Agustin">
                                <option value="San Andres">
                                <option value="San Jose">
                                <option value="Santa Fe">
                                <option value="Cajidiocan">
                                <option value="Romblon">
                            </datalist>
                        </div>
                    </div>

                    <!-- Is Foreigner Checkbox -->
                    <div class="col-md-6">
                        <div class="input-group1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_foreigner" id="is_foreigner" value="1">
                                <label class="form-check-label" for="is_foreigner">
                                    Are you a Foreigner?
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Group Reservation Checkbox -->
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_group_reservation" id="is_group_reservation">
                            <label class="form-check-label" for="is_group_reservation">
                            Is this a Group Reservation?
                            </label>
                        </div>
                    </div>

                    <!-- Add Button for Group Members -->
                    <div class="col-md-6">
                        <button type="button" class="btn btn-info" id="addGroupMemberBtn" disabled>Add Group Member</button>
                    </div>

                    <!-- Button Section -->
                    <div class="col-12 mt-3 text-center">
                        <button type="submit" value="Submit" id="submit-btn" class="btn" style="background-color: black; color: white; border: 2px solid white; font-size: 1.2rem; padding: 10px;">Book Now</button>
                    </div>

                    <!-- Hidden Input for Group Members -->
                    <input type="hidden" name="group_members" id="groupMembersInput">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Adding Group Member -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel">Add Group Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addMemberForm">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="first_name" placeholder="First name" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="last_name" placeholder="Last name" required>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control" name="age" placeholder="Age" required>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" name="gender" required>
                            <option value="">Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="municipality" placeholder="Municipality" required id="groupMunicipalityField">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_foreigner" id="groupIsForeigner" value="1">
                            <label class="form-check-label" for="groupIsForeigner">
                                Are you a Foreigner?
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveMemberBtn">Save</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Check Activities -->
<div class="modal fade" id="checkActivitiesModal" tabindex="-1" aria-labelledby="checkActivitiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkActivitiesModalLabel">List of Reservations</h5>
            </div>
            <div class="modal-body"> <!-- This is where scrolling will occur -->
                <div id="reservations-list">
                    <?php
                    include('database.php');
                    $user_id = $_SESSION['user_id'];
                    $query = "SELECT * FROM reservation WHERE user_id = '$user_id'";
                    $result = mysqli_query($conn, $query);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $formatted_timestamp = date('F j, Y, g:i A', strtotime($row['timestamp']));

                            // Display reservation with a button to check details
                            echo "<div class='reservation-item d-flex justify-content-between'>";
                            echo "<div>";
                            echo "<strong>Reservation ID:</strong> " . htmlspecialchars($row['reservation_id']);
                            echo "</div>";
                            echo "<div class='text-end'>";
                            echo "<button class='btn btn-primary check-details-btn' data-bs-toggle='modal' data-id='" . htmlspecialchars($row['reservation_id']) . "'>Check Details</button><br>";
                            echo "<span class='timestamp'>" . $formatted_timestamp . "</span>";
                            echo "</div>";
                            echo "</div><hr>";
                        }
                    } else {
                        echo "<p>No reservations found.</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Check Details -->
<div class="modal fade" id="checkDetailsModal" tabindex="-1" aria-labelledby="checkDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="checkDetailsModalLabel">Reservation Details</h5>
                <button type="button" class="btn btn-secondary" id="backToCheckActivities" style="border: none; background: none;">
                    <i class="fas fa-arrow-left"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="reservation-details">
                    <!-- Reservation details will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for My Profile -->
<div class="modal fade" id="myProfileModal" tabindex="-1" aria-labelledby="myProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myProfileModalLabel">My Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 text-center">
                        <img src="default-profile.jpg" alt="Profile" class="rounded-circle mb-3" width="120" id="profilePreview">
                        <input type="file" class="form-control" name="profile_image" id="profileImageInput" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom Confirmation Modal -->
<div class="modal fade" id="customConfirmModal" tabindex="-1" aria-labelledby="customConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customConfirmModalLabel">Confirm Cancellation</h5>
      </div>
      <div class="modal-body">
        <!-- Centered Question Text -->
        <div class="question-text">
          <p>Are you sure you want to cancel your reservation?</p>
        </div>
        
        <!-- Radio Buttons for Reasons -->
        <label><strong>Select a reason for cancellation:</strong></label><br>

        <div class="radio-group">
          <input type="radio" id="reason1" name="cancelReason" value="I change my mind">
          <label for="reason1">I change my mind</label>
        </div>
        
        <div class="divider"></div>
        
        <div class="radio-group">
          <input type="radio" id="reason2" name="cancelReason" value="Change of Plans">
          <label for="reason2">Change of Plans</label>
        </div>
        
        <div class="divider"></div>

        <div class="radio-group">
          <input type="radio" id="reason3" name="cancelReason" value="An expected events">
          <label for="reason3">An unexpected events</label>
        </div>
        
        <div class="divider"></div>

        <div class="radio-group">
          <input type="radio" id="reason4" name="cancelReason" value="Other">
          <label for="reason4">Other (please specify):</label>
        </div>
        
        <!-- Input box for custom reason if 'Other' is selected -->
        <textarea id="customReason" class="form-control" rows="3" placeholder="Please specify the reason..." disabled></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="confirmCancelBtn">Confirm</button>
      </div>
    </div>
  </div>
</div>

<script src="script1.js"></script>

<footer>
    <div class="footer-container">
        <div class="footer-content">
            <h3>Looc Fish Sanctuary</h3>
            <p>Email: looc01tourism@gmail.com</p>
            <p>Phone: +63 948 003 5833</p>
            <p>Looc, Romblon, Philippines</p>
        </div>
        <div class="footer-content">
            <h3>Quick Links</h3>
            <ul class="link-list">
                <li><a href="loocsanctuary.php">Home</a></li>
                <li><a href="about-us.php">About Us</a></li>
                <li><a href="#">Visit</a></li>
            </ul>
        </div>
        <div class="footer-content">
            <h3>Follow Us</h3>
            <ul class="social-icons">
                <li><a href="https://www.facebook.com/search/top?q=looc%3A%20a%20premier%20tourist%20destination%20in%20romblon"><i class="fab fa-facebook"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="bottom-bar">
        <p>&copy; 2024 Looc Fish Sanctuary. All rights reserved.</p>
    </div>
</footer>

</body>
</html>