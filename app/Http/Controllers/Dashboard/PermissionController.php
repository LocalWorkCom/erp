<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('dashboard.permissions.list', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'is_active' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $existingPermission = DB::table('permissions')
            ->where('name', $request->name_en)
            ->where('guard_name', 'admin')
            ->first();

        if ($existingPermission) {
            return redirect()->back()
                ->with('error', __('roles.permission_already_exists', ['name' => $request->name_en]))
                ->withInput();
        }
        DB::table('permissions')->insert([
            'name' => $request->name_en,
            'is_active' => $request->is_active,
            'guard_name' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Paths to the translation files
        $enLangPath = resource_path('lang/en/permissions.php');
        $arLangPath = resource_path('lang/ar/permissions.php');

        // Update English translations
        $this->updateLangFile($enLangPath, $request->name_en, $request->name_en);

        // Update Arabic translations
        $this->updateLangFile($arLangPath, $request->name_en, $request->name_ar);

        // $words = explode(' ', $request->name_en);
        // $words_ar = explode(' ', $request->name_ar);

        // // If there are second words in both languages
        // if (count($words) > 1 && count($words_ar) > 1 && $status === true) {
        //     $secondWord = $words[1];
        //     $secondWordAr = $words_ar[1];

        //     // Add translation for the second word
        //     $this->updateLangFile($enLangPath, $secondWord, ucfirst($secondWord));
        //     $this->updateLangFile($arLangPath, $secondWord, ucfirst($secondWordAr));
        // }
        return redirect()->back();
    }


    function updateLangFile($filePath, $key, $value)
    {
        // Check if the file exists
        if (!File::exists($filePath)) {
            // Create a new file with an empty array if it doesn't exist
            File::put($filePath, "<?php\n\nreturn [\n];");
        }

        // Load the existing translations
        $translations = include $filePath;

        // Add or update the translation
        $translations[$key] = $value;

        // Prepare the content to append
        $newTranslation = "    '{$key}' => '{$value}',\n";

        // Check if the translation key already exists in the file
        if (array_key_exists($key, $translations)) {
            // If it exists, just rewrite the entire array (this avoids duplication)
            $content = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
            File::put($filePath, $content);
        } else {
            // Append new translation
            $fileContent = File::get($filePath);

            // Insert before the closing bracket of the array
            $updatedContent = preg_replace('/\];/', $newTranslation . "];", $fileContent);

            // Write the updated content back to the file
            File::put($filePath, $updatedContent);
        }
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $permission = DB::table('permissions')->find($id);

        if (!$permission) {
            return response()->json(['error' => 'Permission not found'], 404);
        }

        // Paths to translation files
        $enLangPath = resource_path('lang/en/permissions.php');
        $arLangPath = resource_path('lang/ar/permissions.php');

        // Check if translation files exist
        if (!file_exists($enLangPath) || !file_exists($arLangPath)) {
            return response()->json(['error' => 'Translation files not found'], 500);
        }

        // Load the existing translations from the language files
        $enTranslations = include $enLangPath;
        $arTranslations = include $arLangPath;

        // Find the existing translation for the permission name
        $nameEn = $permission->name;
        $nameAr = $arTranslations[$permission->name] ?? '';
        $isActive = $permission->is_active;

        return response()->json([
            'permission' => $permission,
            'name_en' => $nameEn,
            'id' => $id,
            'name_ar' => $nameAr,
            'isActive' => $isActive,
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Update the permission in the database
        $permission = DB::table('permissions')->find($request->id);
        DB::table('permissions')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name_en,
                'is_active' => $request->is_active_edit,
                'guard_name' => 'admin',
                'updated_at' => now(),
            ]);

        // Paths to the translation files
        $enLangPath = resource_path('lang/en/permissions.php');
        $arLangPath = resource_path('lang/ar/permissions.php');

        // Update the translation files
        $this->updateLangFile($enLangPath, $request->name_en, $request->name_en);
        $this->updateLangFile($arLangPath, $request->name_en, $request->name_ar);

        // Return back with success message
        return redirect()->route('permissions.list')->with('success', 'Permission updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the permission
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json(['error' => __('roles.permission_not_found')], 404);
        }

        // Check if the permission is assigned to any roles
        $roleCount = DB::table('role_has_permissions')
            ->where('permission_id', $id)
            ->count();
        if ($roleCount > 0) {
            return response()->json(['error' => __('roles.delete_error')], 400);
        }

        // Remove language keys related to this permission (if applicable)
        $this->removePermissionFromLangFiles($permission);

        // Proceed with deleting the permission if not assigned to any roles
        $permission->delete();

        return response()->json(['success' => __('roles.delete_success')]);
    }

    private function removePermissionFromLangFiles($permission)
    {
        // Define the language files to be checked
        $langFiles = ['en', 'ar']; // Adjust according to your project

        foreach ($langFiles as $lang) {
            // Get the path of the language file
            $langPath = resource_path("lang/{$lang}/permissions.php");

            // Check if the language file exists
            if (file_exists($langPath)) {
                // Load the language file
                $translations = include $langPath;

                // Check if the permission key exists in the translations
                if (isset($translations[$permission->name])) {
                    // Remove the permission key from the translations
                    unset($translations[$permission->name]);

                    // Save the updated language file
                    file_put_contents($langPath, '<?php return ' . var_export($translations, true) . ';');
                }
            }
        }
    }
}
