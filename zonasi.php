<?php
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371; // Radius Bumi dalam kilometer

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earth_radius * $c;

    return $distance; // Jarak dalam kilometer
}

function checkZonasi($latitude, $longitude, $kuota_terpenuhi) {
    $school_lat = -5.4649; // Koordinat latitude SDN 7 BAUBAU
    $school_lon = 122.6163; // Koordinat longitude SDN 7 BAUBAU
    $max_distance = 3; // Maksimal jarak 3 km

    $distance = calculateDistance($latitude, $longitude, $school_lat, $school_lon);

    if ($kuota_terpenuhi) {
        return 'Kuota Penuh';
    } elseif ($distance <= $max_distance) {
        return 'Lulus';
    } else {
        return 'Gagal';
    }
}
?>
