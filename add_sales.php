<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vanity ADD Sales</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="AddSales.css">
<style>



</style>


</head>
<body>


<div class="form-container">
    <h2>VANITY SALES</h2>

    <div class="nav-container">
    <a href="view_sales.php" class="button">VIEW SALES</a>
    </div>
 

<?php

$errors = []; // Array to hold validation errors
$showPopup = false; // Flag to determine whether to show the pop-up

if(isset($_POST['ADD'])) {
    $item = $_POST['item'];
    $price = $_POST['price'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $mop = $_POST['mop'];
    $channel = $_POST['channel'];
    $status = $_POST['status'];

    // Validation checks
    if (empty($item)) {
        $errors['item'] = "Item name is required.";
    }
    if (!preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
        $errors['price'] = "Please enter a valid price.";
    }
    if (empty($color)) {
        $errors['color'] = "Color selection is required.";
    }
    // Add other validation checks as needed

    // If there are no errors, proceed with database insertion
    if (count($errors) == 0) {
        //Connect to DB
        include 'db_connect.php';

        // Prepare an insert statement for the correct table
        $sql = "INSERT INTO vanity_sales_2q2024 (item, color, size, price, mop, channel, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssissi", $item, $color, $size, $price, $mop, $channel, $status);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)) {
            $showPopup = true; // Set the flag to show the pop-up
        } else {
            echo "Error while adding: " . mysqli_error($con);
        }

        // Close statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($con);
    }
}

// Include the HTML and JavaScript for the pop-up if $showPopup is true
if ($showPopup):
?>
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">×</span>
        <h2>NEW SALE</h2>
        <p><strong>Item:</strong> <span id="popup-item"><?php echo htmlspecialchars($item); ?></span></p>
        <p><strong>Color:</strong> <span id="popup-color"><?php echo htmlspecialchars($color); ?></span></p>
        <p><strong>Size:</strong> <span id="popup-size"><?php echo htmlspecialchars($size); ?></span></p>
        <p><strong>Price: </strong> <span id="popup-price"><?php echo htmlspecialchars($price); ?></span></p>
    </div>
</div>


<script>
// JavaScript to handle the pop-up logic
window.onload = function() {
    // Show the pop-up
    document.getElementById('popup').style.display = 'block';
};

function closePopup() {
    // Hide the pop-up
    document.getElementById('popup').style.display = 'none';
}
</script>

<style>
/* CSS to style the full-screen pop-up */
.popup {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    display: flex;
    align-items: center;
    justify-content: center;
    
    
}

.popup-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%; /* Smaller width */
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    animation-name: animatetop;
    animation-duration: 0.4s;
}

.popup-content p {
    font-size: 1.2em; /* Larger font size */
}

/* Bold labels for item details */
.popup-content p strong {
    font-weight: bold;
}

@keyframes animatetop {
    from {top: -300px; opacity: 0}
    to {top: 0; opacity: 1}
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>



<?php endif; ?>


    <form method="post">

        <br>
        <label for="item">Item Name</label>
        <select name="item" id="item">
            <option value="" selected disabled class="placeholder">Item</option>
            <option value="Butterfly">Butterfly</option>
            <option value="Bart">Bart</option>
        </select>
        <br>



        <label for="price">Price</label>
    <input type="number" id="price" name="price" placeholder="Price" step="0.01">
    <?php if(isset($errors['price'])): ?>
        <div class="error-message"><?php echo $errors['price']; ?></div>
    <?php endif; ?>
    <br>


        <div class="radio-inputs">
            <label class="radio white">
                <input type="radio" name="color" value="White">
                <span class="name">White</span>
            </label>
            <label class="radio black">
                <input type="radio" name="color" value="Black">
                <span class="name">Black</span>
            </label>
            <label class="radio purple">
                <input type="radio" name="color" value="Purple">
                <span class="name">Purple</span>
            </label>
        </div>



        <label for="size">Size</label>
        <select name="size" id="size">
            <option value="" selected disabled class="placeholder">Size</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="2XL">2XL</option>
        </select>
        <br>


        <label for="mop">Mode of Payment</label>
        <select name="mop" id="mop">
            <option value="" selected disabled class="placeholder">Mode of Payment</option>
            <option value="Cash">Cash</option>
            <option value="Gcash">Gcash</option>
            <option value="Maya">Maya</option>
        </select>
        <br>



        <label for="channel">Sales Channel</label>
        <select name="channel" id="channel">
            <option value="" selected disabled class="placeholder">Sales Channel</option>
            <option value="Referral (Vhann)">Referral (Vhann)</option>
            <option value="Referral (Klyde)">Referral (Klyde)</option>
            <option value="Shopee">Shopee</option>
            <option value="Tiktok">Tiktok</option>
        </select>
        <br>
        <br>


        <div class="radio-group">
            <label><input type="radio" name="status" value="PAID"> Paid</label>
            <label><input type="radio" name="status" value="UNPAID"> Unpaid</label>
        </div>
        <br>

        <input type="submit" name="add" value="ADD SALE">

    </form>
</div>



<script>
// JavaScript for form validation and error display
document.getElementById('itemForm').onsubmit = function(event) {
    var hasError = false;
    // Example validation check
    if (document.getElementById('price').value === '') {
        document.getElementById('priceError').style.display = 'block';
        hasError = true;
    }
    // Add other validation checks as needed

    if (hasError) {
        event.preventDefault(); // Prevent form submission if there are errors
    }
};
</script>

</body>
</html>

