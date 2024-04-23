<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();
        if($request->input('search')){
            $query->where('name', 'like', '%'.$request->input('search').'%');
        }

        $categories = $query->orderByDesc('id')->get();

        return Inertia::render('Category/Index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $this->validate($request, [
            'name' => 'required|min:3|unique:categories,name'
        ]);

        Category::create($validated_data);

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render('Category/Edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated_data = $this->validate($request, [
            'name' => 'required|min:3|unique:categories,name,'.$category->id
        ]);

        Category::where('id', $category->id)->update($validated_data);

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index');

    }

    public function download(Request $request){
        $query = Category::query();
        if($request->input('search')){
            $query->where('name', 'like', '%'.$request->input('search').'%');
        }

        $categories = $query->orderByDesc('id')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $path = public_path() . '/categories.pdf';

        $username = Auth::user()->name;
        $pdf = $pdf->loadView('report', compact('categories', 'username'));

        $pdf->save($path);

        $pdf->setOption('javascript-delay', 3000);
        return response()->download($path);

    }
}
