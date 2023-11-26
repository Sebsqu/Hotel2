<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\User;

class RoomsController extends Controller
{
    public function index()
    {
        $rooms = Room::all('name','size','capacity','price','images_path');

        if ($rooms){
            return response()->json($rooms, 200);
        } else {
            return response()->json([
                'message' => 'Nie znaleziono pokoi'
            ], 400);
        }
    }

    public function show($id)
    {
        $room = Room::find($id);

        if ($room) {
            return response()->json($room, 200);
        } else {
            return response()->json([
                'message' => 'Nie znaleziono pokoju'
            ], 400);
        }
    }

    public function search(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $capacity = $request->input('capacity');

        $availableRooms = Room::whereDoesntHave('reservations', function ($query) use ($startDate, $endDate) {
            $query->where('start_date', '<', $endDate)->where('end_date', '>', $startDate)->where('status', 'booked');
        })->where('capacity', '>=', $capacity)->get();

        if ($availableRooms) {
            return response()->json(['rooms' => $availableRooms], 200);
        } else {
            return response()->json([
                'message' => 'Nie znaleziono dostępnych pokoi w tym okresie'
            ], 400);
        }
    }
}
