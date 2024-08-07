<?php

namespace App\Enums;

enum TicketStatus: string
{
  case Valid = 'ticket_valid';
  case Due = 'ticket_due';
  case Cancel = 'ticket_cancelled';
}