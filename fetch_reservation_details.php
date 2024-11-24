<?php
include('database.php');

if (isset($_GET['reservation_id'])) {
    $reservation_id = intval($_GET['reservation_id']);
    $query = "SELECT * FROM reservation WHERE reservation_id = '$reservation_id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $full_name = htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']);
        $status = strtolower(htmlspecialchars($row['status']));
        $arrival_date = $row['arrival_date'];
        $today = date('Y-m-d');
        $cancel_button_disabled = false;
        $warning_message = '';

        // Calculate days difference
        $arrival_timestamp = strtotime($arrival_date);
        $today_timestamp = strtotime($today);
        $difference_in_days = ($arrival_timestamp - $today_timestamp) / (60 * 60 * 24);

        // Check conditions for disabling the cancel button
        if ($difference_in_days < 1 || $status === 'cancelled') {
            $cancel_button_disabled = true;
            $warning_message = $status === 'cancelled' 
                ? 'This reservation has already been cancelled.' 
                : "You can only cancel your reservation 1 day before the arrival date. If you have any questions, please don't hesitate to contact us.";
        }

        // Calculate total fee
        $total_fee = 0;
        $main_customer_age = intval($row['age']);
        $total_fee += ($main_customer_age <= 20 ? 100 : ($main_customer_age <= 50 ? 200 : 150));

        // Fetch and calculate group members' fees
        $group_query = "SELECT age FROM group_members WHERE reservation_id = '$reservation_id'";
        $group_result = mysqli_query($conn, $group_query);
        while ($member = mysqli_fetch_assoc($group_result)) {
            $age = intval($member['age']);
            $total_fee += ($age <= 20 ? 100 : ($age <= 50 ? 200 : 150));
        }

        // Display reservation details in two columns
        echo "<div style='display: flex; justify-content: space-between; gap: 20px;'>";
        echo "  <div style='flex: 1;'>";
        echo "      <p><strong>Name:</strong> " . $full_name . "</p>";
        echo "      <p><strong>Age:</strong> " . htmlspecialchars($row['age']) . "</p>";
        echo "      <p><strong>Gender:</strong> " . htmlspecialchars($row['gender']) . "</p>";
        echo "      <p><strong>Contact Number:</strong> " . htmlspecialchars($row['contact_number']) . "</p>";
        echo "      <p><strong>Total Fee:</strong> PHP {$total_fee}</p>";
        echo "  </div>";
        echo "  <div style='flex: 1;'>";
        echo "      <p><strong>Municipality:</strong> " . htmlspecialchars($row['municipality']) . "</p>";
        echo "      <p><strong>Foreigner:</strong> " . ($row['is_foreigner'] ? 'Yes' : 'No') . "</p>";
        echo "      <p><strong>Arrival Date:</strong> " . htmlspecialchars($row['arrival_date']) . "</p>";
        echo "      <p><strong>Status:</strong> <span id='status-{$reservation_id}'>" . ucfirst($status) . "</span></p>";
        echo "  </div>";
        echo "</div>";

        // Fetch and display group members' names only
        echo "<p><strong>Group Members:</strong></p><ul>";
        $group_query = "SELECT * FROM group_members WHERE reservation_id = '$reservation_id'";
        $group_result = mysqli_query($conn, $group_query);
        while ($member = mysqli_fetch_assoc($group_result)) {
            echo "<li>" . htmlspecialchars($member['first_name']) . " " . htmlspecialchars($member['last_name']) . "</li>";
        }
        echo "</ul>";

        // Show warning message if applicable
        if ($warning_message) {
            echo "<div class='alert alert-warning'>{$warning_message}</div>";
        }

        // Add Cancel button
        echo "<div class='text-end mb-3'>";
        if ($status === 'pending' && !$cancel_button_disabled) {
            echo "<button class='btn btn-danger cancel-btn' id='cancelReservationBtn' data-id='{$reservation_id}'>Cancel Reservation</button>";
        } else {
            echo "<button class='btn btn-danger cancel-btn' id='cancelReservationBtn' disabled>Cancel Reservation</button>";
        }
        echo "</div>";
    } else {
        echo "<p>No details found for this reservation.</p>";
    }
} else {
    echo "<p>Invalid reservation ID.</p>";
}
?>
