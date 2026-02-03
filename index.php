<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MFO / PAP Dynamic Form</title>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


<style>
body {
    background: #f8f9fa;
}

.indicator-card {
    border: 1px solid #ced4da;
    margin-bottom: 8px;
}

.indicator-header {
    background: #e9ecef;
    padding: 8px 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.indicator-title {
    font-weight: 600;
}

.indicator-body {
    display: none;
    padding: 12px;
    background: #ffffff;
}

textarea {
    resize: vertical;
}

.btn-xs {
    padding: 2px 8px;
    font-size: 12px;
}
</style>
</head>

<body>
    <div class="text-center mb-4">
    <h4 class="fw-bold text-uppercase">
        Office Performance Commitment and Review
    </h4>
    <small class="text-muted">(OPCR)</small>
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
<i class="bi bi-arrow-down-square-fill text-success"></i> Success Indicator ${indicatorCount}</span>
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

            <div class="row g-2 mb-2">
                <div class="col">
                    <input type="number" step="0.01" name="rating_q[]" class="form-control"
                           placeholder="Q" required>
                </div>
                <div class="col">
                    <input type="number" step="0.01" name="rating_e[]" class="form-control"
                           placeholder="E" required>
                </div>
                <div class="col">
                    <input type="number" step="0.01" name="rating_t[]" class="form-control"
                           placeholder="T" required>
                </div>
                <div class="col">
                    <input type="number" step="0.01" name="rating_a[]" class="form-control"
                           placeholder="A" required>
                </div>
            </div>

            <textarea name="remarks[]" rows="2" class="form-control"
                      placeholder="Remarks" required></textarea>

        </div>
    `;

    container.appendChild(block);
}

function toggleIndicator(header) {
    const body = header.nextElementSibling;
    const title = header.querySelector(".indicator-title");

    const isOpen = body.style.display === "block";
    body.style.display = isOpen ? "none" : "block";
    title.innerHTML = isOpen
        ? title.innerHTML.replace("▼", "▶")
        : title.innerHTML.replace("▶", "▼");
}

function deleteIndicator(btn) {
    if (confirm("Remove this success indicator?")) {
        btn.closest(".indicator-card").remove();
    }
}
</script>

</body>
</html>
