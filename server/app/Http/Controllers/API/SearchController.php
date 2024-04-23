<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/searches",
     *     tags={"Searches"},
     *     summary="Create a new search record",
     *     description="Stores a new search record with the query, optional results, and timestamp provided by the authenticated user.",
     *     operationId="storeSearch",
     *     security={{ "apiAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data needed to create a new search record",
     *         @OA\JsonContent(
     *             required={"query", "timestamp"},
     *             @OA\Property(property="query", type="string", description="The search query submitted by the user."),
     *             @OA\Property(property="results", type="string", format="json", description="The results of the search query, stored in JSON format.", nullable=true),
     *             @OA\Property(property="timestamp", type="string", format="date-time", description="The date and time when the search was performed.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Search record created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="The ID of the newly created search record."),
     *             @OA\Property(property="user_id", type="integer", description="The ID of the user who created the search record."),
     *             @OA\Property(property="query", type="string", description="The search query stored."),
     *             @OA\Property(property="results", type="string", format="json", description="The results of the search stored in JSON format."),
     *             @OA\Property(property="timestamp", type="string", format="date-time", description="The timestamp when the search was made."),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="The timestamp when the record was created."),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="The timestamp when the record was last updated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input, data validation failed"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized, user is not logged in"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */

    public function store(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'query' => 'required|string',
            'results' => 'nullable|json',
            'timestamp' => 'required|date',
        ]);

        $search = $request->user()->searches()->create($request->only(['query', 'results', 'timestamp']));
        return response()->json($search, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/searches",
     *     tags={"Searches"},
     *     summary="Retrieve all search records for the logged-in user",
     *     description="Fetches a list of all search records associated with the logged-in user.",
     *     operationId="getUserSearches",
     *     security={{ "apiAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="The ID of the search record."),
     *                 @OA\Property(property="user_id", type="integer", description="The ID of the user who performed the search."),
     *                 @OA\Property(property="query", type="string", description="The search query submitted."),
     *                 @OA\Property(property="results", type="string", format="json", description="The results of the search query, stored in JSON format."),
     *                 @OA\Property(property="timestamp", type="string", format="date-time", description="The timestamp when the search was performed."),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="The timestamp when the record was created."),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="The timestamp when the record was last updated.")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized if the user is not logged in"
     *     )
     * )
     */


    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $searches = Search::where('user_id', $userId)->get();
        return response()->json($searches);
    }

    /**
     * @OA\Get(
     *     path="/api/searches/{id}",
     *     tags={"Searches"},
     *     summary="Retrieve a specific search record",
     *     description="Fetches details of a specific search record by its ID.",
     *     operationId="getSearchById",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the search record to retrieve",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="The ID of the search record."),
     *             @OA\Property(property="user_id", type="integer", description="The ID of the user who performed the search."),
     *             @OA\Property(property="query", type="string", description="The search query submitted."),
     *             @OA\Property(property="results", type="string", format="json", description="The results of the search query, stored in JSON format."),
     *             @OA\Property(property="timestamp", type="string", format="date-time", description="The timestamp when the search was performed."),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="The timestamp when the record was created."),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="The timestamp when the record was last updated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Search not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", description="Error message indicating the search was not found.")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $search = Search::find($id);
        if (!$search) {
            return response()->json(['message' => 'Search not found'], 404);
        }
        return response()->json($search);
    }

    /**
     * @OA\Delete(
     *     path="/api/searches/{id}",
     *     tags={"Searches"},
     *     summary="Delete a specific search record",
     *     description="Deletes a specific search record by its ID, ensuring that only the owner of the record can delete it.",
     *     operationId="deleteSearch",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the search record to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Search deleted successfully, no content to return"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Search not found or access denied",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", description="Error message indicating that the search was not found or the user is not authorized to delete it.")
     *         )
     *     )
     * )
     */

    public function destroy(Request $request, $id)  // Changed from delete to destroy to follow Laravel's convention
    {
        $userId = $request->user()->id;
        $search = Search::where('user_id', $userId)->where('id', $id)->first();

        if (!$search) {
            return response()->json(['message' => 'Search not found or access denied'], 404);
        }
        $search->delete();
        return response()->json(null, 204);
    }



}
