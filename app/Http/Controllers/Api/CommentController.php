<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Comment;
use App\Http\Requests\Api\CreateComment;
use App\Http\Requests\Api\DeleteComment;
use App\RealWorld\Transformers\CommentTransformer;
use App\Services\CommentServiceIterface;

class CommentController extends ApiController
{
    private $commentServiceIterface;

    /**
     * CommentController constructor.
     *
     * @param CommentTransformer $transformer
     */
    public function __construct(CommentServiceIterface $commentServiceIterface,
                                CommentTransformer $transformer)
    {
        $this->commentServiceIterface = $commentServiceIterface;
        $this->transformer = $transformer;

        $this->middleware('jwt.auth')->except(['index']);
        $this->middleware('jwt.auth:optional')->only(['index']);
        $this->middleware('auth.active')->only(['store', 'destroy']);
    }

    /**
     * Get all the comments of the article given by its slug.
     *
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Article $article)
    {
        $comments = $article->comments()->get();

        return $this->respondWithTransformer($comments);
    }

    /**
     * Add a comment to the article given by its slug and return the comment if successful.
     *
     * @param CreateComment $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateComment $request, Article $article)
    {
        $comment = $this->commentServiceIterface->createComment($article, $request);

        return $this->respondWithTransformer($comment);
    }

    /**
     * Delete the comment given by its id.
     *
     * @param DeleteComment $request
     * @param $article
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteComment $request, $article, Comment $comment)
    {
        $comment->delete();

        return $this->respondSuccess();
    }
}
