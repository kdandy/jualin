<?php

namespace App\Http\Controllers;

use App\Models\hakakses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HakaksesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search = $request->get('search');
        if ($search) {
            $data['hakakses'] = hakakses::where('id', 'like', "%{$search}%")->get();
        } else {
            $data['hakakses'] = hakakses::all();
        }
        return view('layouts.hakakses.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.hakakses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,superadmin'
        ]);

        hakakses::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('hakakses.index')->with('message', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(hakakses $hakakses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $hakakses = hakakses::find($id);
        return view('layouts.hakakses.edit', compact('hakakses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $hakakses = hakakses::find($id);
        
        if (!$hakakses) {
            return redirect()->route('hakakses.index')->with('error', 'User tidak ditemukan!');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,superadmin'
        ]);
        
        $hakakses->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);
        
        return redirect()->route('hakakses.index')->with('message', 'User berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hakakses = hakakses::find($id);
        
        if (!$hakakses) {
            return redirect()->route('hakakses.index')->with('error', 'User tidak ditemukan!');
        }
        
        // Prevent deleting the current logged in user
        if ($hakakses->id == Auth::user()->id) {
            return redirect()->route('hakakses.index')->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }
        
        $hakakses->delete();
        
        return redirect()->route('hakakses.index')->with('message', 'User berhasil dihapus!');
    }
}
