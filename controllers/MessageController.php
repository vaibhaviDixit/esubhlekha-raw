<?php
class Message
{
    public $messageID;
    public $weddingID;
    public $lang;
    public $type;
    public $text_;
    public $status;
    public $createdAt;
    public $updatedAt;

    // check for msg type 
    public function check($weddingID, $type, $lang)
    {
        DB::connect();
        $result = DB::count('messages', "weddingID = '$weddingID' AND type = '$type' AND lang = '$lang'");
        DB::close();
        return $result;
    }

    public function create(array $data)
    {
        // Sanitize and assign values
        DB::connect();
        $this->messageID = md5(md5($this->lang.$this->type.$this->weddingID).md5(time().uniqid()));
        $this->weddingID = trim(DB::sanitize($data['weddingID']));
        $this->lang = trim(DB::sanitize($data['lang']));
        $this->type = trim(DB::sanitize($data['type']));
        $this->text_ = trim(DB::sanitize($data['text_']));
        $this->status = trim(DB::sanitize($data['status']));
        $this->createdAt = date('Y-m-d H:i:s');
        $this->updatedAt = date('Y-m-d H:i:s');

        if($this->check($this->weddingID,$this->type,$this->lang)){
             DB::connect();
            $result = DB::select('messages','*',"weddingID = '$this->weddingID' AND type = '$this->type' AND lang = '$this->lang'")->fetchAll();
            DB::close();
            $data['messageID']=$result[0]['messageID'];

            return $this->update($data);
        }
        DB::close();

        // Validation Rules
        $fields = [
            'weddingID' => [
                'value' => $this->weddingID,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Wedding ID can't be empty",
                    ],
                    // Add more validation rules if needed
                ],
            ],
            'lang' => [
                'value' => $this->lang,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Language can't be empty",
                    ],
                    // Add more validation rules if needed
                ],
            ],
            'type' => [
                'value' => $this->type,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Message type can't be empty",
                    ],
                    // Add more validation rules if needed
                ],
            ],
            'text_' => [
                'value' => $this->text_,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Message text_ can't be empty",
                    ],
                    // Add more validation rules if needed
                ],
            ],
        ];

        // Call the Validator::validate function
        $validate = Validator::validate($fields);

        if ($validate['error']) {
            return ['error' => $validate['error'], 'errorMsgs' => $validate['errorMsgs']];
        } else {
            // Prepare data array
            $data = [
                'messageID' => $this->messageID,
                'weddingID' => $this->weddingID,
                'lang' => $this->lang,
                'type' => $this->type,
                'text_' => $this->text_,
                'status' => $this->status,
                'createdAt' => $this->createdAt,
                'updatedAt' => $this->updatedAt,
            ];

            // Insert data into the 'messages' table
            DB::connect();
            $createMessage = DB::insert('messages', $data);
            DB::close();


            // Handle success/failure
            if ($createMessage) {
                $this->error = false;
                $this->errorMsgs['createMessage'] = '';
            } else {
                $this->error = true;
                $this->errorMsgs['createMessage'] = 'Message Creation Failed';
            }

            if ($this->error) {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs];
            } else {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs, 'message' => 'Message Creation successful'];
            }
        }
    }

    // update
    public function update(array $data)
{
    // sanitize and assign values
    DB::connect();
    $this->messageID = trim(DB::sanitize($data['messageID']));
    $this->weddingID = trim(DB::sanitize($data['weddingID']));
    $this->lang = trim(DB::sanitize($data['lang']));
    $this->type = trim(DB::sanitize($data['type']));
    $this->text_ = trim(DB::sanitize($data['text_']));
    $this->status = trim(DB::sanitize($data['status']));
    $this->updatedAt = date('Y-m-d H:i:s');
    
    // Validation Rules
    $fields = [
        'messageID' => [
            'value' => $this->messageID,
            'rules' => [
                [
                    'type' => 'required',
                    'message' => "Message ID can't be empty",
                ],
            ],
        ],
        'weddingID' => [
            'value' => $this->weddingID,
            'rules' => [
                [
                    'type' => 'required',
                    'message' => "Wedding ID can't be empty",
                ],
                // Add more validation rules if needed
            ],
        ],
        'lang' => [
            'value' => $this->lang,
            'rules' => [
                [
                    'type' => 'required',
                    'message' => "Language can't be empty",
                ],
            ],
        ],
        'type' => [
            'value' => $this->type,
            'rules' => [
                [
                    'type' => 'required',
                    'message' => "Message type can't be empty",
                ],
            ],
        ],
        'text_' => [
            'value' => $this->text_,
            'rules' => [
                [
                    'type' => 'required',
                    'message' => "Message text_ can't be empty",
                ],
            ],
        ],
        'status' => [
            'value' => $this->status,
            'rules' => [
                // Add validation rules for status if needed
            ],
        ],
    ];

    // Call the Validator::validate function
    $validate = Validator::validate($fields);

    if ($validate['error']) {
        return ['error' => $validate['error'], 'errorMsgs' => $validate['errorMsgs']];
    } else {
        // Prepare data array
        $data = [
            'weddingID' => $this->weddingID,
            'lang' => $this->lang,
            'type' => $this->type,
            'text_' => $this->text_,
            'status' => $this->status,
            'updatedAt' => $this->updatedAt,
        ];

        // Update data in the 'messages' table
        $updateMessage = DB::update('messages', $data, "messageID = '$this->messageID'");

        // Handle success/failure
        if ($updateMessage) {
            $this->error = false;
            $this->errorMsgs['updateMessage'] = '';
        } else {
            $this->error = true;
            $this->errorMsgs['updateMessage'] = 'Message Update Failed';
        }

        if ($this->error) {
            return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs];
        } else {
            return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs, 'message' => 'Message Update successful'];
        }
    }
}
//update() ends

// delete msg
    public function delete($messageID)
{
    // Check if message exists
    DB::connect();
    $messageID = DB::sanitize($messageID);
    $checkMessage = DB::select('messages', 'messageID', "messageID = '$messageID'")->fetch();
    DB::close();

    if (!$checkMessage) {
        return [
            'error' => true,
            'errorMsg' => 'Message not found'
        ];
    }

    // Delete the message
    DB::connect();
    $deleteMessage = DB::delete('messages', "messageID = '$messageID'");
    DB::close();

    if (!$deleteMessage) {
        return [
            'error' => true,
            'errorMsg' => 'Failed to delete Message'
        ];
    } else {
        return [
            'error' => false,
            'errorMsg' => '',
            'message' => "$messageID successfully deleted"
        ];
    }
}
// delete() ends

// get msg
public function get($messageID)
{
    // Sanitize input
    DB::connect();
    $messageID = DB::sanitize($messageID);

    // Retrieve the message
    $getMessage = DB::select('messages', '*', "messageID = '$messageID'")->fetch();
    DB::close();

    if ($getMessage) {
        return $getMessage;
    } else {
        return ['error' => true, 'errorMsgs' => ['message' => 'Message not found']];
    }
}
// get() ends


}
