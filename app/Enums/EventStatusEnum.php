<?php


namespace App\Enums;

enum EventStatusEnum :string {
   case INCOMING = "incoming";
   case ONGOING = "ongoing";
   case DONE = "done";
   case CANCELED = "cancel";
}
