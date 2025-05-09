<?php

namespace App\Http\Controllers;

use Log;
use Mpdf\Mpdf;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'supplier', 'stock'])
            ->when(request('search'), function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                 //   ->orWhere('code', 'like', "%{$search}%");
            })
            ->paginate(10);

        $categories = Category::all();
        $suppliers = Supplier::all();

        if (request()->ajax()) {
            return response()->json([
                'products' => $products->items(),
                'pagination' => [
                    'total' => $products->total(),
                    'per_page' => $products->perPage(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                ]
            ]);
        }

        return view('products.index', compact('products', 'categories', 'suppliers'));
    }



    public function store(ProductRequest $request)
    {

        // dd($request->all());

        $validated = $request->validated();

        // Handle file upload if present
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('products', 'public');
            $validated['picture'] = $picturePath;
        }

        $product = Product::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'product' => $product]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }


    public function show(Product $product)
    {
        return response()->json($product);
    }



    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        // Handle file upload if present
        if ($request->hasFile('picture')) {
            // Delete old picture if exists
            if ($product->picture) {
                Storage::disk('public')->delete($product->picture);
            }

            $picturePath = $request->file('picture')->store('products', 'public');
            $validated['picture'] = $picturePath;
        }

        $product->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'product' => $product]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }



    public function destroy(Product $product)
    {
        // Delete product image if exists
        if ($product->picture) {
            Storage::disk('public')->delete($product->picture);
        }

        $product->delete();

        return response()->json(['success' => true]);
    }



      /**
    * @return \Illuminate\Support\Collection
    */
    public function export()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request)
    {
        Excel::import(new ProductImport, $request->file('file'));
        return back()->with('success', 'Products imported successfully.');
    }




    // details 1 produits
    public function details(Product $product)
    {
        return view('products.details', compact('product'));
    }

    public function downloadPdf(Product $product)
    {
        $pdf = PDF::loadView('products.pdf', compact('product'));
        return $pdf->download('product_' . $product->id . '.pdf');
    }


    // Genere pdf avec logo user

    public function print()
    {
        $user = User::find(1); // Get the authenticated user
        $products = Product::with(['category', 'supplier', 'stock'])->get();
        $data = [
            'products' => $products,
            'user' => $user // Pass the user to the view
        ];

        $mpdf = new Mpdf();
        $html = view('products.print_pdf', $data)->render();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('products.pdf', 'I'); // 'I' for inline display
    }

}
