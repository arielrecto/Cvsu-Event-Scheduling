<?php

namespace App\Http\Controllers;

use App\Enums\UserRolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){

        $userRole = Auth::user()->roles()->first();

        switch($userRole->name){
            case UserRolesEnum::ADMIN->value:
                return to_route('dashboard');
                break;
            case UserRolesEnum::INSTRUCTOR->value:
                return to_route('faculty.dashboard');
                break;
            default :
                return to_route('home');
                break;
        }
    }
}
