<head>
    <title>Global Weather</title>
    <!-- BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <!-- CSS -->
    <link rel="stylesheet" href="style.css" type="text/css">
    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">




</head>

<div class="d-flex flex-column align-items-end mt-4 me-5
">
    <div class="row">
        <button onclick="toggle()" class="btn btn-outline-secondary text-dark">toggle mode</button>
    </div>
</div>


<script>
    function toggle() {
        var element = document.body;
        element.classList.toggle("dark-mode");
    }
</script>
<nav class="container py-4 text-center">
    <div class="pb-3 mb-4 border-bottom">
        <a href="index.php" class="d-flex align-items-center text-dark text-decoration-none">
            <div class="display-5 fw-bold mx-auto dark mt-5" id="nav-bar"><a href="index.php">Global Weather</a></div>
            <h6 id="append-date"></h6>
        </a>
    </div>
</nav>

</div>

<!-- closing body tag in footer.php  -->