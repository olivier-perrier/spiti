<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Team;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        // check to token validity
        $invitation = Invitation::where('token', $request->token)->first();

        if (! $invitation) {
            return view('invitation.message', [
                'status' => 'warning',
                'message' => 'Votre invitation est invalide ou déjà utilisée.',
            ]);
        }

        $validated = $request->validate([
            'name' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $validated['email'] = $invitation->email;

        $user = User::create($validated);

        // add the new User to the Invitation of the Team
        $team = Team::find($invitation->team_id);
        if ($team) {
            $user->teams()->sync($team);
            $user->save();

            $invitation->delete();

            Notification::make()->title("Vous avez rejoins l'organisation ".$team->name)->success()->send();

            return redirect('/admin');
        } else {

            return view('invitation.message', [
                'status' => 'warning',
                'message' => "L'oganisation que vous essayé de rejoindre n'existe plus.",
            ]);
        }
    }
}
