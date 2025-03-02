<?php

function formatPhoneNumber($phoneNumber) {
    $cleaned = preg_replace('/\D/', '', $phoneNumber);

    if (strlen($cleaned) === 10) {
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $cleaned);
    } elseif (strlen($cleaned) === 11) {
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $cleaned);
    } else {
        return $phoneNumber;
    }
}

function convertDateFormat(?string $date): ?string
{
    if (!$date) {
        return null;
    }

    $dateObj = \DateTime::createFromFormat('d/m/Y', $date);
    return $dateObj ? $dateObj->format('Y-m-d') : null;
}
