<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\State;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Log as FacadesLog;

class ProfileController extends Controller
{

    public function index(Request $request): View
    {
        $user = User::where('id', Auth::id())->with('state', 'city')->first();
        return view('client.profile.account', ['user' => $user]);
    }


    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $states = State::with('cities')->get();
        return view('client.profile.profile-edit', [
            'user' => $request->user(),
            'states' => $states
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {



        // dd($request);
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();


        return Redirect::route('client.profile.edit')->with('success', 'تمّ تعديل معلومات الحساب بنجاح');
    }


    // if ($request->ajax()) return json_encode($request->attributes);
    public function avatar(Request $request)
    {

        if (!$request->ajax()) return abort(400);

        $request->validate([
            'avatar' => ['required', 'image', 'mimes:png,jpg']
        ], [
            'image' => 'صورة الملفّ الشخصي يجب أن تكون صورة',
            'mimes' => 'نوع الصورة يجب أن يكون أحد الامتدادات التالية, jpg, png'
        ]);

        $path = $request->file('avatar')->store(
            '/profiles_photos',
            ['disk' => 'public']
        );

        $user = $request->user();
        $user->photo = $path;
        $user->save();

        return response()->json([
            'success' => 'تمّ تغيير الصورة بنجاح',
            'photo' => '/storage' . asset($path)
        ]);
    }
}
