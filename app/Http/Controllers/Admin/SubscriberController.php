<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Subscriber;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SubscriberController extends Controller
{
    use Upload, Notify;


    public function list() {
        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');

        $subscriberData = Subscriber::selectRaw("
            COUNT(*) AS totalSubscriber,
            SUM(CASE WHEN MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear THEN 1 ELSE 0 END) AS thisMonthSubscriber,
            SUM(CASE WHEN YEAR(created_at) = $currentYear THEN 1 ELSE 0 END) AS thisYearSubscriber,
            SUM(CASE WHEN MONTH(created_at) = MONTH(NOW() - INTERVAL 1 MONTH) AND YEAR(created_at) = YEAR(NOW() - INTERVAL 1 MONTH) THEN 1 ELSE 0 END) AS previousMonthCount,
            SUM(CASE WHEN YEAR(created_at) = YEAR(NOW() - INTERVAL 1 YEAR) THEN 1 ELSE 0 END) AS previousYearCount
        ")->first();

        $data['totalSubscriber'] = $subscriberData->totalSubscriber;
        $data['thisMonthSubscriber'] = $subscriberData->thisMonthSubscriber;
        $previousMonthCount = $subscriberData->previousMonthCount;
        $data['thisYearSubscriber'] = $subscriberData->thisYearSubscriber;
        $previousYearCount = $subscriberData->previousYearCount;

        $data['thisMonthSubscriberGrowth'] = ($previousMonthCount > 0) ? (($data['thisMonthSubscriber'] - $previousMonthCount) / $previousMonthCount) * 100 : 0;
        $data['growthPercentageYear'] = ($previousYearCount > 0) ? (($data['thisYearSubscriber'] - $previousYearCount) / $previousYearCount) * 100 : 0;

        return view('admin.subscribers.list', $data);
    }


    public function searchList(Request $request)
    {
        $search = $request->search['value'];

        $subscribers = Subscriber::orderBy('id', 'DESC')
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where('email', 'LIKE', "%{$search}%");
            });

        return DataTables::of($subscribers)
            ->addColumn('checkbox', function ($item) {
                return ' <input type="checkbox" id="chk-' . $item->id . '"
                           class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                           data-id="' . $item->id . '">';
            })
            ->addColumn('email', function ($item) {
                return '<div class="d-flex">
                    <span class="d-block mb-0 ps-3">' . $item->email . '</span>
                </div>';
            })
            ->addColumn('subscribed_at', function ($item) {
                return '<div class="d-flex">
                <span class="d-block mb-0 ps-3">' . dateTime($item->created_at) . '</span>
            </div>';
            })
            ->addColumn('action', function ($item) {
                return '<div class="btn-group" role="group">
                      <a class="btn btn-white deleteBtn" href="javascript:void(0)"
                           data-route="' .route('admin.subscriber.delete',$item->id). '"
                           data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i>
                        </a>
                  </div>';
            })->rawColumns(['checkbox', 'email', 'subscribed_at','action'])
            ->make(true);
    }
    public function deleteMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Item.');
            return response()->json(['error' => 1]);
        } else {
            Subscriber::whereIn('id', $request->strIds)->delete();
            session()->flash('success', 'User has been deleted successfully');
            return response()->json(['success' => 1]);
        }
    }

    public function delete($id){
        $data =  Subscriber::where('id', $id)->firstOr(function () {
            throw new \Exception('The subscriber was not found.');
        });

        $data->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }


        return back()->with('success','Deleted');

    }

    public function sendEmailForm()
    {
        return view('admin.subscribers.send_mail_form');

    }

    public function sendMailUser(Request $request)
    {

        $rules = [
            'subject' => 'required',
            'description' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $basic = basicControl();
        $email_from = $basic->sender_email;
        $requestMessage = $request->message;
        $subject = $request->subject;
        $email_body = $basic->email_description;
        if (!Subscriber::first()) return back()->withInput()->with('error', 'No subscribers to send email.');
        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            $name = explode('@', $subscriber->email)[0];
            $message = str_replace("[[name]]", $name, $email_body);
            $message = str_replace("[[message]]", $requestMessage, $message);
            @Mail::to($subscriber->email)->queue(new SendMail($email_from, $subject, $message));
        }
        return back()->with('success', 'Email has been sent to subscribers.');
    }
}
