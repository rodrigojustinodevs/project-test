<?php

use App\Http\Controllers\CpfController;
use Illuminate\Support\Facades\Route;

Route::post('/processar-cpfs', [CpfController::class, 'processCpfs']);