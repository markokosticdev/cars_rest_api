<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $per_page = !($request->input('per_page')) ? 10 : $request->input('per_page');
        $data = Client::paginate($per_page);

        return response()->json($data);
    }

    /**
     * Store a newly created client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        Validator::make($data, [
            'username' => 'required|filled|alpha_dash|unique:clients',
            'firstname' => 'required|filled',
            'lastname' => 'required|filled',
            'email' => 'required|filled|email:rfc|unique:clients',
        ])->validate();

        Client::create([
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
        ]);

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Display the specified client.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Client $client)
    {
        $data = $client;

        return response()->json($data);
    }

    /**
     * Update the specified client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Client $client)
    {
        $data = json_decode($request->getContent(), true);

        Validator::make($data, [
            'username' => 'required|filled|alpha_dash|unique:clients',
            'firstname' => 'required|filled',
            'lastname' => 'required|filled',
            'email' => 'required|filled|email:rfc|unique:clients',
        ])->validate();

        $client->update([
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
        ]);

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Remove the specified client from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Display the specified client history.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function showHistory(Client $client)
    {
        $data = $client->histories;

        return response()->json($data);
    }

    /**
     * Remove the specified client history from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyHistory(Client $client)
    {
        $client->histories()->delete();

        return response()->json(['success' => 'success'], 200);
    }
}
