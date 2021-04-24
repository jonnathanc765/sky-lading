<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterReceived;


class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::all();

        return view('backend.contacts.index', compact('contacts'));
    }
    public function store(Request $request)
    {

        $data = $request->validate([
            'nombre'      => '',
            'email'     => 'nullable|unique:contacts,email',
            'telefono'     => '',
            'rif'       => '',
            'ciudad'      => '',
            'estado'     => '',
        ]);

        // dd($request);
        
        $contact = Contact::create([
            'name' => $data['nombre'],
            'email' => $data['email'],
            'phone' => $data['telefono'],
            'rif' => $data['rif'],
            'state' => $data['estado'],
            'city' => $data['ciudad']
        ]);

    $status = Mail::to('jorbinogales@gmail.com')->send(new RegisterReceived());

    return response()->json([
            'contact'                  => $contact,
        ], 201);
      
    }
}
