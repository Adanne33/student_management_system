<?php

require_once "includes/db_connect.php";
require_once "includes/get_record_id.php";

$id = $_GET['id'];

// connect our db
$conn = connectDB();

if (isset($_GET['id'])){
  
  $data = getRecordById($conn, $id);

  // You can handle the case where no record is found in the specified id
  if (!$data) {
    echo require_once "includes/no_record.php";
    exit;
  }

  if($data){
    $full_name = $data['full_name'] ;
    $username = $data['username'];
    $faculty = $data['faculty'] ;
    $department = $data['department'];
    $admission_date = $data['admission_date'] ;
    $admission_type = $data['admission_type'];
    $comment = $data['comment'];
  }
} else {
  // You can handle the case where no id is in the URL
  echo require_once "includes/invalid_request.php";
  exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Students Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-lg">
          <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Edit Student Record</h3>
          </div>
          <div class="card-body">
            <form>
              <!-- Full Name and Username -->
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="fullName" placeholder="Full Name" value="<?= $full_name ?>" required>
                    <label for="fullName">Full Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group has-validation">
                    <span class="input-group-text">@</span>
                    <div class="form-floating flex-grow-1">
                      <input type="text" class="form-control" id="username" value="<?= $username ?>" placeholder="Username" required>
                      <label for="username">Username</label>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Faculty and Department -->
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="department" required>
                    
                    <?php
                      $faculties = ['Engineering', 'Science', 'Arts', 'Education', 'Social Science'];

                      foreach($faculties as $index_value){
                        $selected = ($index_value === $faculty) ? 'selected': '';
                        echo "<option value='$index_value' $selected>$index_value</option>";
                      }
                    ?>

                    </select>
                    <label for="faculty">Faculty</label>

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="department" required>

                      <?php
                        $departments = ['Met. & Mat Engr.', 'Microbiology', 'English', 'Mathematics', 'Human Kinetics'];

                        foreach($departments as $index_value){
                          $selected = ($index_value === $department) ? 'selected': '';
                          echo "<option value='$index_value' $selected>$index_value</option>";
                        }
                      ?>

                    </select>
                    <label for="department">Department</label>
                  </div>
                </div>
              </div>

              <!-- Admission Date and Type -->
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="date" class="form-control" id="admissionDate" value="<?= $admission_date ?>" required>
                    <label for="admissionDate">Admission Date</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Admission Type</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="admissionType" id="merit" value="Merit" <?= ($admission_type === "Merit") ? 'checked': '' ?>>
                    <label class="form-check-label" for="merit">Merit</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="admissionType" id="diploma" value="Diploma" <?= ($admission_type === "Diploma") ? 'checked': '' ?>>
                    <label class="form-check-label" for="diploma">Diploma</label>
                  </div>
                </div>
              </div>

              <!-- Comments -->
              <div class="mb-3">
                <label for="comments" class="form-label">Additional Comments</label>
                <textarea class="form-control" id="comments" rows="4" placeholder="Leave a comment here..."><?= $comment ?></textarea>
              </div>

              <!-- Submit Button -->
              <div class="text-center">
                <button type="submit" class="btn btn-primary px-5">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>