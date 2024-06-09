<?php


class Payment
{   
    protected $paymentID;
    protected $userID;
    protected $weddingID;

    // Create operation
    public function create($data)
    {
        DB::connect();
        $this->paymentID = trim(DB::sanitize($data['paymentID']));
        $this->userID = strtolower(trim(DB::sanitize($data['userID'])));
        $this->weddingID = trim(DB::sanitize($data['weddingID']));

        DB::close();

        $data = array(
                'paymentID' => $this->paymentID,
                'userID' => $this->userID,
                'weddingID' => $this->weddingID,
                'paidAt' => date('Y-m-d H:i:s'),
            );


            DB::connect();
            $createPayment = DB::insert('payments', $data);
            DB::close();

            if ($createPayment) {
                $this->error = false;
                $this->errorMsgs['createPayment'] = '';
            } else {
                $this->error = true;
                $this->errorMsgs['createPayment'] = 'Payment updation failed';
            }

            if ($this->error) {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs];
            } else {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs, 'message' => 'Payment successful'];
            }

    }

    
}
