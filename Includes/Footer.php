  <!-- Closing tag for container -->
  </div>
  <footer class="footer mt-auto py-3">
    <div id="special-container">

    </div>
    <div class="border-bottom pb-3 mb-3"></div>
    <p id="random-text" class="text-center text-muted">&copy; 2023 HelpDesk System</p>
  </footer>
  <!-- JS functions -->
  <script>
    // Function to generate random time interval
    function getRandomInterval(min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    // Function to show the image
    function showImage() {
      var img = document.getElementById('special-container');
      img.style.display = 'block';
      img.addEventListener("animationend", function() {
        img.style.display = 'none'; // Hide the image after the animation ends
        var randomDelay = getRandomInterval(minDelay, maxDelay);
        setTimeout(showImage, randomDelay); // Show the image again after a random delay
      });
    }

    // Function to show random text
    function showRandomText() {
      var originalText = "2023 HelpDesk System";
      var randomText = document.getElementById('random-text');
      var texts = [
        "May the Force be with you!",
        "Live long and prosper.",
        "In a galaxy far, far away...",
        "Engage!",
        "The Force will be with you, always.",
        "The dark side of the Force is a pathway to many abilities some consider to be unnatural.",
        "Space: the final frontier.",
        "Live long and prosper.",
        "Resistance is futile.",
        "It's a trap!",
        "I've got a bad feeling about this.",
        "The Force is strong with this one.",
        "Do or do not. There is no try.",
        "Help me, Obi-Wan Kenobi. You're my only hope.",
        "To boldly go where no one has gone before.",
        "Resistance is futile.",
        "I find your lack of faith disturbing.",
      ];
      var randomIndex = Math.floor(Math.random() * texts.length);
      var newText = texts[randomIndex];
      randomText.textContent = newText;

      setTimeout(function() {
        randomText.textContent = originalText;
      }, 5000); // Display the original text after 5 seconds
    }

    // Array of Death Star image URLs
    var Images = [
      '<?php echo BaseUrl; ?>/Resources/DeathStar.png',
      '<?php echo BaseUrl; ?>/Resources/xwing.png',
      // Add more image URLs as needed
    ];

    // Randomly select an image from the array
    var randomImageIndex = Math.floor(Math.random() * Images.length);
    var selectedImage = Images[randomImageIndex];

    // Set the selected image as the background
    var imageToBeShown = document.getElementById('special-container');
    imageToBeShown.style.backgroundImage = 'url(' + selectedImage + ')';

    // Calculate random delay values for image and text
    var minImageDelay = 300000; // Minimum delay in milliseconds for image 
    var maxImageDelay = 600000; // Maximum delay in milliseconds for image 
    var randomImageDelay = getRandomInterval(minImageDelay, maxImageDelay);

    var minTextDelay = 300000; // Minimum delay in milliseconds for text 
    var maxTextDelay = 600000; // Maximum delay in milliseconds for text 
    var randomTextDelay = getRandomInterval(minTextDelay, maxTextDelay);

    // Show the Death Star image and random text after the random delays
    setTimeout(function() {
      showImage();
      setInterval(showImage, randomImageDelay + 5000); // Show new random text after a delay
    }, randomImageDelay);
    setTimeout(function() {
      showRandomText();
      setInterval(showRandomText, randomTextDelay + 5000); // Show new random text after a delay
    }, randomTextDelay);

    feather.replace();

    function goBack() {
      window.history.back();
    }
  </script>
  </body>

  </html>