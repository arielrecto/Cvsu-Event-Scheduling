<?php


namespace App\Enums;

enum UserRolesEnum
:string {
   case STUDENT = "student";
   case ADMIN = "admin";
   case INSTRUCTOR = 'instructor';
}
