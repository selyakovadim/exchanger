<?php

namespace App\Modules\SCI;

use App\Models\Bill;

abstract class SciBase
{
    protected $sci_id;
    protected $sci_key;
    protected $sci_account;

    public function __construct()
    {
        $class = class_basename($this);

        $this->sci_id = config("payment.$class.sci.id");
        $this->sci_key = config("payment.$class.sci.key");
        $this->sci_account = config("payment.$class.sci.account");
    }

    public function getComment($id) {
        return 'Оплата счёта №' . $id;
    }

    public function getHttpMethod() {
        return 'POST';
    }

    abstract public function getURL();

    abstract public function getParameters(Bill &$bill);
}