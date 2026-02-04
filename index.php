<?php
// require_once __DIR__ . '/../config/db.php';
// require_once __DIR__ . '/../config/settings.php';
// require_once __DIR__ . '/../layouts/header.php';
// require_once __DIR__ . '/../layouts/sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MFO / PAP Dynamic Form</title>

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .indicator-card { margin-bottom: 8px; }
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
        textarea { resize: vertical; }
        .btn-xs { padding: 2px 8px; font-size: 12px; }
    </style>
</head>


<body>

<div class="text-center mb-4">
    <h4 class="fw-bold text-uppercase text-black">
        Office Performance Commitment and Review
    </h4>
    <small class="text-black">(OPCR)</small>
</div>

<div class="container mt-4 mb-5">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3">MFO / PAP Performance Form</h4>

            <form method="POST" action="process_form.php">

                <!-- MFO / PAP -->
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
                    Add Success Indicator
                </button>

                <hr>

                <button type="submit" class="btn btn-success">
                    Submit
                </button>

            </form>

        </div>
    </div>

</div>

<script>
let indicatorCount = 0;

function addIndicator() {
    indicatorCount++;

    const container = document.getElementById("indicator-container");
    const block = document.createElement("div");
    block.className = "indicator-card";

    block.innerHTML = `
        <div class="indicator-header" onclick="toggleIndicator(this)">
            <span class="indicator-title">
                <i class="bi bi-arrow-down-square-fill text-success"></i>
                Success Indicator ${indicatorCount}
            </span>
            <button type="button" class="btn btn-danger btn-xs"
                onclick="event.stopPropagation(); deleteIndicator(this)">
                <i class="bi bi-trash-fill"></i>
            </button>
        </div>

        <div class="indicator-body">

            <div class="row g-2 mb-2">
                <div class="col-md-2">
                    <input type="number" name="indicator_number[]" class="form-control"
                           placeholder="SI No." required>
                </div>
                <div class="col-md-10">
                    <input type="text" name="indicator_text[]" class="form-control"
                           placeholder="Success Indicator (Targets + Measures)" required>
                </div>
            </div>

            <div class="mb-2">
                <input type="text" name="accountable[]" class="form-control"
                       placeholder="Individuals / Divisions Accountable" required>
            </div>

            <div class="row g-2 mb-2">
                <div class="col-md-3">
                    <input type="text" name="actual_ratio[]" class="form-control"
                           placeholder="Actual (e.g. 200/20)" required>
                </div>
                <div class="col-md-9">
                    <input type="text" name="actual_desc[]" class="form-control"
                           placeholder="Actual Accomplishments / Expenses" required>
                </div>
            </div>

            

        </div>
    `;

    container.appendChild(block);
}

function toggleIndicator(header) {
    const body = header.nextElementSibling;
    body.style.display = body.style.display === "block" ? "none" : "block";
}

function deleteIndicator(btn) {
    Swal.fire({
        title: 'Remove this indicator?',
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

            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Success indicator removed.',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}
</script>

</body>
</html>
