<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Validator;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index(Profile $profile, User $user)
    {
        $user = User::findOrFail($user->id);
        $profile = Profile::find($user->id);
        return view('profile.index', compact('user', 'profile'));
    }

    public function edit(Profile $profile, User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Profile $profile, User $user)
    {
        Validator::extend('olderThan', function($attribute, $value, $parameters)
        {
            $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 13;
            return (new DateTime())->diff(new DateTime($value))->y >= $minAge;

            // or the same using Carbon:
            // return Carbon\Carbon::now()->diff(new Carbon\Carbon($value))->y >= $minAge;
        },'Age must be greater than 18 years old!');

        $this->authorize('update', $user->profile);
        $data = request()->validate([
            'phone_number' => '',
            'address' => '',
            'birthday' => 'nullable|olderThan:18',
            'profile_photo' => 'image'
        ]);


        if (request('profile_photo')){
            $imagePath = request('profile_photo')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(900, 900);

            $image->save();

            $imageArray = ['profile_photo' => $imagePath];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        $details = request()->validate([
            'name' => '',
            'email' => 'email'

        ]);

        auth()->user()->update($details);

        return redirect('/profile/'. $user->id)->with('success','Profile updated successfully');
    }
}
