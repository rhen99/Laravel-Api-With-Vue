<?php

namespace App\Http\Controllers;
use App\Article;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);

        return ArticleResource::collection($articles);
    }

   
    
    public function store(Request $request)
    {
        $article =  $request->isMethod('put') ? Article::findOrFail($request->article_id) : new Article;

        $article->title = $request->input('title');
        $article->body = $request->input('body');
        $article->author = $request->input('author');
        $article->id = $request->input('article_id');
        if($article->save()){
            return new ArticleResource($article);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $article = Article::findOrFail($id);

        return new ArticleResource($article);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $article = Article::findOrFail($id);

        if($article->delete()){
            return new ArticleResource($article);
        }
    }
}
