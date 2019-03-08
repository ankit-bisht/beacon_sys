<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CommonModel;
use DB;

class BeaconController extends Controller
{
    public function fetchNodes(Request $request)
    {
        $beacon_uuid = $request->input('beacon_uuid');
        $data = [];
        $current_node = DB::table('beacon_listings')
            ->where('beacon_uuid', $beacon_uuid)
            ->select('desc', 'id')
            ->first();
        if (!empty($current_node)) {
            $data['current_node'] = $current_node->desc;
            $adjacent_nodes = DB::table('beacon_connections_lists')
                ->where('first_node', $current_node->id)
                ->orWhere('second_node', $current_node->id)
                ->select('first_node', 'second_node', 'distance', 'direction_name')
                ->get();
            if (isset($adjacent_nodes[0])) {
                $nodes_count = count($adjacent_nodes);
                for ($i = 0; $i < $nodes_count; $i++) {
                    if ($current_node->id == $adjacent_nodes[$i]->first_node) {
                        $adjacent_nodes[$i]->desc = ((new CommonModel)->fetchNodeByID($adjacent_nodes[$i]->second_node))->desc;
                    } else {
                        $adjacent_nodes[$i]->desc = ((new CommonModel)->fetchNodeByID($adjacent_nodes[$i]->first_node))->desc;
                        $adjacent_nodes[$i]->direction_name = config('apiconstants.reverse_direction')[$adjacent_nodes[$i]->direction_name];
                    }
                }
                $data['adjacent_nodes'] = $adjacent_nodes;
                $responseMessage = config('apiconstants.success_message.nodes_fetched_success_message');
            } else {
                $data['adjacent_nodes'] = [];
                $responseMessage = config('apiconstants.error_message.empty_nodes_error_message');
            }
            $responseCode = config('apiconstants.success_code');
        } else {
            $responseCode = config('apiconstants.error_code.empty_node_error_code');
            $responseMessage = config('apiconstants.error_message.empty_node_error_message');
        }
        $res = (new CommonModel)->responseGenerate(
            $responseCode,
            $responseMessage,
            $data
        );
        return $res;
    }
}
