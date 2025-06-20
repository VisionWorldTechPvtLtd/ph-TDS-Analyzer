<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer;
use App\Http\Requests\UpdateCustomer;
use App\Models\User;
use App\Models\roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomersController extends Controller
{
    public function __construct()
    {
        $this->allCustomers = User::all();
        $this->roles = roles::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.customers.index', ['customers' => $this->allCustomers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customers.create',['roles'=>$this->roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
//     public function store(Customer $request)
// {
//     $validatedData = $request->validated();

//     $customer = new User();

//     $customer->first_name = $validatedData['first_name'];
//     $customer->last_name = $validatedData['last_name'];
//     $customer->company = $validatedData['company'];
//     $customer->contact_no = $validatedData['contact_no'];
//     $customer->email = $validatedData['email'];

//     $username = strtok($validatedData['company'], ' ');
//     $generatedPassword = $username . '@123';
//     $customer->password = Hash::make($generatedPassword);

//     $customer->city = $validatedData['city'];
//     $customer->state = $validatedData['state'];
//     $customer->manual_settings = $request->manual_settings == 'on' ? 1 : 0;
//     $customer->address = $request->address;
//     $customer->pincode = $request->pincode;
//     $customer->status = $request->status == true ? '1' : '0';
//     $customer->user_flow_limit = $validatedData['user_flow_limit'];
//     $customer->roles_id = $validatedData['roles_id'];

//     if ($request->hasFile('profile_pic')) {
//         $file = $request->file('profile_pic');
//         $path = 'uploads/customers/profile-pics/';
//         $ext = $file->getClientOriginalExtension();
//         $file_name = time() . '.' . $ext;
//         $file->move(public_path($path), $file_name);
//         $customer->profile_pic = $path . $file_name;
//     }
//     $customer->save();

//     $data = [
//         "customer" => $customer,
//         "data" => "User Registration Complete!"
//     ];
//     $to = $customer->email;
//     Mail::send('admin.emails.register', $data, function ($message) use ($to) {
//         $message->to($to);
//         $message->subject('Borewell Registration');
//     });

//     return redirect()->route('customers.show', ['customer' => $customer->id])
//         ->with('success', 'New Customer Created Successfully!');
// }
public function store(Customer $request)
{
    $validatedData = $request->validated();

    $customer = new User();

    $customer->first_name = $validatedData['first_name'];
    $customer->last_name = $validatedData['last_name'];
    $customer->company = $validatedData['company'];
    $customer->contact_no = $validatedData['contact_no'];
    $customer->email = $validatedData['email'];

    $username = strtok($validatedData['company'], ' ');
    $generatedPassword = $username . '@123';
    $customer->password = Hash::make($generatedPassword);

    $customer->city = $validatedData['city'];
    $customer->state = $validatedData['state'];
    $customer->manual_settings = $request->manual_settings == 'on' ? 1 : 0;
    $customer->address = $request->address;
    $customer->pincode = $request->pincode;
    $customer->status = $request->status == true ? '1' : '0';
    $customer->user_flow_limit = $validatedData['user_flow_limit'];
    $customer->roles_id = $validatedData['roles_id'];

    if ($request->hasFile('profile_pic')) {
        $file = $request->file('profile_pic');
        $path = 'uploads/customers/profile-pics/';
        $ext = $file->getClientOriginalExtension();
        $file_name = time() . '.' . $ext;
        $file->move(public_path($path), $file_name);
        $customer->profile_pic = $path . $file_name;
    }

    $customer->save();

    $data = [
        "customer" => $customer,
        "data" => "User Registration Complete!"
    ];

    $to = $customer->email;
    if ((int)$customer->roles_id === 1) {
        // STP Registration Email
        Mail::send('admin.emails.stpregister', $data, function ($message) use ($to) {
            $message->to($to);
            $message->subject('STP Registration');
        });
    } else {
        // General Borewell Registration Email
        Mail::send('admin.emails.register', $data, function ($message) use ($to) {
            $message->to($to);
            $message->subject('Borewell Registration');
        });
    }

    return redirect()->route('customers.show', ['customer' => $customer->id])
        ->with('success', 'New Customer Created Successfully!');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = User::with(['pumps'])->findOrFail($id);
        return view('admin.customers.show', ['customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomer $request, $id)
    {
        $validatedData = $request->validated();

       $customer = User::findOrFail($id);

       $customer->first_name = $validatedData['first_name'];
       $customer->last_name = $validatedData['last_name'];
       $customer->company = $validatedData['company'];
       $customer->contact_no = $validatedData['contact_no'];
       $customer->city = $validatedData['city'];
       $customer->state = $validatedData['state'];
       $customer->address = $request->address;
       $customer->pincode = $request->pincode;
       $customer->status = $request->status == true ? '1' : '0';
       $customer->manual_settings = $request->manual_settings == 'on' ? 1 : 0;
       $customer->user_flow_limit= $validatedData['user_flow_limit'];
       
       if($request->hasFile('profile_pic')){

            if(File::exists($customer->profile_pic)){
                File::delete($customer->profile_pic);
            }

            $file = $request->file('profile_pic');
            $path = 'uploads/customers/profile-pics/';
            $ext = $file->getClientOriginalExtension();
            $file_name = time().'.'.$ext;
            $file->move($path, $file_name);
            $customer->profile_pic = $path.$file_name;

       }

       $customer->update();

       return redirect()->route('customers.show', ['customer' => $customer->id])->with('success', 'Customers Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        if(File::exists($customer->profile_pic)){
            File::delete($customer->profile_pic);
        }
        $customer->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully !');
    }
}
