<?php
class Wedding
{
    public $weddingID;
    public $lang;
    public $domain;
    public $weddingName;
    public $fromRole;
    public $brideName;
    public $groomName;
    public $brideQualifications;
    public $groomQualifications;
    public $brideBio;
    public $groomBio;
    public $story;
    public $timeline;
    public $hosts;
    public $invitation;
    public $template;
    public $tier;
    public $music;
    public $youtube;
    public $accommodation;
    public $travel;
    public $phone;
    public $whatsappAPIKey;
    public $host;
    public $partner;
    public $manager;
    public $createdAt;
    public $status;
    public $languages;
    public $fromRoles;
    public $tiers;
    public $userList = ['dummy.com'];

    public $error;
    public $errorMsgs;


    /**
     * Check if the wedding ID is unique.
     *
     * @param string $weddingID
     * @param string $lang
     * @return bool True if the wedding ID is unique; false otherwise.
     */
    public function check($weddingID, $lang)
    {
        DB::connect();
        $result = DB::count('weddings', "weddingID = '$weddingID' AND lang = '$lang'");
        DB::close();
        return $result;
    }

    // Create operation
    public function create(array $data)
    {
        // Sanitize and assign values
        DB::connect();
        $this->weddingID = trim(DB::sanitize($data['weddingID']));
        $this->lang = trim(DB::sanitize($data['lang'] ?? 'en'));
        $this->domain = trim(DB::sanitize($data['domain']));
        $this->weddingName = trim(DB::sanitize($data['weddingName']));
        $this->fromRole = trim(DB::sanitize($data['fromRole']));
        $this->brideName = trim(DB::sanitize($data['brideName']));
        $this->groomName = trim(DB::sanitize($data['groomName']));
        $this->brideQualifications = trim(DB::sanitize($data['brideQualifications']));
        $this->groomQualifications = trim(DB::sanitize($data['groomQualifications']));
        $this->brideBio = trim(DB::sanitize($data['brideBio']));
        $this->groomBio = trim(DB::sanitize($data['groomBio']));
        $this->story = $data['story'];
        $this->timeline = $data['timeline'];
        $this->hosts = $data['hosts'];
        $this->invitation = trim(DB::sanitize($data['invitation']));
        $this->template = trim(DB::sanitize($data['template']));
        $this->tier = trim(DB::sanitize($data['tier'] ?? 'basic'));
        $this->music = trim(DB::sanitize($data['music']));
        $this->youtube = trim(DB::sanitize($data['youtube']));
        $this->accommodation = $data['accommodation'];
        $this->travel = $data['travel'];
        $this->phone = trim(DB::sanitize($data['phone']));
        $this->whatsappAPIKey = trim(DB::sanitize($data['whatsappAPIKey']));
        $this->host = trim(DB::sanitize($data['host']));
        $this->partner = trim(DB::sanitize($data['partner']));
        $this->manager = trim(DB::sanitize($data['manager']));



        $this->hosts = [
            "brideFather" => ["name" => $data['brideFather'], "relation" => "Bride Father"],
            "groomFather" => ["name" => $data['groomFather'], "relation" => "Groom Father"],
            "brideMother" => ["name" => $data['brideMother'], "relation" => "Bride Mother"],
            "groomMother" => ["name" => $data['groomMother'], "relation" => "Groom Mother"],
            "brideTagline" => $data['brideTagline'],
            "groomTagline" => $data['groomTagline']
        ];


        $this->languages = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings'
        AND COLUMN_NAME = 'lang'")->fetch()[0]);

        $this->fromRoles = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings'
        AND COLUMN_NAME = 'fromRole'")->fetch()[0]);

        $this->tiers = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings'
        AND COLUMN_NAME = 'tier'")->fetch()[0]);

        $userData = DB::select('users', 'userID', "status <> 'deleted'")->fetchAll();

        foreach ($userData as $user) {
            $this->userList[] = $user['userID'];
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
                    [
                        'type' => 'eventID',
                        'message' => "Invalid Wedding ID",
                    ],
                    [
                        'type' => 'custom',
                        'message' => 'Wedding ID already exists',
                        'validate' => function () {
                            return !($this->check($this->weddingID, $this->lang));
                        },
                    ]
                ],
            ],
            'lang' => [
                'value' => $this->lang,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Language Not Supported',
                        'validate' => function () {
                            return in_array($this->lang, $this->languages);
                        },
                    ]
                ],
            ],
            'domain' => [
                'value' => $this->domain,
                'rules' => [
                    [
                        'type' => 'domain',
                        'message' => 'Invalid Domain'
                    ]
                ],
            ],
            'weddingName' => [
                'value' => $this->weddingName,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Wedding Name can't be empty",
                    ],
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Wedding Name',
                        'minLength' => 10
                    ]
                ],
            ],
            'fromRole' => [
                'value' => $this->fromRole,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "From Role can't be empty",
                    ],
                    [
                        'type' => 'custom',
                        'message' => 'Invalid from field',
                        'validate' => function () {
                            return in_array($this->fromRole, $this->fromRoles);
                        },
                    ]
                ],
            ],
            'brideName' => [
                'value' => $this->brideName,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Bride Name can't be empty",
                    ],
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Bride Name',
                        'minLength' => 3
                    ]
                ],
            ],
            'groomName' => [
                'value' => $this->groomName,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Groom Name can't be empty",
                    ],
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Groom Name',
                        'minLength' => 3
                    ]
                ],
            ],
            'brideQualifications' => [
                'value' => $this->brideQualifications,
                'rules' => [
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Bride Qualifications',
                        'minLength' => 3
                    ]
                ],
            ],
            'groomQualifications' => [
                'value' => $this->groomQualifications,
                'rules' => [
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Groom Qualifications',
                        'minLength' => 3
                    ]
                ],
            ],
            'brideBio' => [
                'value' => $this->brideBio,
                'rules' => [
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Bride Bio',
                        'minLength' => 3
                    ]
                ],
            ],
            'groomBio' => [
                'value' => $this->groomBio,
                'rules' => [
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Groom Qualifications',
                        'minLength' => 3
                    ]
                ],
            ],
            'tier' => [
                'value' => $this->tier,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Tier can't be empty",
                    ],
                    [
                        'type' => 'custom',
                        'message' => 'Invalid Tier',
                        'validate' => function () {
                            return in_array($this->tier, $this->tiers);
                        },
                    ]
                ],
            ],
            'music' => [
                'value' => $this->music,
                'rules' => [
                    [
                        'type' => 'url',
                        'message' => 'Invalid Music Track'
                    ]
                ],
            ],
            'youtube' => [
                'value' => $this->youtube,
                'rules' => [
                    [
                        'type' => 'url',
                        'message' => 'Invalid URL'
                    ],
                    [
                        'type' => 'custom',
                        'message' => 'Invalid YouTube Live URL',
                        'validate' => function () {
                            // Replace this with your validation logic for YouTube embed URL
                            return preg_match("/^(https?:\/\/)?(www\.)?(youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/", $this->youtube);
                        },
                    ]
                ],
            ],
            'phone' => [
                'value' => $this->phone,
                'rules' => [
                    [
                        'type' => 'phone',
                        'message' => 'Invalid Phone Number'
                    ],
                ],
            ],
            'host' => [
                'value' => $this->host,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Host can't be empty",
                    ],
                    [
                        'type' => 'custom',
                        'message' => 'Invalid host',
                        'validate' => function () {
                            return in_array($this->host, $this->userList);
                        },
                    ]
                ],
            ],
            'partner' => [
                'value' => $this->partner,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Invalid partner',
                        'validate' => function () {
                            return in_array($this->partner, $this->userList);
                        },
                    ]
                ],
            ],
            'manager' => [
                'value' => $this->manager,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Invalid manager',
                        'validate' => function () {
                            return in_array($this->manager, $this->userList);
                        },
                    ]
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
                'domain' => $this->domain,
                'weddingName' => $this->weddingName,
                'fromRole' => $this->fromRole,
                'brideName' => $this->brideName,
                'groomName' => $this->groomName,
                'brideQualifications' => $this->brideQualifications,
                'groomQualifications' => $this->groomQualifications,
                'brideBio' => $this->brideBio,
                'groomBio' => $this->groomBio,
                'story' => !empty($this->story) ? json_encode($this->story) : null,
                'timeline' => !empty($this->timeline) ? json_encode($this->timeline) : null,
                'hosts' => !empty($this->hosts) ? json_encode($this->hosts) : null,
                'invitation' => !empty($this->invitation) ? json_encode($this->invitation) : null,
                'template' => $this->template,
                'tier' => $this->tier,
                'music' => $this->music,
                'youtube' => $this->youtube,
                'accommodation' => !empty($this->accommodation) ? json_encode($this->accommodation) : null,
                'travel' => !empty($this->travel) ? json_encode($this->travel) : null,
                'phone' => $this->phone,
                'whatsappAPIKey' => $this->whatsappAPIKey,
                'host' => $this->host,
                'partner' => $this->partner,
                'manager' => $this->manager,
                'createdAt' => date('Y-m-d H:i:s'),
                'status' => 'pending',
            ];


            // Insert data into the 'weddings' table
            DB::connect();
            $createWedding = DB::insert('weddings', $data);
            DB::close();

            // Handle success/failure
            if ($createWedding) {
                $this->error = false;
                $this->errorMsgs['createWedding'] = '';
            } else {
                $this->error = true;
                $this->errorMsgs['createWedding'] = 'Wedding Creation Failed';
            }

            if ($this->error) {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs];
            } else {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs, 'message' => 'Wedding Creation successful'];
            }
        }
    }
    // create function ends

    // Update operation
    public function update($weddingID, $lang, array $data)
    {

        // Sanitize and assign values
        DB::connect();
        $this->weddingID = trim(DB::sanitize($weddingID));
        $this->lang = trim(DB::sanitize($data['lang'] ?? 'en'));
        $this->domain = trim(DB::sanitize($data['domain']));
        $this->weddingName = trim(DB::sanitize($data['weddingName']));
        $this->fromRole = trim(DB::sanitize($data['fromRole']));
        $this->brideName = trim(DB::sanitize($data['brideName']));
        $this->groomName = trim(DB::sanitize($data['groomName']));
        $this->brideQualifications = trim(DB::sanitize($data['brideQualifications']));
        $this->groomQualifications = trim(DB::sanitize($data['groomQualifications']));
        $this->brideBio = trim(DB::sanitize($data['brideBio']));
        $this->groomBio = trim(DB::sanitize($data['groomBio']));
        $this->story = $data['story'];
        $this->timeline = $data['timeline'];
        $this->hosts = $data['hosts'];
        $this->invitation = trim(DB::sanitize($data['invitation']));
        $this->template = trim(DB::sanitize($data['template']));
        $this->tier = trim(DB::sanitize($data['tier']));
        $this->music = trim(DB::sanitize($data['music']));
        $this->youtube = trim(DB::sanitize($data['youtube']));
        $this->accommodation = trim(DB::sanitize($data['accommodation']));
        $this->travel = trim(DB::sanitize($data['travel']));
        $this->phone = trim(DB::sanitize($data['phone']));
        $this->whatsappAPIKey = trim(DB::sanitize($data['whatsappAPIKey']));
        $this->host = trim(DB::sanitize($data['host']));
        $this->partner = trim(DB::sanitize($data['partner']));
        $this->manager = trim(DB::sanitize($data['manager']));
        $this->status = trim(DB::sanitize($data['status']));


        $this->languages = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings'
        AND COLUMN_NAME = 'lang'")->fetch()[0]);

        $this->fromRoles = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings'
        AND COLUMN_NAME = 'fromRole'")->fetch()[0]);

        $this->tiers = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings'
        AND COLUMN_NAME = 'tier'")->fetch()[0]);

        $userData = DB::select('users', 'userID', "role = 
       'host' OR role = 'user' AND status <> 'deleted'")->fetchAll();


        foreach ($userData as $user) {
            $this->userList[] = $user['userID'];
        }

        DB::close();

        $weddingData = $this->getWedding($weddingID, $lang);
        // Validation Rules

        $fields = [
            'weddingID' => [
                'value' => $this->weddingID,
                'rules' => [
                    [
                        'type' => 'eventID',
                        'message' => "Invalid Wedding ID",
                    ],
                    [
                        'type' => 'custom',
                        'message' => 'Wedding ID already exists',
                        'validate' => function () {
                            return $this->getWedding($this->weddingID, $this->lang);
                        },
                    ]
                ],
            ],
            'lang' => [
                'value' => $this->lang,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Language Not Supported',
                        'validate' => function () {
                            return in_array($this->lang, $this->languages);
                        },
                    ]
                ],
            ],
            'domain' => [
                'value' => $this->domain,
                'rules' => [
                    [
                        'type' => 'domain',
                        'message' => 'Invalid Domain'
                    ]
                ],
            ],
            'weddingName' => [
                'value' => $this->weddingName,
                'rules' => [
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Wedding Name',
                        'minLength' => 10
                    ]
                ],
            ],
            'fromRole' => [
                'value' => $this->fromRole,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Invalid from field',
                        'validate' => function () {
                            return in_array($this->fromRole, $this->fromRoles);
                        },
                    ]
                ],
            ],
            'brideName' => [
                'value' => $this->brideName,
                'rules' => [
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Bride Name',
                        'minLength' => 3
                    ]
                ],
            ],
            'groomName' => [
                'value' => $this->groomName,
                'rules' => [
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Groom Name',
                        'minLength' => 3
                    ]
                ],
            ],
            'brideBio' => [
                'value' => $this->brideBio,
                'rules' => [
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Bride Bio',
                        'minLength' => 3
                    ]
                ],
            ],
            'groomBio' => [
                'value' => $this->groomBio,
                'rules' => [
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Groom Qualifications',
                        'minLength' => 3
                    ]
                ],
            ],
            'tier' => [
                'value' => $this->tier,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Invalid Tier',
                        'validate' => function () {
                            return in_array($this->tier, $this->tiers);
                        },
                    ]
                ],
            ],
            'music' => [
                'value' => $this->music,
                'rules' => [
                    [
                        'type' => 'url',
                        'message' => 'Invalid Music Track'
                    ]
                ],
            ],
            'youtube' => [
                'value' => $this->youtube,
                'rules' => [
                    [
                        'type' => 'url',
                        'message' => 'Invalid URL'
                    ],
                    [
                        'type' => 'custom',
                        'message' => 'Invalid YouTube Live URL',
                        'validate' => function () {
                            // Replace this with your validation logic for YouTube embed URL
                            return preg_match("/^(https?:\/\/)?(www\.)?(youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/", $this->youtube);
                        },
                    ]
                ],
            ],
            'phone' => [
                'value' => $this->phone,
                'rules' => [
                    [
                        'type' => 'phone',
                        'message' => 'Invalid Phone Number'
                    ],
                ],
            ],
            'host' => [
                'value' => $this->host,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Invalid host',
                        'validate' => function () {
                            return in_array($this->host, $this->userList);
                        },
                    ]
                ],
            ],
            'partner' => [
                'value' => $this->partner,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Invalid partner',
                        'validate' => function () {
                            return in_array($this->partner, $this->userList);
                        },
                    ]
                ],
            ],
            'manager' => [
                'value' => $this->manager,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Invalid manager',
                        'validate' => function () {
                            return in_array($this->manager, $this->userList);
                        },
                    ]
                ],
            ],
        ];

        // Call the Validator::validate function
        $validate = Validator::validate($fields);

        if ($validate['error']) {
            return ['error' => $validate['error'], 'errorMsgs' => $validate['errorMsgs']];
        } else {


            if(isset($_REQUEST['hosts'])){
            $this->hosts = [

                "brideFather" => ["name" => $data['brideFather'] ?? "", "relation" => "Bride Father"],

                "groomFather" => ["name" => $data['groomFather'] ?? "", "relation" => "Groom Father"],

                "brideMother" => ["name" => $data['brideMother'] ?? "", "relation" => "Bride Mother"],

                "groomMother" => ["name" => $data['groomMother'] ?? "", "relation" => "Groom Mother"],

                "brideTagline" => $data['brideTagline'] ?? "",

                "groomTagline" => $data['groomTagline'] ?? ""
            ];
        }
            if (isset($_REQUEST['basic-details'])) {
                $this->story = [
                    "howWeMet" => str_replace("\r\n", "<br>", $data['howWeMet']),
                    "whenWeMet" => str_replace("\r\n", "<br>", $data['whenWeMet']),
                    "engagement" => str_replace("\r\n", "<br>", $data['engagement']),
                    "engagementYear" => str_replace("\r\n", "<br>", $data['engagementYear']),
                    "memorableMoments" => str_replace("\r\n", "<br>", $data['memorableMoments']),
                ];
            }

            
            // Prepare data array
            $updateData = [
                'domain' => !empty($this->domain) ? $this->domain : $weddingData['domain'],

                'weddingName' => !empty($this->weddingName) ? $this->weddingName : $weddingData['weddingName'],

                'fromRole' => !empty($this->fromRole) ? $this->fromRole : $weddingData['fromRole'],

                'brideName' => !empty($this->brideName) ? $this->brideName : $weddingData['brideName'],

                'groomName' => !empty($this->groomName) ? $this->groomName : $weddingData['groomName'],

                'brideQualifications' => !empty($this->brideQualifications) ? $this->brideQualifications : $weddingData['brideQualifications'],

                'groomQualifications' => !empty($this->groomQualifications) ? $this->groomQualifications : $weddingData['groomQualifications'],

                'brideBio' => !empty($this->brideBio) ? str_replace("\r\n", "<br>", $this->brideBio) : $weddingData['brideBio'],

                'groomBio' => !empty($this->groomBio) ? str_replace("\r\n", "<br>", $this->groomBio) : $weddingData['groomBio'],

                'story' => !empty($this->story) ? str_replace("\r\n", "<br>", json_encode($this->story)) : $weddingData['story'],

                'timeline' => !empty($this->timeline) ? str_replace("\r\n", "<br>", json_encode($this->timeline)) : $weddingData['timeline'],

                'hosts' => !empty($this->hosts) ? json_encode($this->hosts) : $weddingData['hosts'],

                'invitation' => !empty($this->invitation) ? str_replace("\r\n", "<br>", $this->invitation) : $weddingData['invitation'],

                'template' => !empty($this->template) ? $this->template : $weddingData['template'],

                'tier' => !empty($this->tier) ? $this->tier : $weddingData['tier'],

                'music' => !empty($this->music) ? $this->music : $weddingData['music'],

                'youtube' => !empty($this->youtube) ? $this->youtube : $weddingData['youtube'],

                'accommodation' => !empty($this->accommodation) ? $this->accommodation : $weddingData['accommodation'],

                'travel' => !empty($this->travel) ? $this->travel : $weddingData['travel'],

                'phone' => !empty($this->phone) ? $this->phone : $weddingData['phone'],

                'whatsappAPIKey' => !empty($this->whatsappAPIKey) ? $this->whatsappAPIKey : $weddingData['whatsappAPIKey'],

                'host' => !empty($this->host) ? $this->host : $weddingData['host'],

                'partner' => !empty($this->partner) ? $this->partner : $weddingData['partner'],

                'manager' => !empty($this->manager) ? $this->manager : $weddingData['manager'],

                'status' => !empty($this->status) ? $this->status : $weddingData['status'],

                'updatedAt' => date('Y-m-d H:i:s'),
            ];
            //return $updateData;
            // Update data into the 'weddings' table
            DB::connect();
            $updateWedding = DB::update('weddings', $updateData, "weddingID = '$this->weddingID' and lang = '$this->lang'");
            DB::close();

            // Handle success/failure
            if ($updateWedding) {
                $this->error = false;
                $this->errorMsgs['updateWedding'] = '';
            } else {
                $this->error = true;
                $this->errorMsgs['updateWedding'] = 'Wedding Updation Failed';
            }

            if ($this->error) {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs];
            } else {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs, 'message' => 'Wedding Updation successful'];
            }
        }

    }
    // Update function ends


    /**
     * Get a  wedding with weddingID.
     *
     * @param string $weddingID The weddingID of the wedding.
     * @return array The result of the select query.
     */
    public function getWedding($weddingID, $lang)
    {
        DB::connect();
        $weddingID = DB::sanitize($weddingID);
        $getWedding = DB::select('weddings', '*', "weddingID = '$weddingID' and lang='$lang' ")->fetch();
        DB::close();

        if ($getWedding)
            return $getWedding;
        else
            return ['error' => true, "errorMsgs" => ['wedding' => "Wedding Not Found"]];
    }
    // getWedding() ends



    /**
     * Deletes wedding.
     *
     * @param string $weddingID The weddingID of the wedding to be deleted.
     * @return array The result of the delete operation.
     */
    public function delete($weddingID, $lang)
    {

        $check = $this->getWedding($weddingID, $lang);

        if ($check['error']) {
            return $check;
        }

        // Delete the wedding
        DB::connect();
        $deleteWedding = DB::delete('weddings', "weddingID = '$weddingID' ");

        // also delete gallery of wedding to be deleted
        $deleteWeddingGallery = DB::delete('gallery', "weddingID = '$weddingID' ");

        // also delete guests of wedding to be deleted
        $deleteWeddingGuests = DB::delete('guests', "weddingID = '$weddingID' ");
        DB::close();

        if (!$deleteWedding) {
            return [
                'error' => true,
                'errorMsg' => 'Failed to delete wedding'
            ];
        } else {
            return [
                'error' => false,
                'errorMsg' => '',
                'message' => "$weddingID successfully deleted"
            ];
        }
    }
    //  delete() ends
}


















