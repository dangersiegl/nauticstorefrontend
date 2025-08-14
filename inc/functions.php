<?php
// inc/functions.php

/**
 * Generiert eine vollständige URL basierend auf der Base-URL und dem Pfad.
 *
 * @param string $path Der Pfad, der an die Base-URL angehängt werden soll.
 * @return string Die vollständige URL.
 */
function url($path = '') {
    global $baseUrl;
    return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
}
