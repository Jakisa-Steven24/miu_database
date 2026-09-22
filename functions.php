<?php
/**
 * Small shared helpers.
 * Included once from db.php, so every page can use these functions.
 */

/**
 * Escape a value before printing it inside HTML (prevents broken pages / XSS).
 */
function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

/**
 * Redirect back to a page with a flash message in the URL.
 * e.g. redirect_to("department.php", "Saved!", "success");
 */
function redirect_to($page, $msg, $type = "success")
{
    $sep = (strpos($page, "?") === false) ? "?" : "&";
    header("Location: " . $page . $sep . "msg=" . urlencode($msg) . "&type=" . $type);
    exit;
}

/**
 * Render the flash alert that redirect_to() placed in the URL (?msg=...&type=...).
 */
function flash_alert()
{
    if (!isset($_GET["msg"]) || $_GET["msg"] === "") {
        return "";
    }

    $type  = (($_GET["type"] ?? "") === "error") ? "error" : "success";
    $html  = '<div class="alert ' . $type . '">';
    $html .= h($_GET["msg"]);
    $html .= '</div>';

    return $html;
}

/**
 * Load a single row by primary key, or null when not found.
 * $table / $pk are hardcoded by the caller (never user input).
 */
function fetch_row_by_id($conn, $table, $pk, $id)
{
    $id = (int) $id;

    if ($id <= 0) {
        return null;
    }

    $stmt = $conn->prepare("SELECT * FROM `$table` WHERE `$pk` = ? LIMIT 1");

    if ($stmt === false) {
        return null;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $row ? $row : null;
}

/**
 * Run a SELECT and return all rows as an array (easy to loop, easy to debug).
 */
function fetch_all_rows($conn, $sql)
{
    $result = $conn->query($sql);

    if ($result === false) {
        return [];
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * The View / Edit / Delete buttons shown on every table row.
 */
function row_actions($page, $id)
{
    $id    = (int) $id;
    $html  = '<a class="btn btn-sm btn-view" href="' . $page . '.php?view=' . $id . '">View</a>';
    $html .= '<a class="btn btn-sm btn-edit" href="' . $page . '.php?edit=' . $id . '">Edit</a>';
    $html .= '<a class="btn btn-sm btn-delete" href="delete_' . $page . '.php?id=' . $id . '"';
    $html .= ' onclick="return confirm(\'Delete this record? This cannot be undone.\');"';
    $html .= '>Delete</a>';

    return $html;
}

/**
 * Read-only "details" card used by the View button.
 * Pass an array of "Label" => value pairs.
 */
function details_card($title, $pairs)
{
    $html  = '<div class="content-card">';
    $html .= '<div class="card-head record"><span class="bar"></span><h2>' . h($title) . '</h2></div>';
    $html .= '<div class="card-body"><div class="details">';

    foreach ($pairs as $label => $value) {
        $show  = ($value === null || $value === "") ? "&mdash;" : h($value);
        $html .= '<div class="detail-item"><span>' . h($label) . '</span><strong>' . $show . '</strong></div>';
    }

    $html .= '</div></div></div>';

    return $html;
}
