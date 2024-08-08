# Event Reservation System - BACKEND

This application's purpose is to deliver information about user registered events and its reservations;

### Goals

- [x] **Authentication**: Enable user registration and login.
- [x] **Event Creation**: Allow users to create events with details like title, description, date/time, location, price, and attendee limit.
- [x] **Ticket Reservation**: Users can reserve tickets within attendee limits and deadlines.
- [x] **Events Page**: Display all available events with relevant information.
- [x] **Database Migration**: Create necessary tables, use seeders, and factories.
- [x] **Controllers**: Handle requests and responses in Laravel.
- [x] **Eloquent Handling**: Interact with the database.
- [x] **Model Relationships**: Establish relationships between models.
- [x] **Validation**: Ensure data entered is valid and secure.
- [x] **Sessions & Sanctum**: Maintain application state and use Laravel Sanctum.
- [x] **Middleware**: Protect routes and controllers requiring authentication.
- [x] **Testing**: Create and configure feature tests.

### Endpoints available

```python
{{URL}} /api/register

@post - Create a new user
curl --request POST \
  --url http://localhost:8000/api/register/ \
  --header 'Content-Type: application/json' \
  --data '{
			"email": "aurora@email.com",
			"username": "Aurora239",
			"password": "_@@superpassword2244"
}'
```

```python
{{URL}} /api/login

@post - Login with new user
curl --request POST \
  --url http://localhost:8000/api/login \
  --header 'Content-Type: application/json' \
  --data '{
			"email": "aurora@email.com",
			"password": "_@@superpassword2244"
}'
```

```python
{{URL}} /api/logout

@post - Delete user session
curl --request POST \
  --url http://localhost:8000/api/logout \
  --header 'Content-Type: application/json'
```


```python
{{URL}} /api/users

@get - Get users
curl --request GET \
  --url http://localhost:8000/api/users \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \
  --header 'User-Agent: insomnia/9.3.2'

```


```python
{{URL}} /api/users/{user}

@put - Update your user
curl --request PUT \
  --url http://localhost:8000/api/users/{user_id} \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \
  --header 'Content-Type: application/json' \
  --data '{
			"email": "auroras@email.com",
			"username": "Aurora2239",
			"password": "_@@joao0117"
}'

@delete - Delete your user
curl --request DELETE \
  --url http://localhost:8000/api/users/{user_id} \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \
  --header 'Content-Type: application/json' \
```


```python
{{URL}} /api/events

@get - Get All events
curl --request GET \
  --url http://localhost:8000/api/events \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE'
```

```python
{{URL}} /api/events/me

@get - Get all events you created
curl --request GET \
  --url http://localhost:8000/api/events/me \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE'
```

```python
{{URL}} /api/events{event}

@post - Create a new event
curl --request POST \
  --url http://localhost:8000/api/events/ \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \
  --header 'Content-Type: application/json' \
  --data '{
	"title": "New Event",
	"description": "Chappel Roan",
	"deadline": "2026-06-18T04:50:00.000000Z",
	"date": "2026-07-25",
	"location": "340 Milford Lakes\nAnaismouth, MO 14002-6007",
	"price": 21.90,
	"attendee_limit": 100,
	"status": "event_finished"
}'

@put - Update a event created by you
curl --request PUT \
  --url http://localhost:8000/api/events/{event_id} \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \
  --header 'Content-Type: application/json' \
  --data '{
	"title": "New Event",
	"description": "Chappel Roan",
	"deadline": "2026-06-18T04:50:00.000000Z",
	"date": "2026-07-25",
	"location": "340 Milford Lakes\nAnaismouth, MO 14002-6007",
	"price": 21.90,
	"attendee_limit": 100,
	"status": "event_finished"
}'

@delete - Delete a event created by you 
curl --request DELETE \
  --url http://localhost:8000/api/events/{event_id} \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \
```

```python
{{URL}} /api/tickets

@get - Get a list of all tickets ( mostly used for debugging )
curl --request GET \
  --url http://localhost:8000/api/tickets \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \
```

```python
@get - Get a list of all tickets aquired by you
curl --request GET \
  --url http://localhost:8000/api/tickets/me \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \
```

```python
{{URL}} /api/tickets/{event}

@get - Get the ticket of the specified event of your user
curl --request GET \
  --url http://localhost:8000/api/tickets/{event_id} \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \

@post - Create a new ticket of the specified event for your user
curl --request POST \
  --url http://localhost:8000/api/tickets/{event_id} \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \
  --header 'Content-Type: application/json' \
  --data '{
	"status": "ticket_valid"
}'

@put - Update the specified ticket of your user
curl --request PUT \
  --url http://localhost:8000/api/tickets/{event_id} \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \
  --header 'Content-Type: application/json' \
  --data '{
	"status": "ticket_valid"
}'

@delete - Deletes the specified ticket of your user
curl --request DELETE \
  --url http://localhost:8000/api/tickets/{event_id} \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer YOUR USER TOKEN HERE' \
  --header 'Content-Type: application/json' \
```

<h6 align="center">Application supported by</h6>

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="250" alt="Laravel Logo"></a></p>