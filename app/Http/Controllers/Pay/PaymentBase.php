<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Exchange;
use Illuminate\Http\Request;

abstract class PaymentBase extends Controller
{
    protected $request;

    protected $sci_id;
    protected $sci_key;
    protected $sci_account;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $class = class_basename($this);

        $this->sci_id = config("payment.$class.sci.id");
        $this->sci_key = config("payment.$class.sci.key");
        $this->sci_account = config("payment.$class.sci.account");
    }

    public function index() {

        if (!$this->check()) {
            return $this->responseFail();
        }

        $order = $this->getOrder();

        if ($order === null) {
            return $this->responseFail();
        }

        $order->confirm($this->getTransaction());

        return $this->responseSuccess();
    }

    public function fail()
    {
        return $this->redirect();
    }

    public function success()
    {
        return $this->redirect();
    }

    /**
     * @return Bill
     */
    protected function getOrder()
    {
        return Bill::whereId($this->getOrderId())
            ->where('amount', '<=', (float) $this->getAmount())
            ->where('currency', $this->getCurrency())
            ->where('status', Bill::WAITING)
            ->first();
    }

    protected function redirect()
    {
        $exchange = Exchange::where('bill_id', $this->getOrderId())
            ->select('hash')
            ->first();

        if ($exchange) {
            return redirect()->route('exchange.show', $exchange);
        }

        return redirect()->route('index');
    }

    abstract protected function check();

    abstract protected function responseFail();

    abstract protected function responseSuccess();

    abstract protected function getOrderId();

    abstract protected  function getAmount();

    abstract protected  function getCurrency();

    abstract protected  function getTransaction();
}
