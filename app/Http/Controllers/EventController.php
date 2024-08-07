<?php

namespace App\Http\Controllers;

use App\Http\DTOs\EventDTO;
use App\Http\Requests\Event\EventCreateRequest;
use App\Http\Requests\Event\EventGetMyEventsRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Http\Responses\Response;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function index(): JsonResponse
    {
        $events = Event::all();
        return Response::success($events);
    }

    /**
     * Returns a single Event
     */
    public function show(Event $event): JsonResponse
    {
        return Response::success($event);
    }

    /**
     * Creates a event and saves it to the database
     */
    public function store(EventCreateRequest $request): JsonResponse
    {
        $eventDTO = EventDTO::arrayFromRequest($request);
        $event = Event::create($eventDTO);
        return Response::success($event, 201);
    }

    /**
     * Update a event and saves it to the database
     */
    public function update(Event $event, EventUpdateRequest $request): JsonResponse
    {
        $eventDTO = EventDTO::arrayFromRequest($request);
        $event->update($eventDTO);
        return Response::success($event);
    }
    
    /**
     * Deletes a event from the database
     */
    public function destroy(Event $event): JsonResponse
    {
        $event->delete();
        return Response::success(null, 204);
    }

    /**
     * Returns all events created by the authenticated user
     */
    public function getMyEvents(EventGetMyEventsRequest $request): JsonResponse
    {
        $events = Event::where('user_id', $request->user()->id)->get();
        return Response::success($events);
    }
}
