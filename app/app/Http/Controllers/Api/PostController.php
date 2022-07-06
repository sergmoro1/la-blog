<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostDtoRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;

class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/index",
     *     operationId="getPostList",
     *     tags={"Posts"},
     *     summary="Get list of posts",
     *     description="Returns list of posts",
     *     @OA\Parameter(
     *         name="tags[]",
     *         in="query",
     *         description="tag to filter by",
     *         required=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(type="string")
     *         ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="maximum number of results to return",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")
     *         )
     *     )
     * )
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostDtoRequest $request)
    {
        if ($request->tags) {
            $query = Post::whereHas('tags', function (Builder $query) use ($request) {
                $query->whereIn('name', $request->tags);
            });
        } else {
            $query = Post::with('tags');
        }
        
        return response()->json(
            new PostCollection($query->paginate($request->limit)),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = Post::create($request->all());
        return response()->json([
            'success' => true,
            'data' => new PostResource($post),
        ], 200);
    }

    /**
     * Get the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return responseNotFound();
        }
        return response()->json([
            'success' => true,
            'data' => new PostResource($post),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return responseNotFound();
        }

        $post->update($request->all());

        return response()->json([
            'success' => true,
            'data' => new PostResource($post),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return responseNotFound();
        }

        $post->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
   }

    /**
     * Prepare NotFound response.
     *
     * @return \Illuminate\Http\Response
     */
    protected function responseNotFound() {
        return response()->json([
            'success' => false,
            'message' => 'Not found.', 
        ], 404);
    }
}
