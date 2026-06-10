<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit Life Gym, Goa</title>
    `<h1>   Member registration info</h1>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #afbdcd; }
        .container { margin-top: 30px; }
        table { margin-top: 30px; }
        .form-label { font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">📋 Fit Life Gym, Goa
        <a href="logout.php" class="btn btn-danger btn-sm float-end">Logout</a>
    </h2>

    <!-- Add New Person Form -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Add New Member</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Job / Profession</label>
                        <input type="text" name="job" class="form-control" required>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-success mt-3">Save Record</button>
            </form>
        </div>
    </div>

    <?php
    $conn = mysqli_connect("localhost", "root", "", "people_records");
    if (!$conn) die("<div class='alert alert-danger'>Connection failed!</div>");

    // Insert new record
    if (isset($_POST['submit'])) {
        $name  = mysqli_real_escape_string($conn, $_POST['name']);
        $dob   = $_POST['dob'];
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $job   = mysqli_real_escape_string($conn, $_POST['job']);

        $sql = "INSERT INTO individuals (name, dob, email, job) VALUES ('$name', '$dob', '$email', '$job')";
        if (mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success mt-3'>✅ Record saved successfully!</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
        }
    }

    // Soft Delete (move to trash)
    if (isset($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        mysqli_query($conn, "UPDATE individuals SET deleted_at = NOW() WHERE id = $id");
        echo "<div class='alert alert-info mt-3'>🗑️ Record moved to trash!</div>";
    }
        // Permanent delete from trash
    if (isset($_GET['permanent_delete'])) 
    {
        $id = (int)$_GET['permanent_delete'];
        mysqli_query($conn, "DELETE FROM individuals WHERE id = $id AND deleted_at IS NOT NULL");
        echo "<div class='alert alert-warning mt-3'>🗑️ Record permanently deleted!</div>";
    }

    // Restore from trash
    if (isset($_GET['restore'])) {
        $id = (int)$_GET['restore'];
        mysqli_query($conn, "UPDATE individuals SET deleted_at = NULL WHERE id = $id");
        echo "<div class='alert alert-success mt-3'>✅ Record restored successfully!</div>";
    }
    ?>

    <!-- Active Records -->
    <h4 class="mt-5">all  members</h4>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Name</th><th>Date of Birth</th><th>Email</th><th>Job</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM individuals WHERE deleted_at IS NULL ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['dob']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['job']}</td>
                    <td>
                        <a href='?delete={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Move to trash?')\">Delete</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- 🗑️ Deleted Records (Trash) -->
        <!-- 🗑️ Deleted Records (Trash) -->
    <h4 class="mt-5 text-black">🗑️ Deleted Records (Trash)</h4>
    <table class="table table-bordered table-hover">
        <thead class="table-secondary">
            <tr>
                <th>ID</th><th>Name</th><th>Date of Birth</th><th>Email</th><th>Job</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM individuals WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['dob']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['job']}</td>
                    <td>
                        <a href='?restore={$row['id']}' class='btn btn-success btn-sm'>Restore</a>
                        <a href='?permanent_delete={$row['id']}' class='btn btn-dark btn-sm' onclick=\"return confirm('Permanently delete this record? This action cannot be undone!')\">Permanent Delete</a>
                    </td>
                </tr>";
            }
            if (mysqli_num_rows($result) == 0) {
                echo "<tr><td colspan='6' class='text-center'>No deleted records yet</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>