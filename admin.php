<!-- admin.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Flight</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "flights");
    if ($conn->connect_error) die("Connection failed");

    $departure_city = $_POST['departure_city'];
    $arrival_city = $_POST['arrival_city'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $departure_date = $_POST['departure_date'];
    $price = $_POST['price'];
    $airline = $_POST['airline'];

    $sql = "INSERT INTO flights (departure_city, arrival_city, departure_time, arrival_time, departure_date, price, airline)
            VALUES ('$departure_city', '$arrival_city', '$departure_time', '$arrival_time', '$departure_date', '$price', '$airline')";
    
    if ($conn->query($sql)) {
        echo '<div class="alert alert-success text-center">Flight added successfully!</div>';
    } else {
        echo '<div class="alert alert-danger text-center">Error: ' . $conn->error . '</div>';
    }

    $conn->close();
}
?>

<div class="container mt-5">
  <h2 class="text-center mb-4">Add New Flight</h2>
  <form method="POST" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Departure City</label>
      <input type="text" class="form-control" name="departure_city" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Arrival City</label>
      <input type="text" class="form-control" name="arrival_city" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Departure Time</label>
      <input type="time" class="form-control" name="departure_time" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Arrival Time</label>
      <input type="time" class="form-control" name="arrival_time" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Departure Date</label>
      <input type="date" class="form-control" name="departure_date" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Price</label>
      <input type="number" class="form-control" name="price" required>
    </div>

 

    <div class="col-12 d-grid">
      <button type="submit" class="btn btn-primary">Add Flight</button>
    </div>
  </form>
</div>

</body>
</html>
