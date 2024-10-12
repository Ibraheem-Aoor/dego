<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\UserKyc;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KycVerificationController extends Controller
{
    use Upload, Notify;

    public function kyc()
    {
        $data['kyc'] = Kyc::orderBy('id', 'asc')->where('status', 1)->get();
        return view(template() . 'user.verification_center.index', $data);
    }

    public function kycForm($id)
    {
        $data['kyc'] = Kyc::where('id', $id)->firstOr(function () {
            throw new \Exception('The kyc was not found.');
        });
        $data['userKyc'] = UserKyc::where('user_id', auth()->id())->where('kyc_id', $id)
            ->where('status', '!=', 2)
            ->first();

        return view(template() . 'user.verification_center.kyc_form', $data);
    }

    public function kycFormDetails(Request $request)
    {
        $val = $request->input('kycTypeID');
        $kyc = Kyc::where('id', $val)->firstOr(function () {
            throw new \Exception('The kyc was not found.');
        });
        $oldKyc = UserKyc::where('kyc_id', $kyc->id)->where('user_id', Auth::user()->id)->first();

        if ($oldKyc && $oldKyc->status == 2) {
            return ['kyc' => $kyc, 'status' => $oldKyc->status, 'reason' => $oldKyc->reason];
        }
        if ($oldKyc) {
            return ['kyc' => $kyc, 'status' => $oldKyc->status];
        }

        return  ['kyc' => $kyc];
    }

    public function verificationSubmit(Request $request)
    {
        try{

            $kyc = Kyc::where('id', $request->kycType)->where('status', 1)->firstOr(function () {
                throw new \Exception('The kyc was not found.');
            });

            $params = $kyc->input_form;
            $reqData = $request->except('_token', '_method');
            $rules = [];

            if ($params !== null) {
                foreach ($params as $key => $cus) {
                    $rules[$key] = [$cus->validation == 'required' ? $cus->validation : 'nullable'];
                    if ($cus->type === 'file') {
                        $rules[$key][] = 'image';
                        $rules[$key][] = 'mimes:jpeg,jpg,png';
                        $rules[$key][] = 'max:2048';
                    } elseif ($cus->type === 'text') {
                        $rules[$key][] = 'max:191';
                    } elseif ($cus->type === 'number') {
                        $rules[$key][] = 'integer';
                    } elseif ($cus->type === 'textarea') {
                        $rules[$key][] = 'min:3';
                        $rules[$key][] = 'max:300';
                    }
                }
            }

            $validator = Validator::make($reqData, $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $reqField = [];
            foreach ($request->except('_token', '_method', 'type') as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k == $inKey) {
                        if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                            try {
                                $file = $this->fileUpload($request[$inKey], config('filelocation.kyc.path'), null, null, 'webp', 60);
                                $reqField[$inKey] = [
                                    'field_name' => $inVal->field_name,
                                    'field_label' => $inVal->field_label,
                                    'field_value' => $file['path'],
                                    'field_driver' => $file['driver'],
                                    'validation' => $inVal->validation,
                                    'type' => $inVal->type,
                                ];
                            } catch (\Exception $exp) {
                                session()->flash('error', 'Could not upload your ' . $inKey);
                                return back()->withInput();
                            }
                        } else {
                            $reqField[$inKey] = [
                                'field_name' => $inVal->field_name,
                                'field_label' => $inVal->field_label,
                                'validation' => $inVal->validation,
                                'field_value' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }


            UserKyc::updateOrCreate(
                ['kyc_id' => $request->kycType,
                 'user_id' => auth()->id()],
                [
                    'kyc_info' => $reqField,
                    'status' => 0,
                    'kyc_type' => $kyc->name,
                ]
            );
            return back()->with('success', 'KYC Sent Successfully');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
