<?php

namespace App\Http\Controllers\WebControllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{

    public function index()
    {
        return view('web.clients.index');
    }//end of index


    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required',
            'email'=>['required',Rule::unique('users')->ignore($client->id),Rule::unique('clients')->ignore($client->id)],
            'password'=>'required|confirmed',
            'image'=>'image|max:1024',
        ]);

        $request_data = $request->except(['password','password_confirmation','image']);
        $request_data['password'] = bcrypt($request->password);

        if($request->image){
            if($client->image == 'default.jpg'){
                $img = Image::make($request->image);
                $img->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img_name = rand().'.'.$request->image->getClientOriginalExtension();
                $img->save(public_path('images/clients/'.$img_name),60);
                $request_data['image'] = $img_name;
            }else{

                Storage::disk('public_image')->delete('clients/'.$client->image);

                $img = Image::make($request->image);
                $img->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img_name = rand().'.'.$request->image->getClientOriginalExtension();
                $img->save(public_path('images/clients/'.$img_name),60);
                $request_data['image'] = $img_name;
            }
        }

        $client->update($request_data);

        session()->flash('success',__('site.client_updated'));
        return response()->json([
            'status'=>true,
        ]);
    }//end of update


    public function destroy(Client $client)
    {
        if($client->image != 'default.jpg'){
            Storage::disk('public_image')->delete('clients/'.$client->image);
        }

        $client->delete();
        session()->flash('success',__('site.client_deleted'));
        return redirect()->route('web.clients.index');
    }//end of destroy
}
