<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Http\Resources\StaticPageResource;
use App\Models\Offer;
use App\Models\PrivacyPolicy;
use App\Models\ReturnPolicy;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaticPageController extends Controller
{
    private $lang;

    public function __construct(Request $request)
    {
        $this->lang = $request->header('lang', 'ar');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->query('page');
        $response = null;
        switch ($page) {
            case 'terms':
                $response = StaticPageResource::collection(
                    TermsAndCondition::where('active', 1)->get()
                );
                break;

            case 'privacy':
                $response = StaticPageResource::collection(
                    PrivacyPolicy::where('active', 1)->get()
                );
                break;

            case 'return':
                $response = StaticPageResource::collection(
                    ReturnPolicy::where('active', 1)->get()
                );
                break;

            default:
                return RespondWithBadRequestData($this->lang, 2);
        }
        return ResponseWithSuccessData($this->lang, $response, 1);
    }

}
