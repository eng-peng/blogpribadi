<?php

// ------------------------------------------------------------------
// File: app/Http/Controllers/Controller.php
// Fungsi: Class dasar (abstract) yang menjadi induk semua controller.
//         Semua controller lain meng-extends class ini.
// ------------------------------------------------------------------

namespace App\Http\Controllers;

abstract class Controller
{
    // Kosong: hanya berfungsi sebagai base class.
    // Bisa ditambah trait/shared logic bila seluruh controller membutuhkannya.
}
