<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('Client.index')->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        // dd($request->all());
        $clint = Client::create([
            // 'nom', 'prenom', 'code_client','tele'
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'code_client' => $request->code_client,
            'tele' => $request->tele,
        ]);
        if (!$clint) {
            $request->session()->flash('error', "Input invalid");
            toast(session('error'), 'error');
        } else {
            $request->session()->flash('success', "Client added successfly");
            toast(session('success'), 'success');
        }
        return redirect(route('client.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }
    public function updateClient(Request $request)
    {
        $client = Client::find($request->id_cli);
        // dd($client);
        $request->validate([
            'nom' => ['required', 'String'],
            'prenom' => ['required', 'string'],
            'code_client' => ['required', 'string', \Illuminate\Validation\Rule::unique('clients')->ignore($client->id)],
            'tele' => ["required", "regex:/^(0|\+212)[1-9]([-.]?[0-9]{2}){4}$/", \Illuminate\Validation\Rule::unique('clients')->ignore($client->id)],
        ]);
        $client->nom = $request->nom;
        $client->prenom = $request->prenom;
        $client->code_client = $request->code_client;
        $client->tele = $request->tele;
        $client->save();
        $request->session()->flash('success', "client updated successfly");
        toast(session('success'), 'success');
        return redirect(route('client.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect(route('client.index'));
    }
    public function deleteClient($id)
    {
        $client = Client::find($id);
        // dd($client);
        $client->delete();
        return redirect(route('client.index'));
    }
    public function getInfoClient(Request $request)
    {
        //number to string ==>ora 01722

        $client = Client::find($request->id_client);
        if ($client == null) {
            return response()->json([
                'status' => false,
                'message' => 'data not found',
            ]);
        } else {
            return response()->json([
                'status' => true,
                'client' => $client,
            ]);
        }
    }
}