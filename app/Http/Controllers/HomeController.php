<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'approved', 'blocked', 'suspended'])->except('approval', 'is_blocked', 'is_suspended');;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the awaiting approval view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function approval()
    {
        if(!auth()->check()) {
            return redirect()->route('login');
        }
        elseif (auth()->user()->approved_at)
        {
            return redirect()->route('home');
        }
        return view('approval');
    }

    /**
     * Show the user blocked view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function is_blocked()
    {
        if(!auth()->check()) {
            return redirect()->route('login');
        }
        elseif (!auth()->user()->is_blocked)
        {
            return redirect()->route('home');
        }
        return view('blocked');
    }

    /**
     * Show the user suspended view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function is_suspended()
    {
        if(!auth()->check()) {
            return redirect()->route('login');
        }

        if(auth()->user()->suspended_till) 
        {
            $suspened_till = auth()->user()->suspended_till;
        }
        else
        {
            $suspened_till = now();
        }

        if(now()->gte($suspened_till))
        {
            return redirect()->route('home');
        }
        return view('suspended')->with('timestamp', $suspened_till);
    }
}
