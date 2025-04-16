<?php

require_once "includes/db_connect.php";

// initiate an error handler function
function myErrorHandler($errno, $errstr)
{
  echo "<b>Error:</b> [$errno] $errstr";
}
// set error handler function
set_error_handler("myErrorHandler");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST['save'])) {

    $full_name = trim(htmlspecialchars($_POST['full_name']));
    $username = trim(htmlspecialchars($_POST['username']));
    $faculty = trim(htmlspecialchars($_POST['faculty']));
    $department = trim(htmlspecialchars($_POST['department']));
    $admission_date = trim(htmlspecialchars($_POST['admission_date']));
    $admission_type = trim(htmlspecialchars($_POST['admission_type']));
    $comment = trim(htmlspecialchars($_POST['comment']));

    if (!empty($full_name) && !empty($username) && !empty($faculty) && !empty($department) && !empty($admission_date) && !empty($admission_type)) {

      if ($comment == '') {
        $comment = null;
      }

      // connect to the database
      $conn = connectDB();

      // inserts the data into the database
      $sql = "INSERT INTO records (full_name, username, faculty, department, admission_date, admission_type, comment)
      VALUES (?, ?, ?, ?, ?, ?, ?)";

      // prepare an SQL statement for execution
      $stmt = mysqli_prepare($conn, $sql);

      if ($stmt === false) {
        echo mysqli_error($conn);
      } else {

        // bind variables for the parameter markers in the SQL statement prepared
        mysqli_stmt_bind_param($stmt, 'sssssss', $full_name, $username, $faculty, $department, $admission_date, $admission_type, $comment);

        // execute the prepared statement
        $results = mysqli_stmt_execute($stmt);

        if ($results === false) {
          echo mysqli_stmt_error($stmt);
        } else {
          header('Location: http://localhost:200/index.php?success=1');
          exit;
        }
      }
    } else {
          header('Location: http://localhost:200/index.php?failure=1');
          exit;
    }
  }
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
            <h3 class="mb-0">Students Management System</h3>
          </div>
          <div class="card-body">

            <!--Show success message-->
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                ✅ Form submitted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <!--Show failure message-->
            <?php if (isset($_GET['failure']) && $_GET['failure'] == 1): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
               Form submission error!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>


            <form method="POST">
              <!-- Full Name and Username -->
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="fullName" name="full_name" placeholder="Full Name" required>
                    <label for="fullName">Full Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group has-validation">
                    <span class="input-group-text">@</span>
                    <div class="form-floating flex-grow-1">
                      <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                      <label for="username">Username</label>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Faculty and Department -->
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="faculty" name="faculty" required>
                      <option value="Engineering">Engineering</option>
                      <option value="Science" selected>Science</option>
                      <option value="Arts">Arts</option>
                      <option value="Education">Education</option>
                      <option value="Social Science">Social Science</option>
                    </select>
                    <label for="faculty">Faculty</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="department" name="department" required>
                      <option value="Met. & Mat Engr.">Met. & Mat Engr.</option>
                      <option value="Microbiology" selected>Microbiology</option>
                      <option value="English">English</option>
                      <option value="Mathematics">Mathematics</option>
                      <option value="Human Kinetics">Human Kinetics</option>
                    </select>
                    <label for="department">Department</label>
                  </div>
                </div>
              </div>

              <!-- Admission Date and Type -->
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="date" class="form-control" id="admissionDate" name="admission_date" required>
                    <label for="admissionDate">Admission Date</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Admission Type</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="admission_type" id="merit" value="Merit" required>
                    <label class="form-check-label" for="merit">Merit</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="admission_type" id="diploma" value="Diploma" checked required>
                    <label class="form-check-label" for="diploma">Diploma</label>
                  </div>
                </div>
              </div>

              <!-- Comments -->
              <div class="mb-3">
                <label for="comments" class="form-label">Additional Comments</label>
                <textarea class="form-control" id="comments" name="comment" rows="4" placeholder="Leave a comment here..."></textarea>
              </div>

              <!-- Submit Button -->
              <div class="text-center">
                <button type="submit" class="btn btn-primary px-5" name="save">Submit</button>
                <a href="/index_records.php" class="btn btn-info px-5">View Records</a>
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