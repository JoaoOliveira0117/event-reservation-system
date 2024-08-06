<?php

namespace App\Http\Controllers;

use App\Http\DTOs\EventDTO;
use App\Http\Requests\Event\EventCreateRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Http\Responses\Response;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $eventDTO = EventDTO::fromRequest($request);
        $event = Event::create($eventDTO->toArray());
        return Response::success($event, 201);
    }

    /**
     * Update a event and saves it to the database
     */
    public function update(EventUpdateRequest $request, Event $event): JsonResponse
    {
        $eventDTO = EventDTO::fromRequest($request);
        $event->update($eventDTO->toArray());
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
}
