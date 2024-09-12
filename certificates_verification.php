<?php
// Error reporting for debugging
ob_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    require_once "header.php";
} else {
    session_start();
    include_once "config.php";
}
// session_start();
include_once "config.php";
if ($dbhandle->connect_error) {
    die('Database connection failed: ' . $dbhandle->connect_error);
}

// Define base URL based on host
$BASE_URL = 'https://apply-csbc.com/csbc_uploads_01_23/Certificates/';

// Fetch data from database
$get_upload_file_sts = "SELECT * FROM registration_details_cat_change WHERE verify_status IS NULL OR verify_status = '' ORDER BY RAND() LIMIT 1";
$resultsquery = mysqli_query($dbhandle, $get_upload_file_sts);

if ($rows_sts = mysqli_fetch_assoc($resultsquery)) {
    $cert_file_name = $rows_sts['cert_file_name'];
    $get_image_path_sports_achev = $BASE_URL . $cert_file_name;
    $registration_id = $rows_sts['werollno'];
}
$user_id = $_SESSION['jk_conuser'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $timezone = "Asia/Calcutta";
    if (function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
    $date_now = date("Y-m-d H:i:s");

    // Retrieve POST data
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $reason = isset($_POST['reason']) ? $_POST['reason'] : '';
    $cand_reg_id = isset($_POST['cand_reg_id']) ? $_POST['cand_reg_id'] : '';
    $user_regid = isset($_POST['user_regid']) ? $_POST['user_regid'] : '';

    // Validate input
    if (($status === 'incorrect' || $status === 'invalid') && empty($reason)) {
        echo json_encode(['status' => 'error', 'message' => 'Reason is required for incorrect or invalid status.']);
        exit;
    }

    // Prepare the UPDATE query
    $sql = "UPDATE registration_details_cat_change SET verify_status = ?, remark = ?, user_id = ?, certificate_verify_date = ? WHERE werollno = ?";
    $stmt = $dbhandle->prepare($sql);

    // Check if prepare() was successful
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($dbhandle->error));
    }

    // Bind parameters to the query
    $stmt->bind_param('sssss', $status, $reason, $user_regid, $date_now, $cand_reg_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Data updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update data.']);
    }

    $stmt->close();
    $dbhandle->close();
    exit; // Ensure no further output is sent
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate Verification</title>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <style>
        .verify-btns {
            margin-top: 20%;
            margin-right: 20%;
        }
        .verify-btns div {
            margin-bottom: 10px; /* Space between radio buttons */
        }
        .verify-btns input[type="radio"] {
            margin-right: 10px; /* Space between radio button and label */
        }
        .verify-btns label {
            margin-right: 20px; /* Space between labels */
            margin-top: 40px;
            font-size: x-large;
        }
        /* .file-display {
            max-width: 100%;
            height: auto;
        } */
        .file-display-container {
    height: 800px; /* Set the height of the container */
    overflow-y: auto; /* Enable vertical scrolling if the content exceeds the container height */
    width: 100%; /* Full width */
}

.file-display {
    max-width: 100%;
    height: auto; /* Ensure the image maintains its aspect ratio */
    display: block;
    margin: 0 auto; /* Center the image horizontally */
}
        
    </style>
</head>
<body>
<div class="container containerfff">
    <p><b>Registration ID: </b><?php echo htmlspecialchars($registration_id); ?></p>
    <div class="row">
        <!-- Column for File Display -->
        <div class="col-md-10">
            <div id="file-container">
                <?php
                // Extract file extension
                $file_extension = pathinfo($cert_file_name, PATHINFO_EXTENSION);
                if ($file_extension === 'pdf') {
                    echo '<iframe src="' . htmlspecialchars($get_image_path_sports_achev) . '" width="100%" height="600" frameborder="0">Your browser does not support iframes.</iframe>';
                } elseif ($file_extension === 'jpg' || $file_extension === 'jpeg') {
                    echo '<img src="' . htmlspecialchars($get_image_path_sports_achev) . '" class="file-display" alt="Certificate Image">';
                } else {
                    echo '<p>Unsupported file type: ' . htmlspecialchars($file_extension) . '</p>';
                }
                ?>
            </div>
        </div>

        <!-- Column for Form Controls -->
        <div class="col-md-2">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-horizontal" method="post" name="reg" id="reg">
                <div class="form-group verify-btns">
                    <div>
                        <input type="radio" name="status" value="correct" onclick="handleButtonClick('correct');" required> <label>Correct</label>
                    </div>
                    <div>
                        <input type="radio" name="status" value="incorrect" onclick="handleButtonClick('incorrect');"> <label>Incorrect</label>
                    </div>
                    <div>
                        <input type="radio" name="status" value="invalid" onclick="handleButtonClick('invalid');"> <label>Invalid</label>
                    </div>
                    
                    <div id="reason-container" style="display: none;">
                        <label for="reason">Reason:</label>
                        <textarea id="reason" name="reason" class="form-control" rows="4" placeholder="Enter reason here..." style="width: 90%"></textarea>
                    </div>

                    <input type="hidden" id="cand_reg_id" name="cand_reg_id" value="<?php echo htmlspecialchars($registration_id); ?>">
                    <input type="hidden" id="user_regid" name="user_regid" value="<?php echo htmlspecialchars($user_id); ?>">
                    <button type="button" class="btn btn-primary" onclick="submitForm();">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
<script>
    function checkForm(form) {
        var selectedButton = form.querySelector('input[name="status"]:checked');
        var reasonTextbox = form.querySelector('#reason');

        if (selectedButton && (selectedButton.value === 'invalid' || selectedButton.value === 'incorrect')) {
            if (reasonTextbox.value.trim() === '') {
                alert('Please provide a reason.');
                return false; // Prevent form submission
            }
        }

        return true; // Allow form submission
    }

    function handleButtonClick(buttonValue) {
        var reasonTextbox = document.getElementById('reason');
        var reasonContainer = document.getElementById('reason-container');

        if (buttonValue === 'invalid' || buttonValue === 'incorrect') {
            reasonContainer.style.display = 'block'; // Show the reason textarea
        } else {
            reasonContainer.style.display = 'none'; // Hide the reason textarea
            reasonTextbox.value = ''; // Clear the textarea
        }
    }

    function submitForm() {
        var form = document.getElementById('reg');
        if (checkForm(form)) {
            var status = form.querySelector('input[name="status"]:checked').value;
            var reason = document.getElementById('reason').value;
            var cand_reg_id = document.getElementById('cand_reg_id').value;
            var user_regid = document.getElementById('user_regid').value;

            $.confirm({
                title: 'Confirm Submission',
                content: 'Are you sure you want to submit?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: form.action,
                            type: 'POST',
                            data: {
                                status: status,
                                reason: reason,
                                cand_reg_id: cand_reg_id,
                                user_regid: user_regid
                            },
                            success: function (response) {
                                try {
                                    var jsonResponse = JSON.parse(response);
                                    if (jsonResponse.status === 'success') {
                                        $.alert('Data saved successfully.');
                                        setTimeout(function () {
                                            location.reload();
                                        }, 500);
                                    } else {
                                        $.alert('Error: ' + jsonResponse.message);
                                    }
                                } catch (e) {
                                    console.error('Parsing error:', e);
                                    $.alert('Unexpected response format.');
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX error:', error);
                                $.alert('An error occurred while processing the request.');
                            }
                        });
                    },
                    cancel: function () {
                        // Action to take on cancel (optional)
                    }
                }
            });
        }
    }
</script>
</body>
</html>
<?php
require_once "footer.php";
?>
