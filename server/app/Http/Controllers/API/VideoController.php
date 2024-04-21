<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;



/**
 * @OA\Schema(
 *     schema="Video",
 *     type="object",
 *     title="Video",
 *     description="The Video model schema",
 *     required={"user_id", "title", "description", "file_path"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Unique identifier for the Video",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         format="int64",
 *         description="Foreign key referencing User",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title of the Video",
 *         example="A Day in the Life"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the Video",
 *         example="A detailed description of what the video is about."
 *     ),
 *     @OA\Property(
 *         property="file_path",
 *         type="string",
 *         description="Path to the video file",
 *         example="/videos/day-in-the-life.mp4"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the video was created",
 *         readOnly=true,
 *         example="2021-03-10T02:10:59.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the video was last updated",
 *         readOnly=true,
 *         example="2021-03-11T10:15:00.000000Z"
 *     )
 * )
 */
class VideoController extends Controller
{
    // Display a listing of the videos.
    /**
     * @OA\Get(
     *     path="/api/videos",
     *     operationId="getVideos",
     *     tags={"Videos"},
     *     summary="Display a listing of the videos.",
     *     description="Retrieves and returns all videos from the database.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Video")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function index()
    {
        $video = Video::all();
        return response()->json($video, 201);
    }

    // Store a newly created video in the database.
    /**
     * @OA\Post(
     *     path="/api/videos",
     *     operationId="addVideo",
     *     tags={"Videos"},
     *     summary="Store a newly created video in the database.",
     *     description="Accepts video data and stores it, returning the stored video data.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data required to create a new video",
     *         @OA\JsonContent(
     *             required={"user_id", "title", "description", "file_path"},
     *             @OA\Property(property="user_id", type="integer", format="int64", description="User ID who is creating the video", example=1),
     *             @OA\Property(property="title", type="string", description="Title of the video", example="My Summer Vacation"),
     *             @OA\Property(property="description", type="string", description="Description of the video", example="Video from my summer vacation in Hawaii."),
     *             @OA\Property(property="file_path", type="string", description="File path of the video", example="/uploads/videos/summer_vacation.mp4")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Video successfully created",
     *         @OA\JsonContent(ref="#/components/schemas/Video")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input, data validation failed"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'required|string'
        ]);

        $video = Video::create($validated);
        return response()->json($video, 201);
    }

    // Display the specified video.
    /**
     * @OA\Get(
     *     path="/api/videos/{id}",
     *     operationId="getVideo",
     *     tags={"Videos"},
     *     summary="Display a specific video.",
     *     description="Retrieves and returns data for a single video based on its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the video to retrieve",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Video")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Video not found"
     *     )
     * )
     */
    public function show(Video $video)
    {
        return response()->json($video);    }

    // Update the specified video in the database.
    /**
     * @OA\Put(
     *     path="/api/videos/{id}",
     *     operationId="updateVideo",
     *     tags={"Videos"},
     *     summary="Update a specific video.",
     *     description="Updates an existing video and returns the updated video data.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the video to update",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data required to update the video",
     *         @OA\JsonContent(
     *             required={"user_id", "title", "description", "file_path"},
     *             @OA\Property(property="user_id", type="integer", format="int64", description="User ID who owns the video", example=1),
     *             @OA\Property(property="title", type="string", description="Title of the video", example="My Summer Vacation Updated"),
     *             @OA\Property(property="description", type="string", description="Description of the video", example="Updated description of the video from my summer vacation in Hawaii."),
     *             @OA\Property(property="file_path", type="string", description="New file path of the video", example="/uploads/videos/updated_summer_vacation.mp4")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Video successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/Video")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input, data validation failed"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Video not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'required|string'
        ]);

        $video->update($validated);
        return response()->json($video);
    }

    // Remove the specified video from the database.
    /**
     * @OA\Delete(
     *     path="/api/videos/{id}",
     *     operationId="deleteVideo",
     *     tags={"Videos"},
     *     summary="Delete a specific video.",
     *     description="Deletes a video from the database by its ID and returns no content.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the video to delete",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content, video successfully deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Video not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function destroy(Video $video)
    {
        $video->delete();
        return response()->json(null, 204);
    }
}
