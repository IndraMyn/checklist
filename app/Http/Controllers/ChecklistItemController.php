<?php

namespace App\Http\Controllers;

use App\Models\ChecklistItem;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ChecklistItemController extends Controller
{

    protected $userId;

    public function __construct()
    {
        try {
            $this->userId = JWTAuth::parseToken()->authenticate()->id;
        } catch (\Throwable) {

        }
    }

    public function index($id)
    {
        try {

            $checklistItem = ChecklistItem::where(['checklist_id' => $id])->get();

            return response([
                'data' => $checklistItem
            ]);

        } catch (Exception $e) {

            return response(['error' => $e->getMessage()], 500);

        }
    }

    public function create($id, Request $request)
    {

        $create = new ChecklistItem([
            'item_name' => $request->itemName,
            'checklist_id' => $id,
        ]);

        $create->save();

        return response([
            'message' => "Successfully"
        ]);

    }

    public function getByChecklistId($id, $itemId)
    {
        try {

            $checklistItem = ChecklistItem::where(['checklist_id' => $id, 'id' => $itemId])->first();

            return response([
                'data' => $checklistItem
            ]);

        } catch (Exception $e) {

            return response(['error' => $e->getMessage()], 500);

        }
    }

    public function update($id, $itemId, Request $request)
    {
        $item = ChecklistItem::where(['checklist_id' => $id, 'id' => $itemId])->first();
        
        if (empty($item))
            return response([
                "message" => "ID {$itemId} is not found!"
            ], 400);

        $item->status = false;
        $item->save();
        
        return response([
            "message" => "Successfully"
        ]);
    }

    public function rename($id, $itemId, Request $request)
    {
        $item = ChecklistItem::where(['checklist_id' => $id, 'id' => $itemId])->first();
        
        if (empty($item))
            return response([
                "message" => "ID {$itemId} is not found!"
            ], 400);

        $item->item_name = $request->itemName;
        $item->save();
        
        return response([
            "message" => "Successfully"
        ]);
    }

    public function destroy($id, $itemId)
    {
        $item = ChecklistItem::where(['checklist_id' => $id, 'id' => $itemId])->first();
        
        if (empty($item))
            return response([
                "message" => "ID {$itemId} is not found!"
            ], 400);

        $item->delete();
        return response([
            "message" => "Successfully"
        ]);

    }
}