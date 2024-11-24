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
    
    <title>About Us</title>
<style>
    *{
        margin: 0;
        padding: 0;
    }

    html {
        scroll-behavior: smooth; /* Smooth scrolling */
    }

    .body1 {
        background-color: green;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    header {
        position: relative;
        width: 100%;
        background-color: white; 
        border-bottom: 1px solid black;             
    }

    .header-container1 {
        display: flex;
        justify-content: flex-end;
        padding: 0.8rem;
    }
    h1 {
        margin: 0;
        color: black;
        margin-left: 30px;
    }
    .profile-container{
        margin-right: 20px;
    }
    .about-section {
        padding: 40px 20px;
        color: #333;
        text-align: center;
    }

    .about {
        font-size: 35px;
        color: black;
        margin-top: 50px;
        text-align: center
    }

    .about-section p {
        font-size: 1.1rem;
        max-width: 800px;
        margin: 20px auto; /* Added margin for spacing between paragraphs */
        line-height: 1.6;
        text-align: justify; /* Added text-align to ensure paragraphs are justified */
        margin-top: 2px;
    }

    footer {
    background-color: #343434; /* Customize color as needed */
    color: white;
    padding-top: 50px;
    font-size: 16px;
}
.footer-container {
    max-width: 1140px;
    margin: auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 2px;
}
.footer-content {
    flex: 1;
    min-width: 300px;
    margin: 2px;
    text-align: center;
}
footer h3 {
    font-size: 28px;
    margin-bottom: 15px;
}
.footer-content p {
    margin: 5px 0;
    line-height: 1.5;
}
.footer-content ul {
    padding: 0;
    list-style: none;
}
.link-list li {
    margin: 10px 0;
    position: relative;
}
.link-list li::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 100%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: #f18930;
    transition: width 0.3s;
}
.link-list li:hover::before {
    width: 70px;
}
.link-list a {
    text-decoration: none;
    color: white;
    transition: color 0.3s;
}
.link-list a:hover {
    color: #f18930;
}
.social-icons {
    list-style: none;
    padding: 0;
    text-align: center;
}
.social-icons li {
    display: inline-block;
    margin: 0 5px;
}
.social-icons a {
    color: white;
    font-size: 25px;
    transition: color 0.3s;
}
.social-icons a:hover {
    color: #f18930;
}
.bottom-bar {
    background: #f18930;
    text-align: center;
    padding: 10px 0;
    margin-top: 50px;
}
.bottom-bar p {
    color: #343434;
    margin: 0;
}
@media screen and (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        align-items: center;
    }
    .footer-content {
        margin: 20px 0;
    }
}

</style>
    <script>
        /* JavaScript to Toggle Dropdown */
            document.addEventListener("DOMContentLoaded", function() {
                // Select the dropdown button and dropdown content
                const dropdownButton = document.querySelector(".dropbtn");
                const dropdownContent = document.querySelector(".dropdown-content");

                // Toggle dropdown on button click
                dropdownButton.addEventListener("click", function(event) {
                    // Prevent the click event from propagating to document
                    event.stopPropagation();

                    // Toggle visibility of the dropdown
                    dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
                });

                // Close dropdown if clicking outside of it
                document.addEventListener("click", function(e) {
                    if (!dropdownButton.contains(e.target) && !dropdownContent.contains(e.target)) {
                        dropdownContent.style.display = "none";
                    }
                });
            });
</script>

</head>
<body id="body1">

<header>
    <div class="header-container1 d-flex justify-content-between align-items-center">
        <h1 class="fw-bolder text-capitalized">Looc Fish Sanctuary</h1>
        <div class="profile-container d-flex align-items-center">
            <!-- Display logged-in username -->
            <span class="username me-3 text-black"><?php echo htmlspecialchars($username); ?></span>
            
            <!-- Profile dropdown -->
            <div class="dropdown">
                <i class="fa-solid fa-user-circle fa-2x profile-icon" data-bs-toggle="dropdown"></i>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#myProfileModal">
                            <i class="fa-solid fa-user-pen me-2"></i> My Profile
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

    <p class="about text-uppercase">About The Sanctuary</p>
<div class="about-section">
    <p>On 12 January 1999, the 48-hectare Looc Bay Marine Refuge and Fish Sanctuary was officially opened in the municipality after four years of intensive community education on the value and better management of marine resources. The local government, under the leadership of Mayor Leila Medina Arboleda  together with the community through their Barangay Fishermen Organization and Looc Baywatch Task Force, worked together to ensure the safety of  Looc's marine resources. The marine sanctuary was awarded two Trailblazing Galing Pook awards in 2000 and 2007(Finalist)  by the Galing Pook Foundation for being the best Coastal Resource Management program.</p>
    <p>It is home to multi-colored and wide variety of tropical reef fishes, sea grasses, and coral reef beds, giant clam garden; shy and elusive sea turtles and octopus, eels, pelagics, and white egrets that roost in the historical Looc Lighthouse during the night.</p>
    <p>Today, under the Municipal stewardship of Looc's Mayor, Atty. Lisette Medina Arboleda; intensified the programs and focus to further both environmental and community awareness that leads to the peak of nature conservation . The marine sanctuary is not just a refuge of marine wildlife, but a premier tourist destination and a reminder of how beauty of nature unfolds.</p>

<p>Other remarkable awards:
— Galing Pook Awards in 2000 and 2007 by the Galing Pook Foundation for being the best Coastal Resource Management Program
-Malinis at Masaganang Karagatan (MMK), Ranked as 1st place in the year 2016.
-1st place- Looc Marine Refuge and Fish Sanctuary during the 2024 MIMAROPA RSTWC, (Regional Science, Technology, and Innovation Week) at Calapan City, Oriental Mindoro.
Best Technopreneurship Award, MEDOW project (Modular Eco-Friendly Domestic Waste Water) Treatment Facility.</p>
</div>

<footer>
    <div class="footer-container">
        <div class="footer-content">
            <h3>Looc Fish Sanctuary</h3>
            <p>Email:  looc01tourism@gmail.com</p>
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
