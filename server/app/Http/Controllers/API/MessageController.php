<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Message",
 *     type="object",
 *     title="Message",
 *     description="Schema representation of a Message object",
 *     required={"sender_id", "receiver_id", "content"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Unique identifier of the message",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="sender_id",
 *         type="integer",
 *         format="int64",
 *         description="User ID of the sender",
 *         example=101
 *     ),
 *     @OA\Property(
 *         property="receiver_id",
 *         type="integer",
 *         format="int64",
 *         description="User ID of the receiver",
 *         example=102
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         description="Content of the message",
 *         example="Hello, how are you?"
 *     ),
 *     @OA\Property(
 *         property="read_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the message was read",
 *         nullable=true,
 *         example="2021-03-10T02:10:59.000000Z"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the message was created",
 *         example="2021-03-10T02:10:59.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the message was last updated",
 *         example="2021-03-11T10:15:00.000000Z"
 *     )
 * )
 */

class MessageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/messages",
     *     tags={"Messages"},
     *     summary="Retrieve all messages",
     *     description="Returns a list of all messages in the system.",
     *     operationId="getMessages",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function index()
    {
        $messages = Message::all();
        return response()->json($messages);
    }

    /**
     * @OA\Post(
     *     path="/api/messages",
     *     tags={"Messages"},
     *     summary="Create a new message",
     *     description="Stores a new message in the database and returns the created message.",
     *     operationId="addMessage",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data required to create a new message",
     *         @OA\JsonContent(
     *             required={"sender_id", "receiver_id", "content"},
     *             @OA\Property(property="sender_id", type="integer", format="int64", description="ID of the user sending the message"),
     *             @OA\Property(property="receiver_id", type="integer", format="int64", description="ID of the user receiving the message"),
     *             @OA\Property(property="content", type="string", description="Content of the message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Message created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Message")
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
            'sender_id' => 'required|integer|exists:users,id',
            'receiver_id' => 'required|integer|exists:users,id',
            'content' => 'required|string',
        ]);

        $message = Message::create($validated);
        return response()->json($message, 201);
    }

    // Display the specified message.
    /**
     * @OA\Get(
     *     path="/api/messages/{id}",
     *     tags={"Messages"},
     *     summary="Get a specific message",
     *     description="Retrieves a specific message by its unique identifier.",
     *     operationId="getMessage",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Unique identifier of the message",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Message")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Message not found"
     *     )
     * )
     */
    public function show(Message $message)
    {
        return response()->json($message);
    }

    /**
     * @OA\Put(
     *     path="/api/messages/{id}",
     *     tags={"Messages"},
     *     summary="Update a specific message",
     *     description="Updates an existing message by its unique identifier and returns the updated message.",
     *     operationId="updateMessage",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Unique identifier of the message to be updated",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data required to update the message",
     *         @OA\JsonContent(
     *             required={"content"},
     *             @OA\Property(property="content", type="string", description="Updated content of the message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Message")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input, data validation failed"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Message not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $message->update($validated);
        return response()->json($message);
    }

    /**
     * @OA\Delete(
     *     path="/api/messages/{id}",
     *     tags={"Messages"},
     *     summary="Delete a specific message",
     *     description="Deletes a message by its unique identifier and returns no content.",
     *     operationId="deleteMessage",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Unique identifier of the message to be deleted",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content, message successfully deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Message not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return response()->json(null, 204);
    }
}
