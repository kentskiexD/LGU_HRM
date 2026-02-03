<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MFO / PAP Dynamic Form</title>

<style>
body {
    font-family: Arial;
    padding: 20px;
}

.indicator {
    border: 1px solid #ccc;
    margin-bottom: 8px;
}

.indicator-header {
    background: #f1f1f1;
    padding: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.indicator-title {
    cursor: pointer;
    font-weight: bold;
}

.indicator-actions button {
    margin-left: 5px;
    padding: 3px 8px;
    font-size: 12px;
}

.indicator-body {
    display: none;
    padding: 10px;
    background: #fafafa;
}

.row {
    display: flex;
    gap: 6px;
}

input, textarea {
    width: 100%;
    padding: 5px;
    margin-bottom: 6px;
}

textarea {
    resize: vertical;
}
</style>
</head>

<body>

<h2>MFO / PAP PERFORMANCE FORM</h2>

<form method="POST" action="process_form.php">

    <input type="text" name="mfo_pap" placeholder="MFO / PAP" required>

    <h3>Success Indicators</h3>

    <div id="indicator-container"></div>

    <button type="button" onclick="addIndicator()">➕ Add Success Indicator</button>
    <br><br>
    <button type="submit">Submit</button>

</form>

<script>
let indicatorCount = 0;

function addIndicator() {
    indicatorCount++;

    const container = document.getElementById("indicator-container");

    const block = document.createElement("div");
    block.className = "indicator";

    block.innerHTML = `
        <div class="indicator-header">
            <div class="indicator-title" onclick="toggleIndicator(this)">
                ▶ Success Indicator ${indicatorCount}
            </div>

            <div class="indicator-actions">
                <button type="button" onclick="deleteIndicator(this)">🗑 Delete</button>
            </div>
        </div>

        <div class="indicator-body">
            <div class="row">
                <input type="number" name="indicator_number[]" placeholder="SI No." required>
                <input type="text" name="indicator_text[]" placeholder="Success Indicator Description" required>
            </div>

            <input type="text" name="accountable[]" placeholder="Individual / Division Accountable" required>

            <div class="row">
                <input type="text" name="actual_ratio[]" placeholder="Actual (200/20)" required>
                <input type="text" name="actual_desc[]" placeholder="Actual Description" required>
            </div>

            <div class="row">
                <input type="number" step="0.01" name="rating_q[]" placeholder="Q" required>
                <input type="number" step="0.01" name="rating_e[]" placeholder="E" required>
                <input type="number" step="0.01" name="rating_t[]" placeholder="T" required>
                <input type="number" step="0.01" name="rating_a[]" placeholder="A" required>
            </div>

            <textarea name="remarks[]" rows="2" placeholder="Remarks" required></textarea>
        </div>
    `;

    container.appendChild(block);
}

function toggleIndicator(el) {
    const indicator = el.closest(".indicator");
    const body = indicator.querySelector(".indicator-body");
    const title = indicator.querySelector(".indicator-title");

    const isOpen = body.style.display === "block";
    body.style.display = isOpen ? "none" : "block";
    title.innerHTML = isOpen
        ? title.innerHTML.replace("▼", "▶")
        : title.innerHTML.replace("▶", "▼");
}

function deleteIndicator(btn) {
    if (confirm("Remove this success indicator?")) {
        btn.closest(".indicator").remove();
    }
}
</script>

</body>
</html>
