<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Meta;

class MetaController extends Controller {

    public function index() {
        return view('admin.pages.seo.index')->with($this->data);
    }

    public function getUpdate($id = 0) {
        $meta = Meta::withTrashed()->find($id);

        if(is_null($meta)) {
            if($id != 0) {
                abort(404);
            }

            $article_url = '';
            $title = '';
            $description = '';
            $keywords = '';
            $image = '';
            $type = '';
        } else {
            $article_url = $meta->url;
            $title = $meta->title;
            $description = $meta->description;
            $keywords = $meta->keywords;
            $image = $meta->image;
            $type = $meta->type;
        }

        if(old('article_url')) {
            $article_url = old('article_url');
        }
        if(old('title')) {
            $title = old('title');
        }
        if(old('description')) {
            $description = old('description');
        }
        if(old('keywords')) {
            $keywords = old('keywords');
        }
        if(old('image')) {
            $image = old('image');
        }
        if(old('type')) {
            $type = old('type');
        }

        $this->data['id'] = $id;
        $this->data['article_url'] = $article_url;
        $this->data['title'] = $title;
        $this->data['description'] = trim($description);
        $this->data['keywords'] = $keywords;
        $this->data['image'] = $image;
        $this->data['type'] = $type;

        return view('admin.pages.seo.update')->with($this->data);
    }

    public function postUpdate(Request $request, $id = 0) {
        $data = array(
            'url' => trim($request->article_url, '/'),
            'title' => $request->title,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'image' => $request->image,
            'type' => $request->type
        );

        $meta = Meta::withTrashed()->find($id);

        if(is_null($meta)) {
            if($id != 0) {
                abort(404);
            }

            $meta_check = Meta::withTrashed()->where('url', $data['url'])->first();

            if(!is_null($meta_check)) {
                return back()->withErrors(['fail' => 'URL is exists']);
            }

            $result = Meta::create($data);
        } else {
            $result = $meta->update($data);
        }

        if($result) {
            return redirect()->route('get_seo_meta_index_ad_route');
        } else {
            return back()->withErrors(['fail' => 'Have Errors while proccessing...']);
        }
    }

    public function postDelete(Request $request) {
        $id = $request->id;

        $meta = Meta::withTrashed()->find($id);

        if(!is_null($meta)) {
            $meta->forceDelete();

            return response()->json(['result' => 1]);
        }
        return response()->json(['result' => 0]);
    }

    public function loadDataTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'url',
            2 => 'info',
            4 => 'action'
        );

        $totalData = Meta::withTrashed()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {
            $meta_list = Meta::withTrashed();
        } else {
            $search = $request->input('search.value');

            $meta_list =  Meta::withTrashed()
            ->where('id','LIKE',"%{$search}%")
            ->orWhere('url', 'LIKE',"%{$search}%")
            ->orWhere('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}")
            ->orWhere('image', 'LIKE', "%{$search}")
            ->orWhere('type', 'LIKE', "%{$search}")
            ->orWhere('keywords', 'LIKE', "%{$search}");

            $totalFiltered = Meta::withTrashed() ->where('id','LIKE',"%{$search}%")
            ->orWhere('url', 'LIKE',"%{$search}%")
            ->orWhere('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}")
            ->orWhere('image', 'LIKE', "%{$search}")
            ->orWhere('type', 'LIKE', "%{$search}")
            ->orWhere('keywords', 'LIKE', "%{$search}")
            ->count();
        }

        $meta_list = $meta_list->orderBy($order, $dir)->offset($start)->limit($limit)->get();

        $data = array();

        if(!empty($meta_list)) {
            foreach ($meta_list as $item) {
                $nestedData['id']  = $item->id;
                $nestedData['url'] = '<a href="'.$item->url.'" target="_blank">'.$item->url.'</a>';

                if(empty($item->title)) {
                    $html = ' <button class="btn btn-danger">Title</button>';
                } else {
                    $html = ' <button data-toggle="tooltip" title="'.$item->title.'" class="btn btn-success">Title</button>';
                }
                if(empty($item->description)) {
                    $html .= ' <button class="btn btn-danger">Description</button>';
                } else {
                    $html .= ' <button data-toggle="tooltip" title="'.$item->description.'" class="btn btn-success">Description</button>';
                }
                if(empty($item->keywords)) {
                    $html .= ' <button class="btn btn-danger">Keywords</button>';
                } else {
                    $html .= ' <button data-toggle="tooltip" title="'.$item->keywords.'" class="btn btn-success">Keywords</button>';
                }
                if(empty($item->image)) {
                    $html .= ' <button class="btn btn-danger">Image</button>';
                } else {
                    $html .= ' <button data-toggle="tooltip" title="'.$item->image.'" class="btn btn-success">Image</button>';
                }
                if(empty($item->type)) {
                    $html .= ' <button class="btn btn-danger">Type</button>';
                } else {
                    $html .= ' <button data-toggle="tooltip" title="'.$item->type.'" class="btn btn-success">'.$item->type.'</button>';
                }
                $nestedData['info'] = $html;

                $html = '<a class="mx-1" href="'.route('get_seo_meta_edit_ad_route', ['id' => $item->id]).'">';
                $html.= '   <i class="fas fa-edit text-primary"></i>';
                $html.= '</a>';
                $html.= '<a class="mx-1 delete-btn" href="#" data-id="'.$item->id.'">';
                $html.= '   <i class="fas fa-trash-alt text-danger"></i>';
                $html.= '</a>';
                $nestedData['action'] = $html;


                $data[] = $nestedData;
            }
        }
        $json_data = array(
            'draw'              => intval($request->draw),
            'recordsTotal'      => intval($totalData),
            'recordsFiltered'   => intval($totalFiltered),
            'data'              => $data
        );

        return response()->json($json_data);
    }
}
