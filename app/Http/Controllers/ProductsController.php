<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use Request;
use App\Product;
use App\Parking;
use DB;

class ProductsController extends Controller {

	/**
     * Instantiate a new ProductsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$parking = Parking::find($id);
		
		$parking_name = $parking->parking_name;
		$parking_id = $parking->parking_id;

		$products = DB::table('PRODUCT')->where('parking_id', $id)->paginate(10);
		return view('products.index', compact('products', 'parking_name', 'parking_id'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		//$parkings = get_parkings_dropdown( NULL, NULL );
		$parking_id = $id;

		$parking = Parking::find($id);
		$parking_name = $parking->parking_name;

		return view('products.create', compact('parking_id', 'parking_name'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddProductRequest $request)
	{
		$input = $request->all();

		$product = new Product();
		$product->name = $input['name'];
		$product->description = $input['description'];
		$product->parking_id = $input['parking_id'];
		$product->price = $input['price'];
		$product->save();

		return redirect('parking/'.$product->parking_id.'/products');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = Product::findOrFail($id);
		$parking_id = $product->parking_id;

		$parking = Parking::find($product->parking_id);
		$parking_name = $parking->parking_name;

		return view('products.edit', compact('product', 'parking_id', 'parking_name'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AddProductRequest $request)
	{
		$product = Product::findOrFail($id);
		
		$product->update($request->all());
		
		return redirect('parking/'.$product->parking_id.'/products');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
