<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only('store');
        $this->middleware(['permission:users_update'])->only('update');
        $this->middleware(['permission:users_delete'])->only('destroy');
    }//end of construct

    public function index(Request $request)
    {
        if($request->search){
            $users = User::where('name','like','%'.$request->search.'%')
                ->orWhere('phone','like','%'.$request->search.'%')
                ->orWhere('email','like','%'.$request->search.'%')
                ->whereRoleIs('admin')->latest()->paginate(6);
        }else{
            $users = User::whereRoleIs('admin')->latest()->paginate(6);
        }

        return view('admin.users.index',compact('users','request'));
    }//end of index


    public function store(UserRequest $request)
    {
        $request->validated();

        $request_data = $request->except(['password','password_confirmation','image','permissions']);
        $request_data['password'] = bcrypt($request->password);

        if($request->image){
            $img = Image::make($request->image);
            $img->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->save(public_path('images/users/'.$request->image->hashName()),60);

            $request_data['image'] = $request->image->hashName();
        }

        $user = User::create($request_data);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        session()->flash('success',__('site.user_created'));

        return response()->json([
            'status'=>true,
        ]);
    }//end of store


    public function edit(User $user)
    {
        return view('admin.users.edit',compact('user'));
    }//end of edit


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email'=>['required',Rule::unique('users')->ignore($user->id),Rule::unique('clients')->ignore($user->id)],
            'password'=>'required|confirmed',
            'image'=>'image|max:4000',
            'permissions'=>'array|required'
        ]);

        $request_data = $request->except(['password','password_confirmation','image','permissions']);
        $request_data['password'] = bcrypt($request->password);

        if($request->image){
            if($user->image == 'default.jpg'){
                $img = Image::make($request->image);
                $img->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img->save(public_path('images/users/'.$request->image->hashName()),60);

                $request_data['image'] = $request->image->hashName();
            }else{

                Storage::disk('public_image')->delete('users/'.$user->image);

                $img = Image::make($request->image);
                $img->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img->save(public_path('images/users/'.$request->image->hashName()),60);

                $request_data['image'] = $request->image->hashName();
            }
        }

        $user->update($request_data);

        $user->syncPermissions($request->permissions);

        session()->flash('success',__('site.user_updated'));
        return redirect()->route('users.index');

    }//end of update


    public function destroy(User $user)
    {
        if ($user->image != 'default.jpg'){
            Storage::disk('public_image')->delete('users/'.$user->image);
        }

        $user->detachRole('admin');

        $user->delete();
        session()->flash('success',__('site.user_deleted'));
        return redirect()->route('users.index');
    }//end of destroy
}
