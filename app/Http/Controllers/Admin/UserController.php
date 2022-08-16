<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Show the all users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.users')->with('users', User::all());
    }

    /**
     * premote user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function premote(Request $request, $user_id)
    {
        $user = User::where('id', $user_id)->firstOrFail();
        if ($request->user()->cannot('premote', $user)) {
            abort(403);
        }
        if(Role::where('id', $user->role_id + 1)->first())
        {
            
            $user->increment('role_id', 1);
        }
        return back()->with('message', $user->name . ' has been premoted to ' . $user->role->name);
    }

    /**
     * demote user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function demote(Request $request, $user_id)
    {
        $user = User::where('id', $user_id)->firstOrFail();
        if ($request->user()->cannot('demote', $user)) {
            abort(403);
        }
        if(Role::where('id', $user->role_id - 1)->firstOrFail())
        {
            $user->decrement('role_id', 1);
        }
        return back()->with('message', $user->name . ' has been demoted to ' . $user->role->name);
    }

    
    /**
     * approve user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function approve(Request $request, $user_id)
    {        
        $user = User::where('id', $user_id)->firstOrFail();
        if ($request->user()->cannot('approve', $user)) {
            abort(403);
        }
        $user->update(['approved_at' => now()]);
        return back()->with('message', $user->name . ' has been approved');
    }

    /**
     * suspend user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function suspend(Request $request, $user_id)
    {
        $user = User::where('id', $user_id)->firstOrFail();
        if ($request->user()->cannot('suspend', $user)) {
            abort(403);
        }
        if($user->suspended_till)
        {
            if( $user->suspended_till->addMonth()->gte(now()->addMonths(3)))
            {
                return $this->block($request, $user_id);
            }
            else
            {
                $user->update(['suspended_till' => $user->suspended_till->addMonth()]);
            }
        }
        else
        {
            $user->update(['suspended_till' => now()->addMonth()]);
        }
        return back()->with('message', $user->name . ' has been suspended till ' . $user->suspended_till);
    }    

    /**
     * block user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function block(Request $request, $user_id)
    {
        $user = User::where('id', $user_id)->firstOrFail();
        if ($request->user()->cannot('block', $user)) {
            abort(403);
        }
        $user->update(['is_blocked' => true, 'suspended_till' => NULL]);
        return back()->with('message', $user->name . ' has been blocked');
    }

    /**
     * unblock user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function unblock(Request $request, $user_id)
    {
        $user = User::where('id', $user_id)->firstOrFail();
        if ($request->user()->cannot('unblock', $user)) {
            abort(403);
        }
        $user->update(['is_blocked' => false]);
        return back()->with('message', $user->name . ' has been unblocked');
    }
}
