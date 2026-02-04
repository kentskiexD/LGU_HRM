<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "opcr_db"; // change this to your database name

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// echo "Connected successfully";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MFO / PAP Dynamic Form</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        .indicator-card { margin-bottom: 10px; }

        .indicator-header {
            padding: 8px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            background: #f1f3f5;
            border-radius: 4px;
        }

        .indicator-title { font-weight: 600; }

        .indicator-body {
            display: none;
            padding: 12px;
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 4px 4px;
        }

        .si-section {
            background-color: #f8f9fa;
            border-left: 5px solid #198754;
        }

        textarea {
            resize: vertical;
            min-height: 70px;
        }

        .btn-xs {
            padding: 2px 8px;
            font-size: 12px;
        }
    </style>
</head>

<body>


<div class="text-center mb-4 mt-3">
    <h4 class="fw-bold text-uppercase text-dark">
        Office Performance Commitment and Review
    </h4>
    <small class="text-dark">(OPCR)</small>
</div>

<div class="container mb-5">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3">MFO / PAP Performance Form</h4>

            <form method="POST"  action="save_opcr.php" id="opcrForm">

                <div class="mb-3">
                    <input type="text" name="mfo_pap" class="form-control"
                           placeholder="MFO / PAP" required>
                </div>

                <h6 class="mb-2">Success Indicators</h6>

                <div id="indicator-container"></div>

                <button type="button"
                        class="btn btn-outline-success btn-sm d-flex align-items-center gap-1"
                        onclick="addIndicator()">
                    <i class="bi bi-plus-circle"></i>
                    Add Sub-Function
                </button>

                <hr>

                <button type="submit" name="submit" class="btn btn-success">
                    Submit
                </button>

            </form>

        </div>
    </div>
</div>
<script>
let formChanged = false;
let isSubmitting = false;

/* Track form changes */
document.addEventListener("input", () => {
    if (!isSubmitting) {
        formChanged = true;
    }
});

/* Warn on refresh / exit ONLY if not submitting */
window.addEventListener("beforeunload", function (e) {
    if (formChanged && !isSubmitting) {
        e.preventDefault();
        e.returnValue = "";
    }
});

/* Disable warning when submitting */
document.getElementById("opcrForm").addEventListener("submit", function () {
    isSubmitting = true;
    formChanged = false;
});

/* Toggle indicator body */
function toggleIndicator(header) {
    const body = header.nextElementSibling;
    body.style.display = body.style.display === "block" ? "none" : "block";
}

/* Renumber indicators */
function renumberIndicators() {
    document.querySelectorAll('.indicator-card').forEach((card, index) => {
        card.querySelector('.indicator-number').textContent = index + 1;
    });
}

/* Add indicator */
function addIndicator() {
    const container = document.getElementById("indicator-container");
    const block = document.createElement("div");
    block.className = "indicator-card";

    block.innerHTML = `
        <div class="indicator-header" onclick="toggleIndicator(this)">
            <span class="indicator-title">
                <i class="bi bi-arrow-down-square-fill text-success"></i>
                Sub-function <span class="indicator-number"></span>
            </span>
            <button type="button" class="btn btn-danger btn-xs"
                onclick="deleteIndicator(this)">
                <i class="bi bi-trash-fill"></i>
            </button>
        </div>

        <div class="indicator-body">

            <div class="border rounded p-3 mb-3 si-section">
                <div class="text-center mb-3">
                    <h6 class="fw-bold text-uppercase text-success">Success Indicator</h6>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Target</label>
                    <input type="number" name="indicator_number[]" class="form-control"
                           placeholder="eg. 500" required>
                </div>

                <div>
                    <label class="form-label fw-semibold">Measures</label>
                    <textarea name="indicator_text[]" class="form-control"
                        placeholder="eg. business permit applications acted accurately..."
                        required></textarea>
                </div>
            </div>

            <div class="border rounded p-3 mb-3 si-section">
                <div class="text-center mb-3">
                    <h6 class="fw-bold text-uppercase text-success">
                        Individuals / Divisions Accountable
                    </h6>
                </div>

                <textarea name="accountable[]" class="form-control"
                    placeholder="eg. John Doe, Licensing Division"
                    required></textarea>
            </div>

            <div class="border rounded p-3 mb-3 si-section">
                <div class="text-center mb-3">
                    <h6 class="fw-bold text-uppercase text-success">
                        Actual Accomplishments / Expenses
                    </h6>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Actual</label>
                    <input type="text" name="actual_ratio[]" class="form-control"
                           placeholder="eg. 700/500" required>
                </div>

                <div>
                    <label class="form-label fw-semibold">
                        Actual Accomplishments / Expenses
                    </label>
                    <textarea name="actual_desc[]" class="form-control"
                        placeholder="eg. business permit applications acted accurately..."
                        required></textarea>
                </div>
            </div>

        </div>
    `;

    container.appendChild(block);
    renumberIndicators();
    formChanged = true;

    /* Open only the newest indicator */
    document.querySelectorAll('.indicator-body').forEach(b => b.style.display = 'none');
    block.querySelector('.indicator-body').style.display = 'block';
}

/* Delete indicator */
function deleteIndicator(btn) {
    Swal.fire({
        title: 'Remove this sub-function?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            btn.closest('.indicator-card').remove();
            renumberIndicators();
            formChanged = true;

            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'The sub-function has been removed.',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

/* Load first indicator on page load */
document.addEventListener("DOMContentLoaded", function () {
    addIndicator();
});
</script>


</body>
</html>


<?php if (isset($_GET['success'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: 'OPCR has been saved successfully.',
    confirmButtonColor: '#198754'
}).then(() => {
    // Remove ?success=1 from the URL
    const url = new URL(window.location);
    url.searchParams.delete('success');
    window.history.replaceState({}, document.title, url.pathname);
});
</script>
<?php endif; ?>
