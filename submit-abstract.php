<?php
declare(strict_types=1);

/**
 * submit-abstract.php
 * - Saves abstract submission to DB
 * - Uploads file to /uploads/abstracts
 * - Emails admin with attachment (SMTP via Neo)
 * - Emails submitter confirmation (optional)
 * - Always returns JSON
 */

// -------------------- Error reporting (dev) --------------------
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/php-error.log');

// Always return JSON
header('Content-Type: application/json; charset=utf-8');

// ---------- Helpers ----------
function clean_string(string $value): string {
    $value = trim($value);
    $value = preg_replace('/\s+/', ' ', $value) ?? $value;
    return $value;
}

function respond_error(string $message, int $code = 400, array $extra = []): void {
    http_response_code($code);
    echo json_encode(array_merge([
        'ok' => false,
        'message' => $message,
    ], $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

function respond_success(string $message, array $extra = []): void {
    http_response_code(200);
    echo json_encode(array_merge([
        'ok' => true,
        'message' => $message,
    ], $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

// -------------------- Requirements --------------------
require_once __DIR__ . "/db.php";

// Composer autoload (PHPMailer)
$autoload = __DIR__ . "/vendor/autoload.php";
if (!is_file($autoload)) {
    respond_error(
        "Server setup error: vendor/autoload.php not found. Install PHPMailer via Composer or include PHPMailer manually.",
        500,
        ['missing' => 'vendor/autoload.php']
    );
}
require_once $autoload;

use PHPMailer\PHPMailer\PHPMailer;

// ---------------- CONFIG ----------------
$ADMIN_EMAIL = "ernest@ridevemedia.com";      // where submissions should arrive
$FROM_EMAIL  = "ernest@ridevemedia.com";      // ideally same as SMTP_USER
$FROM_NAME   = "ZARECon 2026 Submissions";

$SEND_CONFIRMATION = true;

// Neo SMTP (per Neo docs: smtp0001.neo.space, SSL 465)
$SMTP_HOST   = "smtp0001.neo.space";
$SMTP_USER   = "ernest@ridevemedia.com";
$SMTP_PASS   = "Enesto.totti1"; // <-- replace
$SMTP_PORT   = 465;

// --------------------------------------

// Build configured PHPMailer
function build_mailer(array $cfg): PHPMailer {
    $mail = new PHPMailer(true);

    // Keep debugging off for users, but log via error_log when needed
    $mail->SMTPDebug  = 0;
    $mail->Debugoutput = function ($str, $level) {
        error_log("SMTP[$level] $str");
    };

    // SMTP always (Neo)
    $mail->isSMTP();
    $mail->Host       = $cfg['SMTP_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $cfg['SMTP_USER'];
    $mail->Password   = $cfg['SMTP_PASS'];

    // Neo uses SSL on 465
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = (int)$cfg['SMTP_PORT'];

    // macOS/XAMPP TLS workaround (useful in local dev)
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ],
    ];

    // Helpful stability tweaks
    $mail->Timeout = 20;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom($cfg['FROM_EMAIL'], $cfg['FROM_NAME']);

    return $mail;
}

function send_admin_email(array $cfg, array $payload): void {
    $mail = build_mailer($cfg);

    $mail->addAddress($cfg['ADMIN_EMAIL']);
    $mail->addReplyTo($payload['email'], $payload['full_name']);

    $mail->Subject = "New Abstract Submission: " . $payload['abstract_title'];

    $body =
        "A new abstract has been submitted.\n\n" .
        "Full Name: {$payload['full_name']}\n" .
        "Email: {$payload['email']}\n" .
        "Institution: {$payload['institution']}\n" .
        "Abstract Title: {$payload['abstract_title']}\n" .
        "Submitted At: {$payload['submitted_at']}\n" .
        "IP Address: {$payload['ip_address']}\n\n" .
        "Attached: {$payload['file_original_name']}\n";

    $mail->Body = $body;

    // Attach uploaded file
    if (!is_file($payload['file_abs_path']) || !is_readable($payload['file_abs_path'])) {
        throw new RuntimeException("Attachment missing or unreadable on server.");
    }
    $mail->addAttachment($payload['file_abs_path'], $payload['file_original_name']);

    $mail->send();
}

function send_confirmation_email(array $cfg, array $payload): void {
    $mail = build_mailer($cfg);

    $mail->addAddress($payload['email'], $payload['full_name']);
    $mail->Subject = "ZARECon 2026: Abstract Submission Received";

    $mail->Body =
        "Hello {$payload['full_name']},\n\n" .
        "Thank you for submitting your abstract to ZARECon 2026.\n\n" .
        "Submission Summary:\n" .
        "Abstract Title: {$payload['abstract_title']}\n" .
        "Institution: {$payload['institution']}\n\n" .
        "We will be in touch after the peer review process.\n\n" .
        "Regards,\n" .
        "ZARECon 2026 Secretariat";

    $mail->send();
}

// ---------- Only accept POST ----------
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    respond_error("Invalid request method.", 405);
}

// ---------- Validate fields ----------
$full_name      = clean_string($_POST['full_name'] ?? '');
$email          = clean_string($_POST['email'] ?? '');
$institution    = clean_string($_POST['institution'] ?? '');
$abstract_title = clean_string($_POST['abstract_title'] ?? '');

if ($full_name === '' || mb_strlen($full_name) < 2) {
    respond_error("Please enter a valid full name.");
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond_error("Please enter a valid email address.");
}
if ($institution === '' || mb_strlen($institution) < 2) {
    respond_error("Please enter a valid institution/organization.");
}
if ($abstract_title === '' || mb_strlen($abstract_title) < 3) {
    respond_error("Please enter a valid abstract title.");
}

// ---------- File validation ----------
if (!isset($_FILES['abstract_file'])) {
    respond_error("Please upload your abstract file (PDF/DOC/DOCX).");
}

$file = $_FILES['abstract_file'];

if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
    respond_error("Upload error. Please try again.");
}

$maxBytes = 10 * 1024 * 1024; // 10MB
if (($file['size'] ?? 0) <= 0 || $file['size'] > $maxBytes) {
    respond_error("File size must be less than 10MB.");
}

$allowedExt = ['pdf', 'doc', 'docx'];
$originalName = $file['name'] ?? 'abstract';
$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

if (!in_array($ext, $allowedExt, true)) {
    respond_error("Invalid file type. Please upload a PDF, DOC, or DOCX file.");
}

if (!class_exists('finfo')) {
    respond_error("Server error: Fileinfo extension is not enabled (finfo missing).", 500);
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime  = $finfo->file($file['tmp_name']) ?: 'application/octet-stream';

$allowedMime = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/octet-stream',
];

if (!in_array($mime, $allowedMime, true)) {
    respond_error("File appears invalid. Please upload a valid PDF/DOC/DOCX.");
}

// ---------- Store upload ----------
$uploadDir = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "abstracts";

if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true)) {
    respond_error("Server error: could not create upload directory.", 500);
}
if (!is_writable($uploadDir)) {
    respond_error("Server error: upload directory is not writable.", 500);
}

$storedName  = bin2hex(random_bytes(16)) . "." . $ext;
$destination = $uploadDir . DIRECTORY_SEPARATOR . $storedName;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    respond_error("Upload failed while saving the file. Please try again.", 500);
}

