<?php

require_once "includes/db_connect.php";
require_once "includes/get_record_id.php";


/**
 * Reading out a specific data from the database
 */
$id = $_GET['id'];

// connect our db
$conn = connectDB();

$data = getRecordById($conn, $id);


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>View Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-lg">
          <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Student Details</h3>
          </div>
          <div class="card-body">

            <!-- Student Info Display -->
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-bold">Full Name</label>
                <div class="form-control-plaintext"><?= $data['full_name'] ?></div>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Username</label>
                <div class="form-control-plaintext"><?= $data['username'] ?></div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-bold">Faculty</label>
                <div class="form-control-plaintext"><?= $data['faculty'] ?></div>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Department</label>
                <div class="form-control-plaintext"><?= $data['department'] ?></div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-bold">Admission Date</label>
                <div class="form-control-plaintext"><?= $data['admission_date'] ?></div>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Admission Type</label>
                <div class="form-control-plaintext"><?= $data['admission_type'] ?></div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Comments</label>
              <div class="form-control-plaintext"><?= $data['comment'] ?></div>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between">
              <a href="index_records.php" class="btn btn-secondary">← Back</a>

              <form action="/students/1/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
                <!-- CSRF token if using Laravel -->
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>