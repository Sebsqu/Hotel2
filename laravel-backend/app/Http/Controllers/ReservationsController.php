<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;

class ReservationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $reservations = Reservation::with(['user', 'room'])
        ->where('user_id', $user->id)
        ->get();

        return response()->json($reservations,200);
    }

    public function indexManager()
    {
        $reservations = Reservation::with(['user', 'room'])->get();

        return response()->json($reservations,200);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required',
                'room_id' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ]);
    
            $reservation = Reservation::create($validatedData);

            $room = Room::findOrFail($validatedData['room_id']);
            $room->book();
    
            return response()->json(['message' => 'Rezerwacja została dodana', 'reservation' => $reservation], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Nie udało się dodać rezerwacji'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'sometimes|required',
                'room_id' => 'sometimes|required',
                'start_date' => 'sometimes|required|date',
                'end_date' => 'sometimes|required|date|after:start_date',
                'status' => 'sometimes|required'
            ]);

            $reservation = Reservation::findOrFail($id);

            $reservation->update($validatedData);

            return response()->json(['message' => 'Rezerwacja została zaktualizowana', 'reservation' => $reservation], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Nie udało się zaktualizować rezerwacji'], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            Reservation::findOrFail($id)->delete();
            return response()->json(['message' => 'Rezerwacja została usunięta'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Nie udało się usunąć rezerwacji'], 500);
        }
    }
}
