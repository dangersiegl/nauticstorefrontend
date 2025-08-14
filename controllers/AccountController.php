<?php
// controllers/AccountController.php

require_once __DIR__ . '/../inc/WishlistHelper.php'; 

require __DIR__ . '/../scripts/PHPMailer/Exception.php';
require __DIR__ . '/../scripts/PHPMailer/PHPMailer.php';
require __DIR__ . '/../scripts/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AccountController {
    private $pdo;
    private $lang;
    private $baseUrl;

    public function __construct($lang, $baseUrl) {
        global $pdo;
        $this->pdo     = $pdo;
        $this->lang    = $lang;
        $this->baseUrl = $baseUrl;
        session_start();
    }

    /**
     * Default action: zeigt Übersicht oder leitet zum Login
     */
    public function index() {
        $this->overview();
    }

    /**
     * Login-Formular anzeigen & verarbeiten
     */
    public function login()
    {
        $loginErrors  = [];
        $loginEmail   = '';

        // 1) Pending-State und TOTP-Flag initialisieren
        $pendingId   = $_SESSION['pending_2fa_user'] ?? null;
        $requireTotp = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? 'login_password';

            // --- 1) Passwort-Login ---
            if ($action === 'login_password') {
                $loginEmail    = trim($_POST['email']    ?? '');
                $loginPassword = $_POST['password']      ?? '';

                if ($loginEmail === '' || !filter_var($loginEmail, FILTER_VALIDATE_EMAIL)) {
                    $loginErrors[] = $this->lang==='en'
                        ? 'Please enter a valid email.'
                        : 'Bitte gültige E-Mail eingeben.';
                }
                if ($loginPassword === '') {
                    $loginErrors[] = $this->lang==='en'
                        ? 'Please enter your password.'
                        : 'Bitte Passwort eingeben.';
                }

                if (empty($loginErrors)) {
                    $stmt = $this->pdo->prepare("
                        SELECT id, email, password, totp_secret
                        FROM users_users
                        WHERE email = :email
                        LIMIT 1
                    ");
                    $stmt->execute(['email' => $loginEmail]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user && password_verify($loginPassword, $user['password'])) {
                        if (!empty($user['totp_secret'])) {
                            // 2FA ist aktiviert → TOTP-Code anfordern
                            $_SESSION['pending_2fa_user'] = $user['id'];
                            $requireTotp = true;
                        } else {
                            // kein TOTP → direkter Login
                            unset($_SESSION['pending_2fa_user']);
                            $_SESSION['user_id'] = $user['id'];
                            header("Location: {$this->baseUrl}/account");
                            exit;
                        }
                    } else {
                        $loginErrors[] = $this->lang==='en'
                            ? 'Email or password is incorrect.'
                            : 'E-Mail oder Passwort ist falsch.';
                    }
                }
            }
            // --- 2) TOTP-Code-Login ---
            elseif ($action === 'login_totp' && $pendingId) {
                $requireTotp = true; // damit wir das TOTP-Formular (wieder) anzeigen

                $code = trim($_POST['totp_code'] ?? '');
                $stmt = $this->pdo->prepare("
                    SELECT totp_secret
                    FROM users_users
                    WHERE id = :id
                    LIMIT 1
                ");
                $stmt->execute(['id' => $pendingId]);
                $secret = $stmt->fetchColumn();

                if ($secret && $this->verifyTotp($secret, $code)) {
                    // 2FA erfolgreich – Login abschließen
                    unset($_SESSION['pending_2fa_user']);
                    $_SESSION['user_id'] = $pendingId;
                    header("Location: {$this->baseUrl}/account");
                    exit;
                } else {
                    $loginErrors[] = $this->lang==='en'
                        ? 'Invalid authentication code.'
                        : 'Ungültiger Authentifizierungscode.';
                }
            }
        }

        // Länder für das Formular (wird im View gebraucht)
        $countries = $this->pdo
            ->query("
                SELECT code, name_de, name_en 
                FROM countries 
                ORDER BY 
                    CASE 
                        WHEN code = 'AT' THEN 1
                        WHEN code = 'DE' THEN 2
                        ELSE 3
                    END,
                    name_de
            ")
            ->fetchAll(PDO::FETCH_ASSOC);

        // und jetzt nur noch einmal das View laden:
        require __DIR__ . '/../views/account/login.php';
    }


    public function register() {
        // ----------------------------------------------------------------------------
        // 1) POST‐Werte vorbefüllen (damit das Formular nach Fehlern wieder ausgefüllt ist)
        // ----------------------------------------------------------------------------
        $errorsRegister    = [];
        $regTitle          = $_POST['title']             ?? 'male';
        $regCompany        = trim($_POST['company']      ?? '');
        $regVatId          = trim($_POST['vat_id']       ?? '');
        $regFirstName      = trim($_POST['first_name']   ?? '');
        $regLastName       = trim($_POST['last_name']    ?? '');
        $regStreet         = trim($_POST['street']       ?? '');
        $regStreetNr       = trim($_POST['street_number']?? '');
        $regAddressAdd     = trim($_POST['address_addition'] ?? '');
        $regPostalCode     = trim($_POST['postal_code']  ?? '');
        $regCity           = trim($_POST['city']         ?? '');
        $regCountry        = $_POST['country_code']      ?? '';
        $regEmail          = trim($_POST['email']        ?? '');
        $regPassword       = $_POST['password']          ?? '';
        $regPassword2      = $_POST['password2']         ?? '';
        $regNewsletter     = isset($_POST['newsletter_opt_in']) ? 1 : 0;
        $regTerms          = isset($_POST['terms_agreed'])       ? 1 : 0;

        // Versandadresse optional
        $regUseShipping       = isset($_POST['use_shipping']);
        $regShipFirstName     = trim($_POST['ship_first_name']        ?? '');
        $regShipLastName      = trim($_POST['ship_last_name']         ?? '');
        $regShipStreet        = trim($_POST['ship_street']            ?? '');
        $regShipStreetNr      = trim($_POST['ship_street_number']     ?? '');
        $regShipAddressAdd    = trim($_POST['ship_address_addition']  ?? '');
        $regShipPostalCode    = trim($_POST['ship_postal_code']       ?? '');
        $regShipCity          = trim($_POST['ship_city']              ?? '');
        $regShipCountry       = $_POST['ship_country_code']           ?? '';

        // ----------------------------------------------------------------------------
        // 2) Nur bei POST: Validierung
        // ----------------------------------------------------------------------------
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- Anrede / Firma ---
            if (!in_array($regTitle, ['male','female','none','company'])) {
                $errorsRegister[] = $this->lang==='en'
                    ? 'Please select a title.'
                    : 'Bitte Anrede auswählen.';
            }
            if ($regTitle==='company' && $regCompany==='') {
                $errorsRegister[] = $this->lang==='en'
                    ? 'Please enter your company name.'
                    : 'Bitte Firmenname eingeben.';
            }

            // --- Pflichtfelder Privat ---
            $required = [
                'First name'      => $regFirstName,
                'Last name'       => $regLastName,
                'Street'          => $regStreet,
                'No.'             => $regStreetNr,
                'Postal code'     => $regPostalCode,
                'City'            => $regCity,
            ];
            foreach ($required as $label => $val) {
                if ($val === '') {
                    $errorsRegister[] = ($this->lang==='en')
                        ? "$label is required."
                        : strtr("$label is required.", [
                            'First name'  => 'Vorname',
                            'Last name'   => 'Nachname',
                            'Street'      => 'Straße',
                            'No.'         => 'Nr.',
                            'Postal code' => 'Postleitzahl',
                            'City'        => 'Ort'
                        ]) . ' ist erforderlich.';
                }
            }

            // --- Land prüfen ---
            $stmtC = $this->pdo->prepare("SELECT COUNT(*) FROM countries WHERE code = :c");
            $stmtC->execute(['c' => $regCountry]);
            if ((int)$stmtC->fetchColumn() === 0) {
                $errorsRegister[] = $this->lang==='en'
                    ? 'Please choose a valid country.'
                    : 'Bitte gültiges Land auswählen.';
            }

            // --- E-Mail & AGB ---
            if ($regEmail === '' || !filter_var($regEmail, FILTER_VALIDATE_EMAIL)) {
                $errorsRegister[] = $this->lang==='en'
                    ? 'Please enter a valid email.'
                    : 'Bitte gültige E-Mail eingeben.';
            }
            if (!$regTerms) {
                $errorsRegister[] = $this->lang==='en'
                    ? 'You must agree to the terms.'
                    : 'Bitte AGB und Datenschutz bestätigen.';
            }

            // --- Passwort‐Policy ---
            $pwPattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/';
            if (!preg_match($pwPattern, $regPassword)) {
                $errorsRegister[] = $this->lang==='en'
                    ? 'Password must be at least 8 characters long and include at least one letter, one number and one special character.'
                    : 'Passwort muss mindestens 8 Zeichen, 1 Zahl, 1 Buchstabe & 1 Sonderzeichen enthalten.';
            }
            if ($regPassword !== $regPassword2) {
                $errorsRegister[] = $this->lang==='en'
                    ? 'Passwords do not match.'
                    : 'Passwörter stimmen nicht überein.';
            }

            // --- E-Mail‐Duplikat prüfen ---
            if (empty($errorsRegister)) {
                $dup = $this->pdo->prepare("SELECT COUNT(*) FROM users_users WHERE email = :email");
                $dup->execute(['email' => $regEmail]);
                if ($dup->fetchColumn() > 0) {
                    $errorsRegister[] = $this->lang==='en'
                        ? 'This email is already registered.'
                        : 'Diese E-Mail ist bereits registriert.';
                }
            }

            // ----------------------------------------------------------------------------
            // 3) Wenn keine Fehler: Anlage, Login, Mail, Redirect
            // ----------------------------------------------------------------------------
            if (empty($errorsRegister)) {
                // 3a) Nutzer anlegen
                $hash = password_hash($regPassword, PASSWORD_DEFAULT);
                $ins = $this->pdo->prepare("
                    INSERT INTO users_users 
                    (first_name, last_name, email, password, newsletter_opt_in, terms_agreed)
                    VALUES
                    (:fn, :ln, :email, :pw, :news, :terms)
                ");
                $ins->execute([
                    'fn'     => $regFirstName,
                    'ln'     => $regLastName,
                    'email'  => $regEmail,
                    'pw'     => $hash,
                    'news'   => $regNewsletter,
                    'terms'  => $regTerms
                ]);
                $userId = $this->pdo->lastInsertId();

                // 3b) Rechnungsadresse anlegen (immer standard=1)
                $insAddr = $this->pdo->prepare("
                INSERT INTO users_addresses
                    (user_id,address_type,title,company,vat_id,street,street_number,
                    address_addition,postal_code,city,country_code,first_name,last_name,standard)
                VALUES
                    (:uid,'billing',:title,:company,:vat,:st,:stnr,
                    :add,:zip,:city,:cc,:fn,:ln,1)
                ");
                $insAddr->execute([
                    'uid'     => $userId,
                    'title'   => $regTitle,
                    'company' => $regCompany ?: null,
                    'vat'     => $regVatId   ?: null,
                    'st'      => $regStreet,
                    'stnr'    => $regStreetNr,
                    'add'     => $regAddressAdd ?: null,
                    'zip'     => $regPostalCode,
                    'city'    => $regCity,
                    'cc'      => $regCountry,
                    'fn'      => $regFirstName,
                    'ln'      => $regLastName
                ]);

                // 3c) Versandadresse, falls angekreuzt (ebenfalls standard=1)
                if ($regUseShipping) {
                    $insShip = $this->pdo->prepare("
                    INSERT INTO users_addresses
                        (user_id,address_type,title,company,vat_id,street,street_number,
                        address_addition,postal_code,city,country_code,first_name,last_name,standard)
                    VALUES
                        (:uid,'shipping',:title,:company,:vat,:st,:stnr,
                        :add,:zip,:city,:cc,:fn,:ln,1)
                    ");
                    $insShip->execute([
                        'uid'     => $userId,
                        'title'   => $regTitle,
                        'company' => $regCompany ?: null,
                        'vat'     => $regVatId   ?: null,
                        'st'      => $regShipStreet,
                        'stnr'    => $regShipStreetNr,
                        'add'     => $regShipAddressAdd ?: null,
                        'zip'     => $regShipPostalCode,
                        'city'    => $regShipCity,
                        'cc'      => $regShipCountry,
                        'fn'      => $regShipFirstName,
                        'ln'      => $regShipLastName
                    ]);
                }

                // 3d) Sofort einloggen
                $_SESSION['user_id']   = $userId;
                $_SESSION['user_name'] = $regFirstName . ' ' . $regLastName;

                // 3e) Bestätigungsmail
                $this->sendRegistrationMail($regFirstName, $regLastName, $regEmail);

                // 3f) Redirect auf Übersicht
                header("Location: {$this->baseUrl}/account");
                exit;
            }
        }

        // ----------------------------------------------------------------------------
        // Länder & View zurückgeben
        // ----------------------------------------------------------------------------
        $countries = $this->pdo
        ->query("SELECT code,name_de,name_en FROM countries ORDER BY name_de")
        ->fetchAll(PDO::FETCH_ASSOC);

        $activeTab = 'register';
        require __DIR__ . '/../views/account/login.php';
    }

    private function sendRegistrationMail($firstName, $lastName, $email) {
        $conf   = \Config::getInstance();
        $logo   = htmlspecialchars($this->baseUrl . '/assets/img/logo.png');
        $loginUrl = $this->baseUrl . '/account/login';
    
        $mail = new PHPMailer(true);
        try {
            // SMTP-Setup
            $mail->isSMTP();
            $mail->Host       = $conf->smtpHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $conf->smtpUser;
            $mail->Password   = $conf->smtpPass;
            $mail->SMTPSecure = $conf->smtpSecure==='ssl'
                                ? PHPMailer::ENCRYPTION_SMTPS
                                : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $conf->smtpPort;
    
            // Absender/E-Mail
            $mail->setFrom($conf->smtpFromEmail, $conf->smtpFromName);
            $mail->addAddress($email, "$firstName $lastName");
    
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = $this->lang==='en'
                ? 'Welcome to Nauticstore24!'
                : 'Vielen Dank für Ihre Registrierung!';
    
            // Header-/Footer-Texte
            if ($this->lang==='en') {
                $greeting = "Dear $firstName,";
                $intro    = "Thank you for registering at Nauticstore24. You can now place orders, view your order history and manage your data in your account dashboard.";
                $btnText  = "Go to your account";
            } else {
                $greeting = "Hallo $firstName,";
                $intro    = "herzlichen Dank für Ihre Registrierung bei Nauticstore24! Sie können nun Bestellungen durchführen, Ihren Bestellstatus einsehen und Ihre Daten verwalten.";
                $btnText  = "Zu Ihrem Konto";
            }
    
            // Footer mit allen Kontaktdaten
            if ($this->lang==='en') {
                $footer = <<<HTML
    <p style="font-size:0.9em;color:#666;margin:0">
      Nauticstore24<br>
      Unterhart 3, 4113 St. Martin — Austria<br>
      Phone: +43 660 5198793 | WhatsApp: +43 660 5198793 | 
      <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a><br>
      <a href="{$this->baseUrl}">{$this->baseUrl}</a>
    </p>
    HTML;
            } else {
                $footer = <<<HTML
    <p style="font-size:0.9em;color:#666;margin:0">
      Nauticstore24<br>
      Unterhart 3, 4113 St. Martin — Österreich<br>
      Tel: +43 660 5198793 | WhatsApp: +43 660 5198793 | 
      <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a><br>
      <a href="{$this->baseUrl}">{$this->baseUrl}</a>
    </p>
    HTML;
            }
    
            // HTML­Template
            $mail->Body = <<<HTML
    <!DOCTYPE html>
    <html lang="{$this->lang}">
    <head><meta charset="UTF-8"><title>{$mail->Subject}</title></head>
    <body style="margin:0;padding:0;font-family:Arial,sans-serif;color:#333">
     <table width="100%" bgcolor="#f5f5f5" cellpadding="20"><tr><td align="center">
      <table width="600" bgcolor="#fff" cellpadding="0" cellspacing="0" style="border-radius:4px;overflow:hidden">
       <tr><td bgcolor="#004974" style="padding:20px;text-align:center">
         <img src="$logo" alt="Nauticstore24" style="max-height:50px">
       </td></tr>
       <tr><td style="padding:30px">
         <h1 style="margin-top:0;color:#004974">{$mail->Subject}</h1>
         <p style="font-size:1.1em;line-height:1.5">$greeting</p>
         <p style="font-size:1em;line-height:1.5">$intro</p>
         <p style="text-align:center;margin:30px 0">
           <a href="$loginUrl"
              style="background:#004974;color:#fff;
                     padding:12px 24px;
                     text-decoration:none;
                     font-size:1em;
                     border-radius:4px;
                     display:inline-block;">
             $btnText
           </a>
         </p>
       </td></tr>
       <tr><td bgcolor="#f0f0f0" style="padding:20px;text-align:center">
         $footer
       </td></tr>
      </table>
     </td></tr></table>
    </body>
    </html>
    HTML;
    
            $mail->send();
        } catch(Exception $e) {
            error_log("Registration mail error: " . $e->getMessage());
        }
    }
    

    /**
     * Logout: Session zerstören und zur Login-Seite
     */
    public function logout() {
        session_destroy();
        header("Location: {$this->baseUrl}/account/login");
        exit;
    }

    /**
     * Profilseite mit Möglichkeit, Name zu ändern
     */
    public function profile() {
        if (empty($_SESSION['user_id'])) {
            header("Location: {$this->baseUrl}/account/login");
            exit;
        }

        $stmt = $this->pdo->prepare("SELECT id, name, email FROM users_users WHERE id = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newName = trim($_POST['name'] ?? '');
            if ($newName === '') {
                $errors[] = $this->lang==='en'
                    ? 'Please enter your name.'
                    : 'Bitte Namen eingeben.';
            }
            if (empty($errors)) {
                $upd = $this->pdo->prepare("UPDATE users_users SET name = :name WHERE id = :id");
                $upd->execute([
                    'name' => $newName,
                    'id'   => $_SESSION['user_id']
                ]);
                // neu laden, damit Änderungen sichtbar werden
                header("Location: {$this->baseUrl}/account/profile");
                exit;
            }
        }

        require __DIR__ . '/../views/account/profile.php';
    }

    /**
     * Bestellungen des Nutzers anzeigen
     */
    public function orders() {
        if (empty($_SESSION['user_id'])) {
            header("Location: {$this->baseUrl}/account/login");
            exit;
        }

        $stmt = $this->pdo->prepare("
            SELECT id, order_date, total_amount
            FROM orders
            WHERE user_id = :uid
            ORDER BY order_date DESC
        ");
        $stmt->execute(['uid' => $_SESSION['user_id']]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/account/orders.php';
    }

    /**
     * Dashboard / Übersicht nach Login
     */
    public function overview() {
        if (empty($_SESSION['user_id'])) {
            header("Location: {$this->baseUrl}/account/login");
            exit;
        }

        // 1) Namen aus users_users lesen
        $stmt = $this->pdo->prepare("
            SELECT first_name, last_name
            FROM users_users
            WHERE id = :uid
            LIMIT 1
        ");
        $stmt->execute(['uid' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Bestellungen wie gehabt…
        $stmt = $this->pdo
            ->prepare("SELECT id, order_date, total_amount FROM orders_orders
                    WHERE user_id = :uid ORDER BY order_date DESC");
        $stmt->execute(['uid'=>$_SESSION['user_id']]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Aktuelle Standard-Adressen laden:
        $sql = "
        SELECT a.*, c.name_de, c.name_en
        FROM users_addresses a
        JOIN countries c ON c.code = a.country_code
        WHERE a.user_id = :uid
            AND a.standard = 1
            AND a.address_type = :type
        LIMIT 1
        ";

        // Rechnungsadresse
        $stmtB = $this->pdo->prepare($sql);
        $stmtB->execute(['uid'=>$_SESSION['user_id'], 'type'=>'billing']);
        $billing = $stmtB->fetch(PDO::FETCH_ASSOC);

        // Lieferadresse (falls gesetzt)
        $stmtS = $this->pdo->prepare($sql);
        $stmtS->execute(['uid'=>$_SESSION['user_id'], 'type'=>'shipping']);
        $shipping = $stmtS->fetch(PDO::FETCH_ASSOC);

        // an die View übergeben
        require __DIR__ . '/../views/account/overview.php';
    }

    /**
     * Meine Adressen anzeigen
    */
    public function data()
    {
        // Nur eingeloggt erlaubt
        if (empty($_SESSION['user_id'])) {
            header("Location: {$this->baseUrl}/account/login");
            exit;
        }

        $uid = $_SESSION['user_id'];

        // Rechnungsadresse holen (standard=1)
        $stmt = $this->pdo->prepare("
            SELECT ua.*, c.name_de, c.name_en
            FROM users_addresses ua
            JOIN countries c ON ua.country_code = c.code
            WHERE ua.user_id = :uid
            AND ua.address_type = 'billing'
            AND ua.standard = 1
            LIMIT 1
        ");
        $stmt->execute(['uid' => $uid]);
        $billing = $stmt->fetch(PDO::FETCH_ASSOC);

        // Lieferanschrift holen (standard=1)
        $stmt = $this->pdo->prepare("
            SELECT ua.*, c.name_de, c.name_en
            FROM users_addresses ua
            JOIN countries c ON ua.country_code = c.code
            WHERE ua.user_id = :uid
            AND ua.address_type = 'shipping'
            AND ua.standard = 1
            LIMIT 1
        ");
        $stmt->execute(['uid' => $uid]);
        $shipping = $stmt->fetch(PDO::FETCH_ASSOC);

        // Alle weiteren Adressen (standard=0)
        $stmt = $this->pdo->prepare("
            SELECT ua.*, c.name_de, c.name_en
            FROM users_addresses ua
            JOIN countries c ON ua.country_code = c.code
            WHERE ua.user_id = :uid
            AND ua.standard = 0
            ORDER BY ua.address_type, ua.id
        ");
        $stmt->execute(['uid' => $uid]);
        $others = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // flash message auslesen und wieder löschen
        $flashSuccess = $_SESSION['flash_success'] ?? null;
        unset($_SESSION['flash_success']);

        require __DIR__ . '/../views/account/data.php';
    }

    /**
     * Neue Adresse anlegen / bestehende bearbeiten
     */
    public function dataEdit()
    {
        $this->requireLogin();
        $uid = $_SESSION['user_id'];
        $id  = $_GET['addr'] ?? null;
        $addr['title']   = 'male';
        $addr['company'] = '';
        $addr['vat_id']  = '';

        // Länderliste
        $countries = $this->pdo
            ->query("SELECT code,name_de,name_en FROM countries ORDER BY name_de")
            ->fetchAll(PDO::FETCH_ASSOC);

        // DEFAULTS für “neu anlegen”
        $addr = [
        'address_type'     => $_GET['type'] ?? 'billing',
        'title'            => 'male',
        'company'          => '',
        'vat_id'           => '',
        'first_name'       => '',
        'last_name'        => '',
        'street'           => '',
        'street_number'    => '',
        'address_addition' => '',
        'postal_code'      => '',
        'city'             => '',
        'country_code'     => 'AT',
        'standard'         => 1
        ];

        // Wenn edit: Daten laden
        if ($id) {
            $stmt = $this->pdo->prepare("
            SELECT * FROM users_addresses
            WHERE id = :id AND user_id = :uid
            LIMIT 1
            ");
            $stmt->execute(['id'=>$id,'uid'=>$uid]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $addr = $row;
            } else {
                // falscher Zugriff
                header("Location: {$this->baseUrl}/account/data");
                exit;
            }
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            // Werte aus POST
            $addr['address_type']     = $_POST['address_type']     ?? 'billing';
            $addr['first_name']       = trim($_POST['first_name']   ?? '');
            $addr['last_name']        = trim($_POST['last_name']    ?? '');
            $addr['street']           = trim($_POST['street']       ?? '');
            $addr['street_number']    = trim($_POST['street_number']?? '');
            $addr['address_addition'] = trim($_POST['address_addition'] ?? '');
            $addr['postal_code']      = trim($_POST['postal_code']  ?? '');
            $addr['city']             = trim($_POST['city']         ?? '');
            $addr['country_code']     = $_POST['country_code']     ?? '';
            $addr['title']   = $_POST['title']    ?? 'none';
            $addr['company'] = trim($_POST['company'] ?? '');
            $addr['vat_id']  = trim($_POST['vat_id']  ?? '');
            $addr['standard']= isset($_POST['standard']) ? 1 : 0;

            // Validierung

            // Validierung Anrede/Firma:
            if (!in_array($addr['title'], ['male','female','none','company'])) {
            $errors[] = $this->lang==='en'
                ? 'Please select a title.'
                : 'Bitte Anrede auswählen.';
            }
            if ($addr['title']==='company' && $addr['company']==='') {
            $errors[] = $this->lang==='en'
                ? 'Please enter company name.'
                : 'Bitte Firmenname eingeben.';
            }

            $required = [
                'first_name'=>'Vorname',
                'last_name' =>'Nachname',
                'street'    =>($this->lang==='en'?'Street':'Straße'),
                'street_number'=>($this->lang==='en'?'No.':'Nr.'),
                'postal_code'=>($this->lang==='en'?'Postal code':'Postleitzahl'),
                'city'      =>($this->lang==='en'?'City':'Ort'),
            ];
            foreach ($required as $field=>$label) {
                if ($addr[$field]==='') {
                    $errors[] = ($this->lang==='en')
                        ? "$label is required."
                        : "$label ist erforderlich.";
                }
            }
            // gültiges Land?
            $c = $this->pdo->prepare("SELECT COUNT(*) FROM countries WHERE code=:c");
            $c->execute(['c'=>$addr['country_code']]);
            if ($c->fetchColumn()==0) {
                $errors[] = $this->lang==='en'
                    ? 'Please choose a valid country.'
                    : 'Bitte gültiges Land auswählen.';
            }

            if (empty($errors)) {
                // 1) Wenn ich diese Adresse als Standard markiere,
                //    setze vorher für denselben Typ alle anderen standard=0
                if ($addr['standard']) {
                    $reset = $this->pdo->prepare("
                        UPDATE users_addresses
                        SET standard = 0
                        WHERE user_id = :uid
                        AND address_type = :at
                    ");
                    $reset->execute([
                        'uid' => $uid,
                        'at'  => $addr['address_type']
                    ]);
                }

                if ($id) {
                // Update
                $u = $this->pdo->prepare("
                    UPDATE users_addresses SET
                    title           = :title,
                    company         = :company,
                    vat_id          = :vat_id,
                    address_type    = :at,
                    first_name      = :fn,
                    last_name       = :ln,
                    street          = :st,
                    street_number   = :sn,
                    address_addition= :aa,
                    postal_code     = :pc,
                    city            = :ci,
                    country_code    = :cc,
                    standard        = :std
                    WHERE id = :id AND user_id = :uid
                ");
                $u->execute([
                    'title'   => $addr['title'],
                    'company' => $addr['company'],
                    'vat_id'  => $addr['vat_id'],
                    'at'      => $addr['address_type'],
                    'fn'      => $addr['first_name'],
                    'ln'      => $addr['last_name'],
                    'st'      => $addr['street'],
                    'sn'      => $addr['street_number'],
                    'aa'      => $addr['address_addition'],
                    'pc'      => $addr['postal_code'],
                    'ci'      => $addr['city'],
                    'cc'      => $addr['country_code'],
                    'std'     => $addr['standard'],
                    'id'      => $id,
                    'uid'     => $uid,
                ]);

                } else {
                // Insert
                $i = $this->pdo->prepare("
                    INSERT INTO users_addresses
                    (user_id,title,company,vat_id,address_type,first_name,last_name,
                    street,street_number,address_addition,postal_code,city,country_code,standard)
                    VALUES
                    (:uid,:title,:company,:vat_id,:at,:fn,:ln,
                    :st,:sn,:aa,:pc,:ci,:cc,:std)
                ");
                $i->execute([
                    'uid'     => $uid,
                    'title'   => $addr['title'],
                    'company' => $addr['company'],
                    'vat_id'  => $addr['vat_id'],
                    'at'      => $addr['address_type'],
                    'fn'      => $addr['first_name'],
                    'ln'      => $addr['last_name'],
                    'st'      => $addr['street'],
                    'sn'      => $addr['street_number'],
                    'aa'      => $addr['address_addition'],
                    'pc'      => $addr['postal_code'],
                    'ci'      => $addr['city'],
                    'cc'      => $addr['country_code'],
                    'std'     => $addr['standard'],
                ]);
                }

                $_SESSION['flash_success'] = $this->lang==='en'
                ? 'Your address has been saved.'
                : 'Ihre Adresse wurde gespeichert.';

                // zurück zur Liste
                header("Location: {$this->baseUrl}/account/data");
                exit;
            }
        }

        require __DIR__ . '/../views/account/dataaddressform.php';
    }

    /**
     * Eine Adresse löschen
     */
    public function dataDelete()
    {
        $this->requireLogin();
        $uid = $_SESSION['user_id'];
        $id  = $_GET['addr'] ?? 0;

        $d = $this->pdo->prepare("
        DELETE FROM users_addresses
        WHERE id=:id AND user_id=:uid AND standard=0
        ");
        $d->execute(['id'=>$id,'uid'=>$uid]);

        $_SESSION['flash_success'] = $this->lang==='en'
                ? 'Your address has been deleted.'
                : 'Ihre Adresse wurde gelöscht.';

        header("Location: {$this->baseUrl}/account/data");
        exit;
    }

    public function setDefault()
    {
        $this->requireLogin();
        $uid = $_SESSION['user_id'];
        $addrId = (int)($_GET['addr'] ?? 0);

        // 1) Existenz & Typ prüfen
        $stmt = $this->pdo->prepare("
        SELECT address_type
        FROM users_addresses
        WHERE id = :id
            AND user_id = :uid
        LIMIT 1
        ");
        $stmt->execute(['id'=>$addrId,'uid'=>$uid]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            // ungültig → zurück
            header("Location: {$this->baseUrl}/account/data");
            exit;
        }
        $type = $row['address_type']; // 'billing' oder 'shipping'

        // 2) Alle anderen dieses Typs auf standard=0 setzen
        $this->pdo->prepare("
        UPDATE users_addresses
        SET standard = 0
        WHERE user_id = :uid
            AND address_type = :at
        ")->execute(['uid'=>$uid,'at'=>$type]);

        // 3) gewählte Adresse auf standard=1 setzen
        $this->pdo->prepare("
        UPDATE users_addresses
        SET standard = 1
        WHERE id = :id
            AND user_id = :uid
        ")->execute(['id'=>$addrId,'uid'=>$uid]);

        // 4) Flash-Message
        $_SESSION['flash_success'] = $this->lang==='en'
        ? 'Your default address has been updated.'
        : 'Ihre Standard-Adresse wurde aktualisiert.';

        // 5) Zurück zur Adressen-Übersicht
        header("Location: {$this->baseUrl}/account/data");
        exit;
    }

    /**
     * Setzt alle Adressen eines Typs auf standard = 0
     */
    public function unsetDefault()
    {
        $this->requireLogin();
        $uid      = $_SESSION['user_id'];
        $type     = $_GET['type'] ?? ''; // erwartet 'billing' oder 'shipping'

        // Validieren, dass es ein zulässiger Typ ist
        if (!in_array($type, ['billing','shipping'])) {
            header("Location: {$this->baseUrl}/account/data");
            exit;
        }

        // Alle Adressen dieses Typs auf standard=0 setzen
        $stmt = $this->pdo->prepare("
            UPDATE users_addresses
            SET standard = 0
            WHERE user_id = :uid
            AND address_type = :at
        ");
        $stmt->execute([
            'uid' => $uid,
            'at'  => $type
        ]);

        // Flash-Meldung
        $_SESSION['flash_success'] = $this->lang==='en'
        ? 'Default '.($type==='billing'?'billing':'shipping').' address have been unset.'
        : 'Standard-'.($type==='billing'?'Rechnungs':'Liefer').'adresse wurden zurückgesetzt.';

        // Zurück zur Adressen-Übersicht
        header("Location: {$this->baseUrl}/account/data");
        exit;
    }

    /** Hilfsfunktion */
    private function requireLogin()
    {
        if (empty($_SESSION['user_id'])) {
            header("Location: {$this->baseUrl}/account/login");
            exit;
        }
    }

    public function wishlist() {
        $userId    = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();

        // 1) Wishlist‐Items laden (wie gehabt)
        $stmt = $this->pdo->prepare("
            SELECT wi.id         AS wish_id,
                   wi.product_id,
                   wi.variant_id,
                   wi.price_at_added,
                   wi.added_at,
                   p.name_de,
                   p.name_en,
                   p.url_de,
                   p.url_en,
                   (SELECT pi.image_path
                    FROM products_images pi
                    WHERE pi.product_id = wi.product_id
                    ORDER BY pi.sort_order ASC
                    LIMIT 1) AS image_path,
                   (SELECT pr.price
                    FROM products_prices pr
                    WHERE pr.product_id = wi.product_id
                      AND pr.variant_id = wi.variant_id
                      AND pr.price_type = 'list'
                    ORDER BY pr.quantity_from ASC
                    LIMIT 1) AS current_price,
                   (SELECT v.stock
                    FROM products_variants v
                    WHERE v.product_id = wi.product_id
                      AND v.variant_id = wi.variant_id
                    LIMIT 1) AS stock,
                   wi.notes
            FROM wishlist_items wi
            JOIN products_products p ON p.id = wi.product_id
            WHERE " . ($userId
                ? "wi.user_id = :uid"
                : "wi.user_id IS NULL AND wi.session_id = :sid") . "
            ORDER BY wi.added_at DESC
        ");
        if ($userId) {
            $stmt->execute(['uid' => $userId]);
        } else {
            $stmt->execute(['sid' => $sessionId]);
        }
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $recently = $this->getRecentlyViewed(6);

        // 3) Zufällige Produkte (Random 6)
        $randomStmt = $this->pdo->query("
            SELECT p.id AS product_id,
                   p.name_de,
                   p.name_en,
                   p.url_de,
                   p.url_en,
                   (SELECT pi.image_path 
                    FROM products_images pi 
                    WHERE pi.product_id = p.id 
                    ORDER BY pi.sort_order ASC 
                    LIMIT 1) AS image_path,
                   (COALESCE(
                       (SELECT pr.price
                        FROM products_prices pr
                        WHERE pr.product_id = p.id
                          AND pr.price_type = 'special'
                          AND (pr.start_date IS NULL OR pr.start_date <= NOW())
                          AND (pr.end_date   IS NULL OR pr.end_date   >= NOW())
                        ORDER BY pr.quantity_from ASC 
                        LIMIT 1),
                       (SELECT pr2.price
                        FROM products_prices pr2
                        WHERE pr2.product_id = p.id
                          AND pr2.price_type = 'list'
                        ORDER BY pr2.quantity_from ASC 
                        LIMIT 1)
                    )) AS current_price
            FROM products_products p
            ORDER BY RAND()
            LIMIT 6
        ");
        $randoms = $randomStmt->fetchAll(PDO::FETCH_ASSOC);

        // 4) Items, Recently und Randoms an die View übergeben:
        require __DIR__ . '/../views/account/wishlist.php';
    }

    /**
     * Übersicht & Steuern der Newsletter-Adressen
     */
    public function newsletter()
    {
        $this->requireLogin();
        $uid = $_SESSION['user_id'];

        // 1) Haupt-E-Mail (aus users_users.newsletter_opt_in)
        $stmt = $this->pdo->prepare("SELECT email, newsletter_opt_in FROM users_users WHERE id = :uid");
        $stmt->execute(['uid'=>$uid]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2) alle zusätzlichen Adressen, die confirmed=1 sind und zu diesem User gehören
        $stmt2 = $this->pdo->prepare("
            SELECT id,email
              FROM newsletter_subscriptions
             WHERE user_id = :uid
               AND confirmed = 1
             ORDER BY created_at DESC
        ");
        $stmt2->execute(['uid'=>$uid]);
        $subs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // evtl. Flash-Meldung in Session auslesen
        $flash = $_SESSION['flash_news'] ?? null;
        unset($_SESSION['flash_news']);

        require __DIR__ . '/../views/account/newsletter.php';
    }

    /**
     * Hinzufügen einer neuen Newsletter-Adresse
     */
    public function addNewsletter()
    {
        $this->requireLogin();
        $uid   = $_SESSION['user_id'];
        $email = trim($_POST['email'] ?? '');

        // 1) Basis-Validierung
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_news'] = $this->lang==='en'
                ? 'Please enter a valid email.'
                : 'Bitte gültige E-Mail eingeben.';
            header("Location: {$this->baseUrl}/account/newsletter");
            exit;
        }

        // 2) Prüfen, ob das schon die Haupt-E-Mail ist
        $stmtU = $this->pdo->prepare("SELECT COUNT(*) FROM users_users WHERE email = :e AND id = :id");
        $stmtU->execute(['e'=>$email, 'id'=>$uid]);
        if ($stmtU->fetchColumn()>0) {
            // aktualisiere einfach newsletter_opt_in
            $upd = $this->pdo->prepare("
              UPDATE users_users 
                 SET newsletter_opt_in = 1 
               WHERE id = :uid
            ");
            $upd->execute(['uid'=>$uid]);
            $_SESSION['flash_news'] = $this->lang==='en'
                ? 'Your main email is now subscribed.'
                : 'Ihre Haupt-E-Mail ist jetzt angemeldet.';
            header("Location: {$this->baseUrl}/account/newsletter");
            exit;
        }

        // 2a) Prüfen, ob das schon die Haupt-E-Mail von jemand anderem ist
        $stmtU = $this->pdo->prepare("SELECT COUNT(*) FROM users_users WHERE email = :e AND id != :id");
        $stmtU->execute(['e'=>$email, 'id'=>$uid]);
        if ($stmtU->fetchColumn()>0) {
            $_SESSION['flash_news'] = $this->lang==='en'
                ? 'This e-mail address is already registered for the newsletter.'
                : 'Diese E-Mail-Adresse ist bereits für den Newsletter angemeldet.';
            header("Location: {$this->baseUrl}/account/newsletter");
            exit;
        }

        // 3) Prüfen, ob bereits Subscription existiert
        $stmtN = $this->pdo->prepare("
          SELECT id,confirmed FROM newsletter_subscriptions WHERE email = :e
        ");
        $stmtN->execute(['e'=>$email]);
        if ($row = $stmtN->fetch(PDO::FETCH_ASSOC)) {
            if ($row['confirmed']) {
                $_SESSION['flash_news'] = $this->lang==='en'
                    ? 'This address is already subscribed.'
                    : 'Diese Adresse ist bereits angemeldet.';
            } else {
                // Token erneut verschicken
                $token = bin2hex(random_bytes(32));
                $this->pdo->prepare("
                  UPDATE newsletter_subscriptions 
                     SET token = :tk, created_at = NOW() 
                   WHERE id = :id
                ")->execute(['tk'=>$token,'id'=>$row['id']]);
                $this->sendNewsletterConfirmation($email, $token);
                $_SESSION['flash_news'] = $this->lang==='en'
                    ? 'Confirmation mail re-sent. Please check your inbox.'
                    : 'Bestätigungsmail erneut versendet.';
            }
            header("Location: {$this->baseUrl}/account/newsletter");
            exit;
        }

        // 4) Neu anlegen mit confirmed=0
        $token = bin2hex(random_bytes(32));
        $ins = $this->pdo->prepare("
          INSERT INTO newsletter_subscriptions
            (user_id,email,token,created_at)
          VALUES
            (:uid,:e,:tk,NOW())
        ");
        $ins->execute(['uid'=>$uid,'e'=>$email,'tk'=>$token]);

        // Bestätigungsmail senden
        $this->sendNewsletterConfirmation($email, $token);

        $_SESSION['flash_news'] = $this->lang==='en'
            ? 'Please check your inbox to confirm your subscription.'
            : 'Bitte bestätigen Sie Ihre Anmeldung per E-Mail.';
        header("Location: {$this->baseUrl}/account/newsletter");
        exit;
    }

    /**
     * Bestätigungslink (via E-Mail) für Newsletter
     */
    public function confirmNewsletter()
    {
        $token   = $_GET['token'] ?? '';
        $status  = 'error';
        $message = $this->lang==='en'
        ? 'Invalid or expired confirmation link.'
        : 'Ungültiger oder abgelaufener Bestätigungslink.';
        $targetUrl = $this->baseUrl . '/account/login';

        if ($token) {
            $stmt = $this->pdo->prepare("
                SELECT id,user_id,confirmed
                FROM newsletter_subscriptions
                WHERE token = :t
                LIMIT 1
            ");
            $stmt->execute(['t'=>$token]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                if (!$row['confirmed']) {
                    // bestätigen
                    $this->pdo->prepare("
                    UPDATE newsletter_subscriptions
                        SET confirmed = 1, confirmed_at = NOW()
                    WHERE id = :id
                    ")->execute(['id'=>$row['id']]);
                    $status  = 'success';
                    $message = $this->lang==='en'
                    ? 'Thank you! Your subscription is now active.'
                    : 'Vielen Dank! Ihre Anmeldung wurde bestätigt.';
                } else {
                    $status  = 'success';
                    $message = $this->lang==='en'
                    ? 'Your subscription was already confirmed.'
                    : 'Ihre Anmeldung war bereits bestätigt.';
                }
                // wenn eingeloggt und derselbe User, zu /account/newsletter
                if (!empty($_SESSION['user_id'])
                    && $_SESSION['user_id']==$row['user_id'])
                {
                    $targetUrl = $this->baseUrl . '/account/newsletter';
                }
            }
        }

        // rendern – hier wieder das gleiche View verwenden
        require __DIR__ . '/../views/account/confirm-email.php';
    }


    /**
     * Entfernen einer zusätzlichen Adresse
     */
    public function removeNewsletter()
    {
        $this->requireLogin();
        $uid = $_SESSION['user_id'];
        $sub = (int)($_GET['sub'] ?? 0);
        $del = $this->pdo->prepare("
          DELETE FROM newsletter_subscriptions 
           WHERE id = :id 
             AND user_id = :uid
             AND confirmed = 1
        ");
        $del->execute(['id'=>$sub,'uid'=>$uid]);
        $_SESSION['flash_news'] = $this->lang==='en'
            ? 'Subscription removed.'
            : 'Adresse wurde entfernt.';
        header("Location: {$this->baseUrl}/account/newsletter");
        exit;
    }

    /**
     * Helfer: versendet Bestätigungs-Mail
     */
    protected function sendNewsletterConfirmation(string $email, string $token)
    {
        // Link bauen
        $link = $this->baseUrl . '/account/confirmnewsletter?token=' . urlencode($token);

        // Config & Logo-URL
        $conf    = \Config::getInstance();
        $logoUrl = htmlspecialchars($this->baseUrl . '/assets/img/logo.png');

        // Mailer initialisieren
        $mail = new PHPMailer(true);
        try {
            // SMTP-Setup
            $mail->isSMTP();
            $mail->Host       = $conf->smtpHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $conf->smtpUser;
            $mail->Password   = $conf->smtpPass;
            $mail->SMTPSecure = $conf->smtpSecure==='ssl'
                            ? PHPMailer::ENCRYPTION_SMTPS
                            : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $conf->smtpPort;

            // From/To
            $mail->setFrom($conf->smtpFromEmail, $conf->smtpFromName);
            $mail->addAddress($email);

            // Charset & HTML
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);

            // Subject & Texte
            $subject    = $this->lang==='en'
                        ? 'Confirm your newsletter subscription'
                        : 'Bitte bestätigen Sie Ihre Newsletter-Anmeldung';
            $bodyText   = $this->lang==='en'
                        ? 'Click the button below to confirm your subscription:'
                        : 'Bitte klicken Sie auf den Button, um Ihre Anmeldung zu bestätigen:';
            $btnText    = $this->lang==='en'
                        ? 'Confirm Subscription'
                        : 'Anmeldung bestätigen';
            $disclaimer = $this->lang==='en'
                        ? 'If you did not request this, please ignore this email.'
                        : 'Wenn Sie dies nicht angefordert haben, können Sie diese E-Mail ignorieren.';
            $footer = <<<HTML
            <p style="font-size:0.9em;color:#666;margin:0;">
            Nauticstore24<br>
            Unterhart 3, 4113 St. Martin, Austria<br>
            Phone: +43 660 5198793<br>
            WhatsApp: +43 660 5198793<br>
            Email: <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a><br>
            Web: <a href="{$this->baseUrl}">{$this->baseUrl}</a>
            </p>
            HTML;

            $mail->Subject = $subject;

            // HTML-Body mit Tabellendesign
            $mail->Body = <<<HTML
    <!DOCTYPE html>
    <html lang="{$this->lang}">
    <head>
    <meta charset="UTF-8">
    <title>{$subject}</title>
    </head>
    <body style="margin:0;padding:0;font-family:Arial,sans-serif;color:#333;">
    <table width="100%" bgcolor="#f5f5f5" cellpadding="20">
        <tr>
        <td align="center">
            <table width="600" bgcolor="#fff" cellpadding="0" cellspacing="0" style="border-radius:4px;overflow:hidden;">
            <tr>
                <td bgcolor="#004974" style="padding:20px;text-align:center;">
                <img src="{$logoUrl}" alt="Nauticstore24" style="max-height:50px;">
                </td>
            </tr>
            <tr>
                <td style="padding:30px;">
                <h1 style="margin-top:0;font-size:1.4em;">{$subject}</h1>
                <p style="font-size:1em;line-height:1.5;">{$bodyText}</p>
                <p style="text-align:center;margin:30px 0;">
                    <a href="{$link}" style="
                    background:#004974;
                    color:#fff;
                    padding:12px 24px;
                    text-decoration:none;
                    font-size:1em;
                    border-radius:4px;
                    display:inline-block;
                    ">
                    {$btnText}
                    </a>
                </p>
                <p style="font-size:0.9em;color:#666;">{$disclaimer}</p>
                </td>
            </tr>
            <tr>
                <td bgcolor="#f0f0f0" style="padding:20px;text-align:center;font-size:0.9em;color:#666;">
                {$footer}
                </td>
            </tr>
            </table>
        </td>
        </tr>
    </table>
    </body>
    </html>
    HTML;

            $mail->send();
        } catch (Exception $e) {
            error_log("Newsletter-Bestätigungsmail fehlgeschlagen: " . $e->getMessage());
        }
    }

    /**
     * Schaltet das Newsletter-Abo der Haupt-E-Mail um (an/aus)
     */
    public function toggleNewsletter()
    {
        $this->requireLogin();
        $uid = $_SESSION['user_id'];

        // 1) Aktuellen Status auslesen
        $stmt = $this->pdo->prepare("
            SELECT newsletter_opt_in
            FROM users_users
            WHERE id = :uid
            LIMIT 1
        ");
        $stmt->execute(['uid' => $uid]);
        $current = (int)$stmt->fetchColumn();

        // 2) Neuen Wert berechnen und speichern
        $new = $current ? 0 : 1;
        $upd = $this->pdo->prepare("
            UPDATE users_users
            SET newsletter_opt_in = :new
            WHERE id = :uid
        ");
        $upd->execute(['new' => $new, 'uid' => $uid]);

        // 3) Flash-Message
        if ($new) {
            $_SESSION['flash_news'] = $this->lang==='en'
                ? 'You are now subscribed to the newsletter.'
                : 'Sie sind jetzt zum Newsletter angemeldet.';
        } else {
            $_SESSION['flash_news'] = $this->lang==='en'
                ? 'You have been unsubscribed from the newsletter.'
                : 'Sie wurden vom Newsletter abgemeldet.';
        }

        // 4) Zurück zur Übersicht
        header("Location: {$this->baseUrl}/account/newsletter");
        exit;
    }

    /**
     * Zeigt die Sicherheits-Seite an und verarbeitet MFA-Aktionen
     */
    public function security()
    {
        $this->requireLogin();
        $uid = $_SESSION['user_id'];

        // 1) Nutzer-TOTP-Secret auslesen (NULL = nicht aktiviert)
        $stmt = $this->pdo->prepare("
            SELECT email, totp_secret
            FROM users_users
            WHERE id = :uid
        ");
        $stmt->execute(['uid' => $uid]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2) Falls gerade neues Secret erstellt wird, im Session-Cache halten
        $pendingSecret = $_SESSION['pending_totp_secret'] ?? null;

        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            // --- A) TOTP aktivieren: Secret erstmal erzeugen ---
            if ($_POST['action'] === 'generate_totp') {
                // Erzeuge 16‐Byte (128 Bit) Secret, Base32-kodiert
                $bytes = random_bytes(10);
                $secret = rtrim(strtoupper($this->base32_encode($bytes)), '=');
                // Merke Dir das im Session‐Scope
                $_SESSION['pending_totp_secret'] = $secret;
                // Damit die View weiß, dass sie in den „Pending“-Zweig soll:
                $pendingSecret = $secret;
                // $user['totp_secret'] bleibt leer
            }

            // --- B) TOTP bestätigen (Code eingeben) ---
            if ($_POST['action'] === 'confirm_totp') {
                $entered = trim($_POST['totp_code'] ?? '');
                $secret  = $_SESSION['pending_totp_secret'] ?? '';
                if (!$secret || !$this->verifyTotp($secret, $entered)) {
                    $errors[] = $this->lang==='en'
                            ? 'Invalid authentication code.'
                            : 'Ungültiger Authentifizierungscode.';
                } else {
                    // Speichere in DB
                    $upd = $this->pdo->prepare("
                        UPDATE users_users
                        SET totp_secret = :sec
                        WHERE id = :uid
                    ");
                    $upd->execute([
                    'sec' => $secret,
                    'uid' => $_SESSION['user_id']
                    ]);
                    // aufräumen
                    unset($_SESSION['pending_totp_secret']);
                    // Damit die View weiß, dass TOTP jetzt aktiviert ist:
                    $user['totp_secret'] = $secret;

                    $success = $this->lang==='en'
                            ? 'Two-factor authentication enabled.'
                            : 'Zwei-Faktor-Authentifizierung aktiviert.';
                }
            }

            // --- C) TOTP deaktivieren (Passwort + Code eingeben) ---
            if ($_POST['action'] === 'disable_totp') {
                // 1) Password prüfen
                $currentPassword = $_POST['current_password_disable'] ?? '';
                // Password-Hash brauchen wir noch aus der DB
                $stmtPwd = $this->pdo->prepare("
                    SELECT password, totp_secret
                    FROM users_users
                    WHERE id = :uid
                    LIMIT 1
                ");
                $stmtPwd->execute(['uid' => $uid]);
                $rowPwd = $stmtPwd->fetch(PDO::FETCH_ASSOC);

                if (!password_verify($currentPassword, $rowPwd['password'])) {
                    $errors[] = $this->lang === 'en'
                        ? 'Your password is incorrect.'
                        : 'Ihr Passwort ist falsch.';
                } else {
                    // 2) Wenn Passwort passt, TOTP-Code prüfen
                    $code   = trim($_POST['totp_code_disable'] ?? '');
                    $secret = $rowPwd['totp_secret'] ?? '';
                    if (!$secret || !$this->verifyTotp($secret, $code)) {
                        $errors[] = $this->lang === 'en'
                            ? 'Invalid authentication code.'
                            : 'Ungültiger Authentifizierungscode.';
                    } else {
                        // beides korrekt → 2FA deaktivieren
                        $this->pdo->prepare("
                            UPDATE users_users
                            SET totp_secret = NULL
                            WHERE id = :uid
                        ")->execute(['uid' => $uid]);
                        $user['totp_secret'] = null;

                        $success = $this->lang === 'en'
                            ? 'Two-factor authentication disabled.'
                            : '2FA deaktiviert.';
                    }
                }
            }
        }

        // 3) View anzeigen
        require __DIR__ . '/../views/account/security.php';
    }

    /**
     * Erzeugt ein zufälliges Base32-Secret (16 Zeichen).
     */
    private function generateTotpSecret(int $length = 16): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $secret;
    }

    /**
     * Verifiziert einen TOTP-Code (6-stellig) gegen ein Base32-Secret.
     */
    private function verifyTotpCode(string $secret, string $code): bool
    {
        $secretKey = $this->base32Decode($secret);
        $timeStep = floor(time() / 30);
        // wir prüfen +/- 1 Zeitschritt
        for ($i = -1; $i <= 1; $i++) {
            $hash = hash_hmac('sha1', pack('N*', $timeStep + $i), $secretKey, true);
            $offset = ord(substr($hash, -1)) & 0x0F;
            $truncated = substr($hash, $offset, 4);
            $value = unpack('N', $truncated)[1] & 0x7FFFFFFF;
            $generated = str_pad($value % 1000000, 6, '0', STR_PAD_LEFT);
            if (hash_equals($generated, $code)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Base32-Encode (RFC 4648, ohne „=“-Padding)
     */
    private function base32_encode(string $data): string {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $binary   = '';
        // 1) Byteweise in Bits umwandeln
        foreach (str_split($data) as $ch) {
            $binary .= str_pad(decbin(ord($ch)), 8, '0', STR_PAD_LEFT);
        }
        $bits   = strlen($binary);
        $output = '';
        // 2) Alle 5-Bit-Chunks in Base32-Zeichen umwandeln
        for ($i = 0; $i < $bits; $i += 5) {
            $chunk = substr($binary, $i, 5);
            if (strlen($chunk) < 5) {
                $chunk = str_pad($chunk, 5, '0', STR_PAD_RIGHT);
            }
            $output .= $alphabet[bindec($chunk)];
        }
        return $output;
    }

    /**
     * Base32-Decoding (für unser Secret).
     */
    private function base32Decode(string $b32): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $b32 = strtoupper($b32);
        $l = strlen($b32);
        $n = 0;
        $j = 0;
        $binary = '';
        for ($i = 0; $i < $l; $i++) {
            $n = $n << 5;
            $n = $n + strpos($alphabet, $b32[$i]);
            $j += 5;
            if ($j >= 8) {
                $j -= 8;
                $binary .= chr(($n & (0xFF << $j)) >> $j);
            }
        }
        return $binary;
    }


    /**
     * Verifies a TOTP code per RFC6238, +/- $window Schritte erlaubt
     */
    private function verifyTotp(string $secret, string $code, int $window = 1): bool {
        $secretKey = $this->base32Decode($secret);
        $timeSlice = floor(time() / 30);
        for ($i = -$window; $i <= $window; $i++) {
            $timestamp = pack('N*', 0) . pack('N*', $timeSlice + $i);
            $hash = hash_hmac('sha1', $timestamp, $secretKey, true);
            $offset = ord($hash[19]) & 0x0F;
            $binary  = (ord($hash[$offset+0]) & 0x7F) << 24
                    | (ord($hash[$offset+1]) & 0xFF) << 16
                    | (ord($hash[$offset+2]) & 0xFF) <<  8
                    | (ord($hash[$offset+3]) & 0xFF);
            $otp = str_pad((string)($binary % 1000000), 6, '0', STR_PAD_LEFT);
            if (hash_equals($otp, $code)) {
                return true;
            }
        }
        return false;
    }

    public function addwishlist()
    {
        header('Content-Type: application/json; charset=utf-8');
        $productId = (int)($_POST['product_id'] ?? 0);

        // nur >0 als echte Variante behandeln
        $rawVid = trim($_POST['variant_id'] ?? '');
        $variantId = (ctype_digit($rawVid) && (int)$rawVid > 0)
                ? (int)$rawVid
                : null;

        if ($productId < 1) {
            echo json_encode(['status'=>'error','message'=>'Invalid product ID','count'=>0]);
            exit;
        }

        $added = addToWishlist($this->pdo, $productId, $variantId);

        // zähle immer nach, egal ob neu oder schon da
        $countStmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM wishlist_items
            WHERE user_id = :uid
            OR (user_id IS NULL AND session_id = :sid)
        ");
        $countStmt->execute([
        'uid' => $_SESSION['user_id'] ?? null,
        'sid' => session_id()
        ]);
        $count = (int)$countStmt->fetchColumn();

        if ($added) {
            echo json_encode([
            'status'  => 'ok',
            'message' => ($this->lang==='en'
                            ? 'Added to wishlist'
                            : 'Artikel zur Merkliste hinzugefügt'),
            'count'   => $count,
            'id'      => $productId
            ]);
        } else {
            echo json_encode([
            'status'  => 'exists',
            'message' => ($this->lang==='en'
                            ? 'Already in wishlist'
                            : 'Bereits in der Merkliste'),
            'count'   => $count,
            'id'      => $productId
            ]);
        }
        exit;
    }

    public function removewishlist()
    {
        header('Content-Type: application/json; charset=utf-8');
        $productId = (int)($_POST['product_id'] ?? 0);
        $variantId = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : null;

        if ($productId < 1) {
            echo json_encode(['status'=>'error','message'=>'Ungültige Produkt-ID']);
            exit;
        }

        // User/Session
        $userId    = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();

        // Lösche den Eintrag
        $stmt = $this->pdo->prepare("
        DELETE FROM wishlist_items
        WHERE product_id = :pid
            AND (
                (user_id = :uid)
            OR (user_id IS NULL AND session_id = :sid)
            )
        ");
        $stmt->execute([
        'pid' => $productId,
        'uid' => $userId,
        'sid' => $sessionId
        ]);

        // neue Anzahl
        $countStmt = $this->pdo->prepare("
        SELECT COUNT(*) FROM wishlist_items
        WHERE user_id = :uid
            OR (user_id IS NULL AND session_id = :sid)
        ");
        $countStmt->execute([
        'uid' => $userId,
        'sid' => $sessionId
        ]);
        $count = (int)$countStmt->fetchColumn();

        echo json_encode([
        'status'  => 'ok',
        'message' => ($this->lang==='en'
                        ? 'Removed from wishlist'
                        : 'Aus der Merkliste entfernt'),
        'count'   => $count
        ]);
        exit;
    }

    public function forgotPassword() {
        $errors  = [];
        $success = false;
        $email   = '';
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = $this->lang === 'en'
                            ? 'Please enter a valid email address.'
                            : 'Bitte gültige E-Mail eingeben.';
            }
    
            if (empty($errors)) {
                $stmt = $this->pdo->prepare("SELECT id FROM users_users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if ($user) {
                    $token = bin2hex(random_bytes(32));
                    $now   = date('Y-m-d H:i:s');
    
                    $this->pdo
                        ->prepare("DELETE FROM password_resets WHERE email = :email")
                        ->execute(['email' => $email]);
    
                    $ins = $this->pdo->prepare("
                        INSERT INTO password_resets (email, token, created_at)
                        VALUES (:email, :token, :now)
                    ");
                    $ins->execute([
                        'email' => $email,
                        'token' => $token,
                        'now'   => $now
                    ]);
    
                    $link    = $this->baseUrl . '/account/resetpassword?token=' . $token;
                    $config  = \Config::getInstance();
                    $mail    = new PHPMailer(true);
    
                    try {
                        // SMTP-Konfiguration
                        $mail->isSMTP();
                        $mail->Host       = $config->smtpHost;
                        $mail->SMTPAuth   = true;
                        $mail->Username   = $config->smtpUser;
                        $mail->Password   = $config->smtpPass;
                        $mail->SMTPSecure = $config->smtpSecure === 'ssl'
                                            ? PHPMailer::ENCRYPTION_SMTPS
                                            : PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = $config->smtpPort;
    
                        // Absender & Empfänger
                        $mail->setFrom($config->smtpFromEmail, $config->smtpFromName);
                        $mail->addAddress($email);
    
                        // UTF-8 & HTML
                        $mail->CharSet = 'UTF-8';
                        $mail->isHTML(true);
                        $mail->Subject = $this->lang === 'en'
                                         ? 'Password Reset Request'
                                         : 'Passwort zurücksetzen';
    
                        // Logo-URL
                        $logoUrl = htmlspecialchars($this->baseUrl . '/assets/img/logo.png');
    
                        // Footer mit allen Kontaktdaten
                        if ($this->lang === 'en') {
                            $footer = <<<HTML
    <p style="font-size:0.9em;color:#666;margin:0;">
      Nauticstore24<br>
      Unterhart 3, 4113 St. Martin, Austria<br>
      Phone: +43 660 5198793<br>
      WhatsApp: +43 660 5198793<br>
      Email: <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a><br>
      Web: <a href="{$this->baseUrl}">{$this->baseUrl}</a>
    </p>
    HTML;
                            $btnText    = 'Reset Password';
                            $disclaimer = 'If you did not request this, simply ignore this email.';
                        } else {
                            $footer = <<<HTML
    <p style="font-size:0.9em;color:#666;margin:0;">
      Nauticstore24<br>
      Unterhart 3, 4113 St. Martin, Österreich<br>
      Telefon: +43 660 5198793<br>
      WhatsApp: +43 660 5198793<br>
      E-Mail: <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a><br>
      Web: <a href="{$this->baseUrl}">{$this->baseUrl}</a>
    </p>
    HTML;
                            $btnText    = 'Passwort zurücksetzen';
                            $disclaimer = 'Wenn Sie dies nicht angefordert haben, können Sie diese E-Mail ignorieren.';
                        }
    
                        // Body-Text
                        $bodyText = $this->lang === 'en'
                            ? 'You requested a password reset. Please click the button below to choose a new password:'
                            : 'Sie haben ein neues Passwort angefordert. Bitte klicken Sie auf den Button unten, um ein neues Passwort festzulegen:';
    
                        // HTML-Mail-Template mit großem Button
                        $mail->Body = <<<HTML
                        <!DOCTYPE html>
                        <html lang="{$this->lang}">
                        <head>
                        <meta charset="UTF-8">
                        <title>{$mail->Subject}</title>
                        </head>
                        <body style="margin:0;padding:0;font-family:Arial,sans-serif;color:#333;">
                        <table width="100%" bgcolor="#f5f5f5" cellpadding="20">
                            <tr><td align="center">
                            <table width="600" bgcolor="#fff" cellpadding="0" cellspacing="0" style="border-radius:4px;overflow:hidden;">
                                <tr>
                                <td bgcolor="#004974" style="padding:20px;text-align:center;">
                                    <img src="$logoUrl" alt="Nauticstore24" style="max-height:50px;">
                                </td>
                                </tr>
                                <tr>
                                <td style="padding:30px;">
                                    <h1 style="margin-top:0;font-size:1.4em;">{$mail->Subject}</h1>
                                    <p style="font-size:1em;line-height:1.5;">$bodyText</p>
                                    <p style="text-align:center;margin:30px 0;">
                                    <a href="$link"
                                        style="background:#004974;color:#fff;padding:12px 24px;text-decoration:none;font-size:1em;border-radius:4px;display:inline-block;">
                                        $btnText
                                    </a>
                                    </p>
                                    <p style="font-size:0.9em;color:#666;">$disclaimer</p>
                                </td>
                                </tr>
                                <tr>
                                <td bgcolor="#f0f0f0" style="padding:20px;text-align:center;">
                                    $footer
                                </td>
                                </tr>
                            </table>
                            </td></tr>
                        </table>
                        </body>
                        </html>
                        HTML;
    
                        $mail->send();
                    } catch (Exception $e) {
                        error_log("Mail error in forgotPassword(): {$e->getMessage()}");
                    }
                }
    
                // Immer Erfolg anzeigen
                $success = true;
            }
        }
    
        $prefillEmail = $_GET['email'] ?? '';

        // View rendern
        require __DIR__ . '/../views/account/forgot-password.php';
    }

    /**
     * Reset-Formular (via Token) anzeigen und neue PW speichern
     */
    public function resetPassword() {
        $errors      = [];
        $success     = false;
        $token       = $_GET['token'] ?? '';
        $newPassword  = '';
        $newPassword2 = '';

        // Token validieren
        if (!$token) {
            header("Location: {$this->baseUrl}/account/forgot-password");
            exit;
        }
        $stmt = $this->pdo->prepare("
          SELECT email, created_at
          FROM password_resets
          WHERE token = :token
          LIMIT 1
        ");
        $stmt->execute(['token'=>$token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $errors[] = $this->lang==='en'
                ? 'Invalid or expired token.'
                : 'Ungültiger oder abgelaufener Link.';
        } else {
            // prüfen: älter als 1 Stunde?
            $created = strtotime($row['created_at']);
            if (time() - $created > 3600) {
                $errors[] = $this->lang==='en'
                    ? 'Token has expired. Please request a new one.'
                    : 'Dieser Link ist abgelaufen. Bitte erneut anfordern.';
            }
        }

        // POST: Neues Passwort setzen
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) {
            $newPassword  = $_POST['password']  ?? '';
            $newPassword2 = $_POST['password2'] ?? '';

            // Passwort-Policy
            $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/';
            if (!preg_match($pattern, $newPassword)) {
                $errors[] = $this->lang==='en'
                    ? 'Password must be at least 8 characters long and include at least one letter, one number and one special character.'
                    : 'Passwort muss mindestens 8 Zeichen lang sein und mindestens einen Buchstaben, eine Zahl und ein Sonderzeichen enthalten.';
            }
            if ($newPassword !== $newPassword2) {
                $errors[] = $this->lang==='en'
                    ? 'Passwords do not match.'
                    : 'Passwörter stimmen nicht überein.';
            }

            if (empty($errors)) {
                $hash = password_hash($newPassword, PASSWORD_DEFAULT);
                $u = $this->pdo->prepare("
                    UPDATE users_users
                    SET password = :pw
                    WHERE email = :email
                ");
                $u->execute([
                    'pw'    => $hash,
                    'email' => $row['email']
                ]);

                // Token löschen und Erfolg
                $d = $this->pdo->prepare("DELETE FROM password_resets WHERE token = :token");
                $d->execute(['token' => $token]);

                $success = true;
            }
        }

        require __DIR__ . '/../views/account/reset-password.php';
    }

    public function settings()
    {
        // 1) Nur angemeldete Nutzer dürfen hierhin
        if (empty($_SESSION['user_id'])) {
            header("Location: {$this->baseUrl}/account/login");
            exit;
        }

        // 2) Nutzer­daten inklusive Passworthash holen
        $stmt = $this->pdo->prepare("
            SELECT id, first_name, last_name, email, password
            FROM users_users
            WHERE id = :uid
            LIMIT 1
        ");
        $stmt->execute(['uid' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 3) Initialisieren der Error-/Success‐Arrays
        $errorsName     = [];
        $successName    = false;
        $errorsPassword = [];
        $successPassword= false;
        $errorsEmail    = [];
        $successEmail   = false;

        // 4) Auf POST reagieren
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            // ----- A) Name ändern -----
            if ($action === 'change_name') {
                $first = trim($_POST['first_name'] ?? '');
                $last  = trim($_POST['last_name']  ?? '');

                if ($first === '' || $last === '') {
                    $errorsName[] = $this->lang==='en'
                        ? 'First and last name are required.'
                        : 'Vor- und Nachname sind erforderlich.';
                }

                if (empty($errorsName)) {
                    $upd = $this->pdo->prepare("
                        UPDATE users_users
                        SET first_name = :fn, last_name = :ln
                        WHERE id = :uid
                    ");
                    $upd->execute([
                        'fn'  => $first,
                        'ln'  => $last,
                        'uid' => $user['id']
                    ]);
                    // Session-Name aktualisieren
                    $_SESSION['user_name'] = $first . ' ' . $last;
                    $successName = true;
                    // auch im $user‐Array für den View anpassen
                    $user['first_name'] = $first;
                    $user['last_name']  = $last;
                }
            }

            // ----- B) Passwort ändern -----
            elseif ($action === 'change_password') {
                $current = $_POST['current_password'] ?? '';
                $new1    = $_POST['new_password']     ?? '';
                $new2    = $_POST['new_password2']    ?? '';

                // Wenn eines der Felder gesetzt ist, alle drei prüfen
                if ($current || $new1 || $new2) {
                    if (!$current || !$new1 || !$new2) {
                        $errorsPassword[] = $this->lang==='en'
                            ? 'To change your password, fill in all three fields.'
                            : 'Zum Ändern des Passworts bitte alle drei Felder ausfüllen.';
                    } else {
                        // 1) aktuelles Passwort korrekt?
                        if (!password_verify($current, $user['password'])) {
                            $errorsPassword[] = $this->lang==='en'
                                ? 'Current password is incorrect.'
                                : 'Aktuelles Passwort ist falsch.';
                        }
                        // 2) Policy für neues Passwort
                        $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/';
                        if (!preg_match($pattern, $new1)) {
                            $errorsPassword[] = $this->lang==='en'
                                ? 'New password must be at least 8 characters long and include one letter, one number, and one special character.'
                                : 'Neues Passwort muss mindestens 8 Zeichen lang sein und mindestens einen Buchstaben, eine Zahl und ein Sonderzeichen enthalten.';
                        }
                        // 3) Bestätigung
                        if ($new1 !== $new2) {
                            $errorsPassword[] = $this->lang==='en'
                                ? 'New passwords do not match.'
                                : 'Neue Passwörter stimmen nicht überein.';
                        }
                    }

                    // wenn alles ok, updaten
                    if (empty($errorsPassword)) {
                        $hash = password_hash($new1, PASSWORD_DEFAULT);
                        $upw = $this->pdo->prepare("
                            UPDATE users_users
                            SET password = :pw
                            WHERE id = :uid
                        ");
                        $upw->execute([
                            'pw'  => $hash,
                            'uid' => $user['id']
                        ]);
                        $successPassword = true;
                    }
                }
            }

            // ----- C) E-Mail ändern -----
            elseif ($action === 'change_email') {
                $emailPassword = $_POST['email_password'] ?? '';
                $newEmail      = trim($_POST['new_email']  ?? '');
                $newEmail2     = trim($_POST['new_email2'] ?? '');

                // 1) Passwort prüfen
                if (!password_verify($emailPassword, $user['password'])) {
                    $errorsEmail[] = $this->lang==='en'
                        ? 'Your password is incorrect.'
                        : 'Ihr Passwort ist falsch.';
                }
                // 2) neue E-Mail validieren
                if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                    $errorsEmail[] = $this->lang==='en'
                        ? 'Please enter a valid email address.'
                        : 'Bitte gültige E-Mail eingeben.';
                }
                // 3) Bestätigung
                if ($newEmail !== $newEmail2) {
                    $errorsEmail[] = $this->lang==='en'
                        ? 'Email addresses do not match.'
                        : 'E-Mail-Adressen stimmen nicht überein.';
                }
                // 4) Doppel‐Check in DB
                if (empty($errorsEmail)) {
                    $dup = $this->pdo->prepare("SELECT COUNT(*) FROM users_users WHERE email = :e");
                    $dup->execute(['e' => $newEmail]);
                    if ($dup->fetchColumn() > 0) {
                        $errorsEmail[] = $this->lang==='en'
                            ? 'This email is already registered.'
                            : 'Diese E-Mail ist bereits vergeben.';
                    }
                }
                // 5) Token & Mail, wenn alles ok
                if (empty($errorsEmail)) {
                    $token = bin2hex(random_bytes(32));
                    $now   = date('Y-m-d H:i:s');
                    // Neue Tabelle email_resets: user_id, new_email, token, created_at
                    $ins = $this->pdo->prepare("
                        INSERT INTO email_resets (user_id, new_email, token, created_at)
                        VALUES (:uid, :ne, :tk, :ct)
                    ");
                    $ins->execute([
                        'uid' => $user['id'],
                        'ne'  => $newEmail,
                        'tk'  => $token,
                        'ct'  => $now
                    ]);
                    // Mail an neue Adresse
                    $this->sendEmailChangeConfirmation($newEmail, $token);
                    $successEmail = true;
                }
            }
        }

        // 5) View rendern
        require __DIR__ . '/../views/account/settings.php';
    }

    public function confirmEmail()
    {
        $token   = $_GET['token'] ?? '';
        $status  = 'error';
        $message = $this->lang==='en'
        ? 'Invalid or expired confirmation link.'
        : 'Ungültiger oder abgelaufener Bestätigungslink.';
        $targetUrl = $this->baseUrl . '/account/login'; // Default: zum Login

        if ($token) {
            $stmt = $this->pdo->prepare("
                SELECT user_id,new_email,created_at
                FROM email_resets
                WHERE token = :t
                LIMIT 1
            ");
            $stmt->execute(['t'=>$token]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // hier könntest Du noch ein Ablauf-Datum prüfen
                // E-Mail updaten
                $upd = $this->pdo->prepare("
                    UPDATE users_users
                    SET email = :ne
                    WHERE id = :uid
                ");
                $upd->execute([
                    'ne'  => $row['new_email'],
                    'uid' => $row['user_id']
                ]);
                // Token löschen
                $this->pdo
                    ->prepare("DELETE FROM email_resets WHERE token = :t")
                    ->execute(['t'=>$token]);

                $status  = 'success';
                $message = $this->lang==='en'
                ? 'Your email has been confirmed.'
                : 'Ihre E-Mail-Adresse wurde bestätigt.';

                // wenn der User gerade eingeloggt ist, direkt zu Settings,
                // sonst erstmal zum Login (von dort geht er dann idealerweise weiter)
                if (!empty($_SESSION['user_id']) 
                    && $_SESSION['user_id']==$row['user_id'])
                {
                    $targetUrl = $this->baseUrl . '/account/settings';
                }
            }
        }

        // und jetzt *nicht* per requireLogin() prüfen, sondern direkt rendern:
        require __DIR__ . '/../views/account/confirm-email.php';
    }

    protected function sendEmailChangeConfirmation($toEmail, $token) {
    $config = \Config::getInstance();
    $mail   = new PHPMailer(true);
    $link   = "{$this->baseUrl}/account/confirmemail?token={$token}";

        try {
            $mail->isSMTP();
            $mail->Host       = $config->smtpHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $config->smtpUser;
            $mail->Password   = $config->smtpPass;
            $mail->SMTPSecure = $config->smtpSecure==='ssl'
                            ? PHPMailer::ENCRYPTION_SMTPS
                            : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $config->smtpPort;

            $mail->setFrom($config->smtpFromEmail, $config->smtpFromName);
            $mail->addAddress($toEmail);
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = $this->lang==='en'
                ? 'Please confirm your new email address'
                : 'Bitte bestätigen Sie Ihre neue E-Mail-Adresse';

            // ein einfacher HTML‐Aufbau, kannst Du natürlich an Dein Reset‐Template anpassen:
            // 1) Betreff und Texte vorher anlegen
            $subject     = $this->lang==='en'
                ? 'Please confirm your new email address'
                : 'Bitte bestätigen Sie Ihre neue E-Mail-Adresse';

            $mail->Subject = $subject;

            $intro       = $this->lang==='en'
                ? 'Click the button below to confirm your new email address:'
                : 'Bitte bestätigen Sie durch Klick auf den Button Ihre neue E-Mail-Adresse:';

            $buttonText  = $this->lang==='en'
                ? 'Confirm Email'
                : 'E-Mail bestätigen';

            $disclaimer  = $this->lang==='en'
                ? 'If you did not request this, ignore this email.'
                : 'Wenn Sie dies nicht angefordert haben, können Sie diese E-Mail ignorieren.';

            // 2) Den Reset-Link bauen
            $link = "{$this->baseUrl}/account/confirmemail?token={$token}";

            // 3) Heredoc mit den vorher angelegten Variablen
            $body = <<<HTML
            <!DOCTYPE html>
            <html lang="{$this->lang}">
            <head>
            <meta charset="UTF-8">
            <title>{$subject}</title>
            </head>
            <body style="margin:0;padding:0;font-family:Arial,sans-serif;color:#333;">
            <table width="100%" bgcolor="#f5f5f5" cellpadding="20" cellspacing="0">
                <tr><td align="center">
                <table width="600" bgcolor="#ffffff" cellpadding="0" cellspacing="0" style="border-radius:4px;overflow:hidden;">
                    <tr>
                    <td bgcolor="#004974" style="padding:20px;text-align:center;">
                        <img src="{$this->baseUrl}/assets/img/logo.png" alt="Logo" style="max-height:50px;">
                    </td>
                    </tr>
                    <tr>
                    <td style="padding:30px;">
                        <h1 style="margin-top:0;font-size:1.4em;color:#004974;">{$subject}</h1>
                        <p style="font-size:1em;line-height:1.5;">{$intro}</p>
                        <p style="text-align:center;margin:30px 0;">
                        <a href="{$link}" style="
                            background:#004974;color:#ffffff;
                            padding:12px 24px;
                            text-decoration:none;
                            border-radius:4px;
                            display:inline-block;
                            font-size:1em;
                        ">
                            {$buttonText}
                        </a>
                        </p>
                        <p style="font-size:0.9em;color:#666;">{$disclaimer}</p>
                    </td>
                    </tr>
                    <tr>
                    <td bgcolor="#f0f0f0" style="padding:20px;text-align:center;font-size:0.9em;color:#666;">
                        Nauticstore24<br>
                        Unterhart 3, 4113 St. Martin, Österreich<br>
                        Telefon: +43 660 5198793 | WhatsApp: +43 660 5198793 | 
                        <a href="mailto:shop@nauticstore24.at" style="color:#004974;text-decoration:none;">shop@nauticstore24.at</a>
                    </td>
                    </tr>
                </table>
                </td></tr>
            </table>
            </body>
            </html>
            HTML;

            // 4) Body setzen
            $mail->Body = $body;


            $mail->send();
        } catch (\Exception $e) {
            error_log("Email‐Confirm Mail error: ".$e->getMessage());
        }
    }

    // Hilfsmethode: zuletzt angesehene Produkte abrufen
    public function getRecentlyViewed(int $limit = 6): array {
        $userId    = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();

        $sql = "
            SELECT rv.product_id, p.name_de, p.name_en, p.url_de, p.url_en,
                   (SELECT pi.image_path 
                    FROM products_images pi 
                    WHERE pi.product_id = rv.product_id 
                    ORDER BY pi.sort_order ASC 
                    LIMIT 1) AS image_path,
                   (COALESCE(
                       (SELECT pr.price
                        FROM products_prices pr
                        WHERE pr.product_id = rv.product_id
                          AND pr.price_type = 'special'
                          AND (pr.start_date IS NULL OR pr.start_date <= NOW())
                          AND (pr.end_date   IS NULL OR pr.end_date   >= NOW())
                        ORDER BY pr.quantity_from ASC
                        LIMIT 1),
                       (SELECT pr2.price
                        FROM products_prices pr2
                        WHERE pr2.product_id = rv.product_id
                          AND pr2.price_type = 'list'
                        ORDER BY pr2.quantity_from ASC
                        LIMIT 1)
                    )) AS current_price
            FROM recently_viewed rv
            JOIN products_products p ON p.id = rv.product_id
            WHERE " . ($userId
                ? "rv.user_id = :uid"
                : "rv.user_id IS NULL AND rv.session_id = :sid") . "
            ORDER BY rv.viewed_at DESC
            LIMIT :lim
        ";

        $stmt = $this->pdo->prepare($sql);
        if ($userId) {
            $stmt->bindValue('uid', $userId, PDO::PARAM_INT);
        } else {
            $stmt->bindValue('sid', $sessionId, PDO::PARAM_STR);
        }
        $stmt->bindValue('lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * AJAX: Prüft, ob eine E-Mail bereits registriert ist.
     * GET Parameter: email
     * Antwort: JSON { exists: true|false }
     */
    public function checkemail() {
        header('Content-Type: application/json; charset=utf-8');

        $email = trim($_GET['email'] ?? '');
        $exists = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users_users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $exists = $stmt->fetchColumn() > 0;
        }

        echo json_encode(['exists' => $exists]);
        exit;
    }
}
?>