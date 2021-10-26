<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TicketController extends Controller
{
    const STATUS = [
        'UN_RESOLVE' => 0,
        'RESOLVE' => 1
    ];

    public function list(Request $request)
    {
        $list = Ticket::all();
        return response()->json($list);
    }

    public function create(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required',
        ]);

        if (!$request->user()->tokenCan('ticket:create')) {
            throw ValidationException::withMessages([
                'permission' => ['The provided credentials no permission.'],
            ]);
        }

        $ticket = Ticket::create([
            'type' => $request->type,
            'name' => $request->name,
            'status' => self::STATUS['UN_RESOLVE']
        ]);

        return response()->json($ticket);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required',
        ]);
        if (!$request->user()->tokenCan('ticket:update')) {
            throw ValidationException::withMessages([
                'permission' => ['The provided credentials no permission.'],
            ]);
        }

        $ticket = Ticket::where('id', $id)->update([
            'type' => $request->type,
            'name' => $request->name,
        ]);
    }

    public function resolve(Request $request, $id)
    {
        if (!$request->user()->tokenCan('ticket:resolve')) {
            throw ValidationException::withMessages([
                'permission' => ['The provided credentials no permission.'],
            ]);
        }

        $ticket = Ticket::where('id', $id)->update([
            'status' => self::STATUS['RESOLVE'],
        ]);
    }

    public function delete(Request $request, $id)
    {
        if (!$request->user()->tokenCan('ticket:delete')) {
            throw ValidationException::withMessages([
                'permission' => ['The provided credentials no permission.'],
            ]);
        }

        Ticket::where('id', $id)->delete();
    }
}
