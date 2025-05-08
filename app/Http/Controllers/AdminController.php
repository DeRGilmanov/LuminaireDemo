<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Slide;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
/*use Nette\Utils\Image;*/
use SimpleXMLElement;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\Contact;

class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->get()->take(10);
        $dashboardDatas = DB::select("SELECT
                                       SUM(total) AS TotalAmount,
                                       SUM(IF(status = 'ordered', total, 0)) AS TotalOrderedAmount,
                                       SUM(IF(status = 'delivered', total, 0)) AS TotalDeliveredAmount,
                                       SUM(IF(status = 'canceled', total, 0)) AS TotalCanceledAmount,
                                       COUNT(*) AS Total,
                                       SUM(IF(status = 'ordered', 1, 0)) AS TotalOrdered,
                                       SUM(IF(status = 'delivered', 1, 0)) AS TotalDelivered,
                                       SUM(IF(status = 'canceled', 1, 0)) AS TotalCanceled
                                       FROM orders;
                                    ");

        $monthlyDatas = DB::select("SELECT
                                      M.id AS MonthNo,
                                      M.name AS MonthName,
                                      IFNULL(D.TotalAmount, 0) AS TotalAmount,
                                      IFNULL(D.TotalOrderedAmount, 0) AS TotalOrderedAmount,
                                      IFNULL(D.TotalDeliveredAmount, 0) AS TotalDeliveredAmount,
                                      IFNULL(D.TotalCanceledAmount, 0) AS TotalCanceledAmount
                                  FROM
                                      month_names M
                                  LEFT JOIN (
                                      SELECT
                                          MONTH(created_at) AS MonthNo,
                                          SUM(total) AS TotalAmount,
                                          SUM(IF(status = 'ordered', total, 0)) AS TotalOrderedAmount,
                                          SUM(IF(status = 'delivered', total, 0)) AS TotalDeliveredAmount,
                                          SUM(IF(status = 'canceled', total, 0)) AS TotalCanceledAmount
                                      FROM
                                          Orders
                                      WHERE
                                          YEAR(created_at) = YEAR(NOW())
                                      GROUP BY
                                          MONTH(created_at)
                                  ) D ON D.MonthNo = M.id
                                  ORDER BY
                                      M.id;
                                  ");

        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $OrderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $DeliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $CanceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());

        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');


        return view('admin.index', compact('orders','dashboardDatas', 'AmountM', 'OrderedAmountM', 'DeliveredAmountM', 'CanceledAmountM', 'TotalAmount', 'TotalOrderedAmount', 'TotalDeliveredAmount', 'TotalCanceledAmount'));
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);

        return view('admin.brands', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.brand-add');
    }

    public function brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:jpeg,jpg,png,|max:2048'

        ]);
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateBrandThumbailsImage($image, $file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Бренд успешно добавлен');

    }

    public function brand_edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
    }

    public function brand_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,' . $request->id,
            'image' => 'mimes:jpeg,jpg,png,|max:2048'
        ]);

        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/brands') . '/' . $brand->image)) {
                File::delete(public_path('uploads/brands') . '/' . $brand->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateBrandThumbailsImage($image, $file_name);
            $brand->image = $file_name;
        }

        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Бренд обновлен');
    }

    public function brand_delete($id)
    {
        $brand = Brand::find($id);
        if (File::exists(public_path('uploads/brands') . '/' . $brand->image)) {
            File::delete(public_path('uploads/brands') . '/' . $brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'Бренд успешно удален');
    }

    public function GenerateBrandThumbailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function category_add()
    {
        return view('admin.category-add');
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:jpeg,jpg,png,|max:2048'

        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateCategoryThumbailsImage($image, $file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Категория успешно добавлена');
    }

    public function GenerateCategoryThumbailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function category_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $request->id,
            'image' => 'mimes:jpeg,jpg,png,|max:2048'
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
                File::delete(public_path('uploads/categories') . '/' . $category->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateCategoryThumbailsImage($image, $file_name);
            $category->image = $file_name;
        }
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Категория обновлена');
    }

    public function category_delete($id)
    {
        $category = Category::find($id);
        if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
            File::delete(public_path('uploads/categories') . '/' . $category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Категория успешно удалена');
    }

    public function products()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function product_add()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-add', compact('categories', 'brands'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required|integer',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug); // Используем slug из запроса
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        // Обработка основного изображения
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbailsImage($image, $imageName);
            $product->image = $imageName;
        }

        // Обработка изображений галереи
        $gallery_images = "";
        $gallery_arr = array();
        $counter = 1;

        if ($request->hasFile('images')) {
            $allowedfileExtion = array("jpeg", "jpg", "png", "gif");
            $files = $request->file('images');

            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                if (in_array($extension, $allowedfileExtion)) {
                    $gfileName = $current_timestamp . "-" . $counter . "." . $extension;
                    $this->GenerateProductThumbailsImage($file, $gfileName);
                    array_push($gallery_arr, $gfileName);
                    $counter++;
                } else {
                    return back()->with('error', 'Недопустимый тип файла для изображения галереи');
                }
            }
            $gallery_images = implode(",", $gallery_arr);
        }

        $product->images = $gallery_images;
        $product->save();

        return redirect()->route('admin.products')->with('status', 'Продукт был успешно добавлен');
    }
    public function GenerateProductThumbailsImage($image, $imageName){
        $destinationPathThumbail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');
        $img = Image::read ($image->path());

        $img->cover(540,689,"top");
        $img->resize(540,689,function ($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);

        $img->resize(104,104,function ($constraint){
            $constraint->aspectRatio();
        })->save($destinationPathThumbail.'/'.$imageName);
    }
    public function product_edit($id)
    {
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-edit', compact('product','categories', 'brands'));
    }
    public function product_update(Request $request)
    {
       $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,'.$request->id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required|integer',
            'image' => 'mimes:jpeg,jpg,png|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);
       $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug); // Используем slug из запроса
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image'))
        {
            if(File::exists(public_path('uploads/products').'/'.$product->image))
            {
                File::delete(public_path('uploads/products').'/'.$product->image);
            }
            if(File::exists(public_path('uploads/products/thumbnails').'/'.$product->image))
            {
                File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
            }
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbailsImage($image, $imageName);
            $product->image = $imageName;
        }

        // Обработка изображений галереи
        $gallery_images = "";
        $gallery_arr = array();
        $counter = 1;

        if ($request->hasFile('images'))
        {
            foreach (explode(',',$product->images) as $ofile)
            {
                if(File::exists(public_path('uploads/products').'/'.$ofile))
                {
                    File::delete(public_path('uploads/products').'/'.$ofile);
                }
                if(File::exists(public_path('uploads/products/thumbnails').'/'.$ofile))
                {
                    File::delete(public_path('uploads/products/thumbnails').'/'.$ofile);
                }
            }

            $allowedfileExtion = array("jpeg", "jpg", "png", "gif");
            $files = $request->file('images');

            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                if (in_array($extension, $allowedfileExtion)) {
                    $gfileName = $current_timestamp . "-" . $counter . "." . $extension;
                    $this->GenerateProductThumbailsImage($file, $gfileName);
                    array_push($gallery_arr, $gfileName);
                    $counter++;
                } else {
                    return back()->with('error', 'Недопустимый тип файла для изображения галереи');
                }
            }
            if (!empty($gallery_arr)) {
                $product->images = implode(",", $gallery_arr);
            }

            $gallery_images = implode(",", $gallery_arr);
            $product->images = $gallery_images;
        }


        $product->save();
        return redirect()-> route('admin.products')->with('status','Товар успешно обновлен!');
    }
       public function product_delete($id)
       {
          $product =  Product::find($id);
          if(File::exists(public_path('uploads/products').'/'.$product->image))
          {
              File::delete(public_path('uploads/products').'/'.$product->image);
          }
          if(File::exists(public_path('uploads/products/thumbnails').'/'.$product->image))
          {
              File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
          }
           foreach (explode(',',$product->images) as $ofile)
           {
               if(File::exists(public_path('uploads/products').'/'.$ofile))
               {
                   File::delete(public_path('uploads/products').'/'.$ofile);
               }
               if(File::exists(public_path('uploads/products/thumbnails').'/'.$ofile))
               {
                   File::delete(public_path('uploads/products/thumbnails').'/'.$ofile);
               }
           }

          $product->delete();
          return redirect()-> route('admin.products')->with('status', 'Товар успешно удален!');
       }
       public function coupons()
       {
        $coupons=Coupon::orderBy('expiry_date', 'DESC')->paginate(12);
        return view ('admin.coupons', compact('coupons'));
       }
       public function coupon_add()
       {
        return view ('admin.coupon-add');
       }
       public function coupon_store(Request $request)
       {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);
        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route('admin.coupons')->with('status', 'Промокод успешно добавлен');
       }
       public function coupon_edit($id)
       {
        $coupon = Coupon::find($id);
        return view ('admin.coupon-edit', compact('coupon'));
       }
       public function coupon_update(Request $request)
       {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);
        $coupon = Coupon::find($request->id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route('admin.coupons')->with('status', 'Промокод успешно обновлен');
       }
         public function coupon_delete($id)
         {
          $coupon = Coupon::find($id);
          $coupon->delete();
          return redirect()->route('admin.coupons')->with('status', 'Промокод успешно удален');
         }
          public function orders()
          {
            $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
            return view ('admin.orders', compact('orders'));

          }

          public function order_details($order_id)
          {
            $order = Order::find($order_id);
            $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('order_id', $order_id)->first();
            return view ('admin.order-details', compact('order', 'orderItems', 'transaction'));
          }
          public function update_order_status(Request $request)
          {
            $order = Order::find($request->order_id);
            $order->status = $request->order_status;

            if ($request->order_status == 'delivered')
             {
                $order->delivered_date = Carbon::now();
            }
            elseif ($request->order_status == 'canceled')
            {
                $order->canceled_date = Carbon::now();
            }

            $order->save();

            if ($request->order_status == 'delivered') {
                $transaction = Transaction::where('order_id', $request->order_id)->first();
                $transaction->status = 'approved';
                $transaction->save();
            }

            return back()->with('status', 'Статус заказа обновлен!');
          }
          public function slides()
          {
            $slides = Slide::orderBy('created_at', 'DESC')->paginate(12);
            return view ('admin.slides', compact('slides'));
          }
          public function slide_add()
          {
            return view ('admin.slide-add');
          }
        public function slide_store(Request $request)
        {
            $request->validate([
                'tagline' => 'required',
                'title' => 'required',
                'subtitle' => 'required',
                'link' => 'required',
                'status' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png|max:2048'
            ]);
            $slide = new Slide();
            $slide->tagline = $request->tagline;
            $slide->title = $request->title;
            $slide->subtitle = $request->subtitle;
            $slide->link = $request->link;
            $slide->status = $request->status;

            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateSlideThumbailsImage($image, $file_name);
            $slide->image = $file_name;
            $slide->save();
            return redirect()->route('admin.slides')->with('status', 'Слайд успешно добавлен');
        }

        public function GenerateSlideThumbailsImage($image, $imageName)
        {
            $destinationPath = public_path('uploads/slides');
            $img = Image::read($image->path());
            $img->cover(400, 690, "top");
            $img->resize(400, 690, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $imageName);
        }
        public function slide_edit($id)
        {
            $slide = Slide::find($id);
            return view ('admin.slide-edit', compact('slide'));
        }
        public function slide_update(Request $request)
        {
            $request->validate([
                'tagline' => 'required',
                'title' => 'required',
                'subtitle' => 'required',
                'link' => 'required',
                'status' => 'required',
                'image' => 'mimes:jpeg,jpg,png|max:2048'
            ]);
            $slide = Slide::find($request->id);
            $slide->tagline = $request->tagline;
            $slide->title = $request->title;
            $slide->subtitle = $request->subtitle;
            $slide->link = $request->link;
            $slide->status = $request->status;
            if($request->hasFile('image'))
            {
                if(File::exists(public_path('uploads/slides').'/'.$slide->image))
                {
                    File::delete(public_path('uploads/slides').'/'.$slide->image);
                }

                $image = $request->file('image');
                $file_extention = $request->file('image')->extension();
                $file_name = Carbon::now()->timestamp . '.' . $file_extention;
                $this->GenerateSlideThumbailsImage($image, $file_name);
                $slide->image = $file_name;
            }
                $slide    ->save();
                return redirect()->route('admin.slides')->with('status', 'Слайд успешно обновлен');
        }
        public function slide_delete($id)
        {
            $slide = Slide::find($id);
            if(File::exists(public_path('uploads/slides').'/'.$slide->image))
            {
                File::delete(public_path('uploads/slides').'/'.$slide->image);
            }
            $slide->delete();
            return redirect()->route('admin.slides')->with('status', 'Слайд успешно удален');
        }
    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(10);
        return view ('admin.contacts', compact('contacts'));
    }
    public function contact_delete($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->route('admin.contacts')->with('status', 'Сообщение успешно удалено');
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->get()->take(8);
        return response()->json($results);
    }


    public function exportXml()///////////////////////////////////////////////////////////////////////////////////////////////////////каталог
{
    $products = Product::all();

    $xml = new SimpleXMLElement('<products/>');

    foreach ($products as $product) {
        $item = $xml->addChild('product');
        $item->addChild('id', $product->id);
        $item->addChild('name', $product->name);
        $item->addChild('price', $product->price);
        $item->addChild('description', $product->description);
    }

    return response($xml->asXML(), 200)
        ->header('Content-Type', 'application/xml')
        ->header('Content-Disposition', 'attachment; filename="products.xml"');

    }


    public function exportOrdersXml()///////////////////////////////////////////////////////////////////////////////////////////////////////Список заказов
    {
{
    $orders = Order::all(); // Или фильтрация по дате/статусу, если нужно

    $xml = new SimpleXMLElement('<orders/>');

    foreach ($orders as $order) {
        $item = $xml->addChild('order');
        $item->addChild('id', $order->id);
        $item->addChild('user_id', $order->user_id);
        $item->addChild('total', $order->total);
        $item->addChild('status', $order->status);
        $item->addChild('created_at', $order->created_at);
    }

    return response($xml->asXML(), 200)
        ->header('Content-Type', 'application/xml')
        ->header('Content-Disposition', 'attachment; filename="orders.xml"');
}
    }
}
