<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = News::query()->get();
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        $status = '<span class="badge badge-success" style="font-size: 13px;">' . trans('web.active') . '</span>';
                    } else {
                        $status = '<span class="badge badge-danger" style="font-size: 13px;">' . trans('web.inactive') . '</span>';
                    }
                    return $status;
                })->editColumn('type', function ($data) {
                    if ($data->type == 1) {
                        $status =  trans('web.news');
                    } else {
                        $status =   trans('web.announcements');
                    }
                    return $status;
                })->editColumn('title', function ($data) {
                    return $data->title;
                })->editColumn('article', function ($data) {
                    return $data->article;
                })->editColumn('description', function ($data) {
                    return $data->description;
                })
                ->addColumn('actions', function ($data) {
                    $actions = '<button id="show" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_show_news">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                    <span class="svg-icon svg-icon-3">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"/>
                                                                    </svg>
																</span>
                                    <!--end::Svg Icon-->
                                </button>

                                <button id="edit" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_news">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                    <span class="svg-icon svg-icon-3">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="currentColor" />
																		<path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="currentColor" />
																	</svg>
																</span>
                                    <!--end::Svg Icon-->
                                </button>
                                <!--end::Update-->
                                <!--begin::Delete-->
                                <button id="delete" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                    <span class="svg-icon svg-icon-3">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
																		<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
																		<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
																	</svg>
																</span>
                                    <!--end::Svg Icon-->
                                </button>';

                    return $actions;

                })
                ->rawColumns(['others'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('news.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'article_en' => 'required|string',
            'article_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'type' => 'required|numeric',
            'fileupload' => 'required|mimes:jpeg,png,jpg'
        ], [
            'title_en.required' => trans("web.required"),
            'title_en.string' => trans("web.string"),
            'title_ar.required' => trans("web.required"),
            'title_ar.string' => trans("web.string"),

            'article_en.required' => trans("web.required"),
            'article_en.string' => trans("web.string"),
            'article_ar.required' => trans("web.required"),
            'article_ar.string' => trans("web.string"),

            'description_en.required' => trans("web.required"),
            'description_en.string' => trans("web.string"),
            'description_ar.required' => trans("web.required"),
            'description_ar.string' => trans("web.string"),

            'type.string' => trans("web.required"),
            'type.numeric' => trans("web.numeric"),

            'fileupload.required' => trans("web.required"),
            'fileupload.mimes' => trans("web.mimes"),

        ]);
        if ($validator->passes()) {
            $data = new News();
            $data->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
            $data->article = ['en' => $request->article_en, 'ar' => $request->article_ar];
            $data->description = ['en' => $request->description_en, 'ar' => $request->description_ar];
            $data->type = $request->type;
            $data->status = 1;
            if ($request->file('fileupload')) {
                $value = $request->file('fileupload');
                $name = time().rand(1,100).'.'.$value->extension();
                $value->move(public_path('/images/news/'), $name);
                $data->image = $name;
            }
            $data->save();



            return response()->json(['success' => $data]);
        }
        return response()->json(['error' => $validator->errors()->toArray()]);

    }

    public function show(Request $request,News $news)
    {
        if ($request->ajax()) {
            $news = News::find($news->id);
            if ($news->status == 1) {
                $status = '<span class="badge badge-success" style="font-size: 13px;">' . trans('web.active') . '</span>';
            } else {
                $status = '<span class="badge badge-danger" style="font-size: 13px;">' . trans('web.inactive') . '</span>';
            }

            if ($news->type == 1) {
                $type =  trans('web.news');
            } else {
                $type =   trans('web.announcements');
            }

            return response()->json(['news'=>$news,'status'=>$status,'type'=>$type]);
        }
    }

    public function edit(Request $request,News $news)
    {
        if ($request->ajax()) {
            $news = News::find($news->id);
            return response()->json($news);
        }
    }

    public function update(Request $request, News $news)
    {
        $validator = Validator::make($request->all(), [
            'title_en_edit' => 'required|string',
            'title_ar_edit' => 'required|string',
            'article_en_edit' => 'required|string',
            'article_ar_edit' => 'required|string',
            'description_en_edit' => 'required|string',
            'description_ar_edit' => 'required|string',
            'type_edit' => 'required|numeric',
            'status_edit' => 'required|numeric',
            'fileuploads' => $request->fileuploads != 'undefined' ? 'mimes:jpeg,jpg,png|sometimes' : '',
        ], [
            'title_en_edit.required' => trans("web.required"),
            'title_en_edit.string' => trans("web.string"),
            'title_ar_edit.required' => trans("web.required"),
            'title_ar_edit.string' => trans("web.string"),

            'article_en_edit.required' => trans("web.required"),
            'article_en_edit.string' => trans("web.string"),
            'article_ar_edit.required' => trans("web.required"),
            'article_ar_edit.string' => trans("web.string"),

            'description_en_edit.required' => trans("web.required"),
            'description_en_edit.string' => trans("web.string"),
            'description_ar_edit.required' => trans("web.required"),
            'description_ar_edit.string' => trans("web.string"),

            'type_edit.string' => trans("web.required"),
            'type_edit.numeric' => trans("web.numeric"),

            'status_edit.string' => trans("web.required"),
            'status_edit.numeric' => trans("web.numeric"),


            'fileuploads.mimes' => trans("web.mimes"),
            'fileuploads.uploaded' => trans("web.uploaded"),

        ]);
        if ($validator->passes()) {
            $data = News::find($news->id);
            $data->title = ['en' => $request->title_en_edit, 'ar' => $request->title_ar_edit];
            $data->article = ['en' => $request->article_en_edit, 'ar' => $request->description_ar_edit];
            $data->description = ['en' => $request->description_en_edit, 'ar' => $request->description_ar_edit];
            $data->type = $request->type_edit;
            $data->status = $request->status_edit;
            if ($request->input('fileuploads') != 'undefined'){
                $value = $request->file('fileuploads');
                $name = time().rand(1,100).'.'.$value->extension();
                $value->move(public_path('/images/news/'), $name);
                $data->image = $name;
            }
            $data->save();



            return response()->json(['success' => $data]);
        }
        return response()->json(['error' => $validator->errors()->toArray()]);

    }

    public function destroy(News $news)
    {
        $news = News::find($news->id)->delete();
        return response()->json(['success' => $news]);
    }
}
