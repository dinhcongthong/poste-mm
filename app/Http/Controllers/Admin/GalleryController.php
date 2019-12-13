<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Config;

use App\Models\Gallery;
use App\Models\Param;
use App\Models\ImageFactory;

use App\Http\Requests\GalleryRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    /*
    Index Page Gallery Management
    */
    public function index(Request $request) {
        $id = $request->id ? $request->id : '';
        $name = $request->name ? $request->name : '';
        $tag = $request->tag ? $request->tag : '';

        $galleryTags = Param::getListShowOnGallery();
        $galleryList = Gallery::getGalleryList($id, $name, $tag, $paginateSize = 24);

        $this->data['galleryList'] = $galleryList;
        $this->data['galleryTags'] = $galleryTags;
        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['tag'] = $tag;

        return view('admin.pages.gallery.index')->with($this->data);
    }

    /*
    */
    public function getUpdate() {
        $galleryTags = Param::getListShowOnGallery();
        $dimensionList = Config::get('image.dimensions');

        $this->data['galleryTags'] = $galleryTags;
        $this->data['dimensionList'] = $dimensionList;

        return view('admin.pages.gallery.add')->with($this->data);
    }

    public function postUpdate(GalleryRequest $request) {
        $tag = $request->tag;
        $dimension = $request->dimension;

        $tagItem = Param::getParamItem($tag);

        if($request->hasFile('fileImages')) {
            $imgFiles = $request->fileImages;

            $file_url_arr = Gallery::uploadImage($imgFiles, $tagItem->news_type, $tagItem->tag_type, $dimension, false);

            if(!$file_url_arr) {
                return back()->with(['result' => false, 'error' => 'Invalid Image']);
            } else {
                return redirect()->route('get_gallery_index_ad_route');
            }
        } else {
            return back()->with(['result' => false, 'error' => 'Don\t have any Image']);
        }
    }

    public function getDelete($id) {
        $gallery = Gallery::withTrashed()->with([
            'getNews', 'getNewsByContent', 'getCategories', 'getMovies',
            'getTheaters', 'getAds', 'getGolfs', 'getGolfByImage',
            'getPersonalFirstImage', 'getPersonalSecondImage',
            'getBullboardFirstImage', 'getBullboardSecondImage',
            'getRealEstateFirstImage', 'getRealEstateSecondImage',
            'getUserAvatar', 'getPosteTowns', 'getFoodImageTown', 'getBusinessListFromAvatar',
            'getBusinessListFromAvatar', 'getBusinessListFromPrimaryMap',
            'getBusinessMapList', 'getBusinessGalleries'
        ])->find($id);

        if(is_null($gallery)) {
            return redirect()->route('get_gallery_index_ad_route');
        }

        $this->data['gallery'] = $gallery;

        $this->data['newsThumbnailList'] = $gallery->getNews;

        $this->data['newsImageList'] = $gallery->getNewsByContent;

        $this->data['categoryList'] = $gallery->getCategories;

        $this->data['movieList'] = $gallery->getMovies;

        $this->data['theaterList'] = $gallery->getTheaters;

        $this->data['adList'] = $gallery->getAds;

        $this->data['golfList'] = $gallery->getGolfs;

        $this->data['golfImageList'] = $gallery->getGolfByImage;

        $this->data['personalFirstImages'] = $gallery->getPersonalFirstImage;

        $this->data['personalSecondImages'] = $gallery->getPersonalSecondImage;

        $this->data['bullboardFirstImage'] = $gallery->getBullboardFirstImage;

        $this->data['bullboardSecondImage'] = $gallery->getBullboardSecondImage;

        $this->data['realEstateFirstImage'] = $gallery->getRealEstateFirstImage;

        $this->data['realEstateSecondImage'] = $gallery->getRealEstateSecondImage;

        $this->data['userAvatar'] = $gallery->getUserAvatar;

        $this->data['posteTown'] = $gallery->getPosteTowns;

        $this->data['foodImageTown'] = $gallery->getFoodImageTown;

        $this->data['businessListFromAvatar'] = $gallery->getBusinessListFromAvatar;

        $this->data['businessListFormPrimaryMap'] = $gallery->getBusinessListFromPrimaryMap;

        $this->data['businessMapList'] = $gallery->getBusinessMapList;

        $this->data['businessGalleries'] = $gallery->getBusinessGalleries;

        return view('admin.pages.gallery.delete')->with($this->data);
    }

    public function postDelete($id) {
        $result = Gallery::deleteFile($id, true);

        if($result) {
            return redirect()->route('get_gallery_index_ad_route');
        } else {
            return redirect()->back()->with(['error' => 'Something is wrong']);
        }
    }
}
