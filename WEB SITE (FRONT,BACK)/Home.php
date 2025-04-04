<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jayamaga</title>
    <link rel="stylesheet" href="/Style/style.css">
    <script src="/Script/script.js" defer></script>
</head>
<body>
     <!-- Video Background -->
     <video autoplay muted loop id="bgVideo">
        <source src="/Videos/video 1.mp4" type="video/mp4">
    </video>
    <!-- Header Section -->
    <header>
        <div class="logo">JAYAMAGA</div>
        <nav>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#courses">Subjects</a></li>
                <li><a href="#events">Online Subjects</a></li>
                <li><a href="#contact">Contact</a></li>

            </ul> 
        </nav>
        <div class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>
    
    
    

    <!-- Hero Section -->
    <section id="home" class="hero">
        <h1><b>Welcome to Our Institute</b></h1>
        <p><b>Unlock your potential with quality education and training.</b></p>
        <a href="#footer" class="login-btn" style="
        display: inline-block;
        padding: 0.9rem 0;
        width: 100%;
        max-width: 350px; /* Adjust width as needed */
        border: none;
        border-radius: 10px;
        background: #ffc107; /* Yellow background */
        color: #000; /* Black text */
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-align: center; /* Centers the text */
        text-decoration: none; /* Remove underline */
        transition: all 0.3s ease;
      " onmouseover="this.style.background='#e0a800'; this.style.boxShadow='0px 5px 15px rgba(255, 193, 7, 0.3)'" onmouseout="this.style.background='#ffc107'; this.style.boxShadow='none'">
        Learn more
      </a>          
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <!-- About Content -->
        <div class="about-overlay">
            <h2 class="about-txt">About Us</h2>
            <div class="about-content">
                <img src="/Images/about.jpg" alt="Institute Image" class="about-image">
                <div class="about-text">
                    <p>We are a premier institute committed to providing high-quality education and training. Our mission is to empower students to achieve their full potential.</p>
                    <p>Founded in 2020, our institute has been at the forefront of innovative education, offering a range of courses designed to equip students with the skills needed for success in today's competitive job market.</p>
                    <p>Our dedicated faculty members bring a wealth of experience and knowledge, ensuring that students receive personalized attention and guidance throughout their learning journey.</p>
                    <p>Join us today and be a part of a vibrant learning community that fosters growth, creativity, and excellence.</p>
                </div>
            </div>
        </div>
    </section>

    <?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "institute";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM courses";
$result = $conn->query($sql);
?>

<section id="courses" class="courses">
    <h2>S U B J E C T S</h2>
    <div class="course-list">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="course">
                <div class="course-details">
                    <h3><?php echo $row['title']; ?></h3>
                    <p>
                        Time - <?php echo $row['time']; ?> <br>
                        Price - Rs <?php echo $row['price']; ?> <br>
                        Date - <?php echo $row['date']; ?>
                    </p>
                    <br>
                    <a href="/Subjects/<?php echo strtolower($row['title']); ?>.php" class="login-btn">
                        Select
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<style>
    /* Glow Animation */
    @keyframes glow {
        0% {
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.6), 0 0 20px rgba(255, 204, 0, 0.4);
        }
        100% {
            box-shadow: 0 0 20px rgba(255, 204, 0, 0.8), 0 0 40px rgba(255, 204, 0, 0.6);
        }
    }

    /* Glow Effect on Course Box */
    .course {
        display: inline-block;
        padding: 20px;
        margin: 20px;
        border: 2px solid #ffc107;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .course:hover {
        animation: glow 1.5s infinite alternate;
    }

    .course-details {
        text-align: center;
    }

    .login-btn {
        display: inline-block;
        padding: 0.9rem 0;
        width: 100%;
        max-width: 350px;
        border: none;
        border-radius: 10px;
        background: #ffc107;
        color: #000;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .login-btn:hover {
        background: #e0a800;
        animation: glow 1.5s infinite alternate;
    }

    .login-btn:focus {
        outline: none;
    }
</style>


<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "institute";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM online";
$result = $conn->query($sql);
?>

<section id="events" class="events">
    <h2>Online Classes</h2>
    <div class="event-list">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="event">
                <div class="event-details">
                    <h3><?php echo $row['title']; ?></h3>
                    <p><strong>Teacher:</strong> <?php echo $row['teacher']; ?></p>
                    <p><strong>Date:</strong> <?php echo $row['date']; ?></p>
                    <p><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
                    <br>
                    <a href="<?php echo $row['link']; ?>" class="login-btn">
                        Select
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<?php
$conn->close();
?>

<style>
    /* Glow Animation */
    @keyframes glow {
        0% {
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.6), 0 0 20px rgba(255, 204, 0, 0.4);
        }
        100% {
            box-shadow: 0 0 20px rgba(255, 204, 0, 0.8), 0 0 40px rgba(255, 204, 0, 0.6);
        }
    }

    /* Glow Effect on Event Box */
    .event {
        display: inline-block;
        padding: 20px;
        margin: 20px;
        border: 2px solid #ffc107;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .event:hover {
        animation: glow 1.5s infinite alternate;
    }

    .event-details {
        text-align: center;
    }

    /* Glow Effect on Select Button */
    .login-btn {
        display: inline-block;
        padding: 0.9rem 0;
        width: 100%;
        max-width: 350px;
        border: none;
        border-radius: 10px;
        background: #ffc107;
        color: #000;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .login-btn:hover {
        background: #e0a800;
        animation: glow 1.5s infinite alternate;
    }

    .login-btn:focus {
        outline: none;
    }
