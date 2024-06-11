<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\State;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Log as FacadesLog;

class ProfileController extends Controller
{

    public function index(Request $request): View
    {
        $user = User::where('id', Auth::id())->with('state', 'city')->first();

        if ($user->role == 'admin') return view('admin.profile.account', ['user' => $user]);
        return view('client.profile.account', ['user' => $user]);
    }


    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $states = State::with('cities')->get();
        $user = $request->user();
        if ($user->isAdmin()) {

            return view('admin.profile.account-edit', [
                'user' => $user,
                'states' => $states
            ]);
        }
        return view('client.profile.profile-edit', [
            'user' => $user,
            'states' => $states
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {



        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        if ($user->isAdmin()) {

            return Redirect::route('admin.profile.edit')->with('success', 'تمّ تعديل معلومات الحساب بنجاح');
        }

        return Redirect::route('client.profile.edit')->with('success', 'تمّ تعديل معلومات الحساب بنجاح');
    }



    public function avatar(Request $request)
    {

        if (!$request->ajax()) return abort(400);

        $request->validate([
            'avatar' => ['required', File::image()->types(['png', 'jpg'])->dimensions(Rule::dimensions()->height(500)->width(500))]
        ], [
            'required' => 'الصورة إجبارية',
            'image' => 'صورة الملفّ الشخصي يجب أن تكون صورة',
            'mimes' => 'نوع الصورة يجب أن يكون أحد الامتدادات التالية, jpg, png',
            'dimensions' => 'الرجاء اختيار صورة بأبعاد 500 * 500'
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
