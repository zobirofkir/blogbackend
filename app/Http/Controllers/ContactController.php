<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Jobs\ContactMailJob;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ContactResource::collection(
            Contact::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request)
    {
        $contact = Contact::create($request->validated());
        ContactMailJob::dispatch($contact);    
        return ContactResource::make($contact);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return ContactResource::make($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
        return ContactResource::make(
            $contact->refresh()
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        return $contact->delete();
    }
}
