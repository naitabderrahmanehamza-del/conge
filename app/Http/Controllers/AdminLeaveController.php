<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminLeaveController extends Controller
{
    //
     public function credit(Request $request, $userId)
    {
        $request->validate([
            'jours' => 'required|integer|min:1'
        ]);

        $user = User::findOrFail($userId);

        $user->solde_conges = $request->jours+ $user->solde_conges ;
        $user->save();

        return response()->json([
            'message' => 'solde a ete  credite',
            'nouveau_solde' => $user->solde_conges
        ]);
    }

    
    public function debit(Request $request, $userId)
    {
        $request->validate([
            'jours' => 'required|integer|min:1'
        ]);

        $user = User::findOrFail($userId);

        $jours = $request->jours;

        if ($user->solde_conges < $jours) {
            return response()->json([
                'message' => 'Solde insuffisant t'
            ], 422);
        }
        $user->solde_conges = $user->solde_conges-$jours ;
        $user->save();

        return response()->json([
            'message' => 'Solde a ete debite',
            'nouveau_solde' => $user->solde_conges
        ]);
    }
}
