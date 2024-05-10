<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Notification;
use App\Models\User;
use App\Services\AwsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private AwsService $awsService;

    public function __construct(AwsService $awsService)
    {
        $this->awsService = $awsService;
    }

    public function index()
    {
        return view('profile', ['user' => auth()->user()]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->awsService->store($data['image']);
        }

        auth()->user()->update($data);

        return redirect()->back()->with('status', 'Profile updated successfully.');
    }

    public function mark(Notification $notification){
        $notification->delete();
        return redirect()->back();
    }

    public function show(User $user)
    {
        return view('profile', ['user' => $user]);
    }
}
