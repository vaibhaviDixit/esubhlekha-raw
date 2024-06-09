<?php

class Gallery
{   
    protected $imageID;
    protected $imageName;
    protected $imageURL;
    protected $weddingID;
    protected $type;

    // Update operation
    public function update($data)
    {   
       
        DB::connect();
        $this->imageName = trim(DB::sanitize($data['imageName']));
        $this->imageURL = strtolower(trim(DB::sanitize($data['imageURL'])));
        $this->weddingID = trim(DB::sanitize($data['weddingID']));
        $this->type = trim(DB::sanitize($data['type']));

        DB::close();
        $this->imageID  = md5(md5($this->imageURL.$this->weddingID).md5(time().uniqid()));

        // we need single bride photo and single groom photo for each weddingID
        // so if there already exists (imageURL) for photo with particular name we have to delete that row
        
        $this->deleteOld($this->weddingID,$this->imageName);

        $data = array(
                'imageID' => $this->imageID,
                'imageName' => $this->imageName,
                'imageURL' => $this->imageURL,
                'weddingID' => $this->weddingID,
                'type' => $this->type,
                'uploadedAt' => date('Y-m-d H:i:s'),
            );


            DB::connect();
            $createGallery = DB::insert('gallery', $data);
            DB::close();

            if ($createGallery) {
                $this->error = false;
                $this->errorMsgs['createGallery'] = '';
            } else {
                $this->error = true;
                $this->errorMsgs['createGallery'] = 'Upload operation failed';
            }

            if ($this->error) {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs];
            } else {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs, 'message' => 'Uploaded successfully'];
            }

    }

    // get gallery
    public function getGallery($weddingID)
    {
        DB::connect();
        $weddingID = DB::sanitize($weddingID);
        $getGallery = DB::select('gallery', '*', "weddingID = '$weddingID' ")->fetch();
        DB::close();

        if ($getGallery)
            return $getGallery;
        else
            return ['error' => true, "errorMsgs" => ['gallery' => "Gallery Not Found"]];
    }

    // get image in gallery
    public function getGalleryImg($weddingID,$imageName)
    {
        DB::connect();
        $weddingID = DB::sanitize($weddingID);
        $getGallery = DB::select('gallery', '*', "weddingID = '$weddingID' and imageName='$imageName' ")->fetch();
        DB::close();

        if ($getGallery)
            return $getGallery;
        else
            return ['error' => true, "errorMsgs" => ['gallery' => "Gallery Not Found"]];
    }

    // get type wise image in gallery

    // event
    public function getEventGallery($weddingID)
    {
        DB::connect();
        $weddingID = DB::sanitize($weddingID);
        $getGallery = DB::select('gallery', '*', "weddingID = '$weddingID' and type='event' ")->fetchAll();
        DB::close();

        if ($getGallery)
            return $getGallery;
        else
            return ['error' => true, "errorMsgs" => ['gallery' => "Gallery Not Found"]];
    }

        // pre wedding
    public function getPreWedGallery($weddingID)
    {
        DB::connect();
        $weddingID = DB::sanitize($weddingID);
        $getGallery = DB::select('gallery', '*', "weddingID = '$weddingID' and type='gallery' ")->fetchAll();
        DB::close();

        if ($getGallery)
            return $getGallery;
        else
            return ['error' => true, "errorMsgs" => ['gallery' => "Gallery Not Found"]];
    }
    

    // delete old img
    public function deleteOld($weddingID, $imageName)
    {

        $check = $this->getGalleryImg($weddingID, $imageName);

        if ($check['error']) {
            return $check;
        }

        // Delete the gallery
        DB::connect();
        $deleteGallery = DB::delete('gallery', "weddingID = '$weddingID' and imageName='$imageName' ");
        DB::close();

        if (!$deleteGallery) {
            return [
                'error' => true,
                'errorMsg' => 'Failed to delete image'
            ];
        } else {
            return [
                'error' => false,
                'errorMsg' => '',
                'message' => "Image successfully deleted"
            ];
        }
    }
    //  deleteOld() ends

    // delete old img
    public function deleteByURL($weddingID, $url)
    {

        // Delete the gallery
        DB::connect();
        $deleteGallery = DB::delete('gallery', "weddingID = '$weddingID' and imageURL='$url' ");
        DB::close();

        if (!$deleteGallery) {
            return [
                'error' => true,
                'errorMsg' => 'Failed to delete image'
            ];
        } else {
            return [
                'error' => false,
                'errorMsg' => '',
                'message' => "Image successfully deleted"
            ];
        }
    }
    //  deleteOld() ends

}
















