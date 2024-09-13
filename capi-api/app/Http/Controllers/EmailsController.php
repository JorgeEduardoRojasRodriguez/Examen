<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emails;
use App\Http\Controllers\BaseController;

class EmailsController extends BaseController
{
    // get, post, put, delete
    public function index()
    {
        return $this->sendResponse(Emails::all(), 'Emails retrieved successfully.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $emails = Emails::create($input);
        return $this->sendResponse($emails->toArray(), 'Emails created successfully.');
    }

    public function show($id)
    {
        $emails = Emails::find($id);
        if (is_null($emails)) {
            return $this->sendError('Emails not found.');
        }
        return $this->sendResponse($emails->toArray(), 'Emails retrieved successfully.');
    }

    public function update(Request $request, Emails $emails)
    {
        $input = $request->all();
        $emails->fill($input);
        $emails->save();
        return $this->sendResponse($emails->toArray(), 'Emails updated successfully.');
    }

    public function destroy($id)
    {
        $emails = Emails::find($id);
        if (is_null($emails)) {
            return $this->sendError('Emails not found.');
        }
        $emails->delete();
        return $this->sendResponse($emails->toArray(), 'Emails deleted successfully.');
    }

}
