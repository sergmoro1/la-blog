<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Requests\TagDtoRequest;
use App\Http\Resources\TagResource;
use App\Http\Resources\TagCollection;

class TagController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tags",
     *     operationId="indexTag",
     *     tags={"Tags"},
     *     summary="Get list of tags",
     *     description="Returns list of tags",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="search string",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *         ),
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
     *             @OA\Items(ref="#/components/schemas/Tag")
     *         )
     *     )
     * )
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TagDtoRequest $request)
    {
        if ($request->search) {
            $query = Tag::whereHas('posts', function (Builder $query) use ($request) {
                $query->where('name', 'like', '%'.$request->tags.'%');
            });
        } else {
            $query = Tag::with('posts');
        }
 
        return response()->json(
            new TagCollection($query->paginate($request->limit)),
            200
        );
    }

    /**
     * @OA\Post(
     *     path="/api/tags",
     *     operationId="createTag",
     *     tags={"Tags"},
     *     summary="Create tag",
     *     description="Create new tag",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             ref="#/components/schemas/TagOnly"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example="true"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Tag created."
     *             )
     *         )
     *     )
     * )
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $tag = Tag::create($request->all());
        return response()->json([
            'success' => true,
            'message' => "Tag created.",
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/tags/{id}",
     *     operationId="getTag",
     *     tags={"Tags"},
     *     summary="Get tag",
     *     description="Get tag by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Tag ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Tag"
     *         )
     *     )
     * )
     * 
     * Get the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return $this->responseNotFound();
        }
        return response()->json([
            'success' => true,
            'data' => new TagResource($tag),
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/tags",
     *     operationId="updateTag",
     *     tags={"Tags"},
     *     summary="Update tag",
     *     description="Update existing tag",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             ref="#/components/schemas/TagOnly"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example="true"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Tag updated."
     *             )
     *         )
     *     )
     * )
     * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return $this->responseNotFound();
        }

        $tag->update($request->all());

        return response()->json([
            'success' => true,
            'message' => "Tag ($id) updated.",
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/tags/{id}",
     *     operationId="deleteTag",
     *     tags={"Tags"},
     *     summary="Delete tag",
     *     description="Delete tag by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Tag ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example="true"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Tag deleted."
     *             )
     *         )
     *     )
     * )
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return $this->responseNotFound();
        }
        
        $tag->delete();
        
        return response()->json([
            'success' => true,
            'message' => "Tag ($id) deleted.",
        ], 200);
   }
}
