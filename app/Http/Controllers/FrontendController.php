<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Enquiry;
use App\Models\Faq;
use App\Models\IndiaServiceDescription;
use App\Models\Menu;
use App\Models\Review;
use App\Models\State;
use App\Models\SubCategory;
use App\Models\SubMenu;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function home()
    {
        $subcategories = Subcategory::where('status', 1)
            ->orderByDesc('created_at')
            ->select('id', 'name', 'slug', 'icon', 'trending', 'featured', 'background_image')
            ->get();
        $trendingsubcat = $subcategories->where('trending', 1);
        $featuresubcat = $subcategories->where('featured', 1);
        $providers = Vendor::with(['subCategory:id,name'])->where('status', 1)
            ->select('id', 'vendor_name', 'sub_category', 'vendor_image', 'price', 'review_count')
            ->orderByDesc('created_at')
            ->get();
        $reviews = Review::where('status', 1)
            ->select('id', 'description', 'name', 'profession', 'status')
            ->get();
        return view('frontend.home', compact('subcategories', 'trendingsubcat', 'featuresubcat', 'providers', 'reviews'));
    }
    public function subCategory($slug)
    {
        $subcategory = SubCategory::where('slug', $slug)->select('id', 'slug', 'name', 'background_image')->first();
        $menus = Menu::select('id', 'name', 'image', 'slug', 'category_id', 'subcategory_id')
            ->where('subcategory_id', $subcategory->id ?? '')
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->get();
        if (!$subcategory) {
            abort(404, 'Category not found');
        }
        $submenus = SubMenu::join('menus', 'sub_menus.menu_id', '=', 'menus.id') // Join the menus table
            ->with(['subCategory', 'menu', 'cityName.state']) // Eager load relationships
            ->where('sub_menus.subcategory_id', $subcategory->id ?? '') // Specify the table for subcategory_id
            ->where('sub_menus.status', 1) // Specify the table for status
            ->orderByDesc('menus.created_at') // Order by a field from the menus table
            ->select(
                // 'sub_menus.id as id',
                'sub_menus.id as submenu_id',
                'sub_menus.id',
                'sub_menus.name',
                'sub_menus.image',
                'sub_menus.slug',
                'sub_menus.total_price',
                'sub_menus.discounted_price',
                'sub_menus.discount',
                'sub_menus.subcategory_id',
                'sub_menus.menu_id',
                'sub_menus.city_id',
                'sub_menus.description',
                'sub_menus.details'
            )
            ->paginate(10);
        // $subcategories = Menu::where('status', 1)
        //     ->select('id', 'name')
        //     ->get();
        $cities = City::paginate(10);

        return view('frontend.service-list', compact('submenus', 'subcategory', 'menus', 'cities'));
    }

    public function filterSubmenus(Request $request, $slug)
    {
        $subcategory = SubCategory::where('slug', $slug)
            ->select('id', 'slug', 'name', 'background_image')
            ->first();

        if (!$subcategory) {
            return response()->json([
                'error' => 'Subcategory not found'
            ], 404);
        }

        $query = SubMenu::where('subcategory_id', $subcategory->id)->select(
            // 'sub_menus.id as id',
            'sub_menus.id as submenu_id',
            'sub_menus.id',
            'sub_menus.name',
            'sub_menus.image',
            'sub_menus.slug',
            'sub_menus.total_price',
            'sub_menus.discounted_price',
            'sub_menus.discount',
            'sub_menus.subcategory_id',
            'sub_menus.menu_id',
            'sub_menus.city_id',
            'sub_menus.description',
            'sub_menus.details'
        );

        // Keyword filter
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('discounted_price', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%')
                    ->orWhere('total_price', 'like', '%' . $request->keyword . '%')
                    ->orWhereHas('cityName', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->keyword . '%');
                    })
                    ->orWhereHas('menu', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->keyword . '%');
                    });
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $query->whereHas('cityName', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->location . '%')
                    ->orWhereHas('state', function ($stateQuery) use ($request) {
                        $stateQuery->where('name', 'like', '%' . $request->location . '%');
                    });
            });
        }

        // Categories filter
        if ($request->filled('categories')) {
            $query->whereHas('menu', function ($q) use ($request) {
                $q->whereIn('name', $request->categories);
            });
        }

        // Experience filter (from Vendor table)
        if ($request->filled('experience')) {
            $experienceRange = explode('-', $request->experience); // For example, "1-5"
            $minExperience = trim($experienceRange[0]);
            $maxExperience = trim($experienceRange[1]);

            $query->whereHas('vendors', function ($q) use ($minExperience, $maxExperience) {
                $q->whereBetween('experience', [$minExperience, $maxExperience]);
            });
        }

        // Execute the query and paginate results
        $submenus = $query->paginate(10);

        // Render views for response
        $serviceListView = view('frontend.partials.service-list', compact('submenus'))->render();
        $filterView = view('frontend.partials.service-list', compact('submenus'))->render(); // Updated filter

        return response()->json([
            'html' => $serviceListView,
            'filterHtml' => $filterView,
        ]);
    }


    // public function filterSubmenus(Request $request,$slug)
    // {
    //     $subcategory = SubCategory::where('slug', $slug)->select('id', 'slug', 'name', 'background_image')->first();
    //     $query = Submenu::where('sub_menus.subcategory_id', $subcategory->id ?? '')->query();

    //     // Keyword filter
    //     if ($request->filled('keyword')) {
    //         $query->where('name', 'like', '%' . $request->keyword . '%')
    //             ->orWhere('discounted_price', 'like', '%' . $request->keyword . '%')
    //             ->orWhere('description', 'like', '%' . $request->keyword . '%')
    //             ->orWhere('total_price', 'like', '%' . $request->keyword . '%')
    //             ->orWhereHas('cityName', function ($q) use ($request) {
    //                 $q->where('name', 'like', '%' . $request->keyword . '%');
    //             })
    //             ->orWhereHas('menu', function ($q) use ($request) {
    //                 $q->where('name', 'like', '%' . $request->keyword . '%');
    //             });
    //     }

    //     // Location filter
    //     if ($request->filled('location')) {
    //         $query->whereHas('cityName', function ($q) use ($request) {
    //             $q->where('name', 'like', '%' . $request->location . '%')
    //                 ->orWhereHas('state', function ($stateQuery) use ($request) {
    //                     $stateQuery->where('name', 'like', '%' . $request->location . '%');
    //                 });
    //         });
    //     }

    //     // Categories filter
    //     if ($request->filled('categories')) {
    //         $query->whereHas('menu', function ($q) use ($request) {
    //             $q->whereIn('name', $request->categories);
    //         });
    //     }

    //     // Experience filter (from Vendor table)
    //     if ($request->filled('experience')) {
    //         $experienceRange = explode('-', $request->experience); // For example, "1-5"
    //         $minExperience = trim($experienceRange[0]);
    //         $maxExperience = trim($experienceRange[1]);

    //         $query->whereHas('vendors', function ($q) use ($minExperience, $maxExperience) {
    //             $q->whereBetween('experience', [$minExperience, $maxExperience]);
    //         });
    //     }

    //     $submenus = $query->get();

    //     $serviceListView = view('frontend.partials.service-list', compact('submenus'))->render();
    //     $filterView = view('frontend.partials.service-list', compact('submenus'))->render(); // Updated filter

    //     return response()->json([
    //         'html' => $serviceListView,
    //         'filterHtml' => $filterView,
    //     ]);
    // }

    public function servicesInIndia($city)
    {
        $faqs = Faq::where('status', 1)->select('question', 'answer')->get();
        $description = IndiaServiceDescription::first();
        $vendors = Vendor::where('status', 1)
            ->with(['verified', 'cityName'])
            ->whereHas('cityName', function ($query) use ($city) {
                $query->where('name', $city);
            })
            ->select('id', 'sub_category', 'city', 'verified', 'vendor_image', 'description', 'vendor_name')
            ->get();
        // $subcategory = Subcategory::where('status', 1)
        //     ->where('slug', $slug)
        //     ->first();
        $subcategories = Subcategory::where('status', 1)->get();
        $menus = Menu::where('status', 1)->get();
        $states = State::where('status', 'active')->where('country_id', 101)->get();
        return view('frontend.services-in-india-vendors', compact('faqs', 'vendors', 'description', 'subcategories', 'menus', 'states'));
    }

    public function servicesInIndiaCity($slug)
    {
        $states = State::where('country_id', 101)
            ->select('id', 'country_id', 'name', 'status')
            ->get();
        $faqs = Faq::where('status', 1)->select('question', 'answer')->get();
        $submenus = SubMenu::with(['subCategory', 'menu', 'cityName.state'])
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->select('id', 'name', 'image', 'slug', 'total_price', 'discounted_price', 'discount', 'subcategory_id', 'menu_id', 'city_id', 'description', 'details')
            ->get();
        $reviews = Review::where('status', 1)
            ->select('id', 'description', 'name', 'profession', 'status')
            ->get();
        $subcategory = Subcategory::where('status', 1)
            ->where('slug', $slug)
            ->first();
        $cities = City::select('id', 'name', 'state_id', 'status')
            ->where('status', 'active')
            ->paginate(10);

        // Use a subquery to directly filter vendors by city
        $vendors = Vendor::whereIn('city', function ($query) {
            $query->select('id')
                ->from('cities')
                ->where('status', 'active');
        })->first();

        $description = IndiaServiceDescription::where('sub_category_id', $subcategory->id ?? '')->first();
        return view('frontend.service-in-india', compact('faqs', 'submenus', 'description', 'reviews', 'subcategory', 'states', 'cities', 'vendors'));
    }

    public function enquiryStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $enquiry = new Enquiry();
        $enquiry->mobile_number = $request->mobile_number;
        $enquiry->save();

        return response()->json(['success' => 'Mobile number saved successfully']);
    }

    public function enquiryUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'date_time' => 'required|date',
            'move_from_origin' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate a random 4-digit OTP
        $otp = rand(1000, 9999);

        // Update the enquiry based on mobile number
        $enquiry = Enquiry::where('mobile_number', $request->mobile_number)->first();
        if ($enquiry) {
            $enquiry->name = $request->name;
            $enquiry->move_from_origin = $request->move_from_origin;
            $enquiry->email = $request->email;
            $enquiry->date_time = $request->date_time;
            $enquiry->subcategory_id = $request->subcategory_id;
            $enquiry->otp = $otp; // Store the generated OTP
            $enquiry->save();

            return response()->json(['success' => 'Details and OTP updated successfully']);
        }

        return response()->json(['error' => 'Enquiry not found'], 404);
    }

    public function verifyOtp(Request $request)
    {
        // Validate the OTP input
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string',
            'otp' => 'required|digits:4', // Ensure OTP is exactly 4 digits
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the enquiry by mobile number
        $enquiry = Enquiry::where('mobile_number', $request->mobile_number)->first();

        if ($enquiry) {
            // Check if the OTP matches and is not already verified
            if ($enquiry->otp == $request->otp && is_null($enquiry->otp_verified_at)) {
                // OTP is valid, update the verification time
                $enquiry->otp_verified_at = now();
                $enquiry->save();

                return response()->json(['success' => 'OTP verified successfully']);
            } elseif ($enquiry->otp_verified_at) {
                return response()->json(['error' => 'OTP has already been verified'], 400);
            }
        }

        return response()->json(['error' => 'Invalid OTP'], 400);
    }


    public function providerDetails($id)
    {
        $subcategories = Subcategory::where('status', 1)
            ->orderByDesc('created_at')
            ->get();
        $faqs = Faq::where('status', 1)->select('question', 'answer')->get();
        $vendor = Vendor::where('id', $id)->first();
        return view('frontend.vender-profile', compact('vendor', 'faqs', 'subcategories'));
    }

    public function reviewStore(Request $request)
    {
        // Validate request
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email',
        //     'phone_number' => 'required|max:15',
        //     'description' => 'required|string',
        //     'rating' => 'required',
        // ]);

        // Store review logic here
        // Example:
        // return $request->all();
        Review::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'description' => $request->description,
            'rating' => $request->rating,
            'type' => 1,
        ]);

        // Return success response
        return response()->json(['success' => true, 'message' => 'Review submitted successfully!']);
    }
    public function sitemapXML()
    {
        $services = subcategory::all(); // Fetch your services
        $cities = City::all();      // Fetch your cities

        $content = view('sitemap', compact('services', 'cities'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
