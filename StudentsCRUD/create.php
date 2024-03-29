<?php

// Include config file
global $link;
require_once 'config.php';

// Define variables and initialize with empty values
$studentID = $name = $email = "";
$studentID_err = $name_err = $email_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate studentID
    $input_studentID = trim($_POST["studentID"]);
    echo $input_studentID;
    if(empty($input_studentID)) {
        $studentID_err = "Please enter the student's ID.";
    } elseif (!ctype_digit($input_studentID)) {
        $studentID_err = "Please enter a positive integer value.";
    } else {
        $studentID = $input_studentID;
    }

    //Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/")))) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = $input_email;
    }

    // Check input errors before inserting in database
    if(empty($studentID_err) && empty($name_err) && empty($email_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO student (studentID, name, email) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iss", $param_studentID, $param_name, $param_email);

            // Set parameters
            $param_studentID = $studentID;
            $param_name = $name;
            $param_email = $email;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Create Record</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper {
                width: 500px;
                margin: 0 auto;
            }
        </style>
    </head>

    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h2>Create Record</h2>
                        </div>
                        <p>Please fill this form and submit to add student record to the database.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group <?php echo (!empty($studentID_err)) ? 'has-error' : ''; ?>">
                                <label>Student ID</label>
                                <input type="text" name="studentID" class="form-control" value="<?php echo $studentID; ?>">
                                <span class="help-block"><?php echo $studentID_err;?></span>
                            </div>

                            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control"><?php echo $name; ?></input>
                                <span class="help-block"><?php echo $name_err;?></span>
                            </div>

                            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                                <span class="help-block"><?php echo $email_err;?></span>
                            </div>

                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
