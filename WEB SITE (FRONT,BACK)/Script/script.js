function confirmLogout() {
    const isConfirmed = confirm("Are you sure you want to log out?");
    if (isConfirmed) {
        // Redirect to the login page
        window.location.href = "/index.html"; 
    }
}


document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('header nav ul');
    const heroSection = document.querySelector('.hero');

    // Image URLs for the background images
    const images = [
        '/images/image2.png',
        '/images/image3.png',
        '/images/image2.png'
    ];
    
    let currentIndex = 0;

    // Function to change background image
    function changeBackgroundImage() {
        currentIndex = (currentIndex + 1) % images.length;
        heroSection.style.backgroundImage = `url(${images[currentIndex]})`;
    }

    // Set an interval to change the image every 5 seconds
    setInterval(changeBackgroundImage, 5000);

    menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('show');
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".nav-links a");

    for (const link of links) {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            const targetId = this.getAttribute("href").substring(1);
            const targetSection = document.getElementById(targetId);

            if (targetSection) {
                window.scrollTo({
                    top: targetSection.offsetTop,
                    behavior: "smooth"
                });
            }
        });
    }
});


// Select all links with hashes
const links = document.querySelectorAll('a[href^="#"]');

links.forEach(link => {
    link.addEventListener('click', function(event) {
        // Prevent default anchor click behavior
        event.preventDefault();

        // Store hash
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        // Scroll to the target element
        targetElement.scrollIntoView({
            behavior: 'smooth', 
            block: 'start',    
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll('.nav-links a');

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault(); 
            const targetId = this.getAttribute('href'); 
            const targetSection = document.querySelector(targetId); 
            
            // Scroll to the target section
            targetSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start' 
            });
        });
    });
});

// Scroll to Top Button Functionality
const scrollToTopBtn = document.getElementById("scrollToTopBtn");

// Show button when scrolled down
window.onscroll = function () {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        scrollToTopBtn.classList.add("visible");
    } else {
        scrollToTopBtn.classList.remove("visible");
    }
};

// Smooth scroll to top on button click
scrollToTopBtn.onclick = function () {
    window.scrollTo({
        top: 0,
        behavior: "smooth" 
    });
};

document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('nav a');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('href').substring(1);
            scrollToSection(sectionId);
        });
    });
});

let lastScrollY = window.scrollY;
    let isScrollingDown = false;

    function handleScroll() {
        const header = document.getElementById('header');
        
        if (window.scrollY > lastScrollY) {
            // Scrolling down, hide the header
            header.style.top = '-80px';
            isScrollingDown = true;
        } else if (isScrollingDown) {
            // Scrolling up, show the header
            header.style.top = '0';
            isScrollingDown = false;
        }

        lastScrollY = window.scrollY;
    }

   // Get the menu toggle button and the nav element
const menuToggle = document.getElementById('menuToggle');
const nav = document.querySelector('nav');

// Add event listener for click
menuToggle.addEventListener('click', () => {
    nav.classList.toggle('active'); 
    menuToggle.classList.toggle('active'); 
});

function logout() {
    
    var confirmation = confirm("Are you sure you want to logout?");
    
    if (confirmation) {
        
        window.location.href = "/index.html";  e
    }
}





