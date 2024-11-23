<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class AdminController extends Controller
{
    public function validate_account(Request $request, $id)
    {
        $user = Auth::user();

        // Vérifiez si l'utilisateur est un administrateur
        if ($user->role !== User::ROLES['admin']) {
            return response()->json(["message" => "Unauthorized access. Only admins can validate accounts."], 403);
        }

        // Validez le compte de l'agent ou du propriétaire
        $account = User::findOrFail($id);

        if (in_array($account->role, [User::ROLES['agent'], User::ROLES['owner']])) {
            $account->is_validated = 1;
            $account->save();

            return response()->json(["message" => "Account validated successfully."], 200);
        }

        return response()->json(["message" => "Only agents or owners can be validated."], 403);
    }
}
