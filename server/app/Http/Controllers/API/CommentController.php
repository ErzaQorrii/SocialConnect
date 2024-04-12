<!-- <?php

// namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
// use App\Models\Comment;
// use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Comment",
 *     type="object",
 *     title="Comment",
 *     description="Comment model",
 *     required={"post_id", "user_id", "content"},
 *     @OA\Property(property="id", type="integer", format="int64", description="Unique identifier for the Comment"),
 *     @OA\Property(property="post_id", type="integer", format="int64", description="ID of the post associated with the comment"),
 *     @OA\Property(property="user_id", type="integer", format="int64", description="ID of the user who made the comment"),
 *     @OA\Property(property="content", type="string", description="Text content of the comment"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the comment was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the comment was last updated")
 * )
 */

// class CommentController extends Controller
// {
    /**
     * @OA\Get(
     *     path="/comments",
     *     operationId="getComments",
     *     tags={"Comments"},
     *     summary="Retrieve all comments",
     *     description="Returns all comments from the database",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Comment")
     *         )
     *     )
     * )
     */
    // public function index() {
    //     $comments = Comment::all();
    //     return response()->json($comments);
    // }

    /**
     * @OA\Post(
     *     path="/comments",
     *     operationId="addComment",
     *     tags={"Comments"},
     *     summary="Create a new comment",
     *     description="Stores a new comment in the database",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comment created",
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     )
     * )
     */
    // public function store(Request $request) {
    //     $validated = $request->validate([
    //         'post_id' => 'required|integer|exists:posts,id',
    //         'user_id' => 'required|integer|exists:users,id',
    //         'content' => 'required|string'
    //     ]);
    //     $comment = Comment::create($validated);
    //     return response()->json($comment, 201);
    // }

    /**
     * @OA\Get(
     *     path="/comments/{id}",
     *     operationId="getComment",
     *     tags={"Comments"},
     *     summary="Retrieve a single comment",
     *     description="Returns a single comment by ID from the database",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the comment to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     )
     * )
     */
    // public function show($id) {
    //     $comment = Comment::findOrFail($id);
    //     return response()->json($comment);
    // }

    /**
     * @OA\Put(
     *     path="/comments/{id}",
     *     operationId="updateComment",
     *     tags={"Comments"},
     *     summary="Update a comment",
     *     description="Updates and returns a comment",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the comment to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     )
     * )
     */
    // public function update(Request $request, $id) {
    //     $validated = $request->validate([
    //         'content' => 'required|string'
    //     ]);
    //     $comment = Comment::findOrFail($id);
    //     $comment->update($validated);
    //     return response()->json($comment);
    // }

    /**
     * @OA\Delete(
     *     path="/comments/{id}",
     *     operationId="deleteComment",
     *     tags={"Comments"},
     *     summary="Delete a comment",
     *     description="Deletes a comment from the database",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the comment to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     )
     * )
     */
//     public function destroy($id) {
//         $comment = Comment::findOrFail($id);
//         $comment->delete();
//         return response()->json(null, 204);
//     }
// } 
