use Illuminate\Support\Facades\Storage;

public function update(Request $request)
{
    $request->validate([
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = auth()->user();

    if ($request->hasFile('profile_picture')) {
        // Delete the old profile picture from S3
        if ($user->profile_picture) {
            Storage::disk('s3')->delete($user->profile_picture);
        }

        // Upload the new profile picture
        $path = $request->file('profile_picture')->store('profile_pictures', 's3');

        // Set the file to be publicly accessible
        Storage::disk('s3')->setVisibility($path, 'public');

        // Save the profile picture path in the database
        $user->profile_picture = $path;
    }

    $user->save();

    return redirect()->back()->with('status', 'Profile updated successfully.');
}
