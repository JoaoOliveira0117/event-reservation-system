<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventCreateRequest;
use App\Http\Requests\Event\EventGetMyEventsRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Http\Responses\Response;
use App\Http\Services\EventService;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function index(): JsonResponse
    {
        $events = EventService::getAll();
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
        $event = EventService::create($request);
        return Response::success($event, 201);
    }

    /**
     * Update a event and saves it to the database
     */
    public function update(Event $event, EventUpdateRequest $request): JsonResponse
    {
        if (!Gate::allows('manage-event', $event)) {
            return Response::error((object) ['error' => 'Unauthorized.'], 403);
        }
        
        EventService::update($event, $request);
        return Response::success($event);
    }
    
    /**
     * Deletes a event from the database
     */
    public function destroy(Event $event): JsonResponse
    {
        if (!Gate::allows('manage-event', $event)) {
            return Response::error((object) ['error' => 'Unauthorized.'], 403);
        }

        EventService::delete($event);
        return Response::success(null, 204);
    }

    /**
     * Returns all events created by the authenticated user
     */
    public function getMyEvents(EventGetMyEventsRequest $request): JsonResponse
    {
        $events = EventService::getUserEvents($request->user());
        return Response::success($request->user()->events);
    }
}
