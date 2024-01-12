<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Read Student</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 650px;
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
                    <h2>Student Details</h2>
                </div>
                <?php
                // Check if the studentID parameter is set in the URL
                if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
                    // Include config file
                    require_once 'config.php';

                    // Prepare a select statement
                    $sql = "SELECT * FROM student WHERE studentID = ?";

                    if($stmt = mysqli_prepare($link, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "i", $param_id);

                        // Set parameters
                        $param_id = trim($_GET["id"]);

                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            $result = mysqli_stmt_get_result($stmt);

                            if(mysqli_num_rows($result) == 1){
                                // Fetch result row as an associative array
                                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                                // Display individual student details
                                echo "<div class='form-group'>";
                                echo "<label>StudentID:</label>";
                                echo "<p class='form-control-static'>".$row["studentID"]."</p>";
                                echo "</div>";
                                echo "<div class='form-group'>";
                                echo "<label>Name:</label>";
                                echo "<p class='form-control-static'>".$row["name"]."</p>";
                                echo "</div>";
                                echo "<div class='form-group'>";
                                echo "<label>Email:</label>";
                                echo "<p class='form-control-static'>".$row["email"]."</p>";
                                echo "</div>";
                                echo "<p><a href='index.php' class='btn btn-primary'>Back</a></p>";
                            } else{
                                // URL doesn't contain valid student ID
                                echo "No records found.";
                            }
                        } else{
                            echo "ERROR: Could not execute $sql. " . mysqli_error($link);
                        }
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);

                    // Close connection
                    mysqli_close($link);
                } else{
                    // Redirect to error page if studentID parameter is not present in the URL
                    header("location: error.php");
                    exit();
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>