$filePathRel = "uploads/abstracts/" . $storedName;

// ---------- Save to DB ----------
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

$sql = "INSERT INTO abstract_submissions
        (full_name, email, institution, abstract_title, file_original_name, file_stored_name, file_path, file_mime, file_size_bytes, ip_address, user_agent)
        VALUES
        (:full_name, :email, :institution, :abstract_title, :file_original_name, :file_stored_name, :file_path, :file_mime, :file_size_bytes, :ip_address, :user_agent)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':full_name'          => $full_name,
    ':email'              => $email,
    ':institution'        => $institution,
    ':abstract_title'     => $abstract_title,
    ':file_original_name' => $originalName,
    ':file_stored_name'   => $storedName,
    ':file_path'          => $filePathRel,
    ':file_mime'          => $mime,
    ':file_size_bytes'    => (int)($file['size'] ?? 0),
    ':ip_address'         => $ipAddress,
    ':user_agent'         => $userAgent ? mb_substr($userAgent, 0, 255) : null,
]);

// ---------- Email admin + optional confirmation ----------
$cfg = [
    'ADMIN_EMAIL' => $ADMIN_EMAIL,
    'FROM_EMAIL'  => $FROM_EMAIL,
    'FROM_NAME'   => $FROM_NAME,
    'SMTP_HOST'   => $SMTP_HOST,
    'SMTP_USER'   => $SMTP_USER,
    'SMTP_PASS'   => $SMTP_PASS,
    'SMTP_PORT'   => $SMTP_PORT,
];

$payload = [
    'full_name'          => $full_name,
    'email'              => $email,
    'institution'        => $institution,
    'abstract_title'     => $abstract_title,
    'file_original_name' => $originalName,
    'file_abs_path'      => $destination,
    'submitted_at'       => date('Y-m-d H:i:s'),
    'ip_address'         => (string)($ipAddress ?? ''),
];

$email_sent = true;

try {
    send_admin_email($cfg, $payload);
} catch (Throwable $e) {
    $email_sent = false;
    error_log("Admin email failed: " . $e->getMessage());
}

if ($SEND_CONFIRMATION) {
    try {
        send_confirmation_email($cfg, $payload);
    } catch (Throwable $e) {
        // Don't block submission if confirmation fails
        error_log("Confirmation email failed: " . $e->getMessage());
    }
}

// ---------- Final response ----------
respond_success(
    $email_sent
        ? "Abstract submitted successfully ✅ Thank you, {$full_name}."
        : "Abstract submitted ✅ (Email notification failed — submission was saved).",
    [
        'saved_file' => $filePathRel,
        'email_sent' => $email_sent,
    ]
);
