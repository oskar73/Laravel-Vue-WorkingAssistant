<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Page;
use Illuminate\Http\Request;
use Validator;

class UploadController extends AdminController
{
    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function uploadCover(Request $request, $page_id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'fileCover' => 'required|image|mimes:jpeg,jpg,gif,png|max:10240',
            ]);
            if ($validation->fails()) {
                echo "<html><body onload=\"alert('Image validation is failed.')\"></body></html>";
            } else {
                if ($page_id == 0) {
                    $page = tenant()->footer;
                } else {
                    $page = $this->model->findorfail($page_id);
                }

                $file = $request->file('fileCover');
                if ($file) {
                    $name = guid().'.'.$file->getClientOriginalExtension();
                    $media = $page->addMediaFromRequest('fileCover')
                        ->usingFileName($name)
                        ->toMediaCollection();

                    echo "<html><body onload=\"parent.applyBoxImage('".$media->getUrl()."')\"></body></html>";
                } else {
                    echo "<html><body onload=\"alert('Failed to upload.')\"></body></html>";
                }
            }
        } catch (\Exception $e) {
            echo "<html><body onload=\"alert('".json_encode($e->getMessage())."')\"></body></html>";
        }
    }

    public function uploadLarageImage(Request $request, $page_id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'fileImage' => 'required|image',
            ]);

            if ($validation->fails()) {
                echo "<html><body onload=\"alert('Image validation is failed.')\"></body></html>";
            } else {
                if ($page_id == 0) {
                    $page = tenant()->footer;
                } else {
                    $page = $this->model->findorfail($page_id);
                }

                $file = $request->file('fileImage');
                if ($file) {
                    $name = guid().'.'.$file->getClientOriginalExtension();
                    $media = $page->addMediaFromRequest('fileImage')->usingFileName($name)->toMediaCollection();

                    echo "<html><body onload=\"parent.applyBoxImage('".$media->getUrl()."')\"></body></html>";
                } else {
                    echo "<html><body onload=\"alert('Failed to upload.')\"></body></html>";
                }
            }
        } catch (\Exception $e) {
            echo "<html><body onload=\"alert('".json_encode($e->getMessage())."')\"></body></html>";
        }
    }

    public function uploadModuleImage(Request $request, $page_id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'fileImage' => 'required|image|mimes:jpeg,jpg,png,gif|max:10240',
            ]);
            if ($validation->fails()) {
                echo "<html><body onload=\"alert('Image validation is failed.')\"></body></html>";
            } else {
                if ($page_id == 0) {
                    $page = tenant()->footer;
                } else {
                    $page = $this->model->findorfail($page_id);
                }

                $file = $request->file('fileImage');
                if ($file) {
                    $name = guid().'.'.$file->getClientOriginalExtension();
                    $media = $page->addMediaFromRequest('fileImage')->usingFileName($name)->toMediaCollection();

                    echo "<html><body onload=\"parent.sliderImageSaved('".$media->getUrl()."')\"></body></html>";
                } else {
                    echo "<html><body onload=\"alert('Failed to upload.')\"></body></html>";
                }
            }
        } catch (\Exception $e) {
            echo "<html><body onload=\"alert('".json_encode($e->getMessage())."')\"></body></html>";
        }
    }

    public function uploadModuleVideo(Request $request, $page_id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'fileVideo' => 'required|mimes:mp4,mov,ogg,qt,flv,3gp,avi,wmv,mpeg,mpg|max:102400',
            ]);
            if ($validation->fails()) {
                if ($validation->fails()) {
                    return response()->json(['status' => 0, 'data' => $validation->errors()]);
                }
            } else {
                if ($page_id == 0) {
                    $page = tenant()->footer;
                } else {
                    $page = $this->model->findorfail($page_id);
                }

                $file = $request->file('fileVideo');
                if ($file) {
                    $name = guid().'.'.$file->getClientOriginalExtension();
                    $media = $page->addMediaFromRequest('fileVideo')
                        ->usingFileName($name)
                        ->toMediaCollection();

                    return response()->json(['status' => 1, 'data' => $media->getUrl()]);
                } else {
                    return response()->json(['status' => 0, 'data' => ['Failed to upload']]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'data' => [json_encode($e->getMessage())]]);
        }
    }

    public function storeImage(Request $request, $page_id)
    {
        try {
            if ($page_id == 0) {
                $page = tenant()->footer;
            } else {
                $page = $this->model->findorfail($page_id);
            }

            $count = $request->get('count');
            $b64str = $request->get('hidimg-'.$count);
            $imgname = $request->get('hidname-'.$count);
            $imgtype = $request->get('hidtype-'.$count);

            if ($imgtype == 'png') {
                $name = guid().'.png';
            } else {
                $name = guid().'.jpg';
            }

            $media = $page->addMediaFromBase64($b64str)->usingFileName($name)->toMediaCollection();

            echo "<html><body onload=\"parent.document.getElementById('img-".$count."').setAttribute('src','".$media->getUrl()."');  parent.document.getElementById('img-".$count."').removeAttribute('id') \"></body></html>";
        } catch (\Exception $e) {
            echo "<html><body onload=\"alert('".json_encode($e->getMessage())."')\"></body></html>";
        }
    }

    public function image_resize($src, $dst, $width, $height, $crop = 0)
    {

        //if(!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";
        [$w, $h] = getimagesize($src);

        $type = strtolower(substr(strrchr($src, '.'), 1));
        if ($type == 'jpeg') {
            $type = 'jpg';
        }
        switch ($type) {
            case 'bmp': $img = imagecreatefromwbmp($src); break;
            case 'gif': $img = imagecreatefromgif($src); break;
            case 'jpg': $img = imagecreatefromjpeg($src); break;
            case 'png': $img = imagecreatefrompng($src); break;
            default: return 'Unsupported picture type!';
        }
        if ($w < $width or $h < $height) {
            $width = 1629;
            $height = 850;
        }
        if ($w < $width or $h < $height) {
            $width = 1533;
            $height = 800;
        }
        if ($w < $width or $h < $height) {
            $width = 1438;
            $height = 750;
        }
        if ($w < $width or $h < $height) {
            $width = 1380;
            $height = 720;
        }
        if ($w < $width or $h < $height) {
            $width = 1342;
            $height = 700;
        }
        if ($w < $width or $h < $height) {
            $width = 1246;
            $height = 650;
        }
        if ($w < $width or $h < $height) {
            $width = 1150;
            $height = 600;
        }
        if ($w < $width or $h < $height) {
            $width = 1054;
            $height = 550;
        }
        if ($w < $width or $h < $height) {
            $width = 958;
            $height = 500;
        }
        if ($w < $width or $h < $height) {
            $width = 863;
            $height = 450;
        }
        if ($w < $width or $h < $height) {
            $width = 767;
            $height = 400;
        }
        if ($w < $width or $h < $height) {
            $width = 671;
            $height = 350;
        }
        if ($w < $width or $h < $height) {
            $width = 575;
            $height = 300;
        }
        if ($w < $width or $h < $height) {
            return 'Picture is too small. Minimum dimension: 575 x 350 pixels.';
        }

        // resize
        if ($crop) {
            $ratio = max($width / $w, $height / $h);
            $h = $height / $ratio;
            $x = ($w - $width / $ratio) / 2;
            $w = $width / $ratio;
        } else {
            $ratio = min($width / $w, $height / $h);
            $width = $w * $ratio;
            $height = $h * $ratio;
            $x = 0;
        }

        $new = imagecreatetruecolor($width, $height);

        // preserve transparency
        if ($type == 'gif' or $type == 'png') {
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }

        imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

        switch ($type) {
            case 'bmp': imagewbmp($new, $dst); break;
            case 'gif': imagegif($new, $dst); break;
            case 'jpg': imagejpeg($new, $dst); break;
            case 'png': imagepng($new, $dst); break;
        }

        return true;
    }

    public function largeImage(Request $request, $page_id)
    {
        $path = storage_path('app/public/');
        $urlpath = '/media/';

        $customvalue = $request->get('hidRefId');
        //Check folder. Create if not exist
        $pagefolder = $path;
        if (! file_exists($pagefolder)) {
            mkdir($pagefolder, 0777);
        }

        //Optional: If using customvalue to specify upload folder
        if ($customvalue != '') {
            $pagefolder = $path.$customvalue.'/';
            if (! file_exists($pagefolder)) {
                mkdir($pagefolder, 0777);
            }
            $urlpath = $urlpath.$customvalue.'/';
        }

        $filename = basename($_FILES['fileImage']['name']);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES['fileImage']['tmp_name']);
        if ($check !== false) {
            //echo "File is an image - " . $check["mime"];
            $uploadOk = 1;
        } else {
            echo "<html><body onload=\"alert('File is not an image.')\"></body></html>";
            exit();
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
            echo "<html><body onload=\"alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')\"></body></html>";
            exit();
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "<html><body onload=\"alert('Sorry, your file was not uploaded.')\"></body></html>";
            exit();
        } else {
            $data = getimagesize($_FILES['fileImage']['tmp_name']);
            $width = $data[0];
            $height = $data[1];

            $random = base_convert(rand(), 10, 36).date('his');
            $pic_type = strtolower(strrchr($_FILES['fileImage']['name'], '.'));

            if ($width <= 1600) {
                move_uploaded_file($_FILES['fileImage']['tmp_name'], $pagefolder.$random.$pic_type);
            } else {
                $pic_name = "original$random$pic_type";

                move_uploaded_file($_FILES['fileImage']['tmp_name'], $pagefolder.$pic_name);

                //Save image
                if (true !== ($pic_error = $this->image_resize1($pagefolder.$pic_name, $pagefolder."$random$pic_type", 1600, 1600))) { //Resize image to max 1600x1600 to safe size
                    echo "<html><body onload=\"alert('".$pic_error."')\"></body></html>";
                    exit();
                }

                unlink($pagefolder.$pic_name); //delete original
            }

            //Replace image src with the new saved file
            echo "<html><body onload=\"parent.applyLargerImage('".$urlpath."$random$pic_type"."')\"></body></html>";
        }
    }

    public function image_resize1($src, $dst, $width, $height)
    {

        //echo "<html><body onload=\"alert('".$dst."')\"></body></html>";
        //exit();

        [$w, $h] = getimagesize($src);

        $type = strtolower(substr(strrchr($src, '.'), 1));
        if ($type == 'jpeg') {
            $type = 'jpg';
        }
        switch ($type) {
            case 'bmp': $img = imagecreatefromwbmp($src); break;
            case 'gif': $img = imagecreatefromgif($src); break;
            case 'jpg': $img = imagecreatefromjpeg($src); break;
            case 'png': $img = imagecreatefrompng($src); break;
            default: return 'Unsupported picture type!';
        }

        $ratio = min($width / $w, $height / $h);
        $width = $w * $ratio;
        $height = $h * $ratio;
        $x = 0;

        $new = imagecreatetruecolor($width, $height);

        // preserve transparency
        if ($type == 'gif' or $type == 'png') {
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }

        imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

        switch ($type) {
            case 'bmp': imagewbmp($new, $dst); break;
            case 'gif': imagegif($new, $dst); break;
            case 'jpg': imagejpeg($new, $dst); break;
            case 'png': imagepng($new, $dst); break;
        }

        return true;
    }

    public function moduleImage(Request $request, $page_id)
    {
        $path = storage_path('app/public/');
        $urlpath = '/media/';

        //Get customvalue
        $customvalue = $_REQUEST['hidCustomVal']; //Custom value (optional). If you set "customval" parameter in ContentBuilder, the value can be read here.

        //Check folder. Create if not exist
        $pagefolder = $path;
        if (! file_exists($pagefolder)) {
            mkdir($pagefolder, 0777);
        }
        //Optional: If using customvalue to specify upload folder
        if ($customvalue != '') {
            $pagefolder = $path.$customvalue.'/';
            if (! file_exists($pagefolder)) {
                mkdir($pagefolder, 0777);
            }
            $urlpath = $urlpath.$customvalue.'/';
        }
        $filename = basename($_FILES['fileImage']['name']);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES['fileImage']['tmp_name']);
        if ($check !== false) {
            //echo "File is an image - " . $check["mime"];
            $uploadOk = 1;
        } else {
            echo "<html><body onload=\"alert('File is not an image.')\"></body></html>";
            exit();
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
            echo "<html><body onload=\"alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')\"></body></html>";
            exit();
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "<html><body onload=\"alert('Sorry, your file was not uploaded.')\"></body></html>";
            exit();
        } else {
            $data = getimagesize($_FILES['fileImage']['tmp_name']);
            $width = $data[0];
            $height = $data[1];

            $random = base_convert(rand(), 10, 36).date('his');
            $pic_type = strtolower(strrchr($_FILES['fileImage']['name'], '.'));

            if ($width <= 1600) {
                move_uploaded_file($_FILES['fileImage']['tmp_name'], $pagefolder.$random.$pic_type);
            } else {
                $pic_name = "original$random$pic_type";

                move_uploaded_file($_FILES['fileImage']['tmp_name'], $pagefolder.$pic_name);

                //Save image
                if (true !== ($pic_error = $this->image_resize1($pagefolder.$pic_name, $pagefolder."$random$pic_type", 1600, 1600))) { //Resize image to max 1600x1600 to safe size
                    echo "<html><body onload=\"alert('".$pic_error."')\"></body></html>";
                    exit();
                }

                unlink($pagefolder.$pic_name); //delete original
            }

            //Replace image src with the new saved file
            echo "<html><body onload=\"parent.sliderImageSaved('".$urlpath."$random$pic_type"."')\"></body></html>";
        }
    }

    public function saveImage(Request $request, $page_id)
    {
        $path = storage_path('app/public/');
        $urlpath = '/media/';

        $count = $request->get('count');
        $b64str = $request->get('hidimg-'.$count);
        $imgname = $request->get('hidname-'.$count);
        $imgtype = $request->get('hidtype-'.$count);

        $customvalue = $request->get('hidcustomval-'.$count); //Get customvalue

        if ($imgtype == 'png') {
            $image = $imgname.'-'.base_convert(rand(), 10, 36).'.png';
        } else {
            $image = $imgname.'-'.base_convert(rand(), 10, 36).'.jpg';
        }
        //Check folder. Create if not exist
        $pagefolder = $path;
        if (! file_exists($pagefolder)) {
            mkdir($pagefolder, 0777);
        }
        //Optional: If using customvalue to specify upload folder
        if ($customvalue != '') {
            $pagefolder = $path.$customvalue.'/';
            if (! file_exists($pagefolder)) {
                mkdir($pagefolder, 0777);
            }
            $urlpath = $urlpath.$customvalue.'/';
        }
        $success = file_put_contents($pagefolder.$image, base64_decode($b64str));
        if ($success === false) {
            if (! file_exists($path)) {
                echo "<html><body onload=\"alert('Saving image to folder failed. Folder ".$pagefolder." not exists.')\"></body></html>";
            } else {
                echo "<html><body onload=\"alert('Saving image to folder failed. Please check write permission on ".$pagefolder."')\"></body></html>";
            }
        } else {
            //Replace image src with the new saved file
            echo "<html><body onload=\"parent.document.getElementById('img-".$count."').setAttribute('src','".$urlpath.$image."');  parent.document.getElementById('img-".$count."').removeAttribute('id') \"></body></html>";
        }
    }
}
