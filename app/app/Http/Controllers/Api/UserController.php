<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserDtoRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     operationId="indexUser",
     *     tags={"Users"},
     *     summary="Get list of users",
     *     description="Returns list of users",
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
    public function index(UserDtoRequest $request)
    {
        if ($request->search) {
            $query = User::whereHas('posts', function (Builder $query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
            });
        } else {
            $query = User::with('posts');
        }
 
        return response()->json(
            new UserCollection($query->paginate($request->limit)),
            200
        );
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     operationId="createUser",
     *     tags={"Users"},
     *     summary="Create user",
     *     description="Create new user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             ref="#/components/schemas/UserOnly"
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
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        return response()->json([
            'success' => true,
            'message' => "User created.",
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     operationId="getUser",
     *     tags={"Users"},
     *     summary="Get user",
     *     description="Get user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="User ID",
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
     *             ref="#/components/schemas/User"
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
        $user = User::find($id);
        if (!$tag) {
            return $this->responseNotFound();
        }
        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/users",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     summary="Update user",
     *     description="Update existing user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             ref="#/components/schemas/UserOnly"
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
     *                 example="User updated."
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
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->responseNotFound();
        }

        $tag->update($request->all());

        return response()->json([
            'success' => true,
            'message' => "User ($id) updated.",
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     operationId="deleteUser",
     *     tags={"Users"},
     *     summary="Delete user",
     *     description="Delete user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="User ID",
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
     *                 example="User deleted."
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
        $user = User::find($id);
        if (!$user) {
            return $this->responseNotFound();
        }
        
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => "User ($id) deleted.",
        ], 200);
   }
}
