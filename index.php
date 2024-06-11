<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vanity TOTAL Sales</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

table {
    width: 80%;
    margin: 40px auto;
    border-collapse: collapse;
    text-align: left;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

th, td {
    padding: 15px;
    border-bottom: 2px solid #ddd;
}

th {
    background-color: #303030; /* Updated color */
    color: #ffffff;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #f5f5f5;
}

.total-sales, .total-items {
    display: block;
    width: 50%; /* Shorter box */
    margin: 20px auto;
    padding: 10px;
    background-color: #303030; /* Updated color */
    color: #ffffff;
    text-align: center;
    border-radius: 5px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.size-count {
    margin: 20px auto;
    width: 80%;
}

.size-count div {
    margin-bottom: 10px;
}

/* ADD SALES BUTTON CSS */
.nav-container {
            display: flex;
            justify-content: center; /* Center the buttons horizontally */
            margin: 20px 0; /* Add some margin above and below the container */
        }

        .button {
            background-color: #303030; /* Dark gray background */
            color: white; /* White text */
            border: none;
            padding: 15px 30px;
            margin: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            background-color: #5cb85c;
        }

        .button:hover {
            background-color: #4cae4c;
        }
</style>
</head>
<body>

<?php
include 'db_connect.php'; // Include the database connection file

// SQL query to select data
$sql = "SELECT id, item, color, size, price, mop, channel, status FROM vanity_sales_2q2024";
$result = mysqli_query($con, $sql);

// Initialize variables
$total_price = 0;
$item_count = 0;
$bart_count = 0;
$butterfly_count = 0;
$paid_count = 0;
$unpaid_count = 0;

// Check if there are results and display them
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Item</th><th>Color</th><th>Size</th><th>Price</th><th>MOP</th><th>Channel</th><th>Status</th></tr>";
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $status_text = $row["status"] == 1 ? 'PAID' : 'UNPAID';
        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["item"]. "</td><td>" . $row["color"]. "</td><td>" . $row["size"]. "</td><td>₱" . number_format($row["price"], 2) . "</td><td>" . $row["mop"]. "</td><td>" . $row["channel"]. "</td><td>" . $status_text . "</td></tr>";
        $total_price += $row["price"];
        $item_count++;
        if ($row["item"] == 'Bart') $bart_count++;
        if ($row["item"] == 'Butterfly') $butterfly_count++;
        if ($row["status"] == 1) $paid_count++;
        else $unpaid_count++;
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Display the total price and item count
echo "<div class='total-sales'>Total Sales: ₱" . number_format($total_price, 2) . "</div>";
echo "<div class='total-items'>Total Number of Items: " . $item_count . "</div>";
echo "<div class='total-items'>Total Number of Bart: " . $bart_count . "</div>";
echo "<div class='total-items'>Total Number of Butterfly: " . $butterfly_count . "</div>";
echo "<div class='total-items'>Total Paid: " . $paid_count . "</div>";
echo "<div class='total-items'>Total Unpaid: " . $unpaid_count . "</div>";


// Do not close the connection here

// ... [size count queries and display code] ...

// Close the connection after all queries are done
mysqli_close($con);
?>


    
</div>

<div class="nav-container">
        <a href="add_sales.php" class="button">ADD SALES</a>
    </div>

<script>
window.onload = function() {
    var items = document.querySelectorAll('td:nth-child(2)');
    var sizes = document.querySelectorAll('td:nth-child(4)');
    var colors = document.querySelectorAll('td:nth-child(3)');
    var totals = {
        'Butterfly': {'WHITE': {}, 'BLACK': {}},
        'Bart': {'WHITE': {}, 'BLACK': {}}
    };

    // Initialize size counts
    ['S', 'M', 'L', 'XL', '2XL'].forEach(function(size) {
        totals['Butterfly']['WHITE'][size] = 0;
        totals['Butterfly']['BLACK'][size] = 0;
        totals['Bart']['WHITE'][size] = 0;
        totals['Bart']['BLACK'][size] = 0;
    });

    // Calculate totals
    items.forEach(function(item, index) {
        var itemText = item.textContent.trim();
        var sizeText = sizes[index].textContent.trim();
        var colorText = colors[index].textContent.trim();
        console.log('Item:', itemText, 'Size:', sizeText, 'Color:', colorText); // Debugging log
        if (totals[itemText] && totals[itemText][colorText] && totals[itemText][colorText][sizeText] !== undefined) {
            totals[itemText][colorText][sizeText]++;
        }
    });

    // Display totals
    for (var brand in totals) {
        for (var color in totals[brand]) {
            for (var size in totals[brand][color]) {
                var count = totals[brand][color][size];
                document.getElementById(brand + '-' + color + '-' + size).textContent = count;
            }
        }
    }
};
</script>

</body>



</html>
