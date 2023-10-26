<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\AdminSettings;
use App\Models\Campaigns;
use App\Models\Donations;
use App\Models\User;
use App\Models\Rewards;
use Fahim\PaypalIPN\PaypalIPNListener;
use App\Helper;
use Mail;
use Carbon\Carbon;
use App\Models\PaymentGateways;

class BankTransferController extends Controller
{
  public function __construct(AdminSettings $settings, Request $request)
  {
    $this->settings = $settings::first();
    $this->request = $request;
  }

  public function show()
  {

    if (!$this->request->expectsJson()) {
      abort(404);
    }

    // Insert DB and send Mail
    $sql                   = new Donations;
    $sql->campaigns_id     = $this->request->campaign_id;
    $sql->txn_id           = 'null';
    $sql->fullname         = $this->request->full_name;
    $sql->email            = $this->request->email;
    $sql->country          = $this->request->country;
    $sql->postal_code      = $this->request->postal_code;
    $sql->donation         = $this->request->amount;
    $sql->payment_gateway  = 'Bank Transfer';
    $sql->comment          = $this->request->input('comment', '');
    $sql->anonymous        = $this->request->input('anonymous', '0');
    $sql->rewards_id       = $this->request->input('_pledge', 0);
    $sql->approved         = '0';
    $sql->save();



    return response()->json([
      'success' => true,
      'url' => url('donation/pending', $this->request->campaign_id)
    ]);
  }
}
