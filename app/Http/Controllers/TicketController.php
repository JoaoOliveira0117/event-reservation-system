<?php

namespace App\Http\Controllers;

use App\Http\DTOs\TicketDTO;
use App\Http\Requests\Ticket\TicketCreateRequest;
use App\Http\Requests\Ticket\TicketDeleteRequest;
use App\Http\Requests\Ticket\TicketUpdateRequest;
use App\Http\Responses\Response;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(): JsonResponse
    {
        $tickets = Ticket::all();
        return Response::success($tickets);
    }

    /**
     * Returns a single Event
     */
    public function show(Ticket $ticket): JsonResponse
    {
        return Response::success($ticket);
    }

    /**
     * Creates a event and saves it to the database
     */
    public function store(TicketCreateRequest $request): JsonResponse
    {
        $ticketDTO = TicketDTO::arrayFromRequest($request);
        $ticket = Ticket::create($ticketDTO);
        return Response::success($ticket, 201);
    }

    /**
     * Update a event and saves it to the database
     */
    public function update(TicketUpdateRequest $request): JsonResponse
    {
        $ticketDTO = TicketDTO::arrayFromRequest($request);
        
        $ticket = Ticket::where('user_id', $ticketDTO['user_id'])
            ->where('event_id', $ticketDTO['event_id'])
            ->firstOrFail();
            
        $ticket->update($ticketDTO);
        return Response::success($ticket);
    }
    
    /**
     * Deletes a event from the database
     */
    public function destroy(TicketDeleteRequest $request): JsonResponse
    {
        $ticketDTO = TicketDTO::arrayFromRequest($request);

        $ticket = Ticket::where('user_id', $ticketDTO['user_id'])
            ->where('event_id', $ticketDTO['event_id'])
            ->firstOrFail();

        $ticket->delete();
        return Response::success((object) [], 204);
    }
}
