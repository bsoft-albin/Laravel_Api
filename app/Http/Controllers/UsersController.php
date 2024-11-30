<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;  this is the Deafult Namespace Containing Request Methods
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    //CRUD operations of Users
    public function GetAllUsers()
    {
        // Retrieve all users from the 'users' table
        $allUsers = DB::table('users')->get();

        if ($allUsers->count() > 0) {
            return response()->json([
                'data' => ['usersList' => $allUsers, 'usersCount' => $allUsers->count()],
                'statusCode' => 200,
                'statusMessage' => 'Success'
            ]);
        } else {
            return response()->json([
                'data' => $allUsers,
                'statusCode' => 204,
                'statusMessage' => 'No Record Found'
            ]);
        }
    }

    public function PostSingleUser(UserRequest $request)
    {

        $validatedData = $request->validated();

        // Insert the new user using the DB facade
        DB::table('users')->insert([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'phone_number' => $validatedData['phone_number'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            "statusCode" => 201,
            "statusMessage" => "User Created"
        ]);
    }

    public function UpdateUserById(Request $request, $id)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            // add more fields as needed
        ]);

        // Update the user in the database using DB facade
        $updated = DB::table('users')->where('id', $id)->update($validated);

        if (!$updated) {
            return response()->json(['statusCode' => 404, 'statusMessage' => 'User not found or no changes made']);
        }

        return response()->json(['statusCode' => 202, 'statusMessage' => 'User updated successfully']);
    }

    //this is also Query Parameter Method, i.e see Delete Method
    public function PatchUpdateUserById(Request $request, $id)
    {
        // You may want to add validation for specific fields
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            // add other optional fields as needed
        ]);

        //$data = $request->validate();

        // Partially update the user in the database using DB facade
        $updated = DB::table('users')->where('id', $id)->update($validated);

        if (!$updated) {
            return response()->json(['statusCode' => 404, 'statusMessage' => 'User not found or no changes made']);
        }

        return response()->json(['statusCode' => 202, 'statusMessage' => 'User updated successfully']);
    }

    // the below method is Route Parameter Method, not Query parameter or Query String method
    public function DeleteUserById($id)
    {
        // Delete the user from the database using DB facade
        $deleted = DB::table('users')->where('id', $id)->delete();

        if (!$deleted) {
            return response()->json(["statusCode" => 204, 'statusMessage' => 'User not found']);
        }

        return response()->json(["statusCode" => 200, 'statusMessage' => 'User deleted successfully']);
    }

    // the below Method is getting record Using ==> [Query String or Paramter], not Route Parameter
    public function GetSingleUserById(Request $request)
    {
        // Retrieve the 'id' query parameter from the request
        $id = $request->query('id');

        if (!$id) {
            return response()->json([
                'statusCode' => 400,
                'statusMessage' => 'id query parameter is required'
            ]);
        }

        // Fetch the user from the database
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return response()->json([
                'statusCode' => 404,
                'statusMessage' => 'User not found'
            ]);
        }

        return response()->json([
            'data' => $user,
            'statusCode' => 200,
            'statusMessage' => 'User retrieved successfully'
        ]);
    }

    //below method is using HEAD Http Method !!!
    public function GetSingleUserUsingHeadHttpVerb(Request $request)
    {
        $id = $request->query('id');

        if (!$id) {
            return response()->json([
                'statusCode' => 400,
                'statusMessage' => 'ID query parameter is required'
            ]);
        }

        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return response()->json([
                'statusCode' => 404,
                'statusMessage' => 'User not found'
            ]);
        }

        return response()->noContent(200); // HEAD will only return the headers
    }

    public function GetOptions()
    {
        return response()->json([
            'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
            'statusCode' => 200,
            'statusMessage' => 'Options retrieved successfully'
        ])->header('Allow', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
    }

    public function AlternatePutOrPatchMethod(Request $request)
    {

        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'
            // add more fields as needed
        ]);

        // Update the user in the database using DB facade
        $updated = DB::table('users')->where('id', $request['id'])->update($validated);

        if (!$updated) {
            return response()->json(['statusCode' => 404, 'statusMessage' => 'User not found or no changes made']);
        }

        return response()->json(['statusCode' => 202, 'statusMessage' => 'User updated successfully']);
    }
}
