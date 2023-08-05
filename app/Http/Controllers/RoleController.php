<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\RoleAccess;
use App\Models\OrderStatusAccess;
use App\Models\ReclamationTypeAccesses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        $formattedRoles = $roles->map(function ($role) {
            return [
                'id' => $role->id,
                'Nom' => $role->name,
                'Date ajout' => $role->created_at,
                'Date modif' => $role->updated_at,
            ];
        });


        return response()->json([ "data"=>$formattedRoles]);

    }


    public function get_permissions()
    {

        $user_role_id=Auth::user()->role_id;

        $RoleAccess = RoleAccess::where("role_id",$user_role_id)->get("module");

        $OrderStatus = OrderStatusAccess::with("OrderStatus")->where("role_id",$user_role_id)->get();
        $formattedOrderStatus = $OrderStatus->map(function ($status) {
            return [
                'Nom' => $status->OrderStatus->name,
                'Id' => $status->order_status_id,
            ];
        });

        $RecType = ReclamationTypeAccesses::where("role_id",$user_role_id)->get("reclamations_type_id");


        $data = [
            'Role' => Role::find($user_role_id)->name,
            'RoleAccess' => $RoleAccess,
            'OrderStatus' => $formattedOrderStatus,
            'RecType' => $RecType,
        ];

        return response()->json([ "data"=>$data]);

    }



    public function get_role($id)
    {

             //check role if exists
             $Role = Role::find($id);
             if (!$Role) {
                 return response()->json([
                     "error" => "Le Role Pas de trauver"
                 ]);  
             }

        $RoleAccess = RoleAccess::where("role_id",$id)->get("module");

        $OrderStatus = OrderStatusAccess::where("role_id",$id)->select('order_status_id as id')->get();

        $RecType = ReclamationTypeAccesses::where("role_id",$id)->select('reclamations_type_id as id')->get();


        $data = [
            'Nom' => $Role->name,
            'RoleAccess' => $RoleAccess,
            'OrderStatus' => $OrderStatus,
            'RecType' => $RecType,
        ];

        return response()->json([ "data"=>$data]);

    }

    

    

   
    public function new_role(Request $request)
    {
        $request->validate([
            "Nom" => "required",
            "PermissionsModules" => "required|array",
            "PermissionsOrderStatus" => "array",
            "PermissionsReclamtionTypes" => "array",
        ]);


        $prefix = 'BL-';
        $uniqueId = $prefix . uniqid();

        $role = Role::create([
            'name' => $request->Nom,
        ]);

        if(is_array($request->PermissionsModules) && count($request->PermissionsModules)){
        foreach ($request->PermissionsModules as $item ) {
            RoleAccess::create([
                'role_id' => $role->id,
                'module' => $item,
            ]);
        }
    }else  return response()->json([ "error" => "vous n'avez pas selectionner un module ou permission" ]);  


        if(is_array($request->PermissionsOrderStatus) && count($request->PermissionsOrderStatus)){
            foreach ($request->PermissionsOrderStatus as $item ) {
                OrderStatusAccess::create([
                    'role_id' => $role->id,
                    'order_status_id' => $item,
                ]);
            }
        }

        if (is_array($request->PermissionsReclamtionTypes) && count($request->PermissionsReclamtionTypes)) {
            foreach ($request->PermissionsReclamtionTypes as $item ) {
                ReclamationTypeAccesses::create([
                    'role_id' => $role->id,
                    'reclamations_type_id' => $item,
                ]);
            }
        }

        return response()->json([
            "success" => "le Role est ajouter avec success"
        ]);        
    }



    public function update_role(Request $request,$id)
    {
        $request->validate([
            "Nom" => "required",
            "PermissionsModules" => "required|array",
            "PermissionsOrderStatus" => "array",
            "PermissionsReclamtionTypes" => "array",
        ]);

         //check role if exists
         $Role = Role::find($id);
         if (!$Role) {
             return response()->json([
                 "error" => "Le Role Pas de trauver"
             ]);  
         }

        $Role->update([
            'name' => $request->Nom,
        ]);

        if(is_array($request->PermissionsModules) && count($request->PermissionsModules)){
            RoleAccess::where("role_id",$id)->delete();
        foreach ($request->PermissionsModules as $item ) {
            RoleAccess::create([
                'role_id' => $Role->id,
                'module' => $item,
            ]);
        }
    }else  return response()->json([ "error" => "vous n'avez pas selectionner un module ou permission" ]);  

        if(is_array($request->PermissionsOrderStatus) && count($request->PermissionsOrderStatus)){
            OrderStatusAccess::where("role_id",$id)->delete();
            foreach ($request->PermissionsOrderStatus as $item ) {
                OrderStatusAccess::create([
                    'role_id' => $Role->id,
                    'order_status_id' => $item,
                ]);
            }
        }

        if (is_array($request->PermissionsReclamtionTypes) && count($request->PermissionsReclamtionTypes)) {
            ReclamationTypeAccesses::where("role_id",$id)->delete();
            foreach ($request->PermissionsReclamtionTypes as $item ) {
                ReclamationTypeAccesses::create([
                    'role_id' => $Role->id,
                    'reclamations_type_id' => $item,
                ]);
            }
        }

        return response()->json([
            "success" => "le Role est ajouter avec success"
        ]);        
    }


    public function get_permissions_orders_statuses()
    {

        $user=Auth::user();

        $RoleAccess = OrderStatusAccess::where("role_id",$user->role_id)->get("module");

        $OrderStatus = OrderStatusAccess::where("role_id",$user_role_id)->all();
        $formattedOrderStatus = $roles->map(function ($role) {
            return [
                'Nom' => $role->order_status_id->OrderStatus->name,
                'Id' => $role->order_status_id,
            ];
        });

        $RecType = ReclamationTypeAccesses::where("role_id",$user_role_id)->get("reclamations_type_id");


        $data = [
            'Role' => Role::find($user_role_id)->name,
            'RoleAccess' => $RoleAccess,
            'OrderStatus' => $formattedOrderStatus,
            'RecType' => $RecType,
        ];

        return response()->json([ "data"=>$data]);

    }





}