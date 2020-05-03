<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\RealWorld\Paginate\Paginate;
use App\RealWorld\Filters\ArticleFilter;
use App\Http\Requests\Api\CreateArticle;
use App\Http\Requests\Api\UpdateArticle;
use App\Http\Requests\Api\DeleteArticle;
use App\RealWorld\Transformers\ArticleTransformer;
use App\Services\ArticleServiceInterface;

class ArticleController extends ApiController
{
    private $articleService;

    /**
     * ArticleController constructor.
     *
     * @param ArticleTransformer $transformer
     */
    public function __construct(ArticleServiceInterface $articleService,
                                ArticleTransformer $transformer)
    {
        $this->articleService = $articleService;
        $this->transformer = $transformer;

        $this->middleware('jwt.auth')->except(['index', 'show']);
        $this->middleware('jwt.auth:optional')->only(['index', 'show']);
        $this->middleware('auth.active')->only(['store', 'update', 'destroy']);
    }

    /**
     * Get all the articles.
     *
     * @param ArticleFilter $filter
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ArticleFilter $filter)
    {
        $articles = new Paginate(Article::loadRelations()->filter($filter));

        return $this->respondWithPagination($articles);
    }

    /**
     * Create a new article and return the article if successful.
     *
     * @param CreateArticle $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateArticle $request)
    {
        $user = auth()->user();

        $article = $this->articleService->createArticle($user, $request);

        return $this->respondWithTransformer($article);
    }

    /**
     * Get the article given by its slug.
     *
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Article $article)
    {
        return $this->respondWithTransformer($article);
    }

    /**
     * Update the article given by its slug and return the article if successful.
     *
     * @param UpdateArticle $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateArticle $request, Article $article)
    {
        if ($request->has('article')) {
            $article->update($request->get('article'));
        }

        return $this->respondWithTransformer($article);
    }

    /**
     * Delete the article given by its slug.
     *
     * @param DeleteArticle $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteArticle $request, Article $article)
    {
        $article->delete();

        return $this->respondSuccess();
    }
}
