<?php

namespace App\Http\Middleware;

use App\Models\Kyc as KYCModel;
use App\Models\UserKyc;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class KYC
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (basicControl()->isKycMandatory == 0){
            return $next($request);
        }

        $validator = Validator::make($request->all(), []);
        $kycTypes = KYCModel::pluck('id');
        $userKyc = UserKyc::where('user_id', Auth::user()->id)->whereIn('kyc_id', $kycTypes)->get();
        $userKycIds = $userKyc->pluck('kyc_id')->toArray();
        $missingKycTypes = array_diff($kycTypes->toArray(), $userKycIds);

        if (!empty($missingKycTypes)) {
            return redirect()->route('user.kyc.settings')
                ->with('error', 'KYC Verification is pending')
                ->withErrors($validator)
                ->withInput();
        }

        $statuses = $userKyc->pluck('status');
        $desiredStatuses = [0, 2];

        if ($statuses->contains(function ($status) use ($desiredStatuses) {
            return in_array($status, $desiredStatuses);
        })) {
            return redirect()->route('user.kyc.settings')
                ->with('error', 'KYC Verification is pending')
                ->withErrors($validator)
                ->withInput();
        }

        return $next($request);
    }


}
