<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function category()
    {
        return view('pages.category');
    }

    public function subcategory()
    {
        return view('pages.subcategory');
    }

    public function product()
    {
        return view('pages.product');
    }

    public function way()
    {
        return view('pages.way');
    }

    public function client()
    {
        return view('pages.client');
    }

    public function order()
    {
        return view('pages.order');
    }

    public function control()
    {
        return view('pages.control');
    }

    public function calendar()
    {
        return view('pages.calendar');
    }

    public function report()
    {
        return view('pages.report');
    }

    public function user()
    {
        return view('pages.user');
    }
}
