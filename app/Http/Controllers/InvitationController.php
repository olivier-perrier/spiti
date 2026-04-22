<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Team;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function show(Request $request)
    {
        $invitation = Invitation::where('token', $request->token)->first();

        if (! $invitation) {

            return view('invitation.message', [
                'status' => 'warning',
                'message' => 'Votre invitation est invalide ou déjà utilisée.',
            ]);
        }

        $user = User::where('email', $invitation->email)->first();

        // a user already exists for the email
        if ($user) {
            // add the user to the Team of the Invitation
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
        } else {

            return view('invitation/show', []);
        }
    }
}
