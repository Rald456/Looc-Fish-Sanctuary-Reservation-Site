// JavaScript to Control Municipality Field for Foreigner Checkbox
document.getElementById('is_foreigner').addEventListener('change', function () {
    const municipalityField = document.getElementById('municipalityField');
    if (this.checked) {
        municipalityField.disabled = true;
        municipalityField.value = 'N/A'; // Set value to N/A
    } else {
        municipalityField.disabled = false;
        municipalityField.value = ''; // Clear value when enabled
    }
});

// Enable/Disable "Add Group Member" button based on "Group Reservation" checkbox
document.getElementById('is_group_reservation').addEventListener('change', function() {
    const addGroupMemberBtn = document.getElementById('addGroupMemberBtn');
    addGroupMemberBtn.disabled = !this.checked;
});

// JavaScript to control "Add Group Member" button
document.getElementById('addGroupMemberBtn').addEventListener('click', function() {
    const modal = new bootstrap.Modal(document.getElementById('addMemberModal'));
    modal.show();
});

// For managing foreigner checkbox in group member modal
document.getElementById('groupIsForeigner').addEventListener('change', function () {
    const groupMunicipalityField = document.getElementById('groupMunicipalityField');
    if (this.checked) {
        groupMunicipalityField.disabled = true;
        groupMunicipalityField.value = 'N/A'; // Set value to N/A
    } else {
        groupMunicipalityField.disabled = false;
        groupMunicipalityField.value = ''; // Clear value when enabled
    }
});

// Collect and send group member data along with the main reservation
let groupMembers = []; // Array to store group members

document.getElementById('saveMemberBtn').addEventListener('click', function() {
    const form = document.getElementById('addMemberForm');
    const formData = new FormData(form);

    const memberDetails = {
        first_name: formData.get('first_name'),
        last_name: formData.get('last_name'),
        age: formData.get('age'),
        gender: formData.get('gender'),
        municipality: formData.get('municipality'),
        is_foreigner: formData.get('is_foreigner') ? true : false
    };

    groupMembers.push(memberDetails);

    // Update hidden input field with the group member data (as JSON)
    document.getElementById('groupMembersInput').value = JSON.stringify(groupMembers);

    // Close modal and reset form
    const modal = bootstrap.Modal.getInstance(document.getElementById('addMemberModal'));
    modal.hide();
    form.reset();
});

// Capitalize the first letter of user input in the municipality field
document.getElementById('municipalityField').addEventListener('input', function () {
    const words = this.value.split(' ');
    this.value = words
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        .join(' ');
});

// Capitalize the first letter of user input in the firstname_field 
document.getElementById('firstname_field').addEventListener('input', function () {
    const words = this.value.split(' ');
    this.value = words
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        .join(' ');
});

// Capitalize the first letter of user input in the lastname_field 
document.getElementById('lastname_field').addEventListener('input', function () {
    const words = this.value.split(' ');
    this.value = words
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        .join(' ');
});

// Initialize Check Activities modal
document.addEventListener("DOMContentLoaded", function () {
    const checkActivitiesModal = new bootstrap.Modal(document.getElementById('checkActivitiesModal'), {
        backdrop: 'static',
        keyboard: false
    });
});

// For check reservation details button
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".check-details-btn").forEach(button => {
        button.addEventListener("click", function () {
            const reservationId = this.getAttribute("data-id");
            fetchReservationDetails(reservationId);
        });
    });
});

// Handle the confirm cancellation button in the confirmation modal
document.getElementById('confirmCancelBtn').addEventListener('click', function () {
    const reservationId = document.querySelector("#reservation-details").getAttribute("data-reservation-id");

    if (reservationId) {
        const selectedReason = document.querySelector('input[name="cancelReason"]:checked');
        let reasonText = '';

        if (selectedReason) {
            reasonText = selectedReason.value;
        }

        if (document.getElementById('reason4').checked) {
            reasonText = document.getElementById('customReason').value.trim();
        }

        if (reasonText === '') {
            alert('Please select or provide a reason for cancellation.');
            return;
        }

        fetch('cancel_reservation.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `reservation_id=${reservationId}&cancel_reason=${encodeURIComponent(reasonText)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`#status-${reservationId}`).textContent = 'Cancelled';

                    const cancelButton = document.getElementById(`cancelReservationBtn`);
                    if (cancelButton) {
                        cancelButton.disabled = true;
                        cancelButton.textContent = "Cancelled";
                    }

                    fetchReservationDetails(reservationId);

                    const confirmModalInstance = bootstrap.Modal.getInstance(document.getElementById('customConfirmModal'));
                    confirmModalInstance.hide();
                } else {
                    console.error('Error:', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});

// Enable or disable custom reason input based on selection
document.querySelectorAll('input[name="cancelReason"]').forEach(radio => {
    radio.addEventListener('change', function () {
        const customReasonInput = document.getElementById('customReason');
        if (this.value === 'Other') {
            customReasonInput.disabled = false;
        } else {
            customReasonInput.disabled = true;
            customReasonInput.value = '';
        }
    });
});

// Fetch reservation details and handle cancel button logic
function fetchReservationDetails(reservationId) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `fetch_reservation_details.php?reservation_id=${reservationId}`, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("reservation-details").innerHTML = xhr.responseText;
            document.getElementById("reservation-details").setAttribute("data-reservation-id", reservationId);

            new bootstrap.Modal(document.getElementById("checkDetailsModal"), { backdrop: 'static' }).show();

            const cancelReservationBtn = document.getElementById('cancelReservationBtn');
            if (cancelReservationBtn) {
                cancelReservationBtn.addEventListener('click', function () {
                    const confirmModal = new bootstrap.Modal(document.getElementById('customConfirmModal'), { backdrop: 'static' });
                    document.getElementById('checkDetailsModal').classList.add('modal-dim');
                    confirmModal.show();
                });
            }
        } else {
            document.getElementById("reservation-details").innerHTML = "Error loading reservation details.";
        }
    };
    xhr.send();
}

// Handle "Back to Check Activities" button click
document.getElementById('backToCheckActivities').addEventListener('click', function () {
    const checkDetailsModalInstance = bootstrap.Modal.getInstance(document.getElementById('checkDetailsModal'));
    checkDetailsModalInstance.hide();

    setTimeout(function () {
        new bootstrap.Modal(document.getElementById('checkActivitiesModal'), { backdrop: 'static' }).show();
    }, 300);
});

// Remove any leftover modal backdrop after closing modals
document.addEventListener('hidden.bs.modal', function (event) {
    if (document.querySelectorAll('.modal.show').length === 0) {
        document.querySelectorAll('.modal-backdrop').forEach(function (backdrop) {
            backdrop.remove();
        });
        document.body.classList.remove('modal-open');
    }
});

// Handle closing of the CustomConfirmModal
document.getElementById('customConfirmModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('checkDetailsModal').classList.remove('modal-dim');
});