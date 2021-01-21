<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Tag;
use App\TagParentOne;
use App\TagParentTwo;
use App\TagParentThree;
use App\TagParentFour;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::where('type', 'moral')->where('is_deleted', false)->with('user')->with('parent_one')->with('parent_two')->with('parent_three')->with('parent_four')->orderBy('name')->get();

        return view('tags.index',[
            'tags' => $tags,
            'msg_success' => request()->session()->get('msg_success'),
            'msg_error' => request()->session()->get('msg_error')
        ]);
    }

    public function create(Request $request)
    {
        $tags = Tag::where('type', 'moral')->where('is_deleted', false)->with('user')->with('parent')->orderBy('name')->get();
        $tagParentOnes = TagParentOne::where('is_deleted', false)->orderBy('name')->get();
        $tagParentTwos = TagParentTwo::where('is_deleted', false)->orderBy('name')->get();
        $tagParentThrees = TagParentThree::where('is_deleted', false)->orderBy('name')->get();
        $tagParentFours = TagParentFour::where('is_deleted', false)->orderBy('name')->get();
        $tag = new Tag;
        if($request->getMethod()=='GET'){
            return view('tags.create', [
                "tags"=>$tags,
                "tagParentOnes"=>$tagParentOnes,
                "tagParentTwos"=>$tagParentTwos,
                "tagParentThrees"=>$tagParentThrees,
                "tagParentFours"=>$tagParentFours,
                "tag"=>$tag
            ]);
        }

        $tag->name = $request->input('name', '');
        $tag->parent1 = (int)$request->input('parent1', 0);
        $tag->parent2 = (int)$request->input('parent2', 0);
        $tag->parent3 = (int)$request->input('parent3', 0);
        $tag->parent4 = (int)$request->input('parent4', 0);
        $tag->users_id = Auth::user()->id;
        $tag->save();

        $request->session()->flash("msg_success", "برچسب با موفقیت افزوده شد.");
        return redirect()->route('tags');
    }

    public function edit(Request $request, $id)
    {
        $tags = Tag::where('type', 'moral')->where('is_deleted', false)->where('id', '!=', $id)->with('user')->with('parent')->orderBy('name')->get();
        $tagParentOnes = TagParentOne::where('is_deleted', false)->orderBy('name')->get();
        $tagParentTwos = TagParentTwo::where('is_deleted', false)->orderBy('name')->get();
        $tagParentThrees = TagParentThree::where('is_deleted', false)->orderBy('name')->get();
        $tagParentFours = TagParentFour::where('is_deleted', false)->orderBy('name')->get();
        $tag = Tag::where('id', $id)->where('is_deleted', false)->first();
        if($tag==null){
            $request->session()->flash("msg_error", "برچسب مورد نظر پیدا نشد!");
            return redirect()->route('tags');
        }
        if($request->getMethod()=='GET'){
            return view('tags.create', [
                "tags"=>$tags,
                "tagParentOnes"=>$tagParentOnes,
                "tagParentTwos"=>$tagParentTwos,
                "tagParentThrees"=>$tagParentThrees,
                "tagParentFours"=>$tagParentFours,
                "tag"=>$tag
            ]);
        }

        $tag->name = $request->input('name', '');
        $tag->parent1 = (int)$request->input('parent1', 0);
        $tag->parent2 = (int)$request->input('parent2', 0);
        $tag->parent3 = (int)$request->input('parent3', 0);
        $tag->parent4 = (int)$request->input('parent4', 0);
        $tag->users_id = Auth::user()->id;
        $tag->save();

        $request->session()->flash("msg_success", "برچسب با موفقیت ویرایش شد.");
        return redirect()->route('tags');
    }

    public function delete(Request $request, $id)
    {
        $tag = Tag::where('id', $id)->where('is_deleted', false)->first();
        if($tag==null){
            $request->session()->flash("msg_error", "برچسب مورد نظر پیدا نشد!");
            return redirect()->route('tags');
        }

        $tag->is_deleted = true;
        $tag->save();

        $request->session()->flash("msg_success", "برچسب با موفقیت حذف شد.");
        return redirect()->route('tags');
    }
}
