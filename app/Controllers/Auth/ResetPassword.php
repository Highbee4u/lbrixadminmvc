<?php
class ResetPassword extends Controller {



use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Notifications\ForgotPassword;



{
    use Notifiable;

    public function show()
    {
        return view('auth.reset-password');
    }

    public function routeNotificationForMail() {
        return request()->email;
    }

    public function send(Request $request = null)
    {
        $email = $request->validate([
            'email' => ['required']
        ]);
        $user = User::where('email', $email)->first();

        if ($user) {
            $this->notify(new ForgotPassword($user->id));
            return back()->with('succes', 'An email was send to your email address');
        }
    }
}
