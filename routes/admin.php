<?php 
 
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\Admin\HomeController; 
 
route::resource('home',HomeController::class)->only(['index','edit','destroy'])->names('admin.home');