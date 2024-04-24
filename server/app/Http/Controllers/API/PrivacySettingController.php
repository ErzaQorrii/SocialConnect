<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PrivacySetting;
use Illuminate\Http\Request;
/**
 * @OA\Schema(
 *     schema="PrivacySetting",
 *     type="object",
 *     title="Privacy Setting",
 *     description="A model for storing user privacy settings",
 *     required={"id", "user_id", "setting_type", "setting_value"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier for the privacy setting"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         format="int64",
 *         description="The ID of the user to whom the privacy setting belongs"
 *     ),
 *     @OA\Property(
 *         property="setting_type",
 *         type="string",
 *         description="The type of privacy setting",
 *         example="profile_visibility"
 *     ),
 *     @OA\Property(
 *         property="setting_value",
 *         type="string",
 *         description="The value of the privacy setting",
 *         example="public"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time at which the privacy setting was created",
 *         example="2021-04-03T10:15:30+01:00"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time at which the privacy setting was last updated",
 *         example="2021-04-03T10:15:30+01:00"
 *     )
 * )
 */

class PrivacySettingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/privacy-settings",
     *     tags={"Privacy Settings"},
     *     summary="Retrieve User Privacy Settings",
     *     description="Fetches all privacy settings for the authenticated user.",
     *     operationId="getPrivacySettings",
     *     security={{ "apiAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="ID of the privacy setting"),
     *                 @OA\Property(property="user_id", type="integer", description="User ID who owns the setting"),
     *                 @OA\Property(property="setting_type", type="string", description="Type of the privacy setting"),
     *                 @OA\Property(property="setting_value", type="string", description="Value of the privacy setting"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the setting was created"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the setting was updated")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Unauthorized access message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Unexpected error")
     *         )
     *     )
     * )
     */

    public function index(Request $request)
    {
        $user = $request->user();
        return response()-json($user->privacySettings);
    }

    /**
     * @OA\Post(
     *     path="/api/privacy-settings",
     *     tags={"Privacy Settings"},
     *     summary="Create a new privacy setting",
     *     description="Allows authenticated users to create a new privacy setting.",
     *     operationId="createPrivacySetting",
     *     security={{ "apiAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data required to create a new privacy setting",
     *         @OA\JsonContent(
     *             required={"setting_type", "setting_value"},
     *             @OA\Property(property="setting_type", type="string", description="Type of the privacy setting"),
     *             @OA\Property(property="setting_value", type="string", description="Value of the privacy setting")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Privacy setting created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID of the newly created privacy setting"),
     *             @OA\Property(property="user_id", type="integer", description="User ID who owns the setting"),
     *             @OA\Property(property="setting_type", type="string", description="Type of the privacy setting"),
     *             @OA\Property(property="setting_value", type="string", description="Value of the privacy setting"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the setting was created"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the setting was updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Validation error messages")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Unauthorized access message")
     *         )
     *     )
     * )
     */

    public function store(Request $request)
    {
        $request->validate([
           'setting_type' => 'required|string',
           'setting_value' => 'required|string'
        ]);
        $setting = $request->user()->privacySettings()->create([
            'setting_type' => $request->setting_type,
            'setting_value' => $request->setting_value
        ]);

        return response()->json($setting, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/privacy-settings/{id}",
     *     tags={"Privacy Settings"},
     *     summary="Get a specific privacy setting",
     *     description="Retrieves details of a specific privacy setting by its unique ID.",
     *     operationId="getPrivacySetting",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the privacy setting to retrieve",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID of the privacy setting"),
     *             @OA\Property(property="user_id", type="integer", description="User ID who owns the setting"),
     *             @OA\Property(property="setting_type", type="string", description="Type of the privacy setting"),
     *             @OA\Property(property="setting_value", type="string", description="Value of the privacy setting"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the setting was created"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the setting was updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Privacy setting not found")
     *         )
     *     )
     * )
     */

    public function show($id)
    {
        $setting = PrivacySetting::findOrFail($id);
        return response()->json($setting);
    }


    /**
     * @OA\Put(
     *     path="/api/privacy-settings/{id}",
     *     tags={"Privacy Settings"},
     *     summary="Update a specific privacy setting",
     *     description="Updates the value of a specific privacy setting for the authenticated user.",
     *     operationId="updatePrivacySetting",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the privacy setting to update",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data required to update the privacy setting",
     *         @OA\JsonContent(
     *             required={"setting_value"},
     *             @OA\Property(property="setting_value", type="string", description="New value of the privacy setting")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Privacy setting updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID of the privacy setting"),
     *             @OA\Property(property="user_id", type="integer", description="User ID who owns the setting"),
     *             @OA\Property(property="setting_type", type="string", description="Type of the privacy setting"),
     *             @OA\Property(property="setting_value", type="string", description="Updated value of the privacy setting"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the setting was created"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the setting was updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Privacy setting not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Validation error messages")
     *         )
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'setting_value' => 'required|string'
        ]);

        $setting = PrivacySetting::where('user_id', $request->user()->id)->findOrFail($id);
        $setting->update([
            'setting_value' => $request->setting_value
        ]);

        return response()->json($setting);
    }

    /**
     * @OA\Delete(
     *     path="/api/privacy-settings/{id}",
     *     tags={"Privacy Settings"},
     *     summary="Delete a specific privacy setting",
     *     description="Deletes a specific privacy setting based on the ID provided. This operation is irreversible.",
     *     operationId="deletePrivacySetting",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the privacy setting to delete",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Content - Successfully deleted the privacy setting."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found - The privacy setting could not be found.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Privacy setting not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - User is not authenticated or lacks permission for this action.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Unauthorized access or operation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error - Error during the process of deletion.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Internal server error")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        $setting = PrivacySetting::findOrFail($id);
        $setting->delete();

        return response()->json(null, 204);


    }
    /**
     * @OA\Post(
     *     path="/api/apply-template",
     *     tags={"Privacy Settings"},
     *     summary="Apply privacy template settings",
     *     description="Apply privacy template settings to a user's account based on the provided template.",
     *     operationId="applyTemplate",
     *     security={{ "apiAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         description="The privacy template to apply",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 example={"type1": "value1", "type2": "value2", "type3": "value3"},
     *                 additionalProperties={"type": "string"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="privacySettings",
     *                 type="object",
     *                 description="The updated privacy settings of the user",
     *                 additionalProperties={"type": "string"}
     *             ),
     *             example={"type1": "value1", "type2": "value2", "type3": "value3"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request. Invalid input provided."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. User is not authenticated.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Unauthorized access or operation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error. Something went wrong on the server side.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Internal server error")
     *         )
     *     )
     * )
     */




    public function applyTemplate(Request $request)
    {
        $template = $request->template;
        $user = $request->user();

        foreach ($template as $type => $value) {
            $setting = $user->privacySettings()->updateOrCreate(
                ['setting_type' => $type],
                ['setting_value' => $value]
            );
        }

        return response()->json($user->privacySettings);
    }

}

