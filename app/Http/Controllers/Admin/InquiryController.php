<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountryMaster;
use App\Models\InquiryMaster;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(){

        $inquiries = InquiryMaster::orderBy('inquiry_date', 'desc')->get();

        $countries = CountryMaster::orderBy('country_name', 'asc')->get();

        return view('pages.inquiries.manage_inquiries', compact('inquiries','countries'));
    }
}
