<?php

$conn = new mysqli("localhost", "root", "", "opcr_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* =========================
       SAVE MFO (PARENT)
    ========================== */
    $mfo_pap = $_POST['mfo_pap'];

    $stmtMfo = $conn->prepare("
        INSERT INTO mfo (mfo_pap)
        VALUES (?)
    ");
    $stmtMfo->bind_param("s", $mfo_pap);
    $stmtMfo->execute();

    // Get generated mfo_id
    $mfo_id = $conn->insert_id;
    $stmtMfo->close();

    /* =========================
       GET SUB-FUNCTION DATA
    ========================== */
    $success_target         = $_POST['indicator_number'];
    $success_measure        = $_POST['indicator_text'];
    $indiv_div_account      = $_POST['accountable'];
    $actual_target          = $_POST['actual_ratio'];
    $actual_accomplishment  = $_POST['actual_desc'];

    /* =========================
       SAVE SUB-FUNCTIONS (CHILD)
    ========================== */
    for ($i = 0; $i < count($success_target); $i++) {

        // Skip empty rows
        if (
            empty($success_target[$i]) &&
            empty($success_measure[$i])
        ) {
            continue;
        }

        /* -------- COMPUTE rating_q -------- */
        $rating_q = 1;

        // Extract ACTUAL from "actual/target"
        if (strpos($actual_target[$i], '/') !== false) {
            list($actual, ) = explode('/', $actual_target[$i]);
        } else {
            $actual = $actual_target[$i];
        }

        if (
            is_numeric($actual) &&
            is_numeric($success_target[$i]) &&
            $success_target[$i] > 0
        ) {
            $percentage = ($actual / $success_target[$i]) * 100;

            if ($percentage >= 150) {
                $rating_q = 5;
            } elseif ($percentage >= 120) {
                $rating_q = 4;
            } elseif ($percentage >= 100) {
                $rating_q = 3;
            } elseif ($percentage >= 70) {
                $rating_q = 2;
            } else {
                $rating_q = 1;
            }
        }

        /* -------- INSERT SUB-FUNCTION -------- */
        $stmtOpcr = $conn->prepare("
            INSERT INTO opcr
            (
                mfo_id,
                success_target,
                success_measure,
                indiv_div_account,
                actual_target,
                actual_accomplishment,
                rating_q
            )
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmtOpcr->bind_param(
            "isssssi",
            $mfo_id,
            $success_target[$i],
            $success_measure[$i],
            $indiv_div_account[$i],
            $actual_target[$i],
            $actual_accomplishment[$i],
            $rating_q
        );

        $stmtOpcr->execute();
        $stmtOpcr->close();
    }

    header("Location: opcr_form.php?success=1");
    exit;
}

$conn->close();
