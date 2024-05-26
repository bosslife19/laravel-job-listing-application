<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{

    public function index()
    {
        // dd(request()->tag);
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)


        ]);
    }

    public function show(Listing $listing)
    {

        return view('listings.show', ['listing' => $listing]);
    }

    // show create form

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        // dd($request->file("logo"));
        $formfields = $request->validate([
            "company" => "required",
            "title" => "required",
            "location" => "required",
            "email" => "email|required",
            "website" => "required",
            "tags" => "required",
            "description" => "required",
        ]);

        if($request->hasFile('logo')){
            $formfields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        // do this

        // $formfields['user_id'] = auth()->id();
        // Listing::create($formfields);

        // or this

        auth()->user()->listings()->create($formfields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    // show edit form

    public function edit(Listing $listing){
       

        return view('listings.edit', ['listing'=>$listing]);
    }

    public function update (Request $request, Listing $listing){

        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized action');
        }
        $formfields = $request->validate([
            "company" => "required",
            "title" => "required",
            "location" => "required",
            "email" => "email|required",
            "website" => "required",
            "tags" => "required",
            "description" => "required",
        ]);

        if($request->hasFile('logo')){
            $formfields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        
        $listing->update($formfields);

        return back()->with('message', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing){
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized action');
        }
        $listing->delete();

        return redirect('/')->with('message', 'Listing deleted successfully!');
    }

    public function manage(){
        // dd(auth()->user()->listings);
        return view('listings.manage', ['listings'=>auth()->user()->listings]);
    }
}


