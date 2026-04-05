<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function conge()
    {
        $user = Auth::guard('api')->user();

        return response()->json([
            'solde_conges' => $user->solde_conges
        ]);
    }

    public function requestLeave(Request $request)
    {
        $user = Auth::guard('api')->user();

        $request->validate([
            'jours' => 'required|integer|min:1'
        ]);

        $jours = $request->jours;

        if ($user->solde_conges < $jours) {
            return response()->json([
                'message' => ' insuffisant'
            ], 422);
        }

        $user->solde_conges -= $jours;
        
        /** @var \App\Models\User $user */
        $user->save();

        return response()->json([
            'message' => 'Demande  a ete acceepte ',
            'nouveau_solde' => $user->solde_conges
        ]);
    }
}