</style>



    <!-- Contact Section -->
<section id="contact" class="contact">
    <h2>Contact Us</h2>
    <div class="contact-container">
        <form class="contact-form">
            <input type="text" placeholder="Your Name" required>
            <input type="email" placeholder="Your Email" required>
            <textarea placeholder="Your Message" rows="4" required></textarea>
            <button type="submit" class="submit-button">Send Message</button>
        </form>
        <div class="contact-info">
            <h3>Get in Touch</h3>
            <p>For any inquiries or assistance, please reach out to us:</p>
            <p>Email: info@example.com</p>
            <p>Phone: +123 456 7890</p>
        </div>
    </div>
    <!-- Google Map -->
    <div class="map-container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345097165!2d144.95373531531852!3d-37.81720997975159!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f8f3b8f%3A0x4ae3e0e574decbf0!2sFederation%20Square!5e0!3m2!1sen!2sau!4v1637123456789!5m2!1sen!2sau" 
            width="100%" 
            height="300" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>
</section>

<style>
    /* Glow Animation */
    @keyframes glow {
        0% {
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.6), 0 0 20px rgba(255, 204, 0, 0.4);
        }
        100% {
            box-shadow: 0 0 20px rgba(255, 204, 0, 0.8), 0 0 40px rgba(255, 204, 0, 0.6);
        }
    }

    /* Contact Form Inputs and Textarea */
    .contact-form input, 
    .contact-form textarea {
        padding: 10px;
        margin: 10px 0;
        border: 2px solid #ccc;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .contact-form input:focus, 
    .contact-form textarea:focus {
        border-color: #ffc107;
        animation: glow 1.5s infinite alternate;
        box-shadow: 0 0 10px rgba(255, 204, 0, 0.6), 0 0 20px rgba(255, 204, 0, 0.4);
    }

    /* Submit Button */
    .submit-button {
        padding: 10px 20px;
        background: #ffc107;
        border: none;
        border-radius: 5px;
        color: #000;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .submit-button:hover {
        background: #e0a800;
        animation: glow 1.5s infinite alternate;
    }

    .submit-button:focus {
        outline: none;
    }

    /* Map Container */
    .map-container {
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    .map-container:hover {
        animation: glow 1.5s infinite alternate;
        box-shadow: 0 0 20px rgba(255, 204, 0, 0.6), 0 0 40px rgba(255, 204, 0, 0.4);
    }
</style>


    <!-- Register Now Banner -->
    <div class="register-now-banner">
        <a href="/Checout/CheckOut.html">
            <img src="/Images/—Pngtree—register now banner design transparent_8901766.png" alt="Register Now">
        </a>
    </div>

    <div class="time-baner">
        <a href="/studentTimeTableLogin.php">
            <img src="/Images/TimeImage.png" alt="Register Now">
        </a>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTopBtn" title="Go to top">↑</button>

    <!-- Footer Section -->
        <section id="footer" class="footer">
            <footer style="background-color: #000000; color: white; padding: 20px 0; text-align: center; font-family: Arial, sans-serif;">
                <div style="max-width: 1200px; margin: auto;">
                    <!-- Institute Name and Description -->
                    <div style="margin-bottom: 15px;">
                        <h2 style="margin: 0; font-size: 24px;">Jayamaga Institute</h2>
                        <p style="margin: 5px 0; font-size: 16px;">Empowering minds, shaping futures. Excellence in education and beyond.</p>
                    </div>
                    
                    <!-- Contact Details -->
                    <div style="margin-bottom: 15px; font-size: 14px;">
                        <p>Email: <a href="mailto:info@jayamaga.edu" style="color: #ffc107; text-decoration: none;">info@jayamaga.edu</a></p>
                        <p>Phone: <a href="tel:+94112223344" style="color: #ffc107; text-decoration: none;">+94 11 2233 344</a></p>
                        <p>Address: 123 Main Street, Colombo, Sri Lanka</p>
                    </div>
        
                    <!-- Social Media Links with Icons -->
                    <div style="margin-bottom: 15px;">
                        <a href="#" style="margin: 0 10px; color: white; font-size: 18px; text-decoration: none;">
                            <img src="https://img.icons8.com/ios-filled/24/ffffff/facebook--v1.png" alt="Facebook" style="vertical-align: middle;"> Facebook
                        </a>
                        <a href="#" style="margin: 0 10px; color: white; font-size: 18px; text-decoration: none;">
                            <img src="https://img.icons8.com/ios-filled/24/ffffff/twitter--v1.png" alt="Twitter" style="vertical-align: middle;"> Twitter
                        </a>
                        <a href="#" style="margin: 0 10px; color: white; font-size: 18px; text-decoration: none;">
                            <img src="https://img.icons8.com/ios-filled/24/ffffff/instagram-new.png" alt="Instagram" style="vertical-align: middle;"> Instagram
                        </a>
                        <a href="#" style="margin: 0 10px; color: white; font-size: 18px; text-decoration: none;">
                            <img src="https://img.icons8.com/ios-filled/24/ffffff/linkedin.png" alt="LinkedIn" style="vertical-align: middle;"> LinkedIn
                        </a>
                    </div>
        
                    <!-- Copyright -->
                    <div style="font-size: 14px; color: #f8f9fa;">
                        <p>&copy; 2024 Jayamaga Institute. All Rights Reserved.</p>
                    </div>
                </div>
            </footer>
        </section>


</body>
</html>
