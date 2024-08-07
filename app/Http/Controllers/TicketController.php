<?php

namespace App\Http\Controllers;

use App\Http\DTOs\TicketDTO;
use App\Http\Requests\Ticket\TicketCreateRequest;
use App\Http\Requests\Ticket\TicketDeleteRequest;
use App\Http\Requests\Ticket\TicketUpdateRequest;
use App\Http\Responses\Response;
use App\Http\Services\TicketService;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    /**
     * Returns all tickets
     */
    public function index(): JsonResponse
    {
        $tickets = TicketService::getAll();
        return Response::success($tickets);
    }

    /**
     * Returns a single ticket
     */
    public function show(Ticket $ticket): JsonResponse
    {
        return Response::success($ticket);
    }

    /**
     * Creates a ticket and saves it to the database
     */
    public function store(TicketCreateRequest $request): JsonResponse
    {
        $ticket = TicketService::create($request);
        return Response::success($ticket, 201);
    }

    /**
     * Update a ticket and saves it to the database
     */
    public function update(TicketUpdateRequest $request): JsonResponse
    {
        $ticketDTO = TicketDTO::arrayFromRequest($request);
        
        $ticket = Ticket::where('user_id', $ticketDTO['user_id'])
            ->where('event_id', $ticketDTO['event_id'])
            ->firstOrFail();
        
        if (!Gate::allows('manage-event', $ticket)) {
            return Response::error((object) ['error' => 'Unauthorized.'], 403);
        }
            
        $ticket->update($ticketDTO);
        return Response::success($ticket);
    }
    
    /**
     * Deletes a ticket from the database
     */
    public function destroy(Event $event, TicketDeleteRequest $request): JsonResponse
    {
        $ticketDTO = TicketDTO::arrayFromRequest($request);

        $ticket = Ticket::where('user_id', $ticketDTO['user_id'])
            ->where('event_id', $event->id)
            ->firstOrFail();
        

        if (!Gate::allows('manage-event', $ticket)) {
            return Response::error((object) ['error' => 'Unauthorized.'], 403);
        }

        $ticket->delete();
        return Response::success((object) [], 204);
    }
}
