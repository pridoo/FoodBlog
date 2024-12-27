<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/footer.css"> <!-- Link to CSS file -->
</head>
<body>

<footer>
    <div class="footer-container" id="footer">
        <div class="footer-section">
            <h4>About</h4>
            <p  style="font-size:20px">We are a group of passionate technologists, designers, and problem-solvers who bring innovative solutions to life.</p>
        </div>
        <div class="footer-section">
            <h4>Contact</h4>
            <p style="font-size:20px">Email: contact@example.com</p>
            <p style="font-size:20px">Phone: (123) 456-7890</p>
        </div>
        <div class="footer-section">
            <h4>Follow Us</h4>
            <a style="font-size:20px" href="https://www.instagram.com" target="_blank">Instagram</a>
            <a style="font-size:20px" href="https://www.facebook.com" target="_blank">Facebook</a>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; <?php echo date("Y"); ?> YourWebsite. All rights reserved.
    </div>
</footer>

<!-- Scroll-up button -->
<button id="scrollUpBtn" class="scroll-up-btn">
    &#8679; <!-- This is a simple up arrow icon -->
</button>

<script>
    let scrollTimeout;

    // When the user scrolls, execute scrollFunction with a delay
    window.onscroll = function() {
        clearTimeout(scrollTimeout); // Clear the previous timeout
        scrollTimeout = setTimeout(scrollFunction, 100); // 100 ms delay
    };

    function scrollFunction() {
        var scrollUpBtn = document.getElementById("scrollUpBtn");
        if (window.pageYOffset + window.innerHeight >= document.body.offsetHeight - 100) {
            scrollUpBtn.style.display = "block";
        } else {
            scrollUpBtn.style.display = "none";
        }
    }

    // Scroll to the top when the button is clicked
    document.getElementById('scrollUpBtn').addEventListener('click', function() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    });
</script>

</body>
</html>
