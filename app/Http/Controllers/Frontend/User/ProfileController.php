<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Services\UserService;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;

/**
 * Class ProfileController.
 */
class ProfileController
{
    /**
     * @param  UpdateProfileRequest  $request
     * @param  UserService  $userService
     * @return mixed
     */
    public function update(UpdateProfileRequest $request, UserService $userService)
    {
        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ]);

            $avatarFile = $request->file('avatar');
            $avatarFileName = 'avatar_' . $user->id . '_' . time() . '.' . $avatarFile->getClientOriginalExtension();
            $avatarPath = $avatarFile->storeAs('avatars', $avatarFileName, 'public');
            
            $user->avatar = $avatarPath;
            $user->save();
        }

        $userService->updateProfile($request->user(), $request->validated());

        if (session()->has('resent')) {
            return redirect()->route('frontend.auth.verification.notice')->withFlashInfo(__('You must confirm your new e-mail address before you can go any further.'));
        }

        return redirect()->route('frontend.user.account', ['#information'])->withFlashSuccess(__('Profile successfully updated.'));
    }
}
