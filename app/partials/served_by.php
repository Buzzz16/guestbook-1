<?php
declare(strict_types=1);

/**
 * Partial Banner Identitas Server / Node Mahasiswa
 */

if (!defined('MEMBER_NAMA') || !defined('MEMBER_NIM') || !defined('MEMBER_ROUTE')) {
    $identityPath = __DIR__ . '/../../identity.php';
    if (file_exists($identityPath)) {
        require_once $identityPath;
    }
}

$servedNama = defined('MEMBER_NAMA') ? htmlspecialchars((string) MEMBER_NAMA, ENT_QUOTES, 'UTF-8') : 'Unknown Member';
$servedNim = defined('MEMBER_NIM') ? htmlspecialchars((string) MEMBER_NIM, ENT_QUOTES, 'UTF-8') : '000000000000';
$servedRoute = defined('MEMBER_ROUTE') ? htmlspecialchars((string) MEMBER_ROUTE, ENT_QUOTES, 'UTF-8') : 'm0';
?>
<div class="served-by-banner" role="region" aria-label="Identitas Node Pelayan">
    <div class="served-by-inner">
        <span class="served-by-status">
            <span class="pulse-dot" aria-hidden="true"></span>
            <span class="route-badge">NODE // <?= $servedRoute ?></span>
        </span>
        <p class="served-by-text">
            Anda dilayani oleh laman <strong><?= $servedNama ?></strong> (<span
                class="mono-nim"><?= $servedNim ?></span>)
        </p>
        <span class="served-by-meta">TEL-U // IF-48-05</span>
    </div>
</div>