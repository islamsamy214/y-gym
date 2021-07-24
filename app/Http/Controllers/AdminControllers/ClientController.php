<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:clients_read'])->only('index');
        $this->middleware(['permission:clients_create'])->only('store');
        $this->middleware(['permission:clients_update'])->only('update');
        $this->middleware(['permission:clients_delete'])->only('destroy');
    }//end of construct

    public function index(Request $request)
    {
        if($request->search){
            $clients = Client::where('name','like','%'.$request->search.'%')->latest()->paginate(8);
        }else{
            $clients = Client::latest()->paginate(8);
        }

        return view('admin.clients.index',compact('clients','request'));
    }//end of index


    public function store(ClientRequest $request)
    {
        $request->validated();
        $request_data = $request->except(['password','password_confirmation','image']);
        $request_data['password'] = bcrypt($request->password);

        if($request->image){
            $img = Image::make($request->image);
            $img->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img_name = rand().'.'.$request->image->getClientOriginalExtension();
            $img->save(public_path('images/clients/'.$img_name),60);
            $request_data['image'] = $img_name;

        }

        $client = Client::create($request_data);

        session()->flash('success',__('site.client_created'));

        return response()->json([
            'status'=>true,
        ]);
    }//end of store


    public function edit(Client $client)
    {
        return view('admin.clients.edit',compact('client'));
    }//end of edit


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
        return redirect()->route('clients.index');
    }//end of update


    public function getPayment($client_id){
        return view('admin.clients.payment',compact('client_id'));
    }//end of getPayment


    public function payment(Request $request, $client_id){
        $request->validate([
            'months' => 'required|numeric',
            'offers' => 'max:100',
        ]);

        $client = Client::findOrFail($client_id);

        $client->update([
            'payed_date'=>date('Y-m-d'),
            'expiry_date'=>date('Y-m-d', strtotime('+'.$request->months.' month')),
        ]);

        session()->flash('success',__('site.client_paid'));
        return redirect()->route('clients.index');

    }//end of payment

    public function destroy(Client $client)
    {
        if($client->image != 'default.jpg'){
            Storage::disk('public_image')->delete('clients/'.$client->image);
        }

        $client->delete();
        session()->flash('success',__('site.client_deleted'));
        return redirect()->route('clients.index');
    }//end of destroy

}
