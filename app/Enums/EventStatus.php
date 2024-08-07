<?php

namespace App\Enums;

enum EventStatus: string
{
  case Pending = 'event_pending';
  case Full = 'event_full';
  case Finished = 'event_finished';
}