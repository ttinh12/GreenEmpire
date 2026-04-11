<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client.layouts.master');
    }
    public function service()
    {
        $services = DB::table('services')->paginate(10);

        return view('client.services.index', compact('services'));
    }
    public function serviceDetail($id)
    {
        $service = DB::table('services')->where('id', $id)->first();
        if (!$service)
            abort(404);

        return view('client.services.show', compact('service'));
    }
    public function update(Request $request)
    {
        // 1. Lấy đúng user đang đăng nhập
        $user = User::find(auth()->id());

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user->name = $request->name;

        if ($request->hasFile('avatar')) {
            // 2. Lưu file và chỉ lấy cái tên đường dẫn tương đối
            $path = $request->file('avatar')->store('avatars', 'public');

            // 3. LƯU Ý: Không dùng asset() ở đây. Chỉ lưu tên path thôi.
            $user->avatar_url = $path;
        }

        // 4. Lưu vào DB
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Cập nhật thông tin thành công!');
    }
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('client.profile.edit', compact('user'));
    }
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'], // Kiểm tra mật khẩu cũ có đúng không
            'password' => ['required', Password::defaults(), 'confirmed'], // Mật khẩu mới phải khớp với confirmation
        ], [
            'current_password.current_password' => 'Mật khẩu hiện tại không chính xác.',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Đã cập nhật mật khẩu mới thành công!');
    }

    public function dashboard()
    {
        return view('client.dashboard');
    }
    public function profile()
    {
        return view('client.profile');
    }
    public function setting()
    {
        return view('client.setting');
    }
    public function logout()
    {
        return view('client.logout');
    }
    public function ticket()
    {
        return view('client.tickets.index');
    }
}
