<?php

namespace App\Http\Controllers\Admin\Contacts;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Module\Website\Contact;
use Yajra\DataTables\DataTables;

class ContactsController extends AdminController
{
    public function index()
    {
        return view('admin.contacts.index');
    }

    public function getContacts()
    {
        $contacts = Contact::all();

        return Datatables::of($contacts)
            ->addColumn('date', function ($row) {
                return $row->created_at;
            })->addColumn('action', function ($row) {
                return '
                    <a href="'.route('admin.contacts.detail', $row->id).'" class="btn btn-info btn-sm rounded" >
                       <i class="la la-eye"></i> Detail
                    </a>
                    <a href="javascript:void(0);" data-url="'.route('admin.contacts.delete', $row->id).'" class="btn btn-danger btn-sm rounded delete-contact" >
                        <i class="la la-remove"></i> Delete
                    </a>';
            })->rawColumns(['action'])
            ->make(true);
    }

    public function detail($id)
    {
        $contact = Contact::find($id);

        return view('admin.contacts.detail', compact('contact'));
    }

    public function delete($id)
    {
        Contact::destroy($id);

        return back()->with('info', 'Deleted successfully!');
    }
